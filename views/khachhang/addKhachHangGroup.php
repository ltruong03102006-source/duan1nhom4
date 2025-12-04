<style>
    .wrap { max-width: 1200px; margin: 0 auto; }
    table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 8px; overflow: hidden; }
    th, td { padding: 10px; border-bottom: 1px solid #e5e7eb; }
    th { background: #2563eb; color: #fff; text-align: left; }
    tr:nth-child(even) { background: #f8fafc; }
    .btn { padding: 8px 14px; border: 0; border-radius: 6px; cursor: pointer; }
    .btn-add { background: #10b981; color: #fff; }
    .btn-del { background: #ef4444; color: #fff; }
    .btn-save { background: #2563eb; color: #fff; }
    input, select { width: 100%; padding: 8px 10px; border: 1px solid #e2e8f0; border-radius: 6px; }
</style>

<div class="container-fluid px-4 wrap">
    <h1 class="mt-4">Thêm Nhóm Khách Hàng</h1>

    <div class="card mb-4">
        <div class="card-header">Nhập nhiều khách cùng lúc</div>
        <div class="card-body">

            <form action="?act=addKhachHangGroupProcess" method="POST" id="groupForm">
                <div style="display:flex; gap:10px; margin-bottom:12px;">
                    <button type="button" class="btn btn-add" onclick="addRow()">+ Thêm dòng</button>
                    <button type="submit" class="btn btn-save">Lưu nhóm khách</button>
                    <a href="?act=listKhachHang" class="btn" style="background:#6c757d;color:#fff;text-decoration:none;display:inline-flex;align-items:center;">Quay lại</a>
                </div>

                <div style="overflow-x:auto;">
                    <table id="khachTable">
                        <thead>
                            <tr>
                                <th style="width:140px;">Mã Code</th>
                                <th style="min-width:200px;">Họ tên *</th>
                                <th style="width:150px;">SĐT *</th>
                                <th style="min-width:200px;">Email</th>
                                <th style="width:120px;">Giới tính</th>
                                <th style="width:140px;">Ngày sinh</th>
                                <th style="width:140px;">Loại khách</th>
                                <th style="width:90px;">Xóa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i=0; $i<5; $i++): ?>
                                <tr>
                                    <td><input name="khach[<?= $i ?>][MaCodeKhachHang]" placeholder="KH001..."></td>
                                    <td><input name="khach[<?= $i ?>][HoTen]" required></td>
                                    <td><input name="khach[<?= $i ?>][SoDienThoai]" required></td>
                                    <td><input type="email" name="khach[<?= $i ?>][Email]"></td>
                                    <td>
                                        <select name="khach[<?= $i ?>][GioiTinh]">
                                            <option value="nam">Nam</option>
                                            <option value="nu">Nữ</option>
                                            <option value="khac" selected>Khác</option>
                                        </select>
                                    </td>
                                    <td><input type="date" name="khach[<?= $i ?>][NgaySinh]"></td>
                                    <td>
                                        <select name="khach[<?= $i ?>][LoaiKhach]">
                                            <option value="ca_nhan" selected>Cá nhân</option>
                                            <option value="cong_ty">Công ty</option>
                                        </select>
                                    </td>
                                    <td><button type="button" class="btn btn-del" onclick="removeRow(this)">X</button></td>
                                </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                </div>

                <p style="margin-top:10px;color:#64748b;">
                    * Bắt buộc: Họ tên + Số điện thoại. Các dòng trống sẽ tự bỏ qua.
                </p>
            </form>

        </div>
    </div>
</div>

<script>
let rowIndex = 5;

function addRow() {
    const tbody = document.querySelector('#khachTable tbody');
    const tr = document.createElement('tr');
    tr.innerHTML = `
        <td><input name="khach[${rowIndex}][MaCodeKhachHang]" placeholder="KH001..."></td>
        <td><input name="khach[${rowIndex}][HoTen]" required></td>
        <td><input name="khach[${rowIndex}][SoDienThoai]" required></td>
        <td><input type="email" name="khach[${rowIndex}][Email]"></td>
        <td>
            <select name="khach[${rowIndex}][GioiTinh]">
                <option value="nam">Nam</option>
                <option value="nu">Nữ</option>
                <option value="khac" selected>Khác</option>
            </select>
        </td>
        <td><input type="date" name="khach[${rowIndex}][NgaySinh]"></td>
        <td>
            <select name="khach[${rowIndex}][LoaiKhach]">
                <option value="ca_nhan" selected>Cá nhân</option>
                <option value="cong_ty">Công ty</option>
            </select>
        </td>
        <td><button type="button" class="btn btn-del" onclick="removeRow(this)">X</button></td>
    `;
    tbody.appendChild(tr);
    rowIndex++;
}

function removeRow(btn) {
    const tr = btn.closest('tr');
    tr.remove();
}
</script>
