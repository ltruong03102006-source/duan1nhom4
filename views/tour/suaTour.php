<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Tour Du Lịch</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: #f4f6f8;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: 600;
            margin-bottom: 5px;
            color: #34495e;
        }

        input,
        select,
        textarea {
            padding: 10px;
            border: 1px solid #dcdde1;
            border-radius: 6px;
            font-size: 15px;
        }

        textarea {
            resize: vertical;
            min-height: 80px;
        }

        .form-row {
            display: flex;
            gap: 15px;
        }

        .form-row .form-group {
            flex: 1;
        }

        .btn-submit {
            background-color: #e67e22;
            color: white;
            font-weight: 600;
            padding: 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-submit:hover {
            background-color: #d35400;
        }

        .preview-img {
            width: 180px;
            height: 120px;
            object-fit: cover;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-top: 8px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Sửa Tour Du Lịch</h2>

        <form action="?act=editTourProcess" method="POST" enctype="multipart/form-data">

            <!-- Hidden ID -->
            <input type="hidden" name="MaTour" value="<?= $tour['MaTour'] ?>">

            <div class="form-group">
                <label>Mã Code Tour *</label>
                <input type="text" name="MaCodeTour" value="<?= $tour['MaCodeTour'] ?>" required>
            </div>

            <div class="form-group">
                <label>Tên Tour *</label>
                <input type="text" name="TenTour" value="<?= $tour['TenTour'] ?>" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Danh Mục Tour</label>
                    <select name="MaDanhMuc">
                        <?php foreach ($listDanhMuc as $dm): ?>
                            <option value="<?= $dm['MaDanhMuc'] ?>"
                                <?= $tour['MaDanhMuc'] == $dm['MaDanhMuc'] ? 'selected' : '' ?>>
                                <?= $dm['TenDanhMuc'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Số ngày</label>
                    <input type="number" name="SoNgay" value="<?= $tour['SoNgay'] ?>">
                </div>

                <div class="form-group">
                    <label>Số đêm</label>
                    <input type="number" name="SoDem" value="<?= $tour['SoDem'] ?>">
                </div>
            </div>

            <div class="form-group">
                <label>Điểm khởi hành</label>
                <input type="text" name="DiemKhoiHanh" value="<?= $tour['DiemKhoiHanh'] ?>">
            </div>

            <div class="form-group">
                <label>Mô tả Tour</label>
                <textarea name="MoTa"><?= $tour['MoTa'] ?? "" ?></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Giá vốn dự kiến (VNĐ)</label>
                    <input type="number" name="GiaVonDuKien" step="0.01" value="<?= $tour['GiaVonDuKien'] ?>">
                </div>

                <div class="form-group">
                    <label>Giá bán mặc định (VNĐ)</label>
                    <input type="number" name="GiaBanMacDinh" step="0.01" value="<?= $tour['GiaBanMacDinh'] ?>">
                </div>
            </div>

            <div class="form-group">
                <label>Ảnh bìa Tour</label>
                <input type="file" name="LinkAnhBia" accept="image/*">

                <input type="hidden" name="old_image" value="<?= $tour['LinkAnhBia'] ?>">

                <?php if (!empty($tour['LinkAnhBia'])): ?>
                    <img src="<?= $tour['LinkAnhBia'] ?>" class="preview-img">
                <?php endif; ?>

            </div>

            <div class="form-group">
                <label>Chính sách bao gồm</label>
                <textarea name="ChinhSachBaoGom"><?= $tour['ChinhSachBaoGom'] ?? "" ?></textarea>
            </div>

            <div class="form-group">
                <label>Chính sách không bao gồm</label>
                <textarea name="ChinhSachKhongBaoGom"><?= $tour['ChinhSachKhongBaoGom'] ?? "" ?></textarea>
            </div>

            <div class="form-group">
                <label>Chính sách hủy tour</label>
                <textarea name="ChinhSachHuy"><?= $tour['ChinhSachHuy'] ?? "" ?></textarea>
            </div>

            <div class="form-group">
                <label>Trạng thái</label>
                <select name="TrangThai">
                    <option value="hoat_dong" <?= $tour['TrangThai'] == 'hoat_dong' ? 'selected' : '' ?>>Hoạt động</option>
                    <option value="khong_hoat_dong" <?= $tour['TrangThai'] == 'khong_hoat_dong' ? 'selected' : '' ?>>Không hoạt động</option>
                </select>
            </div>

            <button type="submit" class="btn-submit">Cập Nhật Tour</button>
        </form>
    </div>

</body>

</html>