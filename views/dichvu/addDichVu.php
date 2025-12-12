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
    }
    .form-container {
        max-width: 900px;
        margin: 40px auto;
        padding: 30px;
        background: var(--card-bg);
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
    h2 { color: var(--primary-color); text-align: center; margin-bottom: 25px; font-size: 24px; }
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
    .btn-primary { background-color: var(--success-color); color: white; }
    .btn-primary:hover { background-color: #0b9e6f; }
    .btn-secondary { background-color: #6c757d; color: white; }
    .required { color: var(--danger-color); }
    .calc-info { font-size: 12px; color: var(--text-secondary); margin-top: 5px; }
</style>

<div class="form-container">
    <h2><i class="fas fa-plus-circle me-1"></i> Thêm Dịch Vụ Cho Đoàn</h2>

    <div class="doan-info">
        <p><strong>Tour:</strong> <?= htmlspecialchars($doan['TenTour']) ?> (<?= htmlspecialchars($doan['MaCodeTour']) ?>)</p>
        <p><strong>Ngày khởi hành:</strong> <?= date('d/m/Y', strtotime($doan['NgayKhoiHanh'])) ?></p>
    </div>

    <form action="?act=addDichVuProcess" method="POST">
        <input type="hidden" name="MaDoan" value="<?= $doan['MaDoan'] ?>">

        <div class="form-row">
            <div class="form-group">
                <label>Nhà Cung Cấp</label>
                <select name="MaNhaCungCap" id="MaNhaCungCap" class="form-select" onchange="capNhatLoaiDichVu()">
                    <option value="" data-dichvu="">-- Chọn NCC (Nếu có) --</option>
                    <?php foreach ($listNhaCungCap as $ncc): ?>
                        <option value="<?= $ncc['MaNhaCungCap'] ?>" 
                                data-dichvu="<?= htmlspecialchars($ncc['LoaiNhaCungCap']) ?>">
                            <?= htmlspecialchars($ncc['TenNhaCungCap']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label>Loại Dịch Vụ <span class="required">*</span></label>
                <select name="LoaiDichVu" id="LoaiDichVu" class="form-select" required>
                    <option value="">-- Vui lòng chọn NCC trước --</option>
                </select>
            </div>
        </div>
        
        <div class="form-group">
            <label>Tên Dịch Vụ <span class="required">*</span></label>
            <input type="text" name="TenDichVu" class="form-control" required placeholder="VD: Bữa trưa tại Nhà hàng ABC">
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label>Ngày Sử Dụng <span class="required">*</span></label>
                <input type="date" name="NgaySuDung" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Ngày Đặt</label>
                <input type="date" name="NgayDat" class="form-control">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Số Lượng <span class="required">*</span></label>
                <input type="number" name="SoLuong" id="soLuong" class="form-control" min="1" value="1" required oninput="calculateTotal()">
            </div>
            <div class="form-group">
                <label>Đơn Giá (VNĐ) <span class="required">*</span></label>
                <input type="number" name="DonGia" id="donGia" class="form-control" min="0" step="1000" required value="0" oninput="calculateTotal()">
                <div id="tongTienDisplay" class="calc-info">Tổng tiền: 0 đ</div>
            </div>
        </div>
        
        <div class="form-group">
            <label>Trạng Thái Xác Nhận <span class="required">*</span></label>
            <select name="TrangThaiXacNhan" class="form-select" required>
                <option value="cho_xac_nhan">Chờ xác nhận</option>
                <option value="da_xac_nhan">Đã xác nhận</option>
                <option value="da_huy">Đã hủy</option>
            </select>
        </div>

        <div class="form-group">
            <label>Ghi Chú</label>
            <textarea name="GhiChu" class="form-control" rows="3"></textarea>
        </div>

        <div class="form-actions">
            <a href="?act=listDichVu&maDoan=<?= $doan['MaDoan'] ?>" class="btn btn-secondary">
                <i class="fas fa-times"></i> Hủy
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Thêm Dịch Vụ
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

    // Danh sách map từ database sang tiếng Việt hiển thị
    const danhSachDichVu = {
        'van_chuyen': 'Vận chuyển',
        'khach_san': 'Khách sạn',
        'nha_hang': 'Nhà hàng',
        've_tham_quan': 'Vé tham quan',
        'huong_dan_vien': 'Hướng dẫn viên',
        'bao_hiem': 'Bảo hiểm',
        'visa': 'Visa / Hộ chiếu',
        'khac': 'Khác'
    };

    function capNhatLoaiDichVu() {
        const selectNCC = document.getElementById('MaNhaCungCap');
        const selectDichVu = document.getElementById('LoaiDichVu');
        
        // Lấy option đang được chọn
        const selectedOption = selectNCC.options[selectNCC.selectedIndex];
        const rawDichVu = selectedOption.getAttribute('data-dichvu');
        
        // Reset option
        selectDichVu.innerHTML = '';

        if (!rawDichVu || selectNCC.value === "") {
            // Không có NCC hoặc NCC ko có dữ liệu -> Hiện tất cả
            selectDichVu.innerHTML += '<option value="">-- Chọn loại dịch vụ --</option>';
            for (const [key, label] of Object.entries(danhSachDichVu)) {
                selectDichVu.innerHTML += `<option value="${key}">${label}</option>`;
            }
        } else {
            // Có NCC -> Lọc
            const dichVuArr = rawDichVu.split(',');
            selectDichVu.innerHTML += '<option value="">-- Chọn dịch vụ của NCC này --</option>';
            
            dichVuArr.forEach(key => {
                key = key.trim();
                if (danhSachDichVu[key]) {
                    selectDichVu.innerHTML += `<option value="${key}">${danhSachDichVu[key]}</option>`;
                }
            });
            // Luôn thêm "Khác" để dự phòng
            selectDichVu.innerHTML += `<option value="khac">Khác (Ngoài danh mục)</option>`;
        }
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        calculateTotal();
        capNhatLoaiDichVu(); // Chạy lần đầu để load danh sách đầy đủ (vì mặc định chưa chọn NCC)
    });
</script>