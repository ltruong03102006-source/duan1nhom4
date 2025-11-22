<style>
    /* CSS đồng bộ với các form khác */
    :root {
        --primary-color: #2563eb;
        --primary-hover: #1d4ed8;
        --bg-color: #f1f5f9;
        --card-bg: #ffffff;
        --text-main: #1e293b;
        --border-color: #e2e8f0;
        --success-color: #10b981;
        --danger-color: #ef4444;
        --warning-color: #f59e0b;
    }
    .form-container {
        max-width: 900px;
        margin: 40px auto;
        padding: 30px;
        background: var(--card-bg);
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
    h2 { color: var(--warning-color); text-align: center; margin-bottom: 25px; font-size: 24px; }
    .doan-info { background: #e0f2f1; padding: 15px; border-radius: 6px; margin-bottom: 20px; border-left: 5px solid var(--success-color); }
    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; margin-bottom: 5px; font-weight: 500; color: var(--text-main); }
    .form-control, .form-select {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid var(--border-color);
        border-radius: 4px;
        font-size: 14px;
        transition: border-color 0.2s;
    }
    .form-row { display: flex; gap: 15px; }
    .form-row .form-group { flex: 1; }
    .form-actions { margin-top: 25px; display: flex; justify-content: flex-end; gap: 10px; }
    .btn { padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; }
    .btn-primary { background-color: var(--warning-color); color: white; }
    .btn-primary:hover { background-color: #d97706; }
    .btn-secondary { background-color: #6c757d; color: white; }
    .required { color: var(--danger-color); }
    .calc-info { font-size: 12px; color: var(--text-secondary); margin-top: 5px; }
</style>

<div class="form-container">
    <h2><i class="fas fa-edit me-1"></i> Sửa Dịch Vụ Cho Đoàn</h2>

    <div class="doan-info">
        <p><strong>Tour:</strong> <?= htmlspecialchars($doan['TenTour']) ?> (<?= htmlspecialchars($doan['MaCodeTour']) ?>)</p>
        <p><strong>Mã Dịch Vụ:</strong> <?= htmlspecialchars($dichVu['MaDichVu']) ?></p>
    </div>

    <form action="?act=editDichVuProcess" method="POST">
        <input type="hidden" name="MaDichVu" value="<?= $dichVu['MaDichVu'] ?>">
        <input type="hidden" name="MaDoan" value="<?= $dichVu['MaDoan'] ?>">

        <div class="form-row">
            <div class="form-group">
                <label>Loại Dịch Vụ <span class="required">*</span></label>
                <select name="LoaiDichVu" class="form-select" required>
                    <?php 
                    $options = ['van_chuyen', 'khach_san', 'nha_hang', 've_tham_quan', 'huong_dan_vien', 'bao_hiem', 'khac'];
                    foreach ($options as $opt): ?>
                        <option value="<?= $opt ?>" <?= $dichVu['LoaiDichVu'] == $opt ? 'selected' : '' ?>>
                            <?= ucfirst(str_replace('_', ' ', $opt)) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Nhà Cung Cấp</label>
                <select name="MaNhaCungCap" class="form-select">
                    <option value="">-- Chọn NCC (Nếu có) --</option>
                    <?php foreach ($listNhaCungCap as $ncc): ?>
                        <option value="<?= $ncc['MaNhaCungCap'] ?>" <?= $dichVu['MaNhaCungCap'] == $ncc['MaNhaCungCap'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($ncc['TenNhaCungCap']) ?> (<?= htmlspecialchars($ncc['LoaiNhaCungCap']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        
        <div class="form-group">
            <label>Tên Dịch Vụ <span class="required">*</span></label>
            <input type="text" name="TenDichVu" class="form-control" value="<?= htmlspecialchars($dichVu['TenDichVu']) ?>" required>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label>Ngày Sử Dụng <span class="required">*</span></label>
                <input type="date" name="NgaySuDung" class="form-control" value="<?= $dichVu['NgaySuDung'] ?>" required>
            </div>
            <div class="form-group">
                <label>Ngày Đặt</label>
                <input type="date" name="NgayDat" class="form-control" value="<?= $dichVu['NgayDat'] ?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Số Lượng <span class="required">*</span></label>
                <input type="number" name="SoLuong" id="soLuong" class="form-control" min="1" value="<?= $dichVu['SoLuong'] ?>" required oninput="calculateTotal()">
            </div>
            <div class="form-group">
                <label>Đơn Giá (VNĐ) <span class="required">*</span></label>
                <input type="number" name="DonGia" id="donGia" class="form-control" min="0" step="1000" value="<?= $dichVu['DonGia'] ?>" required oninput="calculateTotal()">
                <div id="tongTienDisplay" class="calc-info">Tổng tiền: <?= number_format($dichVu['TongTien']) ?> đ</div>
            </div>
        </div>
        
        <div class="form-group">
            <label>Trạng Thái Xác Nhận <span class="required">*</span></label>
            <select name="TrangThaiXacNhan" class="form-select" required>
                <option value="cho_xac_nhan" <?= $dichVu['TrangThaiXacNhan'] == 'cho_xac_nhan' ? 'selected' : '' ?>>Chờ xác nhận</option>
                <option value="da_xac_nhan" <?= $dichVu['TrangThaiXacNhan'] == 'da_xac_nhan' ? 'selected' : '' ?>>Đã xác nhận</option>
                <option value="da_huy" <?= $dichVu['TrangThaiXacNhan'] == 'da_huy' ? 'selected' : '' ?>>Đã hủy</option>
            </select>
        </div>

        <div class="form-group">
            <label>Ghi Chú</label>
            <textarea name="GhiChu" class="form-control" rows="3"><?= htmlspecialchars($dichVu['GhiChu'] ?? '') ?></textarea>
        </div>

        <div class="form-actions">
            <a href="?act=listDichVu&maDoan=<?= $dichVu['MaDoan'] ?>" class="btn btn-secondary">
                <i class="fas fa-times"></i> Hủy
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Cập Nhật Dịch Vụ
            </button>
        </div>
    </form>
</div>

<script>
    function formatCurrency(amount) {
        return amount.toLocaleString('vi-VN') + ' đ';
    }

    function calculateTotal() {
        const soLuong = parseInt(document.getElementById('soLuong').value) || 0;
        const donGia = parseFloat(document.getElementById('donGia').value) || 0;
        const tongTien = soLuong * donGia;
        
        document.getElementById('tongTienDisplay').innerText = 'Tổng tiền: ' + formatCurrency(tongTien);
    }
    
    document.addEventListener('DOMContentLoaded', calculateTotal);
</script>