<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Dashboard Quản Trị</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Tổng quan tình hình kinh doanh</li>
        </ol>

        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body">
                        <div>Tổng Doanh Thu</div>
                        <div class="fs-4 fw-bold"><?= number_format($thongKe['DoanhThu']) ?> VNĐ</div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="?act=listBooking">Xem chi tiết</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-3 col-md-6">
                <div class="card bg-danger text-white mb-4">
                    <div class="card-body">
                        <div>Tổng Chi Phí</div>
                        <div class="fs-4 fw-bold"><?= number_format($thongKe['ChiPhi']) ?> VNĐ</div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="?act=listTaiChinh">Xem chi tiết</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white mb-4">
                    <div class="card-body">
                        <div>Lợi Nhuận Thực Tế</div>
                        <div class="fs-4 fw-bold"><?= number_format($thongKe['LoiNhuan']) ?> VNĐ</div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <span class="small text-white">Lãi ròng tạm tính</span>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card bg-warning text-white mb-4">
                    <div class="card-body">
                        <div>Tổng Khách / Tour</div>
                        <div class="fs-4 fw-bold">
                            <?= $thongKe['TongKhach'] ?> Khách 
                            <span style="font-size: 0.6em; opacity: 0.8;">(<?= $thongKe['TongTour'] ?> Tour)</span>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="?act=listKhachHang">Quản lý khách</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-bar me-1"></i>
                        Biểu đồ Doanh thu (Demo)
                    </div>
                    <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-pie me-1"></i>
                        Tỷ lệ Trạng thái Booking
                    </div>
                    <div class="card-body"><canvas id="myPieChart" width="100%" height="40"></canvas></div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Booking Mới Nhất
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Mã Booking</th>
                            <th>Khách Hàng</th>
                            <th>Tour</th>
                            <th>Ngày Đặt</th>
                            <th>Tổng Tiền</th>
                            <th>Trạng Thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($listBookingMoi)): ?>
                            <?php foreach ($listBookingMoi as $b): ?>
                                <tr>
                                    <td><strong><?= $b['MaCodeBooking'] ?></strong></td>
                                    <td><?= htmlspecialchars($b['TenKhach'] ?? 'Khách lẻ') ?></td>
                                    <td><?= htmlspecialchars($b['TenTour']) ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($b['NgayTao'])) ?></td>
                                    <td class="text-danger fw-bold"><?= number_format($b['TongTien']) ?> đ</td>
                                    <td>
                                        <?php
                                            $stt = $b['TrangThai'];
                                            $color = 'secondary';
                                            $text = 'Không rõ';
                                            if($stt == 'cho_coc') { $color='warning'; $text='Chờ cọc'; }
                                            if($stt == 'da_coc') { $color='primary'; $text='Đã cọc'; }
                                            if($stt == 'hoan_tat') { $color='success'; $text='Hoàn tất'; }
                                            if($stt == 'da_huy') { $color='danger'; $text='Đã hủy'; }
                                        ?>
                                        <span class="badge bg-<?= $color ?>"><?= $text ?></span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="6" class="text-center">Chưa có booking nào.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<script>
    // Lấy dữ liệu từ PHP sang JS
    const rawDataBooking = <?= json_encode($dataBookingChart ?? []) ?>;
    
    // Xử lý dữ liệu cho Pie Chart (Trạng thái booking)
    const labelsPie = [];
    const dataPie = [];
    const colorsPie = [];

    rawDataBooking.forEach(item => {
        let label = item.TrangThai;
        let color = '#6c757d';
        
        if(item.TrangThai === 'cho_coc') { label = 'Chờ cọc'; color = '#ffc107'; }
        if(item.TrangThai === 'da_coc') { label = 'Đã cọc'; color = '#0d6efd'; }
        if(item.TrangThai === 'hoan_tat') { label = 'Hoàn tất'; color = '#198754'; }
        if(item.TrangThai === 'da_huy') { label = 'Đã hủy'; color = '#dc3545'; }

        labelsPie.push(label);
        dataPie.push(item.SoLuong);
        colorsPie.push(color);
    });

    // Ghi đè cấu hình Pie Chart mặc định trong file assets
    window.addEventListener('DOMContentLoaded', event => {
        var ctx = document.getElementById("myPieChart");
        if(ctx) {
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labelsPie,
                    datasets: [{
                        data: dataPie,
                        backgroundColor: colorsPie,
                    }],
                },
            });
        }
    });
</script>