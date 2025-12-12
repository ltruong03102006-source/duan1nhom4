<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Sửa Đoàn Khởi Hành</title>
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

        /* --- CSS CHO THÔNG BÁO LỖI (VALIDATE) --- */
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 6px;
            font-size: 14px;
            display: flex;
            align-items: center;
        }

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .alert-icon {
            margin-right: 10px;
            font-size: 18px;
        }
    </style>
</head>

<body>
    <div class="container">

        <a href="?act=listDoan" class="btn-back">⬅ Quay lại danh sách đoàn</a>

        <h2>Sửa Đoàn Khởi Hành</h2>
        <?php if (isset($_GET['error']) && $_GET['error'] == 'capacity_exceeded'): ?>
            <div style="padding: 15px; margin-bottom: 20px; background: #f8d7da; color: #721c24; border: 1px solid #f5c2c7; border-radius: 6px;">
                ❌ Lỗi: Số chỗ tối đa không được nhỏ hơn số khách đã đặt (<b><?= $doan['DaDat'] ?? 0 ?></b> khách). Vui lòng tăng số chỗ tối đa!
            </div>
        <?php endif; ?>

        <form action="?act=editDoanProcess" method="POST">

            <input type="hidden" name="MaDoan" value="<?= $doan['MaDoan'] ?>">

            <div class="form-row">
                <div class="form-group">
                    <label>Số chỗ tối đa *</label>
                    <input type="number" name="SoChoToiDa" value="<?= $doan['SoChoToiDa'] ?>" min="<?= $doan['DaDat'] ?? 0 ?>" required>
                    <small style="color: #ef4444; margin-top: 5px;">
                        Khách đã đặt: <b><?= $doan['DaDat'] ?? 0 ?></b>.
                    </small>
                </div>
                <div class="form-group">
                    <label>Số chỗ còn trống (Tự tính)</label>
                    <input type="number" value="<?= $doan['SoChoConTrong'] ?? 0 ?>" disabled style="background-color: #f3f4f6; color: #10b981; font-weight: bold;">
                    <small style="color: #10b981; margin-top: 5px;">
                        (Tự tính: Tối đa - Đã đặt)
                    </small>
                </div>
            </div>

        </form>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger">
                <span class="alert-icon">⚠️</span>
                <span>
                    <?php
                    switch ($_GET['error']) {
                        case 'cannot_change_tour_has_booking':
                            echo "<b>Không thể đổi Tour!</b> Đoàn này đã có khách đặt (Booking). Vui lòng hủy các Booking trước khi đổi Tour.";
                            break;
                        case 'busy':
                            $role = isset($_GET['role']) && $_GET['role'] == 'hdv' ? 'Hướng dẫn viên' : 'Tài xế';
                            echo "<b>Lịch trình bị trùng!</b> $role bạn chọn đã bận trong ngày khởi hành này.";
                            break;
                        case 'system_error':
                            echo "Lỗi hệ thống, vui lòng thử lại sau.";
                            break;
                        default:
                            echo "Đã có lỗi xảy ra.";
                    }
                    ?>
                </span>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['success']) && $_GET['success'] == 'update'): ?>
            <div class="alert alert-success">
                <span class="alert-icon">✅</span> Cập nhật thông tin đoàn thành công!
            </div>
        <?php endif; ?>
        <form action="?act=editDoanProcess" method="POST">

            <input type="hidden" name="MaDoan" value="<?= $doan['MaDoan'] ?>">

            <div class="form-group">
                <label>Tour *</label>
                <select name="MaTour">
                    <?php foreach ($listTour as $t): ?>
                        <option value="<?= $t['MaTour'] ?>"
                            <?= $t['MaTour'] == $doan['MaTour'] ? 'selected' : '' ?>>
                            <?= $t['TenTour'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <small style="color: #666; font-size: 12px; margin-top: 5px;">
                    * Lưu ý: Không thể đổi Tour nếu đoàn đã có booking.
                </small>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Ngày khởi hành *</label>
                    <input type="date" name="NgayKhoiHanh" value="<?= $doan['NgayKhoiHanh'] ?>" required>
                </div>
                <div class="form-group">
                    <label>Giờ khởi hành</label>
                    <input type="time" name="GioKhoiHanh" value="<?= $doan['GioKhoiHanh'] ?>">
                </div>
                <div class="form-group">
                    <label>Ngày về</label>
                    <input type="date" name="NgayVe" value="<?= $doan['NgayVe'] ?>">
                </div>
            </div>

            <div class="form-group">
                <label>Điểm tập trung</label>
                <input type="text" name="DiemTapTrung" value="<?= $doan['DiemTapTrung'] ?>">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Số thành viên đoàn</label>
                    <input type="number" name="SoChoToiDa" value="<?= $doan['SoChoToiDa'] ?>">
                </div>
                <div class="form-group">
                    <label>Số chỗ còn trống</label>
                    <input type="number" name="SoChoConTrong" value="<?= $doan['SoChoConTrong'] ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Hướng dẫn viên</label>
                    <select name="MaHuongDanVien">
                        <option value="">-- Chọn HDV --</option>
                        <?php foreach ($listHDV as $h): ?>
                            <?php
                            $isSelected = ($h['MaNhanVien'] == ($doan['MaHuongDanVien'] ?? ''));
                            $isBusy = in_array($h['MaNhanVien'], $busyIds ?? []);
                            // Nếu đang selected thì vẫn cho chọn (không disable)
                            // Nếu muốn chặn luôn trên giao diện thì bỏ !$isSelected
                            $disabled = ($isBusy && !$isSelected) ? 'disabled' : '';
                            ?>
                            <option value="<?= $h['MaNhanVien'] ?>"
                                <?= $isSelected ? 'selected' : '' ?>
                                <?= $disabled ?>
                                style="<?= ($isBusy && !$isSelected) ? 'color: red;' : '' ?>">
                                <?= htmlspecialchars($h['HoTen']) ?> <?= ($isBusy && !$isSelected) ? '(Đang bận)' : '' ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Tài xế</label>
                    <select name="MaTaiXe">
                        <option value="">-- Chọn tài xế --</option>
                        <?php foreach ($listTaiXe as $x): ?>
                            <?php
                            $isSelected = ($x['MaNhanVien'] == ($doan['MaTaiXe'] ?? ''));
                            $isBusy = in_array($x['MaNhanVien'], $busyIds ?? []);
                            $disabled = ($isBusy && !$isSelected) ? 'disabled' : '';
                            ?>
                            <option value="<?= $x['MaNhanVien'] ?>"
                                <?= $isSelected ? 'selected' : '' ?>
                                <?= $disabled ?>
                                style="<?= ($isBusy && !$isSelected) ? 'color: red;' : '' ?>">
                                <?= htmlspecialchars($x['HoTen']) ?> <?= ($isBusy && !$isSelected) ? '(Đang bận)' : '' ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Thông tin xe</label>
                <input type="text" name="ThongTinXe" value="<?= $doan['ThongTinXe'] ?>">
            </div>

            <button type="submit" class="btn-submit">Cập nhật đoàn</button>
        </form>
    </div>
</body>

</html>