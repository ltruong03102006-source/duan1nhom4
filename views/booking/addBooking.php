<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thêm Booking</title>
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
            min-height: 60px;
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
        <a href="?act=listBooking" class="btn-back">⬅ Quay lại danh sách booking</a>

        <h2>Thêm Booking</h2>

        <form action="?act=addBookingProcess" method="POST">
            <div class="form-group">
                <label>Mã Booking *</label>
                <input type="text" name="MaCodeBooking" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Tour *</label>
                    <select name="MaTour" required>
                        <option value="">-- Chọn tour --</option>
                        <?php foreach ($listTour as $t): ?>
                            <option value="<?= $t['MaTour'] ?>"><?= $t['TenTour'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Đoàn khởi hành</label>
                    <select name="MaDoan">
                        <option value="">-- Chọn đoàn --</option>
                        <?php foreach ($listDoan as $d): ?>
                            <option value="<?= $d['MaDoan'] ?>">
                                [#<?= $d['MaDoan'] ?>] <?= $d['TenTour'] ?> -
                                <?= date('d/m/Y', strtotime($d['NgayKhoiHanh'])) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Khách hàng (người đại diện) *</label>
                <select name="MaKhachHang" required>
                    <option value="">-- Chọn khách hàng --</option>
                    <?php foreach ($listKhachHang as $kh): ?>
                        <option value="<?= $kh['MaKhachHang'] ?>">
                            [<?= $kh['MaCodeKhachHang'] ?>] <?= $kh['HoTen'] ?> - <?= $kh['SoDienThoai'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Loại booking</label>
                    <select name="LoaiBooking">
                        <option value="ca_nhan">Cá nhân</option>
                        <option value="nhom">Nhóm</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Số người lớn</label>
                    <input type="number" name="TongNguoiLon" min="0" value="1">
                </div>
                <div class="form-group">
                    <label>Số trẻ em</label>
                    <input type="number" name="TongTreEm" min="0" value="0">
                </div>
                <div class="form-group">
                    <label>Số em bé</label>
                    <input type="number" name="TongEmBe" min="0" value="0">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Tổng tiền (VNĐ)</label>
                    <input type="number" id="TongTien" name="TongTien" min="0" step="1000">
                </div>
                <div class="form-group">
                    <label>Số tiền đã cọc (VNĐ)</label>
                    <input type="number" id="SoTienDaCoc" name="SoTienDaCoc" min="0" step="1000">
                </div>
                <div class="form-group">
                    <label>Số tiền đã trả (VNĐ)</label>
                    <input type="number" id="SoTienDaTra" name="SoTienDaTra" min="0" step="1000" readonly>
                </div>
            </div>

            <div class="form-group">
                <label>Yêu cầu đặc biệt</label>
                <textarea name="YeuCauDacBiet"></textarea>
            </div>

            <button type="submit" class="btn-submit">Tạo Booking</button>
        </form>
    </div>
    <script>
        const tongTienEl = document.getElementById('TongTien');
        const daCocEl = document.getElementById('SoTienDaCoc');
        const daTraEl = document.getElementById('SoTienDaTra');

        function toNumber(v) {
            const n = parseFloat(v);
            return isNaN(n) ? 0 : n;
        }

        function tinhTienConLai() {
            const tongTien = toNumber(tongTienEl.value);
            const daCoc = toNumber(daCocEl.value);

            // Số tiền đã trả = Tổng tiền - Đã cọc (tức còn lại)
            let conLai = tongTien - daCoc;
            if (conLai < 0) conLai = 0;

            daTraEl.value = conLai;
            if (daCoc > tongTien) {
                daTraEl.value = 0;
                return;
            }
        }

        tongTienEl.addEventListener('input', tinhTienConLai);
        daCocEl.addEventListener('input', tinhTienConLai);

        // chạy lần đầu nếu có sẵn dữ liệu
        tinhTienConLai();
    </script>

</body>

</html>