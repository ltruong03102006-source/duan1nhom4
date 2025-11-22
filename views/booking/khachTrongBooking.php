<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Khách trong Booking</title>
    <style>
        body { margin: 0; background: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .header {
            background: #1e88e5; padding: 15px 20px; color: #fff;
            font-size: 20px; font-weight: bold;
        }
        .container {
            width: 95%; max-width: 1200px; margin: 20px auto;
        }
        .info-box {
            background: #fff; padding: 15px; border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08); margin-bottom: 15px;
            font-size: 14px;
        }
        .info-box strong { color: #1565c0; }
        .btn-add, .btn-back {
            padding: 8px 14px; border-radius: 6px; font-size: 14px;
            text-decoration: none; display: inline-block; margin-right: 8px;
            color: #fff;
        }
        .btn-add { background: #43a047; }
        .btn-add:hover { background: #2e7d32; }
        .btn-back { background: #6c757d; }
        .btn-back:hover { background: #5a6268; }

        table {
            width: 100%; border-collapse: collapse; background: #fff;
            border-radius: 8px; overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        th, td { padding: 9px 10px; font-size: 13px; text-align: left; }
        th { background: #0d47a1; color: #fff; }
        tr:nth-child(even) { background: #f1f1f1; }
        .actions { display: flex; gap: 5px; }
        .actions a { text-decoration: none; }
        .btn-delete {
            padding: 4px 8px; border-radius: 4px; border: none;
            background: #e53935; color: #fff; font-size: 12px; cursor: pointer;
        }
        .btn-delete:hover { background: #c62828; }
        .btn-diemdanh {
            padding: 4px 8px; border-radius: 4px; border: none;
            background: #1e88e5; color: #fff; font-size: 12px; cursor: pointer;
        }
        .btn-diemdanh:hover { background: #1565c0; }
        .badge-dd {
            padding: 2px 6px; border-radius: 10px; font-size: 11px; font-weight: 600;
        }
        .dd-yes { background:#e8f5e9; color:#2e7d32; }
        .dd-no { background:#ffebee; color:#c62828; }
    </style>
</head>
<body>

<div class="header">Khách trong Booking #<?= $booking['MaCodeBooking'] ?></div>

<div class="container">

    <div class="info-box">
        <div><strong>Tour:</strong> <?= htmlspecialchars($booking['TenTour'] ?? '') ?></div>
        <div>
            <strong>Đoàn:</strong>
            <?php if (!empty($booking['NgayKhoiHanh'])): ?>
                Khởi hành <?= date('d/m/Y', strtotime($booking['NgayKhoiHanh'])) ?>
                <?php if (!empty($booking['NgayVe'])): ?>
                    - Về <?= date('d/m/Y', strtotime($booking['NgayVe'])) ?>
                <?php endif; ?>
            <?php else: ?>
                Chưa gán đoàn
            <?php endif; ?>
        </div>
        <div><strong>Điểm tập trung:</strong> <?= htmlspecialchars($booking['DiemTapTrung'] ?? '---') ?></div>
        <div><strong>Yêu cầu đặc biệt:</strong> <?= nl2br(htmlspecialchars($booking['YeuCauDacBiet'] ?? '---')) ?></div>
    </div>

    <a href="?act=listBooking" class="btn-back">⬅ Quay lại Booking</a>
    <a href="?act=addKhachTrongBooking&MaBooking=<?= $booking['MaBooking'] ?>" class="btn-add">+ Thêm khách</a>

    <br><br>

    <table>
        <thead>
        <tr>
            <th>Họ tên</th>
            <th>Giới tính</th>
            <th>Ngày sinh</th>
            <th>Số giấy tờ</th>
            <th>SĐT</th>
            <th>Yêu cầu đặc biệt</th>
            <th>Loại phòng</th>
            <th>Điểm danh</th>
            <th>Hành động</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($listKhach as $k): ?>
            <tr>
                <td><?= htmlspecialchars($k['HoTen']) ?></td>
                <td><?= $k['GioiTinh'] ?></td>
                <td><?= $k['NgaySinh'] ?></td>
                <td><?= htmlspecialchars($k['SoGiayTo']) ?></td>
                <td><?= htmlspecialchars($k['SoDienThoai']) ?></td>
                <td><?= nl2br(htmlspecialchars($k['GhiChuDacBiet'])) ?></td>
                <td><?= $k['LoaiPhong'] ?></td>
                <td>
                    <?php if ($k['TrangThaiDiemDanh']): ?>
                        <span class="badge-dd dd-yes">Đã điểm danh</span>
                    <?php else: ?>
                        <span class="badge-dd dd-no">Chưa điểm danh</span>
                    <?php endif; ?>
                </td>
                <td class="actions">
                    <a href="?act=diemDanhProcess&MaKhachTrongBooking=<?= $k['MaKhachTrongBooking'] ?>&MaBooking=<?= $booking['MaBooking'] ?>&status=<?= $k['TrangThaiDiemDanh'] ? 0 : 1 ?>">
                        <button class="btn-diemdanh">
                            <?= $k['TrangThaiDiemDanh'] ? 'Bỏ điểm danh' : 'Điểm danh' ?>
                        </button>
                    </a>
                    <a href="?act=deleteKhachTrongBooking&MaKhachTrongBooking=<?= $k['MaKhachTrongBooking'] ?>&MaBooking=<?= $booking['MaBooking'] ?>"
                       onclick="return confirm('Xóa khách này khỏi booking?');">
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
