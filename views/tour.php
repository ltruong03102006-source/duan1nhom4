<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản Lý Tour</title>

    <style>
        body {
            margin: 0;
            background: #f4f6f9;
            font-family: Arial, sans-serif;
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
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        th, td {
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
            padding: 6px 12px;
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

        img.thumb {
            width: 80px;
            height: 55px;
            object-fit: cover;
            border-radius: 4px;
        }
    </style>
</head>

<body>

    <div class="header">Quản Lý Tour</div>

    <div class="container">

        <a href="?act=addTour">
            <button class="btn-add">+ Thêm Tour Mới</button>
        </a>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ảnh</th>
                    <th>Code Tour</th>
                    <th>Tên Tour</th>
                    <th>Danh Mục</th>
                    <th>Ngày - Đêm</th>
                    <th>Điểm Khởi Hành</th>
                    <th>Giá Bán</th>
                    <th>Trạng Thái</th>
                    <th>Hành Động</th>
                </tr>
            </thead>

            <tbody>
            <?php foreach ($listTour as $tour): ?>
                <tr>
                    <td><?= $tour['MaTour'] ?></td>

                    <td>
                        <img src="<?= $tour['LinkAnhBia'] ?>" class="thumb">
                    </td>

                    <td><?= $tour['MaCodeTour'] ?></td>
                    <td><?= $tour['TenTour'] ?></td>

                    <td><?= $tour['MaDanhMuc'] ?></td>

                    <td><?= $tour['SoNgay'] ?>N - <?= $tour['SoDem'] ?>Đ</td>

                    <td><?= $tour['DiemKhoiHanh'] ?></td>

                    <td><?= number_format($tour['GiaBanMacDinh'], 0, ',', '.') ?>đ</td>

                    <td>
                        <?= $tour['TrangThai'] == 'hoat_dong' ? 'Hoạt động' : 'Không hoạt động' ?>
                    </td>

                    <td class="actions">
                        <a href="?act=editTour&id=<?= $tour['MaTour'] ?>">
                            <button class="btn-edit">Sửa</button>
                        </a>

                        <a href="?act=deleteTour&id=<?= $tour['MaTour'] ?>"
                           onclick="return confirm('Bạn có chắc muốn xóa tour này?');">
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
