<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản Lý Đoàn Khởi Hành</title>
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

        th,
        td {
            padding: 12px 15px;
            text-align: left;
            font-size: 14px;
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
            padding: 6px 12px;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 13px;
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

        .btn-view {
            background: #43a047;
        }

        .btn-view:hover {
            background: #2e7d32;
        }

        .badge {
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-open {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .badge-full {
            background: #ffebee;
            color: #c62828;
        }

        .badge-cancel {
            background: #fff3e0;
            color: #ef6c00;
        }

        .badge-done {
            background: #ede7f6;
            color: #4527a0;
        }
    </style>
</head>

<body>
    <div class="header">Quản Lý Đoàn Khởi Hành</div>

    <div class="container">
        <a href="?act=addDoan" class="btn-add">+ Thêm Đoàn Mới</a>
        <a href="?act=tour" class="btn-add" style="background:#6c757d; margin-left:5px;">⬅ Quay lại Tour</a>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tour</th>
                    <th>Ngày đi</th>
                    <th>Ngày về</th>
                    <th>Giờ khởi hành</th>
                    <th>Điểm tập trung</th>
                    <th>HDV</th>
                    <th>Tài xế</th>
                    <th>Chỗ</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($listDoan as $d): ?>
                    <tr>
                        <td><?= $d['MaDoan'] ?></td>
                        <td><?= htmlspecialchars($d['TenTour']) ?></td>
                        <td><?= $d['NgayKhoiHanh'] ?></td>
                        <td><?= $d['NgayVe'] ?></td>
                        <td><?= $d['GioKhoiHanh'] ?></td>
                        <td><?= htmlspecialchars($d['DiemTapTrung']) ?></td>
                        <td><?= $d['TenHDV'] ?></td>
                        <td><?= $d['TenTaiXe'] ?></td>
                        <td><?= $d['SoChoConTrong'] ?>/<?= $d['SoChoToiDa'] ?></td>
                        <td>
                            <?php
                            $status = $d['TrangThai'] ?? 'con_cho';
                            if ($status === 'con_cho') {
                                echo '<span class="badge badge-open">Còn chỗ</span>';
                            } elseif ($status === 'het_cho') {
                                echo '<span class="badge badge-full">Hết chỗ</span>';
                            } elseif ($status === 'da_huy') {
                                echo '<span class="badge badge-cancel">Đã hủy</span>';
                            } else {
                                echo '<span class="badge badge-done">Hoàn thành</span>';
                            }
                            ?>
                        </td>
                        <td class="actions">
                             <a href="?act=listDichVu&maDoan=<?= $d['MaDoan'] ?>">
                                <button class="btn-view" style="background:#0ea5e9;">Dịch vụ</button>
                            </a>
                            <a href="?act=editDoan&MaDoan=<?= $d['MaDoan'] ?>">
                                <button class="btn-edit">Sửa</button>
                            </a>
                            <a href="?act=deleteDoan&MaDoan=<?= $d['MaDoan'] ?>"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa đoàn này không?');">
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
