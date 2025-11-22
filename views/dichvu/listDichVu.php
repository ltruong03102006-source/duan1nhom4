<style>
    /* CSS đồng bộ với các trang quản lý khác */
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
        --warning-color: #f59e0b;
        --info-color: #0ea5e9;
    }
    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: var(--bg-color); color: var(--text-main); font-size: 14px; }
    .dv-container { padding: 20px; max-width: 1400px; margin: 0 auto; }
    h1 { font-size: 24px; color: var(--primary-color); margin-bottom: 20px; font-weight: 700; }
    .card { background: var(--card-bg); border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); border: none; margin-bottom: 20px; }
    .card-header { padding: 15px 20px; border-bottom: 1px solid var(--border-color); background-color: #f8fafc; border-radius: 8px 8px 0 0; font-size: 16px; font-weight: 600; color: var(--text-main); }
    .card-body { padding: 20px; }
    
    /* Info Box */
    .doan-info {
        background: #e0f2f1;
        padding: 15px;
        border-radius: 6px;
        margin-bottom: 20px;
        border-left: 5px solid var(--success-color);
    }
    .doan-info strong { color: var(--text-main); }

    /* Button styles */
    .actions-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    .btn { padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; font-size: 14px; }
    .btn-primary { background-color: var(--primary-color); color: white; }
    .btn-primary:hover { background-color: var(--primary-hover); }
    .btn-success { background-color: var(--success-color); color: white; }
    .btn-warning { background-color: var(--warning-color); color: white; }
    .btn-danger { background-color: var(--danger-color); color: white; }
    .btn-secondary { background-color: #6c757d; color: white; }

    /* Table styles */
    table.table { width: 100%; border-collapse: collapse; }
    table.table thead th { background-color: var(--primary-color) !important; color: white; padding: 12px 15px; border-bottom: 2px solid var(--border-color); }
    table.table tbody tr:nth-child(even) { background-color: #f8fafc; }
    table.table tbody tr:hover { background-color: #eff6ff; }
    table.table td { padding: 12px 15px; border-bottom: 1px solid var(--border-color); }
    .text-center { text-align: center; }

    /* Badges */
    .badge { padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 600; display: inline-block; }
    .badge-xac-nhan { background-color: #dcfce7; color: #166534; }
    .badge-cho-xn { background-color: #fffbeb; color: #b45309; }
    .badge-da-huy { background-color: #fee2e2; color: #991b1b; }
    .money { color: var(--danger-color); font-weight: bold; }
    .text-sm { font-size: 12px; color: var(--text-secondary); }
</style>

<div class="dv-container">
    <h1><i class="fas fa-tools me-1"></i> Quản lý Dịch vụ Tour (Đoàn <?= htmlspecialchars($doan['MaDoan']) ?>)</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="?act=/">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="?act=listDoan">Danh sách Đoàn</a></li>
        <li class="breadcrumb-item active">Dịch vụ</li>
    </ol>

    <div class="doan-info">
        <p><strong>Tour:</strong> <?= htmlspecialchars($doan['TenTour']) ?> (<?= htmlspecialchars($doan['MaCodeTour']) ?>)</p>
        <p><strong>Ngày khởi hành:</strong> <?= date('d/m/Y', strtotime($doan['NgayKhoiHanh'])) ?> | 
           <strong>Ngày về:</strong> <?= date('d/m/Y', strtotime($doan['NgayVe'])) ?></p>
        <p><strong>Hướng dẫn viên:</strong> <?= htmlspecialchars($doan['TenHDV'] ?? 'Chưa chỉ định') ?></p>
    </div>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">
            ✅ Thao tác thành công!
        </div>
    <?php endif; ?>
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger">
            ❌ Có lỗi xảy ra trong quá trình thực hiện!
        </div>
    <?php endif; ?>
    
    <div class="actions-header">
        <a href="?act=addDichVu&maDoan=<?= $doan['MaDoan'] ?>" class="btn btn-success">
            <i class="fas fa-plus"></i> Thêm Dịch Vụ Mới
        </a>
        <a href="?act=listDoan" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại Danh sách Đoàn
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <i class="fas fa-list me-1"></i>
            Danh sách Dịch vụ Đã Đặt
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Loại DV</th>
                            <th>Tên Dịch Vụ</th>
                            <th>NCC</th>
                            <th>Ngày S/D</th>
                            <th>Đơn Giá</th>
                            <th>Số Lượng</th>
                            <th>Tổng Tiền</th>
                            <th>Trạng Thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($listDichVu)): ?>
                            <?php foreach ($listDichVu as $dv): ?>
                                <tr>
                                    <td><?= $dv['MaDichVu'] ?></td>
                                    <td><?= htmlspecialchars($dv['LoaiDichVu']) ?></td>
                                    <td><?= htmlspecialchars($dv['TenDichVu']) ?></td>
                                    <td><?= htmlspecialchars($dv['TenNhaCungCap'] ?? '---') ?></td>
                                    <td><?= date('d/m/Y', strtotime($dv['NgaySuDung'])) ?></td>
                                    <td><?= number_format($dv['DonGia']) ?> đ</td>
                                    <td class="text-center"><?= $dv['SoLuong'] ?></td>
                                    <td class="money"><?= number_format($dv['TongTien']) ?> đ</td>
                                    <td>
                                        <?php 
                                            $statusClass = '';
                                            $statusText = '';
                                            switch ($dv['TrangThaiXacNhan']) {
                                                case 'da_xac_nhan':
                                                    $statusClass = 'badge-xac-nhan';
                                                    $statusText = 'Đã xác nhận';
                                                    break;
                                                case 'cho_xac_nhan':
                                                    $statusClass = 'badge-cho-xn';
                                                    $statusText = 'Chờ xác nhận';
                                                    break;
                                                case 'da_huy':
                                                    $statusClass = 'badge-da-huy';
                                                    $statusText = 'Đã hủy';
                                                    break;
                                                default:
                                                    $statusClass = 'badge-cho-xn';
                                                    $statusText = 'Chờ xử lý';
                                            }
                                        ?>
                                        <span class="badge <?= $statusClass ?>"><?= $statusText ?></span>
                                        <div class="text-sm">Đặt: <?= $dv['NgayDat'] ? date('d/m/Y', strtotime($dv['NgayDat'])) : '---' ?></div>
                                    </td>
                                    <td class="actions">
                                        <a href="?act=editDichVu&id=<?= $dv['MaDichVu'] ?>" class="btn btn-warning btn-sm" title="Sửa">
                                            <i class="fas fa-edit"></i> Sửa
                                        </a>
                                        <a href="?act=deleteDichVu&id=<?= $dv['MaDichVu'] ?>&maDoan=<?= $dv['MaDoan'] ?>" 
                                           class="btn btn-danger btn-sm mt-1" 
                                           title="Xóa"
                                           onclick="return confirm('Bạn có chắc chắn muốn xóa dịch vụ này không?')">
                                            <i class="fas fa-trash-alt"></i> Xóa
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="10" class="text-center">Chưa có dịch vụ nào được thêm cho đoàn này.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>