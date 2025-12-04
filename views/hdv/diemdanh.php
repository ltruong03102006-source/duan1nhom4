<div class="container-fluid px-4">
    <h1 class="mt-4">✅ Điểm Danh Khách</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="?act=hdvHome">Dashboard HDV</a></li>
        <li class="breadcrumb-item active">Điểm danh</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-users me-1"></i>
            <?php if (!empty($doanInfo)): ?>
                Đoàn #<?= $doanInfo['MaDoan'] ?> • <?= htmlspecialchars($doanInfo['TenTour']) ?>
                (<?= htmlspecialchars($doanInfo['MaCodeTour'] ?? '') ?>)
                • <?= date('d/m/Y', strtotime($doanInfo['NgayKhoiHanh'])) ?> → <?= date('d/m/Y', strtotime($doanInfo['NgayVe'])) ?>
            <?php else: ?>
                Danh sách khách
            <?php endif; ?>
        </div>

        <div class="card-body">
            <?php if (empty($listKhach)): ?>
                <p class="text-muted">Chưa có khách nào trong đoàn này.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th>#</th>
                                <th>Họ tên</th>
                                <th>SĐT</th>
                                <th>Giấy tờ</th>
                                <th>Booking</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; foreach ($listKhach as $k): ?>
                                <?php $dd = (int)($k['TrangThaiDiemDanh'] ?? 0); ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= htmlspecialchars($k['HoTen'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($k['SoDienThoai'] ?? '---') ?></td>
                                    <td><?= htmlspecialchars($k['SoGiayTo'] ?? '---') ?></td>
                                    <td>
                                        <?= htmlspecialchars($k['MaCodeBooking'] ?? ('#' . $k['MaBooking'])) ?>
                                    </td>
                                    <td>
                                        <?php if ($dd === 1): ?>
                                            <span class="badge bg-success">Đã có mặt</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Chưa điểm danh</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="white-space:nowrap;">
                                        <form action="?act=hdvDiemDanhProcess" method="POST" style="display:inline;">
                                            <input type="hidden" name="MaDoan" value="<?= htmlspecialchars($_GET['MaDoan']) ?>">
                                            <input type="hidden" name="MaKhachTrongBooking" value="<?= $k['MaKhachTrongBooking'] ?>">
                                            <input type="hidden" name="status" value="<?= $dd === 1 ? 0 : 1 ?>">
                                            <button class="btn btn-sm <?= $dd === 1 ? 'btn-outline-danger' : 'btn-success' ?>">
                                                <?= $dd === 1 ? 'Bỏ điểm danh' : 'Có mặt' ?>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

            <a href="?act=hdvHome" class="btn btn-secondary mt-3">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>
</div>
