<style>
    .dutoan-container {
        padding: 20px;
    }
    .dutoan-container h1 {
        color: #333;
        margin-bottom: 10px;
        font-size: 28px;
    }
    .tour-info {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        color: white;
    }
    .tour-info h3 {
        margin: 0 0 10px 0;
        font-size: 18px;
    }
    .tour-info p {
        margin: 5px 0;
        font-size: 14px;
    }
    .tong-dutoan {
        background: #fff3cd;
        border: 2px solid #ffc107;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        text-align: center;
    }
    .tong-dutoan h2 {
        margin: 0;
        color: #856404;
        font-size: 24px;
    }
    .tong-dutoan .amount {
        font-size: 32px;
        color: #dc3545;
        font-weight: bold;
        margin-top: 5px;
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
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    table th, table td {
        padding: 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    table th {
        background-color: #007bff;
        color: white;
        font-weight: bold;
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
    .actions {
        display: flex;
        gap: 5px;
    }
    .empty-message {
        text-align: center;
        padding: 40px;
        color: #666;
        background: white;
        border-radius: 8px;
    }
    .money {
        color: #dc3545;
        font-weight: bold;
        font-size: 15px;
    }
    .hang-muc {
        font-weight: 600;
        color: #333;
    }
</style>

<div class="dutoan-container">
    <h1>📊 Dự Toán Chi Phí Tour</h1>
    
    <div class="tour-info">
        <h3>Thông tin Tour</h3>
        <p><strong>Mã Code:</strong> <?= htmlspecialchars($maCodeTour) ?></p>
        <p><strong>Tên Tour:</strong> <?= htmlspecialchars($tenTour) ?></p>
    </div>

    <?php if (!empty($danhSachDuToan)): ?>
    <div class="tong-dutoan">
        <h2>💰 Tổng Dự Toán Chi Phí (Giá Vốn Dự Kiến)</h2>
        <div class="amount"><?= number_format($tongDuToan) ?> đ</div>
        <p style="margin-top: 10px; color: #856404; font-size: 13px;">
            <em>Đây là tổng chi phí ước tính cho 1 khách tham gia tour</em>
        </p>
    </div>
    <?php endif; ?>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">
            <?php
            switch($_GET['success']) {
                case 'add':
                    echo '✅ Thêm dự toán chi phí thành công!';
                    break;
                case 'update':
                    echo '✅ Cập nhật dự toán chi phí thành công!';
                    break;
                case 'delete':
                    echo '✅ Xóa dự toán chi phí thành công!';
                    break;
            }
            ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger">
            ❌ Có lỗi xảy ra! Vui lòng thử lại.
        </div>
    <?php endif; ?>

    <div class="header-actions">
        <a href="?act=addDuToan&maTour=<?= $maTour ?>" class="btn btn-success">+ Thêm Hạng Mục Chi</a>
        <a href="?act=tour" class="btn btn-secondary">← Quay lại danh sách Tour</a>
    </div>

    <?php if (empty($danhSachDuToan)): ?>
        <div class="empty-message">
            <p>Chưa có dự toán chi phí nào. Hãy thêm các hạng mục chi dự kiến!</p>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th style="width: 50px;">STT</th>
                        <th>Hạng Mục Chi</th>
                        <th style="width: 180px;">Số Tiền Dự Kiến</th>
                        <th>Ghi Chú</th>
                        <th style="width: 150px;">Thao Tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($danhSachDuToan as $index => $duToan): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td class="hang-muc"><?= htmlspecialchars($duToan['HangMucChi']) ?></td>
                            <td class="money"><?= number_format($duToan['SoTienDuKien']) ?> đ</td>
                            <td><?= htmlspecialchars($duToan['GhiChu'] ?? '-') ?></td>
                            <td>
                                <div class="actions">
                                    <a href="?act=editDuToan&id=<?= $duToan['MaDuToan'] ?>" class="btn btn-warning">Sửa</a>
                                    <a href="?act=deleteDuToan&id=<?= $duToan['MaDuToan'] ?>&maTour=<?= $maTour ?>" 
                                       class="btn btn-danger" 
                                       onclick="return confirm('Bạn có chắc chắn muốn xóa hạng mục chi này?')">Xóa</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr style="background: #f8f9fa; font-weight: bold;">
                        <td colspan="2" style="text-align: right; padding-right: 20px;">TỔNG CỘNG:</td>
                        <td class="money" style="font-size: 18px;"><?= number_format($tongDuToan) ?> đ</td>
                        <td colspan="2"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    <?php endif; ?>
</div>