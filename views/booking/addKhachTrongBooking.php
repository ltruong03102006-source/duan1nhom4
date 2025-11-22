<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm khách trong Booking</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background-color: #f4f6f8; margin: 0; padding: 0; }
        .container {
            max-width: 700px; margin: 40px auto; background: white;
            padding: 30px; border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        h2 { text-align: center; color: #2c3e50; margin-bottom: 20px; }
        form { display: flex; flex-direction: column; gap: 15px; }
        .form-group { display: flex; flex-direction: column; }
        label { font-weight: 600; margin-bottom: 5px; color: #34495e; }
        input, select, textarea {
            padding: 10px; border: 1px solid #dcdde1;
            border-radius: 6px; font-size: 15px;
        }
        textarea { resize: vertical; min-height: 60px; }
        .form-row { display: flex; gap: 15px; }
        .form-row .form-group { flex: 1; }
        .btn-submit {
            background-color: #43a047; color: white; font-weight: 600;
            padding: 12px; border: none; border-radius: 6px;
            cursor: pointer; transition: 0.3s;
        }
        .btn-submit:hover { background-color: #2e7d32; }
        .btn-back {
            display: inline-block; margin-bottom: 15px;
            padding: 8px 14px; background: #6c757d;
            color: #fff; border-radius: 6px;
            text-decoration: none; font-size: 14px;
        }
        .btn-back:hover { background: #5a6268; }
    </style>
</head>
<body>

<div class="container">
    <a href="?act=khachTrongBooking&MaBooking=<?= $booking['MaBooking'] ?>" class="btn-back">⬅ Quay lại danh sách khách</a>

    <h2>Thêm khách vào Booking #<?= $booking['MaCodeBooking'] ?></h2>

    <form action="?act=addKhachTrongBookingProcess" method="POST">
        <input type="hidden" name="MaBooking" value="<?= $booking['MaBooking'] ?>">

        <div class="form-group">
            <label>Họ tên *</label>
            <input type="text" name="HoTen" required>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Giới tính</label>
                <select name="GioiTinh">
                    <option value="">-- Chọn --</option>
                    <option value="nam">Nam</option>
                    <option value="nu">Nữ</option>
                    <option value="khac">Khác</option>
                </select>
            </div>
            <div class="form-group">
                <label>Ngày sinh</label>
                <input type="date" name="NgaySinh">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Số giấy tờ (CMND/CCCD/Hộ chiếu)</label>
                <input type="text" name="SoGiayTo">
            </div>
            <div class="form-group">
                <label>Số điện thoại</label>
                <input type="text" name="SoDienThoai">
            </div>
        </div>

        <div class="form-group">
            <label>Yêu cầu / Ghi chú đặc biệt</label>
            <textarea name="GhiChuDacBiet"></textarea>
        </div>

        <div class="form-group">
            <label>Loại phòng</label>
            <select name="LoaiPhong">
                <option value="">-- Chọn --</option>
                <option value="don">Phòng đơn</option>
                <option value="doi">Phòng đôi</option>
                <option value="2_giuong">2 giường</option>
            </select>
        </div>

        <button type="submit" class="btn-submit">Thêm khách</button>
    </form>
</div>

</body>
</html>
