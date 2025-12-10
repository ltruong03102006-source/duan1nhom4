<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản lý Danh Mục Tour</title>
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
            width: 90%;
            max-width: 1100px;
            margin: 25px auto;
        }

        /* FORM */
        .card {
            background: #fff;
            padding: 20px;
            margin-bottom: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .card h2 {
            margin-top: 0;
            font-size: 20px;
            color: #0d47a1;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 6px;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 8px 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        button {
            background: #1e88e5;
            color: #fff;
            padding: 10px 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
        }

        button:hover {
            background: #1565c0;
        }

        /* TABLE */
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
        }

        th {
            background: #0d47a1;
            color: white;
        }

        tr:nth-child(even) {
            background: #f1f1f1;
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

        .actions button {
            margin-right: 5px;
        }
    </style>
</head>

<body>

    <div class="header">Quản Lý Danh Mục Tour</div>

    <div class="container">

        <?php if (isset($_GET['error']) && $_GET['error'] == 'in_use'): ?>
            <div style="padding: 15px; margin-bottom: 20px; background: #f8d7da; color: #721c24; border: 1px solid #f5c2c7; border-radius: 6px;">
                ❌ Không thể xóa danh mục này vì đang có Tour sử dụng. Vui lòng xóa hoặc chuyển Tour sang danh mục khác trước.
            </div>
        <?php endif; ?>
        
        <?php if (isset($_GET['success']) && $_GET['success'] == 'deleted'): ?>
            <div style="padding: 15px; margin-bottom: 20px; background: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 6px;">
                ✅ Xóa danh mục thành công!
            </div>
        <?php endif; ?>

        <div class="card">
            <h2>Thêm Danh Mục Tour</h2>

            <form action="?act=addDanhMucTourProcess" method="POST">

                <div class="form-group">
                    <label>Tên danh mục:</label>
                    <input type="text" name="tenDanhMuc" placeholder="Nhập tên danh mục..." required>
                </div>

                <div class="form-group">
                    <label>Mô tả:</label>
                    <textarea rows="3" name="moTa" placeholder="Nhập mô tả..."></textarea>
                </div>

                <button type="submit">Thêm danh mục</button>

            </form>
            <br>

            <!-- BẢNG DANH MỤC -->
            <table>
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên danh mục</th>
                        <th>Mô tả</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dmTour as $tour): ?>
                        <tr>
                            <td><?= $tour['MaDanhMuc'] ?></td>
                            <td><?= $tour['TenDanhMuc'] ?></td>
                            <td><?= $tour['MoTa'] ?></td>

                            <td class="actions">
                                <a href="?act=editDanhMucTour&id=<?= $tour['MaDanhMuc'] ?>">
                                    <button class="btn-edit">Sửa</button>
                                </a>
                                <a href="?act=deleteDanhMucTour&id=<?= $tour['MaDanhMuc'] ?>"
                                    onclick="return confirm('Bạn có chắc muốn xóa danh mục này?');">
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