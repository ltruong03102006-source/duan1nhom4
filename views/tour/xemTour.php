<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Chi Tiết Tour Du Lịch</title>

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
        width: 90%;
        max-width: 1100px;
        margin: 25px auto;
        background: #fff;
        border-radius: 10px;
        padding: 25px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .tour-title {
        font-size: 24px;
        font-weight: bold;
        color: #1e88e5;
        margin-bottom: 10px;
    }

    .tour-code {
        color: #666;
        margin-bottom: 20px;
    }

    .tour-image {
        width: 100%;
        height: 350px;
        object-fit: cover;
        border-radius: 10px;
        border: 1px solid #ccc;
        margin-bottom: 25px;
    }

    .section-title {
        font-size: 18px;
        font-weight: bold;
        margin-top: 25px;
        margin-bottom: 10px;
        color: #0d47a1;
    }

    .info-box {
        padding: 15px;
        background: #f1f1f1;
        border-radius: 8px;
        margin-bottom: 10px;
    }

    .grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }

    .policy-box {
        background: #fafafa;
        padding: 15px;
        border-left: 4px solid #1e88e5;
        border-radius: 5px;
        margin-bottom: 15px;
    }

    .back-btn {
        margin-top: 25px;
        padding: 10px 16px;
        background: #1e88e5;
        color: #fff;
        border-radius: 6px;
        text-decoration: none;
        font-weight: bold;
    }

    .price {
        font-size: 20px;
        font-weight: bold;
        color: #e53935;
    }

    .status-active { color: #2e7d32; font-weight: bold; }
    .status-inactive { color: #c62828; font-weight: bold; }

</style>
</head>

<body>

<div class="header">Chi Tiết Tour</div>

<div class="container">

    <!-- Tên tour -->
    <div class="tour-title"><?= $tour['TenTour'] ?></div>
    <div class="tour-code">Mã Tour: <strong><?= $tour['MaCodeTour'] ?></strong></div>

    <!-- Ảnh bìa -->
    <img src="<?= $tour['LinkAnhBia'] ?>" class="tour-image">

    <!-- Thông tin tổng quan -->
    <div class="section-title">Thông Tin Tổng Quan</div>

    <div class="grid">
        <div class="info-box">
            <strong>Danh Mục:</strong><br>
            <?= $tour['MaDanhMuc'] == 1 ? "Tour trong nước" : ($tour['MaDanhMuc']==2 ? "Tour quốc tế" : "Tour theo yêu cầu") ?>
        </div>

        <div class="info-box">
            <strong>Số Ngày - Đêm:</strong><br>
            <?= $tour['SoNgay'] ?> ngày - <?= $tour['SoDem'] ?> đêm
        </div>

        <div class="info-box">
            <strong>Điểm Khởi Hành:</strong><br>
            <?= $tour['DiemKhoiHanh'] ?>
        </div>

        <div class="info-box">
            <strong>Trạng Thái:</strong><br>
            <?= $tour['TrangThai'] == 'hoat_dong' 
                ? "<span class='status-active'>Hoạt động</span>" 
                : "<span class='status-inactive'>Không hoạt động</span>" ?>
        </div>

        <div class="info-box">
            <strong>Giá Vốn Dự Kiến:</strong><br>
            <span class="price"><?= number_format($tour['GiaVonDuKien'],0,',','.') ?>đ</span>
        </div>

        <div class="info-box">
            <strong>Giá Bán Mặc Định:</strong><br>
            <span class="price"><?= number_format($tour['GiaBanMacDinh'],0,',','.') ?>đ</span>
        </div>
    </div>

    <!-- Mô tả -->
    <div class="section-title">Mô Tả Tour</div>
    <div class="policy-box">
        <?= nl2br($tour['MoTa'] ?? "") ?>
    </div>

    <!-- Chính sách -->
    <div class="section-title">Chính Sách Tour</div>

    <div class="policy-box">
        <strong>✔ Bao gồm:</strong><br><br>
        <?= nl2br($tour['ChinhSachBaoGom'] ?? "") ?>
    </div>

    <div class="policy-box">
        <strong>✘ Không bao gồm:</strong><br><br>
        <?= nl2br($tour['ChinhSachKhongBaoGom'] ?? "") ?>
    </div>

    <div class="policy-box">
        <strong>❗ Chính sách hủy:</strong><br><br>
        <?= nl2br($tour['ChinhSachHuy'] ?? "") ?>
    </div>

    <!-- Thời gian -->
    <div class="section-title">Thông Tin Thời Gian</div>
    <div class="grid">
        <div class="info-box">
            <strong>Ngày tạo:</strong><br>
            <?= $tour['NgayTao'] ?>
        </div>

        <div class="info-box">
            <strong>Ngày cập nhật:</strong><br>
            <?= $tour['NgayCapNhat'] ?>
        </div>
    </div>
    <br>
    <!-- Nút quay lại -->
    <a class="back-btn" href="?act=tour">← Quay lại danh sách tour</a>

</div>

</body>
</html>
