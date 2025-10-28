<!DOCTYPE html>
<html>
<head>
    <title>PHP - Aplikasi Todolist</title>
    <link href="/assets/vendor/bootstrap-5.3.8-dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { 
            background: linear-gradient(135deg, #667eea 0%, #4b86a2ff 100%); 
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .main-container {
            padding: 40px 20px;
        }
        
        .card { 
            border: none; 
            border-radius: 25px; 
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
            background: white;
            overflow: hidden;
            animation: fadeIn 0.5s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .card-body {
            padding: 40px;
        }
        
        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 35px;
            padding-bottom: 25px;
            border-bottom: 3px solid #f0f0f0;
        }
        
        .header-section h1 {
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .btn {
            border-radius: 12px;
            padding: 12px 28px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-primary { 
            background: linear-gradient(45deg, #667eea, #764ba2);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }
        
        .btn-success { 
            background: linear-gradient(45deg, #28a745, #1e7e34);
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }
        
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
        }
        
        .btn-warning { 
            background: linear-gradient(45deg, #ffc107, #e0a800);
            color: #000;
            box-shadow: 0 4px 15px rgba(255, 193, 7, 0.3);
        }
        
        .btn-warning:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 193, 7, 0.4);
        }
        
        .btn-danger { 
            background: linear-gradient(45deg, #dc3545, #c82333);
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
        }
        
        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(220, 53, 69, 0.4);
        }
        
        .btn-secondary {
            background: linear-gradient(45deg, #6c757d, #5a6268);
            box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
        }
        
        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(108, 117, 125, 0.4);
        }
        
        .btn-info {
            background: linear-gradient(45deg, #17a2b8, #138496);
            box-shadow: 0 4px 15px rgba(23, 162, 184, 0.3);
        }
        
        .btn-info:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(23, 162, 184, 0.4);
        }
        
        .btn-outline-primary {
            border: 2px solid #667eea;
            color: #667eea;
            background: transparent;
        }
        
        .btn-outline-primary:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
        }
        
        .btn-outline-success {
            border: 2px solid #28a745;
            color: #28a745;
            background: transparent;
        }
        
        .btn-outline-success:hover {
            background: #28a745;
            color: white;
            transform: translateY(-2px);
        }
        
        .btn-outline-warning {
            border: 2px solid #ffc107;
            color: #ffc107;
            background: transparent;
        }
        
        .btn-outline-warning:hover {
            background: #ffc107;
            color: #000;
            transform: translateY(-2px);
        }
        
        .btn-sm {
            padding: 6px 14px;
            font-size: 0.875rem;
        }
        
        .badge { 
            font-size: 0.85rem;
            padding: 6px 14px;
            border-radius: 20px;
            font-weight: 500;
        }
        
        .alert {
            border-radius: 15px;
            border: none;
            padding: 18px 24px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideDown 0.3s ease-out;
        }
        
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .alert-danger {
            background: linear-gradient(135deg, #fff5f5 0%, #fee 100%);
            color: #dc3545;
            border-left: 4px solid #dc3545;
        }
        
        .search-bar {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .search-bar .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 12px 20px;
            transition: all 0.3s ease;
        }
        
        .search-bar .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
        }
        
        .filter-buttons {
            margin-bottom: 30px;
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }
        
        .table-container {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 20px;
            overflow-x: auto;
        }
        
        .table {
            margin-bottom: 0;
            background: white;
            border-radius: 12px;
            overflow: hidden;
        }
        
        .table thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .table thead th {
            border: none;
            color: white;
            padding: 18px 15px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.875rem;
            letter-spacing: 0.5px;
        }
        
        .table tbody tr {
            transition: all 0.3s ease;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .table tbody tr:hover {
            background: #f8f9ff;
            transform: scale(1.01);
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        
        .table tbody td {
            padding: 18px 15px;
            vertical-align: middle;
        }
        
        .table tbody td a {
            color: #2c3e50;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        .table tbody td a:hover {
            color: #667eea;
        }
        
        .text-muted {
            color: #6c757d !important;
            font-style: italic;
        }
        
        .modal-content {
            border: none;
            border-radius: 20px;
            overflow: hidden;
        }
        
        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px 30px;
            border: none;
        }
        
        .modal-header .modal-title {
            font-weight: 600;
            font-size: 1.5rem;
        }
        
        .modal-header .btn-close {
            filter: brightness(0) invert(1);
            opacity: 0.8;
        }
        
        .modal-body {
            padding: 30px;
        }
        
        .modal-footer {
            padding: 20px 30px;
            border-top: 2px solid #f0f0f0;
        }
        
        .form-label {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 8px;
        }
        
        .form-control, .form-select {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 12px 16px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
        }
        
        .blue-background-class { 
            background-color: #e3e8ff !important;
            opacity: 0.8;
        }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }
        
        .empty-state i {
            font-size: 4rem;
            color: #cbd5e0;
            margin-bottom: 20px;
        }
        
        .empty-state p {
            font-size: 1.1rem;
            color: #6c757d;
        }
        
        @media (max-width: 768px) {
            .card-body { padding: 25px; }
            .header-section { flex-direction: column; gap: 20px; align-items: flex-start; }
            .header-section h1 { font-size: 2rem; }
            .filter-buttons { flex-direction: column; }
            .table-container { padding: 15px; }
        }
    </style>
</head>
<body>
<div class="container-fluid main-container">
    <div class="card">
        <div class="card-body">
            <div class="header-section">
                <h1>
                    <i class="fas fa-tasks"></i>
                    Todo List
                </h1>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTodo">
                    <i class="fas fa-plus-circle"></i>
                    Tambah Data
                </button>
            </div>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle"></i>
                    <span><?php echo htmlspecialchars($_GET['error']); ?></span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="search-bar">
                <form method="GET" class="d-flex gap-2">
                    <input type="hidden" name="page" value="index">
                    <input type="text" name="search" class="form-control flex-grow-1" placeholder="🔍 Cari todo..." value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-search"></i>
                        Cari
                    </button>
                    <a href="index.php" class="btn btn-secondary">
                        <i class="fas fa-redo"></i>
                        Reset
                    </a>
                </form>
            </div>

            <div class="filter-buttons">
                <a href="?filter=all<?php echo isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : ''; ?>" class="btn btn-outline-primary">
                    <i class="fas fa-list"></i>
                    Semua
                </a>
                <a href="?filter=finished<?php echo isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : ''; ?>" class="btn btn-outline-success">
                    <i class="fas fa-check-circle"></i>
                    Selesai
                </a>
                <a href="?filter=unfinished<?php echo isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : ''; ?>" class="btn btn-outline-warning">
                    <i class="fas fa-clock"></i>
                    Belum Selesai
                </a>
            </div>
            
            <div class="table-container">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 60px;">#</th>
                            <th scope="col">Aktivitas</th>
                            <th scope="col" style="width: 150px;">Status</th>
                            <th scope="col" style="width: 200px;">Tanggal Dibuat</th>
                            <th scope="col" style="width: 280px;">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($todos)): ?>
                        <?php foreach ($todos as $i => $todo): ?>
                        <tr>
                            <td><strong><?= $i + 1 ?></strong></td>
                            <td>
                                <a href="?page=detail&id=<?= $todo['id'] ?>">
                                    <i class="fas fa-file-alt me-2"></i>
                                    <?= htmlspecialchars($todo['title']) ?>
                                </a>
                            </td>
                            <td>
                                <?php if ($todo['is_finished']): ?>
                                    <span class="badge bg-success">
                                        <i class="fas fa-check"></i> Selesai
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark">
                                        <i class="fas fa-clock"></i> Belum Selesai
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td><?= date('d M Y - H:i', strtotime($todo['created_at'])) ?></td>
                            <td>
                                <button class="btn btn-sm btn-info me-1"
                                    onclick="window.location.href='?page=detail&id=<?= $todo['id'] ?>'">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-warning me-1"
                                    onclick="showModalEditTodo(<?= $todo['id'] ?>, '<?= htmlspecialchars(addslashes($todo['title'])) ?>', '<?= htmlspecialchars(addslashes($todo['description'] ?? '')) ?>', <?= $todo['is_finished'] ? 'true' : 'false' ?>)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger"
                                    onclick="showModalDeleteTodo(<?= $todo['id'] ?>, '<?= htmlspecialchars(addslashes($todo['title'])) ?>')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <i class="fas fa-inbox"></i>
                                    <p>Belum ada data tersedia!</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- MODAL ADD TODO -->
<div class="modal fade" id="addTodo" tabindex="-1" aria-labelledby="addTodoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTodoLabel">
                    <i class="fas fa-plus-circle me-2"></i>
                    Tambah Data Todo
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="?page=create" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="inputTitle" class="form-label">
                            <i class="fas fa-heading me-2"></i>Judul
                        </label>
                        <input type="text" name="title" class="form-control" id="inputTitle"
                            placeholder="Contoh: Belajar membuat aplikasi website sederhana" required>
                    </div>
                    <div class="mb-3">
                        <label for="inputDescription" class="form-label">
                            <i class="fas fa-align-left me-2"></i>Deskripsi
                        </label>
                        <textarea name="description" class="form-control" id="inputDescription" rows="4"
                            placeholder="Deskripsi detail todo (opsional)"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL EDIT TODO -->
<div class="modal fade" id="editTodo" tabindex="-1" aria-labelledby="editTodoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTodoLabel">
                    <i class="fas fa-edit me-2"></i>
                    Ubah Data Todo
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="?page=update" method="POST">
                <input name="id" type="hidden" id="inputEditTodoId">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="inputEditTitle" class="form-label">
                            <i class="fas fa-heading me-2"></i>Judul
                        </label>
                        <input type="text" name="title" class="form-control" id="inputEditTitle"
                            placeholder="Contoh: Belajar membuat aplikasi website sederhana" required>
                    </div>
                    <div class="mb-3">
                        <label for="inputEditDescription" class="form-label">
                            <i class="fas fa-align-left me-2"></i>Deskripsi
                        </label>
                        <textarea name="description" class="form-control" id="inputEditDescription" rows="4"
                            placeholder="Deskripsi detail todo (opsional)"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="selectEditStatus" class="form-label">
                            <i class="fas fa-flag me-2"></i>Status
                        </label>
                        <select class="form-select" name="is_finished" id="selectEditStatus">
                            <option value="0">Belum Selesai</option>
                            <option value="1">Selesai</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL DELETE TODO -->
<div class="modal fade" id="deleteTodo" tabindex="-1" aria-labelledby="deleteTodoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title" id="deleteTodoLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Hapus Data Todo
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center py-3">
                    <i class="fas fa-trash-alt text-danger" style="font-size: 3rem;"></i>
                    <p class="mt-3 mb-2">Kamu akan menghapus todo:</p>
                    <p class="fw-bold text-danger fs-5" id="deleteTodoActivity"></p>
                    <p class="text-muted">Apakah kamu yakin? Tindakan ini tidak dapat dibatalkan.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Batal
                </button>
                <a id="btnDeleteTodo" class="btn btn-danger">
                    <i class="fas fa-trash me-2"></i>Ya, Tetap Hapus
                </a>
            </div>
        </div>
    </div>
</div>

<script src="/assets/vendor/bootstrap-5.3.8-dist/js/bootstrap.min.js"></script>
<script>
function showModalEditTodo(todoId, title, description, isFinished) {
    document.getElementById("inputEditTodoId").value = todoId;
    document.getElementById("inputEditTitle").value = title;
    document.getElementById("inputEditDescription").value = description;
    document.getElementById("selectEditStatus").value = isFinished ? '1' : '0';
    var myModal = new bootstrap.Modal(document.getElementById("editTodo"));
    myModal.show();
}

function showModalDeleteTodo(todoId, title) {
    document.getElementById("deleteTodoActivity").innerText = title;
    document.getElementById("btnDeleteTodo").setAttribute("href", `?page=delete&id=${todoId}`);
    var myModal = new bootstrap.Modal(document.getElementById("deleteTodo"));
    myModal.show();
}

// Initialize SortableJS for drag-and-drop reordering
document.addEventListener('DOMContentLoaded', function() {
    const tbody = document.querySelector('tbody');
    if (tbody && tbody.querySelector('tr td:not([colspan])')) {
        new Sortable(tbody, {
            animation: 150,
            ghostClass: 'blue-background-class',
            onEnd: function(evt) {
                const todoId = evt.item.querySelector('td a').href.split('id=')[1];
                const newIndex = evt.newIndex;
                console.log('Todo ID:', todoId, 'New Index:', newIndex);
            }
        });
    }
});
</script>
</body>
</html>