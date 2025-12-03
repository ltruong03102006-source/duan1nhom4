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

    * {
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: var(--bg-color);
        color: var(--text-main);
        margin: 0;
        padding: 0;
        font-size: 14px;
    }

    .lich-container {
        padding: 20px;
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

    .card-grid {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 20px;
    }

    /* Form control consistency */
    .form-control,
    .form-select {
        padding: 8px 12px;
        border: 1px solid var(--border-color);
        border-radius: 4px;
        font-size: 14px;
        transition: border-color 0.2s;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: none;
        outline: none;
    }

    .form-label {
        font-weight: 500;
        color: var(--text-main);
        margin-bottom: 5px;
    }

    .form-text {
        font-size: 13px;
        color: var(--text-secondary);
        margin-top: 5px;
    }

    /* Table styles for list pages */
    .table-responsive {
        overflow-x: auto;
    }

    table.table {
        width: 100%;
        border-collapse: collapse;
    }

    table.table thead th {
        background-color: var(--primary-color) !important;
        color: white;
        padding: 12px 15px;
        border-bottom: 2px solid var(--border-color);
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

    /* Statuses (retained from original file) */
    .status-ranh {
        color: var(--success-color);
        font-weight: bold;
    }

    .status-ban {
        color: #ffc107;
        font-weight: bold;
    }

    .status-nghi {
        color: var(--danger-color);
        font-weight: bold;
    }

    .tour-detail {
        font-size: 0.8em;
        color: var(--text-secondary);
    }

    /* Alert styles (retained/unified from original file) */
    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 5px;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    /* Search specific */
    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        flex-wrap: wrap;
        /* Cho phép xuống dòng trên màn hình nhỏ */
    }

    .search-form {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .search-form input.form-control {
        width: 250px;
    }

    @media (max-width: 992px) {
        .card-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="lich-container">
    <h1 class="mt-4">📅 Quản lý Lịch Làm Việc của Nhân Viên</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="?act=/">Dashboard</a></li>
        <li class="breadcrumb-item active">Lịch làm việc</li>
    </ol>

    <?php
    // Lấy keyword để hiển thị lại trên thanh tìm kiếm
    $currentKeyword = htmlspecialchars($_GET['keyword'] ?? '');
    if (isset($_GET['success'])): ?>
        <div class="alert alert-success">
            <?php
            switch ($_GET['success']) {
                case 'add':
                    echo '✅ Thêm lịch làm việc thành công!';
                    break;
                case 'delete':
                    echo '✅ Xóa lịch làm việc thành công!';
                    break;
            }
            ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger">
            ❌ Có lỗi xảy ra! Vui lòng thử lại.
        </div>
    <?php endif; ?>

    <div class="card-grid">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-calendar-plus me-1"></i>
                Thêm Lịch Làm Việc Mới
            </div>
            <div class="card-body">
                <form action="?act=addLichLamViecProcess" method="POST">

                    <div class="mb-3">
                        <label class="form-label">Nhân Viên *</label>
                        <select name="MaNhanVien" class="form-select" required>
                            <option value="">-- Chọn Nhân viên --</option>
                            <?php foreach ($listNhanVien as $nv): ?>
                                <option value="<?= $nv['MaNhanVien'] ?>">
                                    <?= htmlspecialchars($nv['HoTen']) ?> (<?= $nv['MaCodeNhanVien'] ?>) - <?= $nv['VaiTro'] == 'huong_dan_vien' ? 'HDV' : ($nv['VaiTro'] == 'tai_xe' ? 'Tài xế' : 'Khác') ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Từ ngày *</label>
                            <input type="date" name="TuNgay" id="TuNgay" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Đến ngày *</label>
                            <input type="date" name="DenNgay" id="DenNgay" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Trạng Thái *</label>
                            <select name="TrangThai" id="TrangThai" class="form-select" required>
                                <option value="ranh">Rảnh</option>
                                <option value="ban">Bận (Đi Tour)</option>
                                <option value="nghi">Nghỉ</option>
                            </select>
                        </div>
                    </div>


                    <div class="mb-3" id="doanSelect" style="display: none;">
                        <label class="form-label">Chọn Đoàn Tour (Nếu Bận)</label>
                        <select name="MaDoan" class="form-select">
                            <option value="">-- Không chọn Đoàn (Bận việc cá nhân) --</option>
                            <?php foreach ($listDoan as $doan): ?>
                                <option value="<?= $doan['MaDoan'] ?>">
                                    [<?= $doan['MaCodeTour'] ?>] <?= htmlspecialchars($doan['TenTour']) ?> (KH: <?= date('d/m', strtotime($doan['NgayKhoiHanh'])) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text">Chỉ chọn khi trạng thái là **Bận (Đi Tour)**.</div>

                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ghi Chú</label>
                        <textarea name="GhiChu" class="form-control" rows="2"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3"><i class="fas fa-save"></i> Lưu Lịch Làm Việc</button>
                </form>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-list me-1"></i>
                Danh Sách Lịch Đã Xếp
            </div>
            <div class="card-body">

                <div class="table-header">
                    <h4>Tìm kiếm Nhân viên</h4>
                    <form method="GET" action="?act=listLichLamViec" class="search-form">
                        <input type="hidden" name="act" value="listLichLamViec">
                        <input type="text" name="keyword" class="form-control" placeholder="Nhập Tên hoặc Mã Code..." value="<?= $currentKeyword ?>">
                        <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Tìm</button>
                        <?php if (!empty($currentKeyword)): ?>
                            <a href="?act=listLichLamViec" class="btn btn-secondary btn-sm"><i class="fas fa-times"></i> Xóa tìm</a>
                        <?php endif; ?>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Ngày</th>
                                <th>Nhân Viên</th>
                                <th>Trạng Thái</th>
                                <th>Chi Tiết Đoàn</th>
                                <th>Ghi Chú</th>
                                <th>Xóa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($listLichLamViec) && is_array($listLichLamViec)): ?>
                                <?php foreach ($listLichLamViec as $llv): ?>
                                    <tr>
                                        <td><?= date('d/m/Y', strtotime($llv['NgayLamViec'])) ?></td>
                                        <td>
                                            <strong><?= htmlspecialchars($llv['TenNhanVien']) ?></strong>
                                            <span class="tour-detail">(<?= $llv['MaCodeNhanVien'] ?>)</span>
                                        </td>
                                        <td>
                                            <span class="status-<?= $llv['TrangThai'] ?>">
                                                <?php
                                                if ($llv['TrangThai'] == 'ranh') echo 'Rảnh';
                                                else if ($llv['TrangThai'] == 'ban') echo 'Bận';
                                                else echo 'Nghỉ';
                                                ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ($llv['MaDoan'] && $llv['TrangThai'] == 'ban'): ?>
                                                <?= htmlspecialchars($llv['TenTour']) ?>
                                                <div class="tour-detail">Mã: <?= $llv['MaCodeTour'] ?> (KH: <?= date('d/m', strtotime($llv['NgayKhoiHanh'])) ?>)</div>
                                            <?php else: ?>
                                                ---
                                            <?php endif; ?>
                                        </td>
                                        <td><?= htmlspecialchars($llv['GhiChu'] ?? '---') ?></td>
                                        <td>
                                            <a href="?act=deleteLichLamViec&id=<?= $llv['MaLichLamViec'] ?>"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Xóa lịch làm việc này?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">Chưa có lịch làm việc nào được xếp hoặc không tìm thấy kết quả.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const trangThaiSelect = document.getElementById('TrangThai');
        const doanSelectDiv = document.getElementById('doanSelect');

        function toggleDoanSelect() {
            if (trangThaiSelect.value === 'ban') {
                doanSelectDiv.style.display = 'block';
            } else {
                doanSelectDiv.style.display = 'none';
                // Đảm bảo không gửi MaDoan nếu không phải trạng thái bận
                doanSelectDiv.querySelector('select').value = "";
            }
        }

        trangThaiSelect.addEventListener('change', toggleDoanSelect);

        // Khởi tạo trạng thái ban đầu
        toggleDoanSelect();
    });
    const tuNgay = document.getElementById('TuNgay');
    const denNgay = document.getElementById('DenNgay');

    function syncDateRange() {
        if (!tuNgay || !denNgay) return;
        denNgay.min = tuNgay.value || '';
        if (tuNgay.value && denNgay.value && denNgay.value < tuNgay.value) {
            denNgay.value = tuNgay.value;
        }
    }
    tuNgay && tuNgay.addEventListener('change', syncDateRange);
    denNgay && denNgay.addEventListener('change', syncDateRange);
    syncDateRange();
</script>