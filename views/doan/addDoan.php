<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thêm Đoàn Khởi Hành</title>
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

        .form-row {
            display: flex;
            gap: 15px;
        }

        .form-row .form-group {
            flex: 1;
        }

        .btn-submit {
            background-color: #1e88e5;
            color: white;
            font-weight: 600;
            padding: 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 5px;
        }

        .btn-submit:hover {
            background-color: #1565c0;
        }

        .btn-back {
            display: inline-block;
            margin-bottom: 15px;
            padding: 8px 14px;
            background: #6c757d;
            color: #fff;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
        }

        .btn-back:hover {
            background: #5a6268;
        }
    </style>
</head>

<body>
    <div class="container">

        <a href="?act=listDoan" class="btn-back">⬅ Quay lại danh sách đoàn</a>

        <h2>Thêm Đoàn Khởi Hành</h2>

        <form action="?act=addDoanProcess" method="POST">

            <div class="form-group">
                <label>Tour *</label>
                <select name="MaTour" required>
                    <option value="">-- Chọn tour --</option>
                    <?php foreach ($listTour as $t): ?>
                        <option value="<?= $t['MaTour'] ?>"><?= $t['TenTour'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Ngày khởi hành *</label>
                    <input type="date" name="NgayKhoiHanh" required>
                </div>
                <div class="form-group">
                    <label>Giờ khởi hành</label>
                    <input type="time" name="GioKhoiHanh">
                </div>
                <div class="form-group">
                    <label>Ngày về</label>
                    <input type="date" name="NgayVe">
                </div>
            </div>

            <div class="form-group">
                <label>Điểm tập trung</label>
                <input type="text" name="DiemTapTrung" placeholder="VD: Sân bay Nội Bài, VP công ty...">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Số chỗ tối đa *</label>
                    <input type="number" name="SoChoToiDa" min="1" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Hướng dẫn viên</label>
                    <select name="MaHuongDanVien">
                        <option value="">-- Chọn HDV --</option>
                        <?php foreach ($listHDV as $h): ?>
                            <option value="<?= $h['MaNhanVien'] ?>"><?= $h['HoTen'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Tài xế</label>
                    <select name="MaTaiXe">
                        <option value="">-- Chọn tài xế --</option>
                        <?php foreach ($listTaiXe as $x): ?>
                            <option value="<?= $x['MaNhanVien'] ?>"><?= $x['HoTen'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Thông tin xe</label>
                <input type="text" name="ThongTinXe" placeholder="Biển số, loại xe, hãng xe...">
            </div>

            <button type="submit" class="btn-submit">Tạo Đoàn Khởi Hành</button>
        </form>
    </div>
</body>

</html>
