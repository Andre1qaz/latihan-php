<?php
require_once(__DIR__ . '/../models/TodoModel.php');

class TodoController
{
    /**
     * Menampilkan halaman utama dengan daftar todos
     */
    public function index()
    {
        $todoModel = new TodoModel();
        
        // Ambil parameter filter dan search dari query string
        $filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        
        // Validasi filter
        if (!in_array($filter, ['all', 'finished', 'unfinished'])) {
            $filter = 'all';
        }
        
        $todos = $todoModel->getAllTodos($filter, $search);
        include(__DIR__ . '/../views/TodoView.php');
    }

    /**
     * Membuat todo baru
     */
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = isset($_POST['title']) ? trim($_POST['title']) : '';
            $description = isset($_POST['description']) ? trim($_POST['description']) : '';
            
            // Validasi input
            if (empty($title)) {
                $_SESSION['error'] = 'Judul todo tidak boleh kosong!';
                header('Location: index.php');
                exit;
            }
            
            $todoModel = new TodoModel();
            $result = $todoModel->createTodo($title, $description);
            
            if ($result) {
                $_SESSION['success'] = 'Todo berhasil ditambahkan!';
            } else {
                $_SESSION['error'] = 'Judul todo sudah ada. Gunakan judul yang berbeda!';
            }
        }
        header('Location: index.php');
        exit;
    }

    /**
     * Mengupdate todo
     */
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $title = trim($_POST['title']);
            $description = trim($_POST['description']);
            $isFinished = isset($_POST['is_finished']) ? $_POST['is_finished'] : '0';
            
            // Validasi input
            if (empty($title)) {
                $_SESSION['error'] = 'Judul todo tidak boleh kosong!';
                header('Location: index.php');
                exit;
            }
            
            $todoModel = new TodoModel();
            $result = $todoModel->updateTodo($id, $title, $description, $isFinished);
            
            if ($result) {
                $_SESSION['success'] = 'Todo berhasil diupdate!';
            } else {
                $_SESSION['error'] = 'Judul todo sudah ada. Gunakan judul yang berbeda!';
            }
        }
        header('Location: index.php');
        exit;
    }

    /**
     * Menghapus todo
     */
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
            $id = $_GET['id'];
            $todoModel = new TodoModel();
            $result = $todoModel->deleteTodo($id);
            
            if ($result) {
                $_SESSION['success'] = 'Todo berhasil dihapus!';
            } else {
                $_SESSION['error'] = 'Gagal menghapus todo!';
            }
        }
        header('Location: index.php');
        exit;
    }

    /**
     * Menampilkan detail todo
     */
    public function detail()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $todoModel = new TodoModel();
            $todo = $todoModel->getTodoById($id);
            
            if ($todo) {
                include(__DIR__ . '/../views/TodoDetailView.php');
            } else {
                $_SESSION['error'] = 'Todo tidak ditemukan!';
                header('Location: index.php');
                exit;
            }
        } else {
            header('Location: index.php');
            exit;
        }
    }

    /**
     * Update urutan sorting (AJAX endpoint)
     */
    public function updateSort()
    {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (isset($data['todoIds']) && is_array($data['todoIds'])) {
                $todoModel = new TodoModel();
                $result = $todoModel->updateSortOrder($data['todoIds']);
                
                echo json_encode(['success' => $result]);
                exit;
            }
        }
        
        echo json_encode(['success' => false]);
        exit;
    }
}