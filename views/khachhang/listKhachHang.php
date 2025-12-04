<style>
    /* CSS đồng bộ với Tour pages */
    :root {
        --primary-color: #2563eb;
        --primary-hover: #1d4ed8;
        --bg-color: #f1f5f9;
        --card-bg: #ffffff;
        --text-main: #1e293b;
        --text-secondary: #64748b;
        --border-color: #e2e8f0;
        --success-color: #10b981;
        --danger-color: #ef4444;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: var(--bg-color);
        color: var(--text-main);
        font-size: 14px;
    }

    .container-fluid {
        max-width: 1400px;
        margin: 0 auto;
    }

    h1.mt-4 {
        font-size: 20px;
        color: var(--primary-color);
        margin-bottom: 20px !important;
        font-weight: 600;
    }

    /* Card overrides */
    .card {
        background: var(--card-bg);
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        border: none;
    }

    .card-header {
        padding: 15px 20px;
        border-bottom: 1px solid var(--border-color);
        background-color: #f8fafc;
        border-radius: 8px 8px 0 0;
        font-size: 16px;
        font-weight: 600;
        color: var(--text-main);
    }

    .card-body {
        padding: 20px;
    }

    /* Table styles for list pages */
    table.table {
        width: 100%;
        border-collapse: collapse;
    }

    table.table thead th,
    table.table tfoot th {
        background-color: var(--primary-color) !important;
        color: white;
        padding: 12px 15px;
        border-bottom: 2px solid var(--border-color);
        border: none !important;
        /* Override Bootstrap border */
    }

    table.table tbody tr:nth-child(even) {
        background-color: #f8fafc;
    }

    table.table tbody tr:hover {
        background-color: #eff6ff;
    }

    table.table td {
        padding: 12px 15px;
        border-bottom: 1px solid var(--border-color);
    }

    table.table.table-bordered td {
        border: 1px solid var(--border-color) !important;
    }

    /* Button styles */
    .btn {
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .btn-primary {
        background-color: var(--primary-color);
        color: white;
    }

    .btn-primary:hover {
        background-color: var(--primary-hover);
    }

    .btn-warning {
        background-color: #ffc107;
        color: black;
    }

    .btn-warning:hover {
        background-color: #e0a800;
    }

    .btn-danger {
        background-color: var(--danger-color);
        color: white;
    }

    .btn-danger:hover {
        background-color: #c43232;
    }

    .btn-sm {
        padding: 6px 10px;
        font-size: 13px;
    }

    .d-flex.justify-content-between.align-items-center {
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
    }

    .fw-bold {
        font-weight: bold !important;
    }

    .header-actions {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    /* đảm bảo nút không bị full ngang */
    .card-header .btn {
        width: auto !important;
        flex: 0 0 auto !important;
        white-space: nowrap;
    }
</style>
<div class="container-fluid px-4">
    <h1 class="mt-4">Danh sách Khách Hàng</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="?act=/">Dashboard</a></li>
        <li class="breadcrumb-item active">Danh sách Khách hàng</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>
                <i class="fas fa-table me-1"></i>
                Dữ liệu Khách hàng
            </span>

            <div class="header-actions">
                <a href="?act=addKhachHangGroup" class="btn btn-primary btn-sm">+ Thêm nhóm khách</a>
                <a href="?act=addKhachHang" class="btn btn-primary btn-sm">
                    <i class="fas fa-user-plus me-1"></i> Thêm mới
                </a>
            </div>
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Mã Code</th>
                        <th>Họ Tên</th>
                        <th>Số Điện Thoại</th>
                        <th>Email</th>
                        <th>Loại Khách</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Mã Code</th>
                        <th>Họ Tên</th>
                        <th>Số Điện Thoại</th>
                        <th>Email</th>
                        <th>Loại Khách</th>
                        <th>Thao tác</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php if (isset($listKhachHang) && is_array($listKhachHang)): ?>
                        <?php foreach ($listKhachHang as $kh): ?>
                            <tr>
                                <td><?= $kh['MaKhachHang'] ?></td>
                                <td><?= htmlspecialchars($kh['MaCodeKhachHang']) ?></td>
                                <td><?= htmlspecialchars($kh['HoTen']) ?></td>
                                <td><?= htmlspecialchars($kh['SoDienThoai']) ?></td>
                                <td><?= htmlspecialchars($kh['Email']) ?></td>
                                <td>
                                    <?= $kh['LoaiKhach'] == 'cong_ty' ? 'Công ty' : 'Cá nhân' ?>
                                </td>
                                <td>
                                    <a href="?act=editKhachHang&id=<?= $kh['MaKhachHang'] ?>" class="btn btn-warning btn-sm" title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="?act=deleteKhachHang&id=<?= $kh['MaKhachHang'] ?>"
                                        class="btn btn-danger btn-sm"
                                        title="Xóa"
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa khách hàng này không?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>