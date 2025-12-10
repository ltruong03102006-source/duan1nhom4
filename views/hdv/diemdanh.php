<?php require_once 'views/header.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">
        <i class="fas fa-clipboard-list me-2"></i>
        Điểm Danh Đoàn: <?= htmlspecialchars($thongTinDoan['TenDoan'] ?? 'Chưa xác định') ?>
    </h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="?act=homeHDV">Trang chủ HDV</a></li>
        <li class="breadcrumb-item active">Quản lý khách & Điểm danh</li>
    </ol>

    <?php if (isset($_GET['msg'])): ?>
        <?php if ($_GET['msg'] == 'success'): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-1"></i> Đã lưu dữ liệu điểm danh thành công!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php elseif ($_GET['msg'] == 'update_ok'): ?>
            <div class="alert alert-primary alert-dismissible fade show" role="alert">
                <i class="fas fa-info-circle me-1"></i> Cập nhật thông tin khách hàng thành công!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <span class="fw-bold"><i class="fas fa-user-check me-1"></i> CHECK-IN KHÁCH HÀNG</span>
            
            <form action="" method="GET" class="d-flex align-items-center bg-white rounded px-2 py-1 text-dark">
                <input type="hidden" name="act" value="hdvDiemDanh">
                <input type="hidden" name="MaDoan" value="<?= $MaDoan ?>">
                <label class="me-2 fw-bold mb-0 text-dark">Chọn ngày:</label>
                <input type="date" name="date" value="<?= $NgayDiemDanh ?>" 
                       class="form-control form-control-sm border-0 fw-bold text-primary" 
                       style="cursor: pointer;"
                       onchange="this.form.submit()">
            </form>
        </div>

        <div class="card-body">
            <form action="?act=hdvDiemDanhProcess" method="POST">
                <input type="hidden" name="MaDoan" value="<?= $MaDoan ?>">
                <input type="hidden" name="NgayDiemDanh" value="<?= $NgayDiemDanh ?>">

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" width="5%">STT</th>
                                <th width="20%">Họ và Tên</th>
                                <th width="25%">Thông tin & Yêu cầu (Sửa)</th>
                                <th class="text-center" width="25%">
                                    Trạng thái (<?= date('d/m/Y', strtotime($NgayDiemDanh)) ?>)
                                </th>
                                <th>Ghi chú điểm danh</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($danhSachKhach)): ?>
                                <?php foreach ($danhSachKhach as $key => $khach): ?>
                                    <?php 
                                        // Xác định trạng thái hiện tại (Mặc định là 1-Có mặt nếu chưa điểm danh bao giờ)
                                        $currentStatus = $khach['TrangThaiDiemDanh'] ?? 1; 
                                    ?>
                                    <tr>
                                        <td class="text-center"><?= $key + 1 ?></td>
                                        <td class="fw-bold text-primary">
                                            <?= htmlspecialchars($khach['HoTen']) ?>
                                            <input type="hidden" name="names[<?= $khach['MaKhachTrongBooking'] ?>]" value="<?= $khach['HoTen'] ?>">
                                        </td>
                                        
                                        <td>
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div class="small">
                                                    <?php if(!empty($khach['GhiChuDacBiet'])): ?>
                                                        <div class="text-danger fw-bold"><i class="fas fa-exclamation-triangle"></i> <?= htmlspecialchars($khach['GhiChuDacBiet']) ?></div>
                                                    <?php else: ?>
                                                        <div class="text-muted fst-italic">Không có yêu cầu</div>
                                                    <?php endif; ?>
                                                    
                                                    <div class="text-secondary mt-1">
                                                        <i class="fas fa-bed"></i> Phòng: <?= htmlspecialchars($khach['LoaiPhong'] ?? 'Chưa xếp') ?>
                                                    </div>
                                                </div>
                                                
                                                <button type="button" class="btn btn-sm btn-outline-secondary ms-2" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#modalEditInfo_<?= $khach['MaKhachTrongBooking'] ?>"
                                                        title="Sửa thông tin khách">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </div>

                                            <div class="modal fade" id="modalEditInfo_<?= $khach['MaKhachTrongBooking'] ?>" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form action="?act=hdvUpdateInfoKhach" method="POST"> <div class="modal-header bg-info text-white">
                                                                <h5 class="modal-title">Cập nhật: <?= $khach['HoTen'] ?></h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <input type="hidden" name="MaDoan" value="<?= $MaDoan ?>">
                                                                <input type="hidden" name="MaKhach" value="<?= $khach['MaKhachTrongBooking'] ?>">
                                                                <input type="hidden" name="currentDate" value="<?= $NgayDiemDanh ?>">

                                                                <div class="mb-3">
                                                                    <label class="form-label fw-bold">Yêu cầu đặc biệt (Ăn chay, dị ứng, xe lăn...)</label>
                                                                    <textarea name="GhiChuDacBiet" class="form-control" rows="3"><?= $khach['GhiChuDacBiet'] ?></textarea>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-bold">Loại phòng / Số phòng</label>
                                                                    <input type="text" name="LoaiPhong" class="form-control" value="<?= $khach['LoaiPhong'] ?>">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" formaction="?act=hdvUpdateInfoKhach" class="btn btn-info text-white">Lưu thay đổi</button>
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                            </div>
                                                        </form> </div>
                                                </div>
                                            </div>
                                            </td>

                                        <td class="text-center">
                                            <div class="btn-group w-100" role="group">
                                                <input type="radio" class="btn-check" 
                                                       name="status[<?= $khach['MaKhachTrongBooking'] ?>]" 
                                                       id="present_<?= $khach['MaKhachTrongBooking'] ?>" 
                                                       value="1" <?= $currentStatus == 1 ? 'checked' : '' ?>>
                                                <label class="btn btn-outline-success" for="present_<?= $khach['MaKhachTrongBooking'] ?>">
                                                    <i class="fas fa-check"></i> Có
                                                </label>

                                                <input type="radio" class="btn-check" 
                                                       name="status[<?= $khach['MaKhachTrongBooking'] ?>]" 
                                                       id="absent_<?= $khach['MaKhachTrongBooking'] ?>" 
                                                       value="0" <?= ($currentStatus == 0 && $khach['TrangThaiDiemDanh'] !== null) ? 'checked' : '' ?>>
                                                <label class="btn btn-outline-danger" for="absent_<?= $khach['MaKhachTrongBooking'] ?>">
                                                    <i class="fas fa-times"></i> Vắng
                                                </label>
                                            </div>
                                        </td>

                                        <td>
                                            <input type="text" class="form-control form-control-sm" 
                                                   name="note[<?= $khach['MaKhachTrongBooking'] ?>]" 
                                                   value="<?= htmlspecialchars($khach['GhiChuDiemDanh'] ?? '') ?>" 
                                                   placeholder="Lý do (nếu vắng)...">
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="5" class="text-center py-4">Chưa có khách trong đoàn này.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-lg btn-success px-5">
                        <i class="fas fa-save me-2"></i> LƯU ĐIỂM DANH
                    </button>
                    <a href="?act=homeHDV" class="btn btn-lg btn-secondary">Thoát</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card mb-4 border-info">
        <div class="card-header bg-info text-white">
            <i class="fas fa-history me-1"></i>
            <strong>LỊCH SỬ ĐIỂM DANH TOÀN CHUYẾN (VIEW TỔNG QUÁT)</strong>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center">
                    <thead class="table-secondary">
                        <tr>
                            <th class="text-start">Khách hàng / Ngày</th>
                            <?php if(!empty($matrixDates)): ?>
                                <?php foreach($matrixDates as $dateLabel): ?>
                                    <th><?= $dateLabel ?></th>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <th>Chưa có dữ liệu lịch sử</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($danhSachKhach as $khach): ?>
                        <tr>
                            <td class="text-start fw-bold"><?= htmlspecialchars($khach['HoTen']) ?></td>
                            
                            <?php if(!empty($matrixDates)): ?>
                                <?php foreach($matrixDates as $dateLabel): ?>
                                    <td>
                                        <?php 
                                            // Lấy trạng thái từ mảng matrixData đã xử lý ở Controller
                                            $cell = $matrixData[$khach['MaKhachTrongBooking']][$dateLabel] ?? null;
                                        ?>
                                        <?php if($cell): ?>
                                            <?php if($cell['status'] == 1): ?>
                                                <span class="text-success" data-bs-toggle="tooltip" title="<?= htmlspecialchars($cell['note']) ?>">
                                                    <i class="fas fa-check-circle fa-lg"></i>
                                                </span>
                                            <?php else: ?>
                                                <span class="text-danger fw-bold" data-bs-toggle="tooltip" title="<?= htmlspecialchars($cell['note']) ?>">
                                                    VẮNG
                                                </span>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="text-muted small">-</span>
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
                <div class="small text-muted mt-2">
                    * Bảng này giúp HDV theo dõi tổng quan tình hình tham gia của khách trong suốt hành trình.
                </div>
            </div>
        </div>
    </div>

</div>

<?php require_once 'views/footer.php'; ?>