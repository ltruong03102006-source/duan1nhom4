<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Đoàn Khởi Hành</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --bg-body: #f3f4f6;
            --bg-card: #ffffff;
            --text-main: #111827;
            --text-muted: #6b7280;
            --border-color: #e5e7eb;
            --danger: #ef4444;
            --success: #10b981;
            --warning: #f59e0b;
            --info: #0ea5e9;
        }

        * {
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            margin: 0;
            background-color: var(--bg-body);
            color: var(--text-main);
            font-size: 14px;
        }

        /* --- Header --- */
        .header {
            background-color: var(--bg-card);
            border-bottom: 1px solid var(--border-color);
            padding: 16px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }

        .header h1 {
            margin: 0;
            font-size: 20px;
            font-weight: 700;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* --- Toolbar --- */
        .container {
            max-width: 1600px;
            margin: 30px auto;
            padding: 0 32px;
        }

        .toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            gap: 16px;
            flex-wrap: wrap;
        }

        .actions-left {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 10px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
            border: 1px solid transparent;
            font-size: 14px;
            cursor: pointer;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            transform: translateY(-1px);
        }

        .btn-outline {
            background: white;
            border-color: var(--border-color);
            color: var(--text-main);
        }

        .btn-outline:hover {
            background: #f9fafb;
            border-color: #d1d5db;
        }

        .search-box {
            position: relative;
            width: 300px;
        }

        .search-box i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
        }

        .search-box input {
            width: 100%;
            padding: 10px 10px 10px 36px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            outline: none;
        }

        .search-box input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        /* --- Table --- */
        .card {
            background: var(--bg-card);
            border-radius: 12px;
            border: 1px solid var(--border-color);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        thead th {
            background-color: #f9fafb;
            color: var(--text-muted);
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            padding: 14px 20px;
            border-bottom: 1px solid var(--border-color);
            white-space: nowrap;
        }

        tbody td {
            padding: 14px 20px;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
        }

        tbody tr:hover {
            background-color: #f9fafb;
        }

        /* --- Custom Columns --- */
        .tour-name {
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 4px;
            display: block;
        }

        .location-info {
            font-size: 12px;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .date-badge {
            display: flex;
            align-items: center;
            gap: 8px;
            font-family: monospace;
            font-size: 13px;
            color: var(--text-main);
        }

        .staff-info {
            display: flex;
            flex-direction: column;
            gap: 4px;
            font-size: 13px;
        }

        .staff-item {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .staff-item i {
            width: 16px;
            text-align: center;
            color: var(--text-muted);
        }

        /* --- Capacity (Chỗ) --- */
        .capacity-wrap {
            width: 120px;
        }

        .capacity-text {
            font-size: 12px;
            margin-bottom: 4px;
            display: flex;
            justify-content: space-between;
        }

        .progress-bar {
            height: 6px;
            background: #e5e7eb;
            border-radius: 99px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            border-radius: 99px;
        }

        /* --- Status --- */
        .badge {
            padding: 4px 10px;
            border-radius: 99px;
            font-size: 12px;
            font-weight: 600;
            border: 1px solid transparent;
        }

        .st-con_cho {
            background: #ecfdf5;
            color: #047857;
            border-color: #a7f3d0;
        }

        .st-het_cho {
            background: #fff1f2;
            color: #be123c;
            border-color: #fecdd3;
        }

        .st-da_huy {
            background: #fef2f2;
            color: #b91c1c;
            border-color: #fecaca;
        }

        .st-done {
            background: #f3f4f6;
            color: #4b5563;
            border-color: #e5e7eb;
        }

        /* --- Actions --- */
        .action-cell {
            display: flex;
            gap: 8px;
            justify-content: flex-end;
        }

        .btn-icon {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            color: var(--text-muted);
            text-decoration: none;
            transition: 0.2s;
        }

        .btn-icon:hover {
            background: #f3f4f6;
        }

        .btn-icon.edit:hover {
            color: var(--warning);
            background: #fffbeb;
        }

        .btn-icon.service:hover {
            color: var(--info);
            background: #e0f2fe;
        }

        .btn-icon.delete:hover {
            color: var(--danger);
            background: #fef2f2;
        }

        /* Style riêng cho nút Tài chính khi rê chuột */
        .btn-icon.finance:hover {
            color: #0891b2;
            /* Màu xanh cổ vịt đậm (Teal) */
            background: #ecfeff;
            /* Nền xanh rất nhạt */
            border-color: #cffafe;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>
            <i class="fa-solid fa-bus-simple" style="color: var(--primary);"></i>
            Quản Lý Đoàn Khởi Hành
        </h1>

        <div style="font-size: 13px; color: var(--text-muted);">
            Admin Panel
        </div>
    </div>

    <div class="container">
        <?php
        if (isset($_GET['error']) && $_GET['error'] == 'cannot_delete_has_booking') {
            echo '<div class="alert alert-danger">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    Không thể xóa đoàn này vì đã có Khách hàng đặt tour (Booking). Hãy hủy Booking trước hoặc chỉ cập nhật trạng thái đoàn.
                  </div>';
        }
        if (isset($_GET['success']) && $_GET['success'] == 'delete') {
            echo '<div class="alert alert-success">
                    <i class="fa-solid fa-check-circle"></i>
                    Xóa đoàn thành công!
                  </div>';
        }
        ?>
        <div class="toolbar">
            <div class="actions-left">
                <a href="?act=tour" class="btn btn-outline">
                    <i class="fa-solid fa-arrow-left"></i> Quay lại Tour
                </a>
                <a href="?act=addDoan" class="btn btn-primary">
                    <i class="fa-solid fa-plus"></i> Thêm Đoàn Mới
                </a>
            </div>

            <div class="search-box">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input id="searchInput" type="text" placeholder="Tìm theo tên tour, HDV, nơi đón...">
            </div>
        </div>

        <div class="card">
            <div class="table-responsive">
                <table id="doanTable">
                    <thead>
                        <tr>
                            <th style="width: 50px;">ID</th>
                            <th>Thông tin Tour</th>
                            <th>Lịch trình</th>
                            <th>Nhân sự (HDV/Tài xế)</th>
                            <th>Tình trạng chỗ</th>
                            <th>Trạng thái</th>
                            <th style="text-align: right;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($listDoan as $d): ?>
                            <tr>
                                <td><b>#<?= $d['MaDoan'] ?></b></td>

                                <td>
                                    <span class="tour-name"><?= htmlspecialchars($d['TenTour']) ?></span>
                                    <div class="location-info">
                                        <i class="fa-solid fa-location-dot"></i>
                                        Khởi hành: <?= htmlspecialchars($d['DiemTapTrung']) ?>
                                    </div>
                                </td>

                                <td>
                                    <div class="date-badge">
                                        <span style="color: var(--success);">Đi:</span>
                                        <?= date('d/m/Y', strtotime($d['NgayKhoiHanh'])) ?>
                                    </div>
                                    <div class="date-badge" style="margin-top: 4px;">
                                        <span style="color: var(--danger);">Về:</span>
                                        <?= date('d/m/Y', strtotime($d['NgayVe'])) ?>
                                    </div>
                                </td>

                                <td>
                                    <div class="staff-info">
                                        <div class="staff-item">
                                            <i class="fa-solid fa-user-tie" title="Hướng dẫn viên"></i>
                                            <?= !empty($d['TenHDV']) ? $d['TenHDV'] : '<span style="color:#9ca3af;">--</span>' ?>
                                        </div>
                                        <div class="staff-item">
                                            <i class="fa-solid fa-id-card" title="Tài xế"></i>
                                            <?= !empty($d['TenTaiXe']) ? $d['TenTaiXe'] : '<span style="color:#9ca3af;">--</span>' ?>
                                        </div>
                                    </div>
                                </td>

                                <?php
                                $total = (int)$d['SoChoToiDa']; // Ví dụ: 20
                                // Lấy số khách thực tế từ Model (đã sửa ở Bước 1)
                                $booked = (int)$d['DaDat'];
                                $remain = $total - $booked;
                                $percent = $total > 0 ? ($booked / $total) * 100 : 0;

                                // --- Xử lý Logic Trạng Thái theo yêu cầu ---
                                $trangThaiHienThi = '';
                                $classTrangThai = '';

                                // Nếu khách < 10 => Đã hủy
                                if ($booked < 10) {
                                    $trangThaiHienThi = 'Đã hủy (<10 khách)';
                                    $classTrangThai = 'st-da_huy';
                                    $colorBar = '#ef4444'; // Đỏ
                                }
                                // Nếu khách >= Tổng chỗ (>=20) => Hết chỗ
                                elseif ($booked >= $total) {
                                    $trangThaiHienThi = 'Hết chỗ';
                                    $classTrangThai = 'st-het_cho';
                                    $colorBar = '#ef4444'; // Đỏ
                                }
                                // Ngược lại => Còn chỗ
                                else {
                                    $trangThaiHienThi = 'Còn chỗ';
                                    $classTrangThai = 'st-con_cho';
                                    $colorBar = '#10b981'; // Xanh
                                }
                                ?>

                                <td>
                                    <div class="capacity-wrap">
                                        <div class="capacity-text">
                                            <span>Đã có: <b><?= $booked ?></b> khách</span>
                                            <span style="color: #6b7280;">/ <?= $total ?></span>
                                        </div>
                                        <div class="progress-bar">
                                            <div class="progress-fill" style="width: <?= $percent ?>%; background: <?= $colorBar ?>;"></div>
                                        </div>
                                        <div style="font-size: 11px; margin-top: 2px; color: var(--primary);">
                                            <?php if ($remain > 0): ?>
                                                Còn trống: <?= $remain ?>
                                            <?php else: ?>
                                                Đã kín chỗ
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <span class="badge <?= $classTrangThai ?>">
                                        <?= $trangThaiHienThi ?>
                                    </span>
                                </td>

                                <td>
                                    <div class="action-cell">
                                        <a href="?act=listDichVu&maDoan=<?= $d['MaDoan'] ?>" class="btn-icon service" title="Dịch vụ">
                                            <i class="fa-solid fa-bell-concierge"></i>
                                        </a>

                                        <a href="?act=listTaiChinh&MaDoan=<?= $d['MaDoan'] ?>" class="btn-icon finance" title="Tài chính">
                                            <i class="fa-solid fa-file-invoice-dollar"></i>
                                        </a>

                                        <a href="?act=editDoan&MaDoan=<?= $d['MaDoan'] ?>" class="btn-icon edit" title="Sửa">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>

                                        <a href="?act=deleteDoan&MaDoan=<?= $d['MaDoan'] ?>" class="btn-icon delete"
                                            onclick="return confirm('Xóa đoàn này?');" title="Xóa">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <?php if (empty($listDoan)): ?>
                    <div style="text-align:center; padding: 40px; color: var(--text-muted);">
                        <i class="fa-solid fa-bus" style="font-size: 40px; margin-bottom: 10px; opacity: 0.5;"></i>
                        <p>Chưa có đoàn khởi hành nào.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        // Script lọc dữ liệu đơn giản
        const input = document.getElementById('searchInput');
        const table = document.getElementById('doanTable');
        const rows = () => Array.from(table.querySelectorAll('tbody tr'));

        function normalize(s) {
            return (s || '').toString().toLowerCase().trim();
        }

        input.addEventListener('keyup', () => {
            const q = normalize(input.value);
            rows().forEach(tr => {
                const text = normalize(tr.innerText);
                tr.style.display = text.includes(q) ? '' : 'none';
            });
        });
    </script>
</body>

</html>