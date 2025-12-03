<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>📘 Tài Liệu Tour - Dành cho Hướng Dẫn Viên</title>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #333;
        padding: 20px 0;
    }

    .header {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        padding: 25px;
        color: #fff;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        margin-bottom: 30px;
    }

    .header h1 {
        font-size: 28px;
        margin-bottom: 8px;
    }

    .header .subtitle {
        font-size: 16px;
        opacity: 0.9;
    }

    .container {
        width: 95%;
        max-width: 1400px;
        margin: 0 auto;
    }

    .info-card {
        background: #fff;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 25px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 15px 20px;
        border-radius: 8px 8px 0 0;
        margin: -25px -25px 20px -25px;
        font-size: 20px;
        font-weight: bold;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .tour-title {
        font-size: 26px;
        font-weight: bold;
        color: #1e3c72;
        margin-bottom: 15px;
    }

    .tour-code {
        background: #e3f2fd;
        color: #1976d2;
        padding: 8px 15px;
        border-radius: 20px;
        display: inline-block;
        font-weight: 600;
        margin-bottom: 15px;
    }

    .tour-image {
        width: 100%;
        max-height: 400px;
        object-fit: cover;
        border-radius: 12px;
        margin: 20px 0;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 15px;
        margin: 20px 0;
    }

    .info-item {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        border-left: 4px solid #667eea;
    }

    .info-label {
        font-weight: bold;
        color: #495057;
        font-size: 14px;
        margin-bottom: 5px;
    }

    .info-value {
        font-size: 16px;
        color: #212529;
    }

    .timeline {
        position: relative;
        padding-left: 40px;
    }

    .timeline-item {
        position: relative;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 10px;
        margin-bottom: 20px;
        border-left: 4px solid #667eea;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: -42px;
        top: 25px;
        width: 20px;
        height: 20px;
        background: #667eea;
        border-radius: 50%;
        border: 4px solid white;
        box-shadow: 0 0 0 2px #667eea;
    }

    .day-title {
        font-size: 18px;
        font-weight: bold;
        color: #1e3c72;
        margin-bottom: 10px;
    }

    .activity-detail {
        line-height: 1.8;
        color: #495057;
        margin: 10px 0;
    }

    .meal-icons {
        display: flex;
        gap: 15px;
        margin: 10px 0;
        flex-wrap: wrap;
    }

    .meal-icon {
        background: #e8f5e9;
        color: #2e7d32;
        padding: 6px 12px;
        border-radius: 15px;
        font-size: 14px;
        font-weight: 600;
    }

    .meal-icon.no {
        background: #ffebee;
        color: #c62828;
    }

    .price-table {
        width: 100%;
        border-collapse: collapse;
        margin: 15px 0;
    }

    .price-table th {
        background: #667eea;
        color: white;
        padding: 12px;
        text-align: left;
        font-weight: 600;
    }

    .price-table td {
        padding: 12px;
        border-bottom: 1px solid #e0e0e0;
    }

    .price-table tr:hover {
        background: #f5f5f5;
    }

    .price-amount {
        font-weight: bold;
        color: #e53935;
        font-size: 18px;
    }

    .badge {
        padding: 5px 12px;
        border-radius: 15px;
        font-size: 13px;
        font-weight: 600;
    }

    .badge-cao-diem {
        background: #ffebee;
        color: #c62828;
    }

    .badge-thap-diem {
        background: #e8f5e9;
        color: #2e7d32;
    }

    .badge-binh-thuong {
        background: #e3f2fd;
        color: #1976d2;
    }

    .policy-box {
        background: #fffef7;
        padding: 20px;
        border-radius: 10px;
        border-left: 5px solid #ffa726;
        margin: 15px 0;
        line-height: 1.8;
    }

    .policy-title {
        font-weight: bold;
        color: #e65100;
        margin-bottom: 10px;
        font-size: 16px;
    }

    .total-box {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
        color: white;
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        margin: 20px 0;
        box-shadow: 0 4px 12px rgba(238, 90, 111, 0.3);
    }

    .total-label {
        font-size: 16px;
        margin-bottom: 5px;
    }

    .total-amount {
        font-size: 32px;
        font-weight: bold;
    }

    .note-box {
        background: #fff3cd;
        border: 1px solid #ffc107;
        padding: 15px;
        border-radius: 8px;
        margin: 20px 0;
    }

    .note-title {
        font-weight: bold;
        color: #856404;
        margin-bottom: 8px;
    }

    .back-btn {
        display: inline-block;
        margin-top: 20px;
        padding: 12px 25px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
        transition: 0.3s;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }

    .back-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(102, 126, 234, 0.5);
    }

    .empty-state {
        text-align: center;
        padding: 40px;
        color: #999;
        font-style: italic;
    }

    @media print {
        body {
            background: white;
        }
        .back-btn, .header {
            display: none;
        }
    }
</style>
</head>

<body>

