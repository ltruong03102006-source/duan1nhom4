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
    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: var(--bg-color); color: var(--text-main); font-size: 14px; }
    .container-fluid { max-width: 1400px; margin: 0 auto; }
    h1.mt-4 { font-size: 20px; color: var(--primary-color); margin-bottom: 20px !important; font-weight: 600; }

    /* Card overrides */
    .card { background: var(--card-bg); border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); border: none; }
    .card-header { padding: 15px 20px; border-bottom: 1px solid var(--border-color); background-color: #f8fafc; border-radius: 8px 8px 0 0; font-size: 16px; font-weight: 600; color: var(--text-main); }
    .card-body { padding: 20px; }

    /* Table styles for list pages */
    table.table { width: 100%; border-collapse: collapse; }
    table.table thead th, table.table tfoot th { 
        background-color: var(--primary-color) !important; 
        color: white; 
        padding: 12px 15px; 
        border-bottom: 2px solid var(--border-color);
        border: none !important; /* Override Bootstrap border */
    }
    table.table tbody tr:nth-child(even) { background-color: #f8fafc; }
    table.table tbody tr:hover { background-color: #eff6ff; }
    table.table td { padding: 12px 15px; border-bottom: 1px solid var(--border-color); }
    table.table.table-bordered td { border: 1px solid var(--border-color) !important; }

    /* Button styles */
    .btn { padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; }
    .btn-primary { background-color: var(--primary-color); color: white; }
    .btn-primary:hover { background-color: var(--primary-hover); }
    .btn-warning { background-color: #ffc107; color: black; }
    .btn-warning:hover { background-color: #e0a800; }
    .btn-danger { background-color: var(--danger-color); color: white; }
    .btn-danger:hover { background-color: #c43232; }
    .btn-sm { padding: 6px 10px; font-size: 13px; }

    /* Custom status styles */
    .status-dang-lam { color: var(--success-color); font-weight: bold; }
    .status-da-nghi { color: var(--danger-color); font-weight: bold; }
    
    .d-flex.justify-content-between.align-items-center { display: flex !important; justify-content: space-between !important; align-items: center !important; }
    .fw-bold { font-weight: bold !important; }
</style>
<div class="container-fluid px-4">
    <h1 class="mt-4">Danh sách Nhân Viên</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="?act=/">Dashboard</a></li>
        <li class="breadcrumb-item active">Danh sách Nhân viên</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>
                <i class="fas fa-table me-1"></i>
                Dữ liệu Nhân viên
            </span>
            <a href="?act=addNhanVien" class="btn btn-primary btn-sm">
                <i class="fas fa-user-plus me-1"></i> Thêm mới
            </a>
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ảnh</th>
                        <th>Mã Code</th>
                        <th>Họ Tên</th>
                        <th>Vai Trò</th>
                        <th>Số ĐT</th>
                        <th>Email</th>
                        <th>Trạng Thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Ảnh</th>
                        <th>Mã Code</th>
                        <th>Họ Tên</th>
                        <th>Vai Trò</th>
                        <th>Số ĐT</th>
                        <th>Email</th>
                        <th>Trạng Thái</th>
                        <th>Thao tác</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php if (isset($listNhanVien) && is_array($listNhanVien)): ?>
                        <?php foreach ($listNhanVien as $nv): ?>
                            <tr>
                                <td><?= $nv['MaNhanVien'] ?></td>
                                <td>
                                    <?php if (!empty($nv['LinkAnhDaiDien'])): ?>
                                        <img src="<?= $nv['LinkAnhDaiDien'] ?>" alt="Ảnh NV" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                                    <?php else: ?>
                                        <i class="fas fa-user-circle fa-2x text-secondary"></i>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($nv['MaCodeNhanVien']) ?></td>
                                <td><?= htmlspecialchars($nv['HoTen']) ?></td>
                                <td>
                                    <?php
                                    $vaiTro = $nv['VaiTro'];
                                    if ($vaiTro == 'huong_dan_vien') echo 'HDV';
                                    elseif ($vaiTro == 'tai_xe') echo 'Tài xế';
                                    elseif ($vaiTro == 'dieu_hanh') echo 'Điều hành';
                                    else echo 'Admin';
                                    ?>
                                </td>
                                <td><?= htmlspecialchars($nv['SoDienThoai'] ?? '---') ?></td>
                                <td><?= htmlspecialchars($nv['Email'] ?? '---') ?></td>
                                <td>
                                    <?= $nv['TrangThai'] == 'dang_lam' 
                                        ? '<span class="status-dang-lam">Đang làm</span>' 
                                        : '<span class="status-da-nghi">Đã nghỉ</span>' ?>
                                </td>
                                <td>
                                    <a href="?act=editNhanVien&id=<?= $nv['MaNhanVien'] ?>" class="btn btn-warning btn-sm" title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="?act=deleteNhanVien&id=<?= $nv['MaNhanVien'] ?>" 
                                       class="btn btn-danger btn-sm" 
                                       title="Xóa"
                                       onclick="return confirm('Bạn có chắc chắn muốn xóa nhân viên này không?')">
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