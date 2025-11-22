<div class="container-fluid px-4">
    <h1 class="mt-4">Quản Lý Tài Chính - Đoàn #<?= $infoDoan['MaDoan'] ?></h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="?act=listDoan">Danh sách đoàn</a></li>
        <li class="breadcrumb-item active">Tài chính</li>
    </ol>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-success text-white h-100">
                <div class="card-body">
                    <h5>Tổng Thu</h5>
                    <h3><?= number_format($thongKe['TongThu'] ?? 0, 0, ',', '.') ?> VNĐ</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-danger text-white h-100">
                <div class="card-body">
                    <h5>Tổng Chi</h5>
                    <h3><?= number_format($thongKe['TongChi'] ?? 0, 0, ',', '.') ?> VNĐ</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-primary text-white h-100">
                <div class="card-body">
                    <h5>Lợi Nhuận (Tạm tính)</h5>
                    <h3><?= number_format(($thongKe['TongThu'] ?? 0) - ($thongKe['TongChi'] ?? 0), 0, ',', '.') ?> VNĐ</h3>
                </div>
            </div>
        </div>
    </div>

    <a href="?act=addTaiChinh&MaDoan=<?= $infoDoan['MaDoan'] ?>" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Thêm Giao Dịch Mới
    </a>

    <div class="card mb-4">
        <div class="card-header"><i class="fas fa-table me-1"></i> Chi tiết thu chi</div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Ngày</th>
                        <th>Loại</th>
                        <th>Hạng mục</th>
                        <th>Số tiền (VNĐ)</th>
                        <th>Đối tượng/NCC</th>
                        <th>PTTT</th>
                        <th>Ghi chú</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($listTaiChinh as $tc): ?>
                        <tr>
                            <td><?= date('d/m/Y', strtotime($tc['NgayGiaoDich'])) ?></td>
                            <td>
                                <?php if ($tc['LoaiGiaoDich'] == 'thu'): ?>
                                    <span class="badge bg-success">Thu</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Chi</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong><?= $tc['HangMucChi'] ?></strong>
                                <?php if($tc['SoHoaDon']) echo "<br><small class='text-muted'>HĐ: {$tc['SoHoaDon']}</small>"; ?>
                            </td>
                            <td class="fw-bold text-end"><?= number_format($tc['SoTien'], 0, ',', '.') ?></td>
                            <td><?= $tc['TenNhaCungCap'] ?? '---' ?></td>
                            <td><?= $tc['PhuongThucThanhToan'] ?></td>
                            <td><?= $tc['MoTa'] ?></td>
                            <td>
                                <a href="?act=editTaiChinh&id=<?= $tc['MaTaiChinh'] ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                <a href="?act=deleteTaiChinh&id=<?= $tc['MaTaiChinh'] ?>" 
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Bạn chắc chắn muốn xóa giao dịch này?');">
                                   <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>