<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản Lý Tour Du Lịch</title>
    <style>
        body {
            margin: 0;
            background: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }

        /* HEADER */
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

        .actions button {
            padding: 6px 10px;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
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

        img.thumb {
            width: 80px;
            height: 55px;
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        .price {
            color: #e53935;
            font-weight: bold;
        }

        .status-active {
            color: #2e7d32;
            font-weight: bold;
        }

        .status-inactive {
            color: #c62828;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="header">Quản Lý Tour Du Lịch</div>

    <div class="container">
        <a href="?act=addTour">
            <button class="btn-add">+ Thêm Tour Mới</button>
        </a>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ảnh Bìa</th>
                    <th>Mã Code</th>
                    <th>Tên Tour</th>
                    <th>Danh Mục</th>
                    <th>Ngày - Đêm</th>
                    <th>Điểm Khởi Hành</th>
                    <th>Giá Vốn</th>
                    <th>Giá Bán</th>
                    <th>Trạng Thái</th>
                    <th>Ngày Tạo</th>
                    <th>Ngày Cập Nhật</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listTour as $tour): ?>
                    <tr>
                        <td><?= $tour['MaTour'] ?></td>

                        <td>
                            <?php if (!empty($tour['LinkAnhBia'])): ?>
                                <img src="<?= $tour['LinkAnhBia'] ?>" alt="Ảnh tour" class="thumb">
                            <?php else: ?>
                                <span>—</span>
                            <?php endif; ?>
                        </td>

                        <td><?= htmlspecialchars($tour['MaCodeTour']) ?></td>
                        <td><?= htmlspecialchars($tour['TenTour']) ?></td>

                    
                        <td><?= $tour['TenDanhMuc'] ?></td>

                        <td><?= $tour['SoNgay'] ?>N - <?= $tour['SoDem'] ?>Đ</td>
                        <td><?= htmlspecialchars($tour['DiemKhoiHanh']) ?></td>

                        <td class="price"><?= number_format($tour['GiaVonDuKien'], 0, ',', '.') ?>đ</td>
                        <td class="price"><?= number_format($tour['GiaBanMacDinh'], 0, ',', '.') ?>đ</td>

                        <td>
                            <?php if ($tour['TrangThai'] === 'hoat_dong'): ?>
                                <span class="status-active">Hoạt động</span>
                            <?php else: ?>
                                <span class="status-inactive">Không hoạt động</span>
                            <?php endif; ?>
                        </td>

                        <td><?= $tour['NgayTao'] ?></td>
                        <td><?= $tour['NgayCapNhat'] ?></td>

                        <td class="actions">
                            <a href="?act=xemTour&id=<?= $tour['MaTour'] ?>">
                                <button class="btn-view">Xem</button>
                            </a>
                            <a href="?act=editTour&id=<?= $tour['MaTour'] ?>">
                                <button class="btn-edit">Sửa</button>
                            </a>
                            <a href="?act=deleteTour&id=<?= $tour['MaTour'] ?>"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa tour này không?');">
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