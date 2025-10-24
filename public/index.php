<?php
// Mulai session untuk menampung pesan sukses/error
session_start();

// Tentukan page yang akan diakses
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 'index';
}

// Load controller
include('../controllers/TodoController.php');

// Inisialisasi controller
$todoController = new TodoController();

// Routing berdasarkan page
switch ($page) {
    case 'index':
        $todoController->index();
        break;
    case 'create':
        $todoController->create();
        break;
    case 'update':
        $todoController->update();
        break;
    case 'delete':
        $todoController->delete();
        break;
    case 'detail':
        $todoController->detail();
        break;
    case 'updateSort':
        $todoController->updateSort();
        break;
    default:
        // Jika page tidak ditemukan, redirect ke halaman utama
        header('Location: index.php');
        exit;
}