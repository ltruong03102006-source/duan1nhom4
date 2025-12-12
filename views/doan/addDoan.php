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
                <select name="MaTour" id="selectTour" required onchange="calculateNgayVe()">
    <option value="" data-songay="0">-- Chọn tour --</option>
    <?php foreach ($listTour as $t): ?>
        <option value="<?= $t['MaTour'] ?>" data-songay="<?= $t['SoNgay'] ?>">
            <?= $t['TenTour'] ?> (<?= $t['SoNgay'] ?> ngày)
        </option>
    <?php endforeach; ?>
</select>
            </div>

            <div class="form-row">
                <div class="form-group">
    <label>Ngày khởi hành *</label>
    <input type="date" name="NgayKhoiHanh" id="ngayKhoiHanh" required onchange="calculateNgayVe()">
</div>
                <div class="form-group">
                    <label>Giờ khởi hành</label>
                    <input type="time" name="GioKhoiHanh">
                </div>
                <div class="form-group">
    <label>Ngày về</label>
    <input type="date" name="NgayVe" id="ngayVe"> </div>
            </div>

            <div class="form-group">
                <label>Điểm tập trung</label>
                <input type="text" name="DiemTapTrung" placeholder="VD: Sân bay Nội Bài, VP công ty...">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Số thành viên đoàn</label>
                    <input type="number" name="SoChoToiDa" min="1" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Hướng dẫn viên</label>
                    <select name="MaHuongDanVien">
                        <option value="">-- Chọn HDV --</option>
                        <?php foreach ($listHDV as $h): ?>
                            <?php $isBusy = in_array($h['MaNhanVien'], $busyIds ?? []); ?>
                            <option value="<?= $h['MaNhanVien'] ?>" <?= $isBusy ? 'disabled' : '' ?>>
                                <?= htmlspecialchars($h['HoTen']) ?> <?= $isBusy ? '(Bận)' : '' ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                </div>

                <div class="form-group">
                    <label>Tài xế</label>
                    <select name="MaTaiXe">
                        <option value="">-- Chọn tài xế --</option>
                        <?php foreach ($listTaiXe as $x): ?>
                            <?php $isBusy = in_array($x['MaNhanVien'], $busyIds ?? []); ?>
                            <option value="<?= $x['MaNhanVien'] ?>" <?= $isBusy ? 'disabled' : '' ?>>
                                <?= htmlspecialchars($x['HoTen']) ?> <?= $isBusy ? '(Bận)' : '' ?>
                            </option>
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
<script>
    function calculateNgayVe() {
        // 1. Lấy đối tượng DOM
        var tourSelect = document.getElementById('selectTour');
        var ngayKhoiHanhInput = document.getElementById('ngayKhoiHanh');
        var ngayVeInput = document.getElementById('ngayVe');

        // 2. Lấy giá trị
        // Lấy số ngày từ attribute data-songay của option đang được chọn
        var selectedOption = tourSelect.options[tourSelect.selectedIndex];
        var soNgayTour = parseInt(selectedOption.getAttribute('data-songay')) || 0;
        
        var ngayKhoiHanhVal = ngayKhoiHanhInput.value;

        // 3. Kiểm tra nếu có đủ dữ liệu thì tính
        if (soNgayTour > 0 && ngayKhoiHanhVal) {
            var date = new Date(ngayKhoiHanhVal);
            
            // Logic: Ngày về = Ngày khởi hành + (Số ngày tour - 1)
            // Ví dụ: Tour 3 ngày, đi ngày 1 thì về ngày 3 (1 + 3 - 1)
            if (soNgayTour >= 1) {
                date.setDate(date.getDate() + (soNgayTour - 1));
            }

            // 4. Format lại thành chuỗi yyyy-mm-dd để gán vào input type=date
            var year = date.getFullYear();
            var month = ("0" + (date.getMonth() + 1)).slice(-2);
            var day = ("0" + date.getDate()).slice(-2);

            var ngayVeMoi = `${year}-${month}-${day}`;
            
            // Gán giá trị
            ngayVeInput.value = ngayVeMoi;
        }
    }
</script>