<div class="header">
    <h1>📘 Tài Liệu Hướng Dẫn Tour</h1>
    <div class="subtitle">Dành cho Hướng Dẫn Viên - Chỉ Xem</div>
</div>

<div class="container">

    <!-- THÔNG TIN TOUR CƠ BẢN -->
    <div class="info-card">
        <div class="card-header">
            📋 Thông Tin Tour Cơ Bản
        </div>

        <div class="tour-title"><?= htmlspecialchars($tour['TenTour']) ?></div>
        <div class="tour-code">Mã Tour: <?= htmlspecialchars($tour['MaCodeTour']) ?></div>

        <?php if (!empty($tour['LinkAnhBia'])): ?>
            <img src="<?= $tour['LinkAnhBia'] ?>" class="tour-image" alt="<?= htmlspecialchars($tour['TenTour']) ?>">
        <?php endif; ?>

        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">📅 Thời Gian</div>
                <div class="info-value"><?= $tour['SoNgay'] ?> ngày <?= $tour['SoDem'] ?> đêm</div>
            </div>

            <div class="info-item">
                <div class="info-label">📍 Điểm Khởi Hành</div>
                <div class="info-value"><?= htmlspecialchars($tour['DiemKhoiHanh'] ?: 'Chưa xác định') ?></div>
            </div>

            <div class="info-item">
                <div class="info-label">💰 Giá Bán Mặc Định</div>
                <div class="info-value price-amount"><?= number_format($tour['GiaBanMacDinh'], 0, ',', '.') ?>đ</div>
            </div>

            <div class="info-item">
                <div class="info-label">📁 Danh Mục</div>
                <div class="info-value">
                    <?php
                    $danhMuc = [1 => "Tour trong nước", 2 => "Tour quốc tế", 3 => "Tour theo yêu cầu"];
                    echo $danhMuc[$tour['MaDanhMuc']] ?? "Chưa xác định";
                    ?>
                </div>
            </div>
        </div>

        <?php if (!empty($tour['MoTa'])): ?>
            <div style="margin-top: 20px;">
                <div class="info-label">📝 Mô Tả Tour:</div>
                <div style="line-height: 1.8; margin-top: 10px;"><?= nl2br(htmlspecialchars($tour['MoTa'])) ?></div>
            </div>
        <?php endif; ?>
    </div>

    <!-- LỊCH TRÌNH CHI TIẾT -->
    <div class="info-card">
        <div class="card-header">
            🗓️ Lịch Trình Chi Tiết
        </div>

        <?php if (!empty($lichTrinh)): ?>
            <div class="timeline">
                <?php foreach ($lichTrinh as $ngay): ?>
                    <div class="timeline-item">
                        <div class="day-title">
                            Ngày <?= $ngay['NgayThu'] ?>: <?= htmlspecialchars($ngay['TieuDeNgay']) ?>
                        </div>

                        <?php if (!empty($ngay['ChiTietHoatDong'])): ?>
                            <div class="activity-detail">
                                <?= nl2br(htmlspecialchars($ngay['ChiTietHoatDong'])) ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($ngay['DiaDiemThamQuan'])): ?>
                            <div style="margin: 10px 0;">
                                <strong>📍 Địa điểm:</strong> <?= htmlspecialchars($ngay['DiaDiemThamQuan']) ?>
                            </div>
                        <?php endif; ?>

                        <div class="meal-icons">
                            <span class="meal-icon <?= $ngay['CoBuaSang'] ? '' : 'no' ?>">
                                <?= $ngay['CoBuaSang'] ? '✓' : '✗' ?> Bữa Sáng
                            </span>
                            <span class="meal-icon <?= $ngay['CoBuaTrua'] ? '' : 'no' ?>">
                                <?= $ngay['CoBuaTrua'] ? '✓' : '✗' ?> Bữa Trưa
                            </span>
                            <span class="meal-icon <?= $ngay['CoBuaToi'] ? '' : 'no' ?>">
                                <?= $ngay['CoBuaToi'] ? '✓' : '✗' ?> Bữa Tối
                            </span>
                        </div>

                        <?php if (!empty($ngay['NoiO'])): ?>
                            <div style="margin-top: 10px;">
                                <strong>🏨 Nơi Ở:</strong> <?= htmlspecialchars($ngay['NoiO']) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">Chưa có lịch trình chi tiết</div>
        <?php endif; ?>
    </div>

    <!-- BẢNG GIÁ TOUR -->
    <div class="info-card">
        <div class="card-header">
            💰 Bảng Giá Tour (Tham Khảo)
        </div>

        <?php if (!empty($giaTour)): ?>
            <table class="price-table">
                <thead>
                    <tr>
                        <th>Loại Khách</th>
                        <th>Giá Tiền</th>
                        <th>Loại Mùa</th>
                        <th>Áp Dụng Từ</th>
                        <th>Áp Dụng Đến</th>
                        <th>Khuyến Mãi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($giaTour as $gia): ?>
                        <tr>
                            <td>
                                <?php
                                $loaiKhach = ['nguoi_lon' => 'Người lớn', 'tre_em' => 'Trẻ em', 'em_be' => 'Em bé'];
                                echo $loaiKhach[$gia['LoaiKhach']] ?? $gia['LoaiKhach'];
                                ?>
                            </td>
                            <td class="price-amount"><?= number_format($gia['GiaTien'], 0, ',', '.') ?>đ</td>
                            <td>
                                <?php
                                $loaiMua = $gia['LoaiMua'];
                                $badgeClass = 'badge-binh-thuong';
                                $text = 'Bình thường';
                                
                                if ($loaiMua == 'cao_diem') {
                                    $badgeClass = 'badge-cao-diem';
                                    $text = 'Cao điểm';
                                } elseif ($loaiMua == 'thap_diem') {
                                    $badgeClass = 'badge-thap-diem';
                                    $text = 'Thấp điểm';
                                }
                                ?>
                                <span class="badge <?= $badgeClass ?>"><?= $text ?></span>
                            </td>
                            <td><?= $gia['ApDungTuNgay'] ? date('d/m/Y', strtotime($gia['ApDungTuNgay'])) : '-' ?></td>
                            <td><?= $gia['ApDungDenNgay'] ? date('d/m/Y', strtotime($gia['ApDungDenNgay'])) : '-' ?></td>
                            <td>
                                <?php if (!empty($gia['TenKhuyenMai'])): ?>
                                    <?= htmlspecialchars($gia['TenKhuyenMai']) ?> 
                                    (<?= $gia['PhanTramGiamGia'] ?>%)
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-state">Chưa có bảng giá chi tiết</div>
        <?php endif; ?>
    </div>

    <!-- DỰ TOÁN CHI PHÍ -->
    <div class="info-card">
        <div class="card-header">
            📊 Dự Toán Chi Phí (Tham Khảo)
        </div>

        <?php if (!empty($duToan)): ?>
            <?php $tongDuToan = 0; ?>
            <table class="price-table">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Hạng Mục Chi</th>
                        <th>Số Tiền Dự Kiến</th>
                        <th>Ghi Chú</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($duToan as $index => $item): ?>
                        <?php $tongDuToan += $item['SoTienDuKien']; ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><strong><?= htmlspecialchars($item['HangMucChi']) ?></strong></td>
                            <td class="price-amount"><?= number_format($item['SoTienDuKien'], 0, ',', '.') ?>đ</td>
                            <td><?= htmlspecialchars($item['GhiChu'] ?? '-') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="total-box">
                <div class="total-label">💰 Tổng Dự Toán Chi Phí (Giá Vốn/Khách)</div>
                <div class="total-amount"><?= number_format($tongDuToan, 0, ',', '.') ?>đ</div>
            </div>
        <?php else: ?>
            <div class="empty-state">Chưa có dự toán chi phí</div>
        <?php endif; ?>
    </div>

    <!-- CHÍNH SÁCH TOUR -->
    <div class="info-card">
        <div class="card-header">
            📜 Chính Sách Tour
        </div>

        <?php if (!empty($tour['ChinhSachBaoGom'])): ?>
            <div class="policy-box">
                <div class="policy-title">✅ Chính Sách Bao Gồm:</div>
                <?= nl2br(htmlspecialchars($tour['ChinhSachBaoGom'])) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($tour['ChinhSachKhongBaoGom'])): ?>
            <div class="policy-box">
                <div class="policy-title">❌ Chính Sách Không Bao Gồm:</div>
                <?= nl2br(htmlspecialchars($tour['ChinhSachKhongBaoGom'])) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($tour['ChinhSachHuy'])): ?>
            <div class="policy-box">
                <div class="policy-title">🚫 Chính Sách Hủy Tour:</div>
                <?= nl2br(htmlspecialchars($tour['ChinhSachHuy'])) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($tour['ChinhSachHoanTien'])): ?>
            <div class="policy-box">
                <div class="policy-title">💳 Chính Sách Hoàn Tiền:</div>
                <?= nl2br(htmlspecialchars($tour['ChinhSachHoanTien'])) ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- LƯU Ý QUAN TRỌNG -->
    <div class="note-box">
        <div class="note-title">⚠️ Lưu Ý Quan Trọng:</div>
        <ul style="margin-left: 20px; line-height: 1.8;">
            <li>Hãy nghiên cứu kỹ lịch trình để chuẩn bị tốt nhất cho đoàn</li>
            <li>Lưu ý các bữa ăn và nơi ở để điều phối hợp lý</li>
            <li>Nắm rõ chính sách để tư vấn khách hàng chính xác</li>
            <li>Tài liệu này chỉ để tham khảo, không được chỉnh sửa</li>
        </ul>
    </div>

    <a class="back-btn" href="?act=tour">← Quay lại danh sách tour</a>

</div>

</body>
</html>