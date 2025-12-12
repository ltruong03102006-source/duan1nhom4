<style>
    :root {
        --primary-color: #2563eb;
        --success-color: #10b981;
        --danger-color: #ef4444;
        --border-color: #e2e8f0;
    }
    .form-container {
        max-width: 1000px; /* Tăng chiều rộng để chứa bảng */
        margin: 40px auto;
        padding: 30px;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
    h2 { color: var(--primary-color); text-align: center; margin-bottom: 25px; }
    .doan-info { background: #e0f2f1; padding: 15px; border-radius: 6px; margin-bottom: 20px; border-left: 5px solid var(--success-color); }
    .common-section { background: #f8fafc; padding: 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid var(--border-color); }
    .table-responsive { overflow-x: auto; }
    .table th { white-space: nowrap; background-color: #f1f5f9; }
    .table td { vertical-align: middle; }
    .form-control, .form-select { font-size: 14px; }
    .btn-remove { color: var(--danger-color); cursor: pointer; }
</style>

<div class="form-container">
    <h2><i class="fas fa-plus-circle me-1"></i> Thêm Dịch Vụ Cho Đoàn (Nhiều dòng)</h2>

    <div class="doan-info">
        <p><strong>Tour:</strong> <?= htmlspecialchars($doan['TenTour']) ?> (<?= htmlspecialchars($doan['MaCodeTour']) ?>)</p>
        <p><strong>Ngày khởi hành:</strong> <?= date('d/m/Y', strtotime($doan['NgayKhoiHanh'])) ?></p>
    </div>

    <form action="?act=addDichVuProcess" method="POST" id="formAddDichVu">
        <input type="hidden" name="MaDoan" value="<?= $doan['MaDoan'] ?>">

        <div class="common-section">
            <h5 class="mb-3 text-primary"><i class="fas fa-info-circle"></i> Thông tin chung</h5>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Nhà Cung Cấp</label>
                    <select name="MaNhaCungCap" id="MaNhaCungCap" class="form-select" onchange="capNhatLoaiDichVuChoTatCaDong()">
                        <option value="" data-dichvu="">-- Chọn NCC --</option>
                        <?php foreach ($listNhaCungCap as $ncc): ?>
                            <option value="<?= $ncc['MaNhaCungCap'] ?>" 
                                    data-dichvu="<?= htmlspecialchars($ncc['LoaiNhaCungCap']) ?>">
                                <?= htmlspecialchars($ncc['TenNhaCungCap']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Ngày Đặt</label>
                    <input type="date" name="NgayDat" class="form-control" value="<?= date('Y-m-d') ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Trạng Thái</label>
                    <select name="TrangThaiXacNhan" class="form-select">
                        <option value="cho_xac_nhan">Chờ xác nhận</option>
                        <option value="da_xac_nhan">Đã xác nhận</option>
                    </select>
                </div>
            </div>
        </div>

        <h5 class="mb-3 text-primary"><i class="fas fa-list"></i> Danh sách dịch vụ chi tiết</h5>
        <div class="table-responsive">
            <table class="table table-bordered" id="tableDichVu">
                <thead>
                    <tr>
                        <th style="width: 15%">Loại DV <span class="text-danger">*</span></th>
                        <th style="width: 20%">Tên Dịch Vụ <span class="text-danger">*</span></th>
                        <th style="width: 12%">Ngày dùng <span class="text-danger">*</span></th>
                        <th style="width: 10%">SL <span class="text-danger">*</span></th>
                        <th style="width: 15%">Đơn Giá</th>
                        <th style="width: 15%">Thành Tiền</th>
                        <th style="width: 5%">Xóa</th>
                    </tr>
                </thead>
                <tbody id="tbodyDichVu">
                    <tr class="service-row">
                        <td>
                            <select name="LoaiDichVu[]" class="form-select loai-dich-vu-select" required>
                                <option value="">-- Chọn --</option>
                            </select>
                        </td>
                        <td>
                            <input type="text" name="TenDichVu[]" class="form-control" required placeholder="Tên dịch vụ">
                        </td>
                        <td>
                            <input type="date" name="NgaySuDung[]" class="form-control" required>
                        </td>
                        <td>
                            <input type="number" name="SoLuong[]" class="form-control so-luong" min="1" value="1" required oninput="tinhTongTienRow(this)">
                        </td>
                        <td>
                            <input type="number" name="DonGia[]" class="form-control don-gia" min="0" value="0" required oninput="tinhTongTienRow(this)">
                        </td>
                        <td>
                            <input type="text" class="form-control thanh-tien" readonly value="0">
                            <input type="hidden" name="GhiChu[]" value=""> 
                        </td>
                        <td class="text-center">
                            <i class="fas fa-trash-alt btn-remove" onclick="xoaDong(this)"></i>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mb-4">
            <button type="button" class="btn btn-success btn-sm" onclick="themDongMoi()">
                <i class="fas fa-plus"></i> Thêm dòng dịch vụ
            </button>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="?act=listDichVu&maDoan=<?= $doan['MaDoan'] ?>" class="btn btn-secondary">Hủy bỏ</a>
            <button type="submit" class="btn btn-primary">Lưu tất cả</button>
        </div>
    </form>
</div>

<script>
    // 1. Danh sách loại dịch vụ map
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

    // 2. Hàm lấy danh sách option dựa trên NCC đang chọn
    function getOptionsForSelect() {
        const selectNCC = document.getElementById('MaNhaCungCap');
        const selectedOption = selectNCC.options[selectNCC.selectedIndex];
        const rawDichVu = selectedOption.getAttribute('data-dichvu');
        
        let html = '<option value="">-- Chọn --</option>';

        if (!rawDichVu || selectNCC.value === "") {
            // Nếu không có NCC hoặc NCC ko có loại -> Hiện full
            for (const [key, label] of Object.entries(danhSachDichVu)) {
                html += `<option value="${key}">${label}</option>`;
            }
        } else {
            // Lọc theo NCC
            const dichVuArr = rawDichVu.split(',');
            dichVuArr.forEach(key => {
                key = key.trim();
                if (danhSachDichVu[key]) {
                    html += `<option value="${key}">${danhSachDichVu[key]}</option>`;
                }
            });
            html += `<option value="khac">Khác</option>`;
        }
        return html;
    }

    // 3. Cập nhật lại tất cả các dòng khi đổi NCC (Reset lại select box)
    function capNhatLoaiDichVuChoTatCaDong() {
        const optionsHtml = getOptionsForSelect();
        const selects = document.querySelectorAll('.loai-dich-vu-select');
        selects.forEach(sel => {
            sel.innerHTML = optionsHtml;
        });
    }

    // 4. Thêm dòng mới
    function themDongMoi() {
        const tbody = document.getElementById('tbodyDichVu');
        const newRow = document.createElement('tr');
        newRow.className = 'service-row';
        
        // Lấy options hiện tại
        const optionsHtml = getOptionsForSelect();

        newRow.innerHTML = `
            <td>
                <select name="LoaiDichVu[]" class="form-select loai-dich-vu-select" required>
                    ${optionsHtml}
                </select>
            </td>
            <td><input type="text" name="TenDichVu[]" class="form-control" required placeholder="Tên dịch vụ"></td>
            <td><input type="date" name="NgaySuDung[]" class="form-control" required></td>
            <td><input type="number" name="SoLuong[]" class="form-control so-luong" min="1" value="1" required oninput="tinhTongTienRow(this)"></td>
            <td><input type="number" name="DonGia[]" class="form-control don-gia" min="0" value="0" required oninput="tinhTongTienRow(this)"></td>
            <td>
                <input type="text" class="form-control thanh-tien" readonly value="0">
                <input type="hidden" name="GhiChu[]" value="">
            </td>
            <td class="text-center"><i class="fas fa-trash-alt btn-remove" onclick="xoaDong(this)"></i></td>
        `;
        tbody.appendChild(newRow);
    }

    // 5. Xóa dòng
    function xoaDong(btn) {
        const tbody = document.getElementById('tbodyDichVu');
        if (tbody.rows.length > 1) {
            btn.closest('tr').remove();
        } else {
            alert('Cần ít nhất một dòng dịch vụ!');
        }
    }

    // 6. Tính tiền từng dòng
    function tinhTongTienRow(input) {
        const row = input.closest('tr');
        const soLuong = parseFloat(row.querySelector('.so-luong').value) || 0;
        const donGia = parseFloat(row.querySelector('.don-gia').value) || 0;
        const thanhTien = soLuong * donGia;
        row.querySelector('.thanh-tien').value = thanhTien.toLocaleString('vi-VN');
    }

    // Khởi chạy ban đầu
    document.addEventListener('DOMContentLoaded', function() {
        capNhatLoaiDichVuChoTatCaDong();
    });
</script>