<style>
    .info-group { margin-bottom: 20px; border: 1px solid #eee; padding: 15px; border-radius: 5px; }
    .info-group h4 { color: #0d6efd; border-bottom: 2px solid #0d6efd; padding-bottom: 5px; margin-bottom: 15px; }
    .info-group p { margin-bottom: 5px; }
    .btn-action-group { margin-top: 20px; }
    .btn-action { padding: 10px 15px; margin-right: 10px; border: none; border-radius: 5px; cursor: pointer; color: white; }
    .btn-schedule { background: #198754; }
    .btn-report { background: #ffc107; }
    .btn-back { background: #6c757d; }
</style>

<div class="container-fluid px-4">
    <h1 class="mt-4">Chi Tiết Đoàn Khởi Hành (ID: <?= $doanDetail['MaDoan'] ?>)</h1>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="?act=hdvHome">Dashboard HDV</a></li>
        <li class="breadcrumb-item active">Đoàn <?= $doanDetail['MaDoan'] ?></li>
    </ol>
    
    <div class="row">
        <div class="col-lg-6">
            <div class="info-group">
                <h4>Thông tin Tour</h4>
                <p><strong>Tour:</strong> <?= $doanDetail['TenTour'] ?> (<?= $doanDetail['MaCodeTour'] ?>)</p>
                <p><strong>Ngày khởi hành:</strong> <?= date('d/m/Y', strtotime($doanDetail['NgayKhoiHanh'])) ?></p>
                <p><strong>Ngày về:</strong> <?= date('d/m/Y', strtotime($doanDetail['NgayVe'])) ?></p>
                <p><strong>Điểm tập trung:</strong> <?= $doanDetail['DiemTapTrung'] ?></p>
                <p><strong>Số chỗ:</strong> <?= $doanDetail['SoChoToiDa'] ?> (Còn: <?= $doanDetail['SoChoConTrong'] ?>)</p>
            </div>

            <div class="info-group">
                <h4>Chính sách Tour</h4>
                <p><strong>Bao gồm:</strong> <?= nl2br(htmlspecialchars($doanDetail['ChinhSachBaoGom'])) ?></p>
                <hr>
                <p><strong>Không bao gồm:</strong> <?= nl2br(htmlspecialchars($doanDetail['ChinhSachKhongBaoGom'])) ?></p>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="info-group">
                <h4>Thông tin Nhân sự</h4>
                <p><strong>Hướng dẫn viên (Bạn):</strong> Đã phân công (ID: <?= $doanDetail['MaHuongDanVien'] ?>)</p>
                <p><strong>Tài xế:</strong> <?= $doanDetail['TenTaiXe'] ?? 'Chưa phân công' ?> (SĐT: <?= $doanDetail['SdtTaiXe'] ?? 'N/A' ?>)</p>
                <p><strong>Thông tin xe:</strong> <?= $doanDetail['ThongTinXe'] ?? 'N/A' ?></p>
            </div>

            <div class="btn-action-group">

                <!-- XEM LỊCH TRÌNH -->
                <a href="?act=hdvLichTrinh&id=<?= $doanDetail['MaTour'] ?>">
                    <button class="btn-action btn-schedule">
                        <i class="fas fa-calendar-alt"></i> Xem Lịch Trình
                    </button>
                </a>

                <!-- GHI NHẬT KÝ TOUR -->
                <a href="?act=nhatky_hdv&MaDoan=<?= $doanDetail['MaDoan'] ?>">
                    <button class="btn-action btn-report">
                        <i class="fas fa-edit"></i> Ghi Nhật Ký Tour
                    </button>
                </a>

                <!-- ĐIỂM DANH -->
                <a href="?act=diemDanhProcess&MaDoan=<?= $doanDetail['MaDoan'] ?>">
                    <button class="btn-action btn-report" style="background: #e53935;">
                        <i class="fas fa-user-check"></i> Điểm Danh Khách
                    </button>
                </a>

                <!-- QUAY LẠI -->
                <a href="?act=hdvHome">
                    <button class="btn-action btn-back">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </button>
                </a>

            </div>
        </div>
    </div>
</div>
