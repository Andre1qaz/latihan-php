<?php
require_once(__DIR__ . '/../config.php');

class TodoModel
{
    private $conn;

    public function __construct()
    {
        // Inisialisasi koneksi database PostgreSQL
        $this->conn = pg_connect('host=' . DB_HOST . ' port=' . DB_PORT . ' dbname=' . DB_NAME . ' user=' . DB_USER . ' password=' . DB_PASSWORD);
        if (!$this->conn) {
            die('Koneksi database gagal');
        }
    }

    /**
     * Mendapatkan semua todos dengan filter dan pencarian
     */
    public function getAllTodos($filter = 'all', $search = '')
    {
        $query = 'SELECT * FROM todo WHERE 1=1';
        $params = [];
        $paramCount = 1;

        // Filter berdasarkan status
        if ($filter === 'finished') {
            $query .= ' AND is_finished = TRUE';
        } elseif ($filter === 'unfinished') {
            $query .= ' AND is_finished = FALSE';
        }

        // Pencarian berdasarkan title atau description
        if (!empty($search)) {
            $query .= " AND (title ILIKE $" . $paramCount . " OR description ILIKE $" . $paramCount . ")";
            $params[] = '%' . $search . '%';
            $paramCount++;
        }

        $query .= ' ORDER BY sort_order ASC, created_at DESC';

        $result = pg_query_params($this->conn, $query, $params);
        $todos = [];
        if ($result && pg_num_rows($result) > 0) {
            while ($row = pg_fetch_assoc($result)) {
                $todos[] = $row;
            }
        }
        return $todos;
    }

    /**
     * Mendapatkan detail todo berdasarkan ID
     */
    public function getTodoById($id)
    {
        $query = 'SELECT * FROM todo WHERE id=$1';
        $result = pg_query_params($this->conn, $query, [$id]);
        if ($result && pg_num_rows($result) > 0) {
            return pg_fetch_assoc($result);
        }
        return null;
    }

    /**
     * Mengecek apakah title sudah ada
     */
    public function isTitleExists($title, $excludeId = null)
    {
        if ($excludeId) {
            $query = 'SELECT COUNT(*) as count FROM todo WHERE title=$1 AND id != $2';
            $result = pg_query_params($this->conn, $query, [$title, $excludeId]);
        } else {
            $query = 'SELECT COUNT(*) as count FROM todo WHERE title=$1';
            $result = pg_query_params($this->conn, $query, [$title]);
        }
        
        if ($result) {
            $row = pg_fetch_assoc($result);
            return $row['count'] > 0;
        }
        return false;
    }

    /**
     * Membuat todo baru
     */
    public function createTodo($title, $description)
    {
        // Validasi title tidak boleh duplikat
        if ($this->isTitleExists($title)) {
            return false;
        }

        // Dapatkan sort_order terakhir
        $queryMaxOrder = 'SELECT COALESCE(MAX(sort_order), 0) + 1 as next_order FROM todo';
        $resultMaxOrder = pg_query($this->conn, $queryMaxOrder);
        $nextOrder = 1;
        if ($resultMaxOrder) {
            $row = pg_fetch_assoc($resultMaxOrder);
            $nextOrder = $row['next_order'];
        }

        $query = 'INSERT INTO todo (title, description, sort_order) VALUES ($1, $2, $3)';
        $result = pg_query_params($this->conn, $query, [$title, $description, $nextOrder]);
        return $result !== false;
    }

    /**
     * Mengupdate todo
     */
    public function updateTodo($id, $title, $description, $isFinished)
    {
        // Validasi title tidak boleh duplikat (kecuali untuk todo yang sama)
        if ($this->isTitleExists($title, $id)) {
            return false;
        }

        $query = 'UPDATE todo SET title=$1, description=$2, is_finished=$3, updated_at=CURRENT_TIMESTAMP WHERE id=$4';
        $result = pg_query_params($this->conn, $query, [$title, $description, $isFinished, $id]);
        return $result !== false;
    }

    /**
     * Menghapus todo
     */
    public function deleteTodo($id)
    {
        $query = 'DELETE FROM todo WHERE id=$1';
        $result = pg_query_params($this->conn, $query, [$id]);
        return $result !== false;
    }

    /**
     * Update urutan sorting todos
     */
    public function updateSortOrder($todoIds)
    {
        pg_query($this->conn, 'BEGIN');
        
        try {
            foreach ($todoIds as $order => $id) {
                $query = 'UPDATE todo SET sort_order=$1 WHERE id=$2';
                $result = pg_query_params($this->conn, $query, [$order, $id]);
                if (!$result) {
                    throw new Exception('Failed to update sort order');
                }
            }
            pg_query($this->conn, 'COMMIT');
            return true;
        } catch (Exception $e) {
            pg_query($this->conn, 'ROLLBACK');
            return false;
        }
    }
}