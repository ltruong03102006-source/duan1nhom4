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
        background-color: #007bff;
        color: white;
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
</style>

<div class="gia-tour-form-container">
    <h1>Thêm Giá Tour Mới</h1>
    
    <form action="?act=addGiaTourProcess" method="POST">
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

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label>Loại Khách <span class="required">*</span></label>
                    <select name="loaiKhach" required>
                        <option value="">-- Chọn loại khách --</option>
                        <option value="nguoi_lon">Người lớn</option>
                        <option value="tre_em">Trẻ em</option>
                        <option value="em_be">Em bé</option>
                    </select>
                </div>
            </div>
            
            <div class="col">
                <div class="form-group">
                    <label>Giá Tiền (VNĐ) <span class="required">*</span></label>
                    <input type="number" name="giaTien" min="0" step="1000" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label>Áp Dụng Từ Ngày</label>
                    <input type="date" name="apDungTuNgay">
                </div>
            </div>
            
            <div class="col">
                <div class="form-group">
                    <label>Áp Dụng Đến Ngày</label>
                    <input type="date" name="apDungDenNgay">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>Loại Mùa</label>
            <select name="loaiMua">
                <option value="binh_thuong">Bình thường</option>
                <option value="cao_diem">Cao điểm</option>
                <option value="thap_diem">Thấp điểm</option>
            </select>
        </div>

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label>Tên Khuyến Mãi</label>
                    <input type="text" name="tenKhuyenMai" placeholder="VD: Khuyến mãi mùa hè">
                </div>
            </div>
            
            <div class="col">
                <div class="form-group">
                    <label>Phần Trăm Giảm Giá (%)</label>
                    <input type="number" name="phanTramGiamGia" min="0" max="100" step="0.01" value="0">
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Thêm Giá Tour</button>
            <a href="?act=giaTour&maTour=<?= $_GET['maTour'] ?>" class="btn btn-secondary">Hủy</a>
        </div>
    </form>
</div>