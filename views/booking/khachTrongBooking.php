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
<br>
    <a href="?act=listBooking" class="btn-back">⬅ Quay lại Booking</a>
    <a href="?act=addKhachTrongBooking&MaBooking=<?= $booking['MaBooking'] ?>" class="btn-add">+ Thêm khách</a>
    <br>
    <form action="?act=addKhachTrongBookingProcess" method="POST">
  <input type="hidden" name="MaBooking" value="<?= (int)$booking['MaBooking'] ?>">

  <table id="tblKhach" border="1" width="100%" cellpadding="6">
    <thead>
      <tr>
        <th>Họ tên</th>
        <th>Giới tính</th>
        <th>Ngày sinh</th>
        <th>Số giấy tờ</th>
        <th>SĐT</th>
        <th>Loại phòng</th>
        <th>Ghi chú đặc biệt</th>
        <th>Xoá</th>
      </tr>
    </thead>
    <tbody>
      <!-- Dòng đầu -->
      <tr>
        <td><input name="khach[0][HoTen]" required></td>

        <td>
          <select name="khach[0][GioiTinh]">
            <option value="Nam">Nam</option>
            <option value="Nu">Nữ</option>
          </select>
        </td>

        <td><input type="date" name="khach[0][NgaySinh]"></td>

        <td><input name="khach[0][SoGiayTo]" placeholder="CCCD/Passport..."></td>

        <td><input name="khach[0][SoDienThoai]"></td>

        <td>
          <select name="khach[0][LoaiPhong]">
            <option value="don">Đơn</option>
            <option value="doi">Đôi</option>
            <option value="ba">Ba</option>
          </select>
        </td>

        <td><input name="khach[0][GhiChuDacBiet]" placeholder="Ăn chay, dị ứng..."></td>

        <td></td>
      </tr>
    </tbody>
  </table>

  <br>
  <button type="button" onclick="addRow()">+ Thêm khách</button>
  <button type="submit">💾 Lưu tất cả</button>
</form>

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
                    <?php if ((int)($k['HasAttended'] ?? 0) > 0): ?>
                        <span class="badge-dd dd-yes">Đã DD</span>
                    <?php else: ?>
                        <span class="badge-dd dd-no">Chưa DD</span>
                    <?php endif; ?>
                </td>
                <td class="actions">
                    <a href="?act=deleteKhachTrongBooking&MaKhachTrongBooking=<?= $k['MaKhachTrongBooking'] ?>&MaBooking=<?= $booking['MaBooking'] ?>"
                       onclick="return confirm('Xóa khách này khỏi booking?');">
                        <button class="btn-delete">Xóa</button>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <br><br>

    <?php if ($booking['MaDoan'] && !empty($listKhach)): ?>
    <div class="info-box" style="margin-top: 30px; border-left: 5px solid #1e88e5;">
        <strong>LỊCH SỬ ĐIỂM DANH TOÀN CHUYẾN (Đoàn #<?= $booking['MaDoan'] ?>)</strong>
    </div>

    <div class="table-responsive" style="margin-bottom: 30px;">
        <table style="width: 100%;" class="table table-bordered table-striped text-center">
            <thead style="background-color: #f8f9fa;">
                <tr>
                    <th class="text-start" style="width: 150px; background: #0d47a1; color: white; padding: 10px;">Khách hàng / Ngày</th>
                    <?php if(!empty($matrixDates)): ?>
                        <?php foreach($matrixDates as $dateLabel): ?>
                            <th style="background: #0d47a1; color: white; padding: 10px;"><?= $dateLabel ?></th>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <th style="background: #0d47a1; color: white; padding: 10px;">Chưa có dữ liệu lịch sử</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
<?php foreach ($listKhach as $khach): ?>
                <tr>
                    <td class="text-start" style="font-weight: bold;"><?= htmlspecialchars($khach['HoTen']) ?></td>
                    
                    <?php if(!empty($matrixDates)): ?>
                        <?php foreach($matrixDates as $dateLabel): ?>
                            <td>
                                <?php 
                                    // Lấy trạng thái từ mảng matrixData
                                    $cell = $matrixData[$khach['MaKhachTrongBooking']][$dateLabel] ?? null;
                                ?>
                                <?php if($cell): ?>
                                    <?php if($cell['status'] == 1): ?>
                                        <span style="color: #2e7d32;" title="<?= htmlspecialchars($cell['note']) ?>">
                                            <i class="fas fa-check-circle"></i>
                                        </span>
                                    <?php else: ?>
                                        <span style="color: #c62828; font-weight: bold;" title="<?= htmlspecialchars($cell['note']) ?>">
                                            VẮNG
                                        </span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span style="color: #999; font-size: 11px;">-</span>
                                <?php endif; ?>
                            </td>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <td></td>
                    <?php endif; ?>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div style="font-size: 12px; color: #6c757d; margin-top: 10px;">
            * Bảng này hiển thị lịch sử điểm danh của toàn bộ khách trong đoàn.
        </div>
    </div>
    <?php endif; ?>

</div>
<script>
        let idx = 1;

        function addRow() {
            const tr = document.createElement('tr');
            tr.innerHTML = `
        <td><input name="khach[${idx}][HoTen]" required></td>
        <td>
            <select name="khach[${idx}][GioiTinh]">
                <option value="Nam">Nam</option>
                <option value="Nu">Nữ</option>
            </select>
        </td>
        <td><input type="date" name="khach[${idx}][NgaySinh]"></td>
        <td><input name="khach[${idx}][SoDienThoai]"></td>
        <td>
            <select name="khach[${idx}][LoaiPhong]">
                <option value="don">Đơn</option>
                <option value="doi">Đôi</option>
                <option value="ba">Ba</option>
            </select>
        </td>
        <td><button type="button" onclick="this.closest('tr').remove()">X</button></td>
    `;
            document.querySelector('#tblKhach tbody').appendChild(tr);
            idx++;
        }
    </script>

</body>
</html>
