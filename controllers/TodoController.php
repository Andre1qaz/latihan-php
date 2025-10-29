<?php
require_once (__DIR__ . '/../models/TodoModel.php');

class TodoController
{
    public function index()
    {
        $todoModel = new TodoModel();
        $filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
        $search = isset($_GET['search']) ? $_GET['search'] : '';

        if (!empty($search)) {
            $todos = $todoModel->searchTodos($search, $filter);
        } else {
            if ($filter === 'all') {
                $todos = $todoModel->getAllTodos();
            } else {
                $todos = $todoModel->getFilteredTodos($filter);
            }
        }

        include (__DIR__ . '/../views/TodoView.php');
    }

    public function create()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = trim($_POST['title']);
        $description = trim($_POST['description'] ?? '');
        $todoModel = new TodoModel();
        
        if (empty($title)) {
            header('Location: index.php?error=Title is required');
            exit;
        }
        
        // PERBAIKAN: Tangani respons status dari Model
        $result = $todoModel->createTodo($title, $description);

        if ($result === 'exists') {
            header('Location: index.php?error=Title already exists');
            exit;
        } elseif ($result === 'dberror') {
            // Ini akan menunjukkan jika ada masalah database (bukan duplikat)
            header('Location: index.php?error=Database error on create');
            exit;
        }
        // Jika 'success', biarkan lanjut ke redirect di bawah
    }
    header('Location: index.php');
}



    public function update()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        $title = trim($_POST['title']);
        $description = trim($_POST['description'] ?? '');
        $isFinished = isset($_POST['is_finished']) ? ($_POST['is_finished'] == '1') : false;
        $todoModel = new TodoModel();
        
        if (empty($title)) {
            header('Location: index.php?error=Title is required');
            exit;
        }
        
        // PERBAIKAN: Tangani respons status dari Model
        $result = $todoModel->updateTodo($id, $title, $description, $isFinished);

        if ($result === 'exists') {
            header('Location: index.php?error=Title already exists');
            exit;
        } elseif ($result === 'dberror') {
            // Ini akan menunjukkan jika ada masalah database (bukan duplikat)
            header('Location: index.php?error=Database error on update');
            exit;
        }
         // Jika 'success', biarkan lanjut ke redirect di bawah
    }
    header('Location: index.php');
}


    public function detail()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $todoModel = new TodoModel();
            $todo = $todoModel->getTodoById($id);
            if ($todo) {
                include (__DIR__ . '/../views/TodoDetailView.php');
            } else {
                header('Location: index.php?error=Todo not found');
            }
        } else {
            header('Location: index.php');
        }
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
            $id = $_GET['id'];
            $todoModel = new TodoModel();
            $todoModel->deleteTodo($id);
        }
        header('Location: index.php');
    }
}
