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
        background: #eee;
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
        display: inline-block;
    }

    .price {
        font-size: 18px;
        font-weight: bold;
        color: #e53935;
    }

    .status-active { color: #2e7d32; font-weight: bold; }
    .status-inactive { color: #c62828; font-weight: bold; }

    .price-line { display:flex; justify-content:space-between; gap:12px; align-items:baseline; }
    .price-label { font-weight:700; color:#444; }

</style>
</head>

<body>

<div class="header">Chi Tiết Tour</div>

<div class="container">

    <!-- Tên tour -->
    <div class="tour-title"><?= htmlspecialchars($tour['TenTour'] ?? '') ?></div>
    <div class="tour-code">Mã Tour: <strong><?= htmlspecialchars($tour['MaCodeTour'] ?? '') ?></strong></div>

    <!-- Ảnh bìa -->
    <?php if (!empty($tour['LinkAnhBia'])): ?>
        <img src="<?= htmlspecialchars($tour['LinkAnhBia']) ?>" class="tour-image" alt="Ảnh bìa tour">
    <?php else: ?>
        <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='1200' height='350'%3E%3Crect fill='%23e0e0e0' width='1200' height='350'/%3E%3Ctext x='50%25' y='50%25' text-anchor='middle' dy='.3em' fill='%23999' font-family='Arial' font-size='28'%3ENo Image%3C/text%3E%3C/svg%3E"
             class="tour-image" alt="No image">
    <?php endif; ?>

    <!-- Thông tin tổng quan -->
    <div class="section-title">Thông Tin Tổng Quan</div>

    <div class="grid">
        <div class="info-box">
            <strong>Danh Mục:</strong><br>
            <?= htmlspecialchars($tour['TenDanhMuc'] ?? '—') ?>
        </div>

        <div class="info-box">
            <strong>Số Ngày - Đêm:</strong><br>
            <?= (int)($tour['SoNgay'] ?? 0) ?> ngày - <?= (int)($tour['SoDem'] ?? 0) ?> đêm
        </div>

        <div class="info-box">
            <strong>Điểm Khởi Hành:</strong><br>
            <?= htmlspecialchars($tour['DiemKhoiHanh'] ?? '—') ?>
        </div>

        <div class="info-box">
            <strong>Trạng Thái:</strong><br>
            <?= ($tour['TrangThai'] ?? '') === 'hoat_dong'
                ? "<span class='status-active'>Hoạt động</span>"
                : "<span class='status-inactive'>Không hoạt động</span>" ?>
        </div>

        <!-- MỚI: Tổng dự toán (thay Giá vốn) -->
        <div class="info-box">
            <strong>Tổng Dự Toán Chi Phí:</strong><br>
            <span class="price">
                <?= number_format((float)($tour['TongDuToan'] ?? 0), 0, ',', '.') ?>đ
            </span>
        </div>

        <!-- MỚI: Giá bán tách NL/TE/EB -->
        <div class="info-box">
            <strong>Giá Bán (NL / TE / EB):</strong><br><br>

            <div class="price-line">
                <span class="price-label">👤 Người lớn</span>
                <span class="price">
                    <?= isset($tour['GiaNguoiLon']) && $tour['GiaNguoiLon'] !== null
                        ? number_format((float)$tour['GiaNguoiLon'],0,',','.') . "đ"
                        : "—" ?>
                </span>
            </div>

            <div class="price-line">
                <span class="price-label">🧒 Trẻ em</span>
                <span class="price">
                    <?= isset($tour['GiaTreEm']) && $tour['GiaTreEm'] !== null
                        ? number_format((float)$tour['GiaTreEm'],0,',','.') . "đ"
                        : "—" ?>
                </span>
            </div>

            <div class="price-line">
                <span class="price-label">👶 Em bé</span>
                <span class="price">
                    <?= isset($tour['GiaEmBe']) && $tour['GiaEmBe'] !== null
                        ? number_format((float)$tour['GiaEmBe'],0,',','.') . "đ"
                        : "—" ?>
                </span>
            </div>
        </div>
    </div>

    <!-- Mô tả -->
    <div class="section-title">Mô Tả Tour</div>
    <div class="policy-box">
        <?= nl2br(htmlspecialchars($tour['MoTa'] ?? "")) ?>
    </div>

    <!-- Chính sách -->
    <div class="section-title">Chính Sách Tour</div>

    <div class="policy-box">
        <strong>✔ Bao gồm:</strong><br><br>
        <?= nl2br(htmlspecialchars($tour['ChinhSachBaoGom'] ?? "")) ?>
    </div>

    <div class="policy-box">
        <strong>✘ Không bao gồm:</strong><br><br>
        <?= nl2br(htmlspecialchars($tour['ChinhSachKhongBaoGom'] ?? "")) ?>
    </div>

    <div class="policy-box">
        <strong>❗ Chính sách hủy:</strong><br><br>
        <?= nl2br(htmlspecialchars($tour['ChinhSachHuy'] ?? "")) ?>
    </div>

    <div class="policy-box">
        <strong>💵 Chính sách hoàn tiền:</strong><br><br>
        <?= nl2br(htmlspecialchars($tour['ChinhSachHoanTien'] ?? "")) ?>
    </div>

    <!-- Thời gian -->
    <div class="section-title">Thông Tin Thời Gian</div>
    <div class="grid">
        <div class="info-box">
            <strong>Ngày tạo:</strong><br>
            <?= htmlspecialchars($tour['NgayTao'] ?? '') ?>
        </div>

        <div class="info-box">
            <strong>Ngày cập nhật:</strong><br>
            <?= htmlspecialchars($tour['NgayCapNhat'] ?? '') ?>
        </div>
    </div>

    <br>
    <a class="back-btn" href="?act=tour">← Quay lại danh sách tour</a>

</div>

</body>
</html>
