<style>
    /* Style đơn giản cho bảng */
    .table-hdv {
        width: 100%;
        border-collapse: collapse;
    }
    .table-hdv th, .table-hdv td {
        padding: 10px;
        text-align: left;
        border: 1px solid #ddd;
    }
    .status-con-cho { color: green; font-weight: bold; }
    .status-het-cho { color: orange; font-weight: bold; }
    .status-hoan-thanh { color: blue; }
    .btn-detail { background: #0d6efd; color: white; padding: 5px 10px; border-radius: 5px; text-decoration: none; }
    .btn-detail:hover { background: #0b5ed7; }
</style>

<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard Hướng Dẫn Viên</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Các đoàn đang phụ trách</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-list me-1"></i>
            Danh sách Đoàn Khởi Hành
        </div>
        <div class="card-body">
            <?php if (empty($listDoan)): ?>
                <p>Hiện tại bạn chưa được phân công phụ trách đoàn nào.</p>
            <?php else: ?>
                <table class="table-hdv">
                    <thead>
                        <tr>
                            <th>Mã Đoàn</th>
                            <th>Mã Tour</th>
                            <th>Tên Tour</th>
                            <th>Khởi hành</th>
                            <th>Ngày về</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($listDoan as $doan): ?>
                            <tr>
                                <td><?= $doan['MaDoan'] ?></td>
                                <td><?= $doan['MaCodeTour'] ?></td>
                                <td><?= $doan['TenTour'] ?></td>
                                <td><?= date('d/m/Y', strtotime($doan['NgayKhoiHanh'])) ?></td>
                                <td><?= date('d/m/Y', strtotime($doan['NgayVe'])) ?></td>
                                <td>
                                    <span class="status-<?= str_replace('_', '-', $doan['TrangThai']) ?>">
                                        <?= ucfirst(str_replace('_', ' ', $doan['TrangThai'])) ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="?act=hdvDoanDetail&id=<?= $doan['MaDoan'] ?>" class="btn-detail">Xem chi tiết</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>