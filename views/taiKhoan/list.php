<style>
    /* Chỉ giữ lại các class bổ trợ nút bấm, xóa phần style cho table */
    .btn-add {
        background: #198754;
        color: #fff;
        padding: 10px 18px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
        font-weight: bold;
        margin-bottom: 20px;
    }
    .btn-add:hover {
        background: #146c43;
    }
    
    /* XÓA HOẶC COMMENT ĐOẠN NÀY ĐỂ BẢNG GIỐNG TRANG NHÀ CUNG CẤP */
    /*
    table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        margin-top: 20px;
    }
    th, td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    th {
        background: #0d47a1;
        color: white;
    }
    tr:nth-child(even) {
        background: #f1f1f1;
    }
    */

    /* Giữ lại phần style cho các nút hành động */
    .actions button, .actions a button {
        padding: 6px 12px;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        margin-right: 5px;
    }
    .btn-block { background: #dc3545; }
    .btn-block:hover { background: #b02a37; }
    .btn-unblock { background: #198754; }
    .btn-unblock:hover { background: #146c43; }
    .status-active { color: #198754; font-weight: bold; }
    .status-locked { color: #dc3545; font-weight: bold; }
</style>
<div class="container-fluid px-4">
    <h1 class="mt-4">Quản Lý Tài Khoản Nhân Viên</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Tài khoản</li>
    </ol>

    <a href="?act=addTaiKhoan">
        <button class="btn-add">
            <i class="fas fa-plus"></i> Thêm Tài Khoản Mới
        </button>
    </a>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Danh sách tài khoản nhân viên
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>ID TK</th>
                        <th>Tên đăng nhập</th>
                        <th>Họ tên Nhân viên</th>
                        <th>Mã NV</th>
                        <th>Vai trò (DB)</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($listTaiKhoan) && !empty($listTaiKhoan)): ?>
                        <?php foreach ($listTaiKhoan as $tk): ?>
                            <tr>
                                <td><?= $tk['MaTaiKhoan'] ?></td>
                                <td><?= $tk['TenDangNhap'] ?></td>
                                <td><?= $tk['HoTen'] ?></td>
                                <td><?= $tk['MaCodeNhanVien'] ?></td>
                                <td><?= $tk['VaiTroTaiKhoan'] ?></td>
                                <td>
                                    <?php if ($tk['TrangThai'] == 'hoat_dong'): ?>
                                        <span class="status-active">Hoạt động</span>
                                    <?php else: ?>
                                        <span class="status-locked">Bị khóa</span>
                                    <?php endif; ?>
                                </td>
                                <td class="actions">
                                    <a href="?act=editTaiKhoan&id=<?= $tk['MaTaiKhoan'] ?>">
                                        <button class="btn-edit" style="background: #ff9800;">Sửa</button>
                                    </a>
                                    <a href="?act=toggleTrangThaiTaiKhoan&id=<?= $tk['MaTaiKhoan'] ?>"
                                       onclick="return confirm('Bạn có chắc muốn <?= $tk['TrangThai'] == 'hoat_dong' ? 'KHÓA' : 'MỞ KHÓA' ?> tài khoản này?');">
                                        <?php if ($tk['TrangThai'] == 'hoat_dong'): ?>
                                            <button class="btn-block">Khóa</button>
                                        <?php else: ?>
                                            <button class="btn-unblock">Mở khóa</button>
                                        <?php endif; ?>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">Chưa có tài khoản nào được tạo.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>