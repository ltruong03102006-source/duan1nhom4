<style>
    .gia-tour-container {
        padding: 20px;
    }
    .gia-tour-container h1 {
        color: #333;
        margin-bottom: 10px;
    }
    .tour-info {
        background: #e8f4f8;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
    }
    .header-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    .btn {
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 5px;
        cursor: pointer;
        border: none;
        font-size: 14px;
        display: inline-block;
    }
    .btn-primary {
        background-color: #007bff;
        color: white;
    }
    .btn-success {
        background-color: #28a745;
        color: white;
    }
    .btn-warning {
        background-color: #ffc107;
        color: black;
    }
    .btn-danger {
        background-color: #dc3545;
        color: white;
    }
    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }
    .btn:hover {
        opacity: 0.8;
    }
    .table-responsive {
        overflow-x: auto;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background: white;
    }
    table th, table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    table th {
        background-color: #007bff;
        color: white;
    }
    table tr:hover {
        background-color: #f5f5f5;
    }
    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 5px;
    }
    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    .badge {
        padding: 5px 10px;
        border-radius: 3px;
        font-size: 12px;
    }
    .badge-cao-diem {
        background-color: #dc3545;
        color: white;
    }
    .badge-thap-diem {
        background-color: #28a745;
        color: white;
    }
    .badge-binh-thuong {
        background-color: #6c757d;
        color: white;
    }
    .actions {
        display: flex;
        gap: 5px;
    }
    .empty-message {
        text-align: center;
        padding: 40px;
        color: #666;
        background: white;
        border-radius: 5px;
    }
</style>

<div class="gia-tour-container">
    <h1>Quản lý Giá Tour</h1>
    
    <div class="tour-info">
        <strong>Tour:</strong> <?= htmlspecialchars($tenTour) ?>
    </div>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">
            <?php
            switch($_GET['success']) {
                case 'add':
                    echo 'Thêm giá tour thành công!';
                    break;
                case 'update':
                    echo 'Cập nhật giá tour thành công!';
                    break;
                case 'delete':
                    echo 'Xóa giá tour thành công!';
                    break;
            }
            ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger">
            Có lỗi xảy ra! Vui lòng thử lại.
        </div>
    <?php endif; ?>

    <div class="header-actions">
        <a href="?act=addGiaTour&maTour=<?= $maTour ?>" class="btn btn-success">+ Thêm Giá Tour</a>
        <a href="?act=tour" class="btn btn-secondary">← Quay lại danh sách Tour</a>
    </div>

    <?php if (empty($danhSachGia)): ?>
        <div class="empty-message">
            <p>Chưa có giá tour nào. Hãy thêm giá tour mới!</p>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Loại Khách</th>
                        <th>Giá Tiền</th>
                        <th>Áp Dụng Từ</th>
                        <th>Áp Dụng Đến</th>
                        <th>Loại Mùa</th>
                        <th>Khuyến Mãi</th>
                        <th>Giảm Giá</th>
                        <th>Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($danhSachGia as $index => $gia): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td>
                                <?php
                                switch($gia['LoaiKhach']) {
                                    case 'nguoi_lon':
                                        echo 'Người lớn';
                                        break;
                                    case 'tre_em':
                                        echo 'Trẻ em';
                                        break;
                                    case 'em_be':
                                        echo 'Em bé';
                                        break;
                                }
                                ?>
                            </td>
                            <td><?= number_format($gia['GiaTien']) ?> đ</td>
                            <td><?= $gia['ApDungTuNgay'] ? date('d/m/Y', strtotime($gia['ApDungTuNgay'])) : '-' ?></td>
                            <td><?= $gia['ApDungDenNgay'] ? date('d/m/Y', strtotime($gia['ApDungDenNgay'])) : '-' ?></td>
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
                            <td><?= htmlspecialchars($gia['TenKhuyenMai'] ?? '-') ?></td>
                            <td><?= $gia['PhanTramGiamGia'] ?>%</td>
                            <td>
                                <div class="actions">
                                    <a href="?act=editGiaTour&id=<?= $gia['MaGia'] ?>" class="btn btn-warning">Sửa</a>
                                    <a href="?act=deleteGiaTour&id=<?= $gia['MaGia'] ?>&maTour=<?= $maTour ?>" 
                                       class="btn btn-danger" 
                                       onclick="return confirm('Bạn có chắc chắn muốn xóa giá tour này?')">Xóa</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>