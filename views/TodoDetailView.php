<?php
// Mulai session jika belum dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Todo - <?= htmlspecialchars($todo['title']) ?></title>
    <link href="/assets/vendor/bootstrap-5.3.8-dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px 0;
        }
        .detail-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }
        .status-badge {
            font-size: 1rem;
            padding: 10px 20px;
            border-radius: 50px;
        }
        .info-label {
            font-weight: 600;
            color: #667eea;
            margin-bottom: 5px;
        }
        .info-content {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            border-left: 4px solid #667eea;
        }
    </style>
</head>
<body>
<div class="container py-4">
    <div class="detail-card">
        <div class="card-body p-4 p-md-5">
            <!-- Header with back button -->
            <div class="d-flex justify-content-between align-items-start mb-4">
                <a href="index.php" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>
                <div>
                    <?php if ($todo['is_finished'] == 't'): ?>
                        <span class="status-badge badge bg-success">
                            <i class="bi bi-check-circle me-2"></i>Selesai
                        </span>
                    <?php else: ?>
                        <span class="status-badge badge bg-warning text-dark">
                            <i class="bi bi-clock-history me-2"></i>Belum Selesai
                        </span>
                    <?php endif; ?>
                </div>
            </div>

            <hr class="mb-4">

            <!-- Title -->
            <div class="mb-4">
                <div class="info-label">
                    <i class="bi bi-bookmark-fill me-2"></i>JUDUL TODO
                </div>
                <h2 class="mb-0 <?= $todo['is_finished'] == 't' ? 'text-decoration-line-through text-muted' : '' ?>">
                    <?= htmlspecialchars($todo['title']) ?>
                </h2>
            </div>

            <!-- Description -->
            <div class="mb-4">
                <div class="info-label">
                    <i class="bi bi-card-text me-2"></i>DESKRIPSI
                </div>
                <div class="info-content">
                    <?php if (!empty($todo['description'])): ?>
                        <p class="mb-0" style="white-space: pre-wrap;"><?= htmlspecialchars($todo['description']) ?></p>
                    <?php else: ?>
                        <p class="mb-0 text-muted fst-italic">Tidak ada deskripsi</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Timestamps -->
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="info-label">
                        <i class="bi bi-calendar-plus me-2"></i>TANGGAL DIBUAT
                    </div>
                    <div class="info-content">
                        <p class="mb-0">
                            <i class="bi bi-clock me-2"></i>
                            <?= date('l, d F Y', strtotime($todo['created_at'])) ?>
                        </p>
                        <small class="text-muted">
                            Pukul <?= date('H:i:s', strtotime($todo['created_at'])) ?> WIB
                        </small>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="info-label">
                        <i class="bi bi-calendar-check me-2"></i>TERAKHIR DIUPDATE
                    </div>
                    <div class="info-content">
                        <p class="mb-0">
                            <i class="bi bi-clock me-2"></i>
                            <?= date('l, d F Y', strtotime($todo['updated_at'])) ?>
                        </p>
                        <small class="text-muted">
                            Pukul <?= date('H:i:s', strtotime($todo['updated_at'])) ?> WIB
                        </small>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex gap-2 mt-4">
                <button class="btn btn-warning" 
                        onclick="showModalEditTodo(<?= $todo['id'] ?>, '<?= htmlspecialchars(addslashes($todo['title'])) ?>', '<?= htmlspecialchars(addslashes($todo['description'] ?? '')) ?>', '<?= $todo['is_finished'] ?>')">
                    <i class="bi bi-pencil me-2"></i>Edit Todo
                </button>
                <button class="btn btn-danger" 
                        onclick="showModalDeleteTodo(<?= $todo['id'] ?>, '<?= htmlspecialchars(addslashes($todo['title'])) ?>')">
                    <i class="bi bi-trash me-2"></i>Hapus Todo
                </button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL EDIT TODO -->
<div class="modal fade" id="editTodo" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title"><i class="bi bi-pencil me-2"></i>Edit Todo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="?page=update" method="POST">
                <input name="id" type="hidden" id="inputEditTodoId">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="inputEditTitle" class="form-label">Judul <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" id="inputEditTitle" required>
                    </div>
                    <div class="mb-3">
                        <label for="inputEditDescription" class="form-label">Deskripsi</label>
                        <textarea name="description" class="form-control" id="inputEditDescription" rows="4"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="selectEditStatus" class="form-label">Status</label>
                        <select class="form-select" name="is_finished" id="selectEditStatus">
                            <option value="0">Belum Selesai</option>
                            <option value="1">Selesai</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-save me-2"></i>Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL DELETE TODO -->
<div class="modal fade" id="deleteTodo" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="bi bi-trash me-2"></i>Hapus Todo</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Apakah Anda yakin ingin menghapus todo:</p>
                <p class="fw-bold text-danger" id="deleteTodoTitle"></p>
                <p class="text-muted small">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a id="btnDeleteTodo" class="btn btn-danger">
                    <i class="bi bi-trash me-2"></i>Ya, Hapus
                </a>
            </div>
        </div>
    </div>
</div>

<script src="/assets/vendor/bootstrap-5.3.8-dist/js/bootstrap.min.js"></script>
<script>
// Show modal edit
function showModalEditTodo(todoId, title, description, isFinished) {
    document.getElementById("inputEditTodoId").value = todoId;
    document.getElementById("inputEditTitle").value = title;
    document.getElementById("inputEditDescription").value = description;
    document.getElementById("selectEditStatus").value = isFinished === 't' || isFinished === '1' ? '1' : '0';
    
    var myModal = new bootstrap.Modal(document.getElementById("editTodo"));
    myModal.show();
}

// Show modal delete
function showModalDeleteTodo(todoId, title) {
    document.getElementById("deleteTodoTitle").innerText = title;
    document.getElementById("btnDeleteTodo").setAttribute("href", `?page=delete&id=${todoId}`);
    
    var myModal = new bootstrap.Modal(document.getElementById("deleteTodo"));
    myModal.show();
}
</script>
</body>
</html>