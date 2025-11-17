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
        margin-bottom: 30px;
        font-size: 28px;
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
        border-color: #007bff;
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
        background-color: #28a745;
        color: white;
    }
    .btn-primary:hover {
        background-color: #218838;
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
    .help-text {
        font-size: 13px;
        color: #6c757d;
        margin-top: 5px;
    }
    .hang-muc-examples {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
    }
    .hang-muc-examples h4 {
        margin: 0 0 10px 0;
        color: #333;
        font-size: 14px;
    }
    .hang-muc-examples ul {
        margin: 0;
        padding-left: 20px;
    }
    .hang-muc-examples li {
        font-size: 13px;
        color: #555;
        margin: 3px 0;
    }
</style>

<div class="dutoan-form-container">
    <h1>📝 Thêm Dự Toán Chi Phí Mới</h1>
    
    <div class="hang-muc-examples">
        <h4>💡 Các hạng mục chi thường gặp:</h4>
        <ul>
            <li><strong>Vận chuyển:</strong> Xe khách, xăng dầu, phí đường, vé máy bay...</li>
            <li><strong>Ăn uống:</strong> Bữa sáng, trưa, tối, nước uống...</li>
            <li><strong>Lưu trú:</strong> Khách sạn, resort, homestay...</li>
            <li><strong>Vé tham quan:</strong> Vé các điểm du lịch, cáp treo, thuyền...</li>
            <li><strong>Nhân sự:</strong> Lương HDV, tài xế, tiền tip...</li>
            <li><strong>Khác:</strong> Bảo hiểm, chi phí phát sinh...</li>
        </ul>
    </div>
    
    <form action="?act=addDuToanProcess" method="POST">
        <input type="hidden" name="maTour" value="<?= $_GET['maTour'] ?>">
        
        <div class="form-group">
            <label>Tour <span class="required">*</span></label>
            <select name="maTour" disabled>
                <?php foreach ($danhSachTour as $tour): ?>
                    <option value="<?= $tour['MaTour'] ?>" <?= $tour['MaTour'] == $_GET['maTour'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($tour['MaCodeTour'] . ' - ' . $tour['TenTour']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Hạng Mục Chi <span class="required">*</span></label>
            <input type="text" name="hangMucChi" required placeholder="VD: Vận chuyển - Xe khách 45 chỗ">
            <div class="help-text">Nhập tên hạng mục chi phí (vận chuyển, ăn uống, lưu trú...)</div>
        </div>

        <div class="form-group">
            <label>Số Tiền Dự Kiến (VNĐ/khách) <span class="required">*</span></label>
            <input type="number" name="soTienDuKien" min="0" step="1000" required placeholder="VD: 300000">
            <div class="help-text">Chi phí dự kiến cho 1 khách tham gia tour</div>
        </div>

        <div class="form-group">
            <label>Ghi Chú</label>
            <textarea name="ghiChu" placeholder="Nhập ghi chú, mô tả chi tiết về hạng mục chi này..."></textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">✅ Thêm Dự Toán</button>
            <a href="?act=duToanChiPhi&maTour=<?= $_GET['maTour'] ?>" class="btn btn-secondary">❌ Hủy</a>
        </div>
    </form>
</div>