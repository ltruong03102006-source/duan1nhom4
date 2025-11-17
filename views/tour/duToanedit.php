<style>
    .dutoan-form-container {
        max-width: 800px;
        margin: 20px auto;
        padding: 30px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .dutoan-form-container h1 {
        color: #333;
        margin-bottom: 20px;
        font-size: 28px;
    }
    .tour-info {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
        color: white;
    }
    .tour-info p {
        margin: 5px 0;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: #555;
        font-size: 15px;
    }
    .form-group input, 
    .form-group select, 
    .form-group textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
        transition: border-color 0.3s;
    }
    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #ffc107;
    }
    .form-group textarea {
        resize: vertical;
        min-height: 100px;
    }
    .btn {
        padding: 12px 30px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
        margin-right: 10px;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s;
    }
    .btn-primary {
        background-color: #ffc107;
        color: black;
    }
    .btn-primary:hover {
        background-color: #e0a800;
    }
    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }
    .btn-secondary:hover {
        background-color: #545b62;
    }
    .form-actions {
        margin-top: 30px;
        display: flex;
        gap: 10px;
    }
    .required {
        color: red;
    }
    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 5px;
    }
    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    .help-text {
        font-size: 13px;
        color: #6c757d;
        margin-top: 5px;
    }
</style>

<div class="dutoan-form-container">
    <h1>✏️ Cập Nhật Dự Toán Chi Phí</h1>
    
    <div class="tour-info">
        <p><strong>Mã Code:</strong> <?= htmlspecialchars($duToan['MaCodeTour']) ?></p>
        <p><strong>Tour:</strong> <?= htmlspecialchars($duToan['TenTour']) ?></p>
    </div>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger">
            ❌ Có lỗi xảy ra khi cập nhật! Vui lòng thử lại.
        </div>
    <?php endif; ?>
    
    <form action="?act=editDuToanProcess" method="POST">
        <input type="hidden" name="maDuToan" value="<?= $duToan['MaDuToan'] ?>">
        <input type="hidden" name="maTour" value="<?= $duToan['MaTour'] ?>">

        <div class="form-group">
            <label>Hạng Mục Chi <span class="required">*</span></label>
            <input type="text" name="hangMucChi" value="<?= htmlspecialchars($duToan['HangMucChi']) ?>" required placeholder="VD: Vận chuyển - Xe khách 45 chỗ">
            <div class="help-text">Nhập tên hạng mục chi phí (vận chuyển, ăn uống, lưu trú...)</div>
        </div>

        <div class="form-group">
            <label>Số Tiền Dự Kiến (VNĐ/khách) <span class="required">*</span></label>
            <input type="number" name="soTienDuKien" value="<?= $duToan['SoTienDuKien'] ?>" min="0" step="1000" required placeholder="VD: 300000">
            <div class="help-text">Chi phí dự kiến cho 1 khách tham gia tour</div>
        </div>

        <div class="form-group">
            <label>Ghi Chú</label>
            <textarea name="ghiChu" placeholder="Nhập ghi chú, mô tả chi tiết về hạng mục chi này..."><?= htmlspecialchars($duToan['GhiChu'] ?? '') ?></textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">💾 Cập Nhật</button>
            <a href="?act=duToanChiPhi&maTour=<?= $duToan['MaTour'] ?>" class="btn btn-secondary">❌ Hủy</a>
        </div>
    </form>
</div>