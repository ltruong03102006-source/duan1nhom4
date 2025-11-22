<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Booking</title>
    <style>
        body {
            margin: 0;
            background: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }

        .header {
            background: #1e88e5;
            padding: 15px 20px;
            color: #fff;
            font-size: 22px;
            font-weight: bold;
        }

        .container {
            width: 95%;
            max-width: 1400px;
            margin: 25px auto;
        }

        .btn-add {
            padding: 10px 18px;
            background: #1e88e5;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            margin-bottom: 20px;
            text-decoration: none;
            display: inline-block;
        }

        .btn-add:hover {
            background: #1565c0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 10px 12px;
            text-align: left;
            font-size: 13px;
        }

        th {
            background: #0d47a1;
            color: white;
        }

        tr:nth-child(even) {
            background: #f1f1f1;
        }

        .actions {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
        }

        .actions a {
            text-decoration: none;
        }

        .actions button {
            padding: 5px 10px;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
        }

        .btn-edit {
            background: #ff9800;
        }

        .btn-edit:hover {
            background: #ef6c00;
        }

        .btn-delete {
            background: #e53935;
        }

        .btn-delete:hover {
            background: #c62828;
        }

        .btn-khach {
            background: #43a047;
        }

        .btn-khach:hover {
            background: #2e7d32;
        }

        .badge {
            padding: 3px 7px;
            border-radius: 10px;
            font-size: 11px;
            font-weight: 600;
        }

        .badge-cho {
            background: #fff3e0;
            color: #ef6c00;
        }
        .badge-coc {
            background: #e3f2fd;
            color: #1565c0;
        }
        .badge-done {
            background: #e8f5e9;
            color: #2e7d32;
        }
        .badge-cancel {
            background: #ffebee;
            color: #c62828;
        }

        .price {
            color: #e53935;
            font-weight: 600;
        }

    </style>
</head>
<body>
<div class="header">Quản Lý Booking</div>

<div class="container">
    <a href="?act=addBooking" class="btn-add">+ Thêm Booking</a>

    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Mã Booking</th>
            <th>Tour</th>
            <th>Đoàn</th>
            <th>Khách hàng</th>
            <th>Loại</th>
            <th>SL</th>
            <th>Tổng tiền</th>
            <th>Đã trả</th>
            <th>Còn lại</th>
            <th>Trạng thái</th>
            <th>Ngày tạo</th>
            <th>Hành động</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($listBooking as $b): ?>
            <tr>
                <td><?= $b['MaBooking'] ?></td>
                <td><?= htmlspecialchars($b['MaCodeBooking']) ?></td>
                <td><?= htmlspecialchars($b['TenTour'] ?? '') ?></td>
                <td>
                    <?php if (!empty($b['NgayKhoiHanh'])): ?>
                        <?= date('d/m/Y', strtotime($b['NgayKhoiHanh'])) ?>
                    <?php else: ?>
                        —
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($b['TenKhach'] ?? '') ?></td>
                <td><?= $b['LoaiBooking'] == 'nhom' ? 'Nhóm' : 'Cá nhân' ?></td>
                <td>
                    NL: <?= $b['TongNguoiLon'] ?>,
                    TE: <?= $b['TongTreEm'] ?>,
                    EB: <?= $b['TongEmBe'] ?>
                </td>
                <td class="price"><?= number_format($b['TongTien'], 0, ',', '.') ?>đ</td>
                <td class="price"><?= number_format($b['SoTienDaTra'], 0, ',', '.') ?>đ</td>
                <td class="price"><?= number_format($b['SoTienConLai'], 0, ',', '.') ?>đ</td>
                <td>
                    <?php
                    $st = $b['TrangThai'];
                    if ($st == 'cho_coc') echo '<span class="badge badge-cho">Chờ cọc</span>';
                    elseif ($st == 'da_coc') echo '<span class="badge badge-coc">Đã cọc</span>';
                    elseif ($st == 'hoan_tat') echo '<span class="badge badge-done">Hoàn tất</span>';
                    elseif ($st == 'da_huy') echo '<span class="badge badge-cancel">Đã hủy</span>';
                    ?>
                </td>
                <td><?= $b['NgayTao'] ?></td>
                <td class="actions">
                    <a href="?act=khachTrongBooking&MaBooking=<?= $b['MaBooking'] ?>">
                        <button class="btn-khach">Khách</button>
                    </a>
                    <a href="?act=editBooking&MaBooking=<?= $b['MaBooking'] ?>">
                        <button class="btn-edit">Sửa</button>
                    </a>
                    <a href="?act=deleteBooking&MaBooking=<?= $b['MaBooking'] ?>"
                       onclick="return confirm('Xóa booking này?');">
                        <button class="btn-delete">Xóa</button>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
