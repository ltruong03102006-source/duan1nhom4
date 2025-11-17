<style>
    .gia-tour-form-container {
        max-width: 800px;
        margin: 20px auto;
        padding: 30px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .gia-tour-form-container h1 {
        color: #333;
        margin-bottom: 30px;
    }
    .tour-info {
        background: #e8f4f8;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
        color: #555;
    }
    .form-group input, 
    .form-group select, 
    .form-group textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
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
    }
    .btn-primary {
        background-color: #ffc107;
        color: black;
    }
    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }
    .btn:hover {
        opacity: 0.8;
    }
    .form-actions {
        margin-top: 30px;
        display: flex;
        gap: 10px;
    }
    .required {
        color: red;
    }
    .row {
        display: flex;
        gap: 20px;
    }
    .col {
        flex: 1;
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
</style>

<div class="gia-tour-form-container">
    <h1>Cập Nhật Giá Tour</h1>
    
    <div class="tour-info">
        <strong>Tour:</strong> <?= htmlspecialchars($giaTour['TenTour']) ?>
    </div>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger">
            Có lỗi xảy ra khi cập nhật! Vui lòng thử lại.
        </div>
    <?php endif; ?>
    
    <form action="?act=editGiaTourProcess" method="POST">
        <input type="hidden" name="maGia" value="<?= $giaTour['MaGia'] ?>">
        <input type="hidden" name="maTour" value="<?= $giaTour['MaTour'] ?>">

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label>Loại Khách <span class="required">*</span></label>
                    <select name="loaiKhach" required>
                        <option value="">-- Chọn loại khách --</option>
                        <option value="nguoi_lon" <?= $giaTour['LoaiKhach'] == 'nguoi_lon' ? 'selected' : '' ?>>Người lớn</option>
                        <option value="tre_em" <?= $giaTour['LoaiKhach'] == 'tre_em' ? 'selected' : '' ?>>Trẻ em</option>
                        <option value="em_be" <?= $giaTour['LoaiKhach'] == 'em_be' ? 'selected' : '' ?>>Em bé</option>
                    </select>
                </div>
            </div>
            
            <div class="col">
                <div class="form-group">
                    <label>Giá Tiền (VNĐ) <span class="required">*</span></label>
                    <input type="number" name="giaTien" min="0" step="1000" value="<?= $giaTour['GiaTien'] ?>" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label>Áp Dụng Từ Ngày</label>
                    <input type="date" name="apDungTuNgay" value="<?= $giaTour['ApDungTuNgay'] ?>">
                </div>
            </div>
            
            <div class="col">
                <div class="form-group">
                    <label>Áp Dụng Đến Ngày</label>
                    <input type="date" name="apDungDenNgay" value="<?= $giaTour['ApDungDenNgay'] ?>">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>Loại Mùa</label>
            <select name="loaiMua">
                <option value="binh_thuong" <?= $giaTour['LoaiMua'] == 'binh_thuong' ? 'selected' : '' ?>>Bình thường</option>
                <option value="cao_diem" <?= $giaTour['LoaiMua'] == 'cao_diem' ? 'selected' : '' ?>>Cao điểm</option>
                <option value="thap_diem" <?= $giaTour['LoaiMua'] == 'thap_diem' ? 'selected' : '' ?>>Thấp điểm</option>
            </select>
        </div>

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label>Tên Khuyến Mãi</label>
                    <input type="text" name="tenKhuyenMai" value="<?= htmlspecialchars($giaTour['TenKhuyenMai'] ?? '') ?>" placeholder="VD: Khuyến mãi mùa hè">
                </div>
            </div>
            
            <div class="col">
                <div class="form-group">
                    <label>Phần Trăm Giảm Giá (%)</label>
                    <input type="number" name="phanTramGiamGia" min="0" max="100" step="0.01" value="<?= $giaTour['PhanTramGiamGia'] ?>">
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Cập Nhật</button>
            <a href="?act=giaTour&maTour=<?= $giaTour['MaTour'] ?>" class="btn btn-secondary">Hủy</a>
        </div>
    </form>
</div>