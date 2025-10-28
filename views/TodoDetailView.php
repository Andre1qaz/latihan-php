<!DOCTYPE html>
<html>
<head>
    <title>Detail Todo - PHP Todo App</title>
    <link href="/assets/vendor/bootstrap-5.3.8-dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        body { 
            background: linear-gradient(135deg, #667eea 0%, #4b86a2ff 100%); 
            min-height: 100vh;
            padding: 40px 0;
        }
        .card { 
            border: none; 
            border-radius: 20px; 
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
            overflow: hidden;
            animation: fadeInUp 0.5s ease-out;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .card-header { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border: none;
        }
        .card-header h1 {
            margin: 0;
            font-size: 2rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .card-body {
            padding: 40px;
            background: white;
        }
        .detail-section {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 20px;
        }
        .detail-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 3px solid #667eea;
        }
        .info-row {
            display: flex;
            align-items: flex-start;
            padding: 15px 0;
            border-bottom: 1px solid #e9ecef;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: 600;
            color: #667eea;
            min-width: 150px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1rem;
        }
        .info-value {
            flex: 1;
            color: #495057;
            font-size: 1rem;
            line-height: 1.6;
        }
        .badge {
            font-size: 0.9rem;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 500;
        }
        .btn {
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
        }
        .btn-secondary {
            background: linear-gradient(45deg, #6c757d, #5a6268);
        }
        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(108, 117, 125, 0.3);
        }
        .btn-primary {
            background: linear-gradient(45deg, #667eea, #764ba2);
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }
        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            padding-top: 25px;
            border-top: 2px solid #e9ecef;
        }
        .description-box {
            background: white;
            border-radius: 10px;
            padding: 20px;
            border-left: 4px solid #667eea;
            min-height: 80px;
        }
        .timestamp-box {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
        }
        .timestamp-item {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }
        .timestamp-item:last-child {
            margin-bottom: 0;
        }
        .timestamp-item i {
            color: #667eea;
            font-size: 1.1rem;
        }
    </style>
</head>
<body>
<div class="container" style="max-width: 900px;">
    <div class="card">
        <div class="card-header">
            <h1>
                <i class="fas fa-clipboard-list"></i>
                Detail Todo
            </h1>
        </div>
        <div class="card-body">
            <div class="detail-section">
                <div class="detail-title">
                    <?php echo htmlspecialchars($todo['title']); ?>
                </div>
                
                <div class="info-row">
                    <div class="info-label">
                        <i class="fas fa-info-circle"></i>
                        Status
                    </div>
                    <div class="info-value">
                        <?php if ($todo['is_finished']): ?>
                            <span class="badge bg-success">
                                <i class="fas fa-check-circle"></i> Selesai
                            </span>
                        <?php else: ?>
                            <span class="badge bg-warning text-dark">
                                <i class="fas fa-clock"></i> Belum Selesai
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">
                        <i class="fas fa-align-left"></i>
                        Deskripsi
                    </div>
                    <div class="info-value">
                        <div class="description-box">
                            <?php echo $todo['description'] ? nl2br(htmlspecialchars($todo['description'])) : '<em class="text-muted">Tidak ada deskripsi</em>'; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="timestamp-box">
                <div class="timestamp-item">
                    <i class="fas fa-calendar-plus"></i>
                    <strong>Dibuat:</strong>
                    <span><?php echo date('d F Y - H:i', strtotime($todo['created_at'])); ?></span>
                </div>
                <div class="timestamp-item">
                    <i class="fas fa-calendar-check"></i>
                    <strong>Terakhir Diubah:</strong>
                    <span><?php echo date('d F Y - H:i', strtotime($todo['updated_at'])); ?></span>
                </div>
            </div>

            <div class="action-buttons">
                <a href="index.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <a href="?page=index&edit=<?php echo $todo['id']; ?>" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Edit Todo
                </a>
            </div>
        </div>
    </div>
</div>
<script src="/assets/vendor/bootstrap-5.3.8-dist/js/bootstrap.min.js"></script>
</body>
</html>