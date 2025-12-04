<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quản Lý Tour Du Lịch</title>
    <style>
        body {
            margin: 0;
            background: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }

        /* HEADER */
        .header {
            background: #1e88e5;
            padding: 15px 20px;
            color: #fff;
            font-size: 22px;
            font-weight: bold;
        }

        .container {
            width: 95%;
            max-width: 1400px;
            margin: 25px auto;
        }

        .btn-add {
            padding: 10px 18px;
            background: #1e88e5;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            margin-bottom: 20px;
            text-decoration: none;
            display: inline-block;
        }

        .btn-add:hover {
            background: #1565c0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 8px;
            overflow: visible;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 1;
        }

        th,
        td {
            padding: 12px 15px;
            text-align: left;
            font-size: 14px;
        }

        th {
            background: #0d47a1;
            color: white;
        }

        tr:nth-child(even) {
            background: #f1f1f1;
        }

        .actions {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
            position: relative;
            z-index: auto;
        }

        .actions a {
            text-decoration: none;
        }

        .actions button {
            padding: 6px 12px;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 13px;
        }

        /* Dropdown container */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-toggle {
            background: #607d8b;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .dropdown-toggle:hover {
            background: #546e7a;
        }

        .dropdown-toggle::after {
            content: '▼';
            font-size: 10px;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            background: white;
            min-width: 180px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.3);
            border-radius: 6px;
            z-index: 9999;
            margin-top: 5px;
            overflow: hidden;
            border: 1px solid #ddd;
        }

        .dropdown-menu a {
            display: block;
            padding: 12px 15px;
            color: #333;
            text-decoration: none;
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.2s;
        }

        .dropdown-menu a:last-child {
            border-bottom: none;
        }

        .dropdown-menu a:hover {
            background: #e3f2fd;
            padding-left: 20px;
        }

        /* Active state khi click */
        .dropdown.active .dropdown-menu {
            display: block;
            animation: slideDown 0.2s ease;
        }

        .dropdown.active .dropdown-toggle {
            background: #546e7a;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .btn-edit {
            background: #ff9800;
        }

        .btn-edit:hover {
            background: #ef6c00;
        }

        .btn-delete {
            background: #e53935;
        }

        .btn-delete:hover {
            background: #c62828;
        }

        .btn-view {
            background: #43a047;
        }

        .btn-view:hover {
            background: #2e7d32;
        }

        .btn-price {
            background: #9c27b0;
        }

        .btn-price:hover {
            background: #7b1fa2;
        }

        .btn-schedule {
            background: #00acc1;
        }

        .btn-schedule:hover {
            background: #00838f;
        }

        .btn-budget {
            background: #ff5722;
        }

        .btn-budget:hover {
            background: #e64a19;
        }

        .btn-guide {
            background: #009688;
        }

        .btn-guide:hover {
            background: #00796b;
        }

        .tour-info-card {
            display: flex;
            gap: 15px;
            align-items: flex-start;
        }

        .tour-info-card img {
            width: 120px;
            height: 80px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #ddd;
        }

        .tour-details {
            flex: 1;
        }

        .tour-name {
            font-weight: bold;
            color: #1e88e5;
            font-size: 15px;
            margin-bottom: 5px;
        }

        .tour-meta {
            font-size: 13px;
            color: #666;
            line-height: 1.6;
        }

        .tour-meta span {
            display: inline-block;
            margin-right: 15px;
        }

        .tour-meta .label {
            font-weight: 600;
            color: #444;
        }

        img.thumb {
            width: 80px;
            height: 55px;
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        .price {
            color: #e53935;
            font-weight: bold;
        }

        .status-active {
            color: #2e7d32;
            font-weight: bold;
        }

        .status-inactive {
            color: #c62828;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="header">Quản Lý Tour Du Lịch</div>

    <div class="container">
        <?php if (isset($_GET['success'])): ?>
            <div style="padding: 15px; margin-bottom: 20px; background: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 6px;">
                <?php
                switch($_GET['success']) {
                    case 'add':
                        echo '✅ Thêm tour mới thành công!';
                        break;
                    case 'update':
                        echo '✅ Cập nhật tour thành công!';
                        break;
                    case 'delete':
                        echo '✅ Xóa tour thành công!';
                        break;
                }
                ?>
            </div>
        <?php endif; ?>

        <a href="?act=addTour" class="btn-add">+ Thêm Tour Mới</a>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Thông Tin Tour</th>
                    <th>Giá Vốn</th>
                    <th>Giá Bán</th>
                    <th>Trạng Thái</th>
                    <th>Ngày Tạo</th>
                    <th>Ngày Cập Nhật</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listTour as $tour): ?>
                    <tr>
                        <td><?= $tour['MaTour'] ?></td>

                        <td>
                            <div class="tour-info-card">
                                <?php if (!empty($tour['LinkAnhBia'])): ?>
                                    <img src="<?= $tour['LinkAnhBia'] ?>" alt="Ảnh tour">
                                <?php else: ?>
                                    <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='120' height='80'%3E%3Crect fill='%23ddd' width='120' height='80'/%3E%3Ctext x='50%25' y='50%25' text-anchor='middle' dy='.3em' fill='%23999' font-family='Arial' font-size='14'%3ENo Image%3C/text%3E%3C/svg%3E" alt="No image">
                                <?php endif; ?>
                                
                                <div class="tour-details">
                                    <div class="tour-name"><?= htmlspecialchars($tour['TenTour']) ?></div>
                                    <div class="tour-meta">
                                        <span><span class="label">Mã:</span> <?= htmlspecialchars($tour['MaCodeTour']) ?></span><br>
                                        <span><span class="label">📁</span> <?= $tour['TenDanhMuc'] ?></span>
                                        <span><span class="label">📅</span> <?= $tour['SoNgay'] ?>N - <?= $tour['SoDem'] ?>Đ</span><br>
                                        <span><span class="label">📍</span> <?= htmlspecialchars($tour['DiemKhoiHanh']) ?></span>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td class="price"><?= number_format($tour['GiaVonDuKien'], 0, ',', '.') ?>đ</td>
                        <td class="price"><?= number_format($tour['GiaBanMacDinh'], 0, ',', '.') ?>đ</td>

                        <td>
                            <?php if ($tour['TrangThai'] === 'hoat_dong'): ?>
                                <span class="status-active">Hoạt động</span>
                            <?php else: ?>
                                <span class="status-inactive">Không hoạt động</span>
                            <?php endif; ?>
                        </td>

                        <td><?= $tour['NgayTao'] ?></td>
                        <td><?= $tour['NgayCapNhat'] ?></td>

                        <td class="actions">
                            <a href="?act=xemTour&id=<?= $tour['MaTour'] ?>">
                                <button class="btn-view">Xem</button>
                            </a>
                            
                            <a href="?act=editTour&id=<?= $tour['MaTour'] ?>">
                                <button class="btn-edit">Sửa</button>
                            </a>
                            
                            <a href="?act=deleteTour&id=<?= $tour['MaTour'] ?>"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa tour này không?');">
                                <button class="btn-delete">Xóa</button>
                            </a>

                            <div class="dropdown">
                                <button class="dropdown-toggle">⚙️ Khác</button>
                                <div class="dropdown-menu">
                                    <a href="?act=lichTour&maTour=<?= $tour['MaTour'] ?>">📅 Lịch trình</a>
                                    <a href="?act=giaTour&maTour=<?= $tour['MaTour'] ?>">💰 Giá Tour</a>
                                    <a href="?act=duToanChiPhi&maTour=<?= $tour['MaTour'] ?>">📊 Dự toán</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

<script>
// Script xử lý dropdown click
document.addEventListener('DOMContentLoaded', function() {
    const dropdowns = document.querySelectorAll('.dropdown');
    
    dropdowns.forEach(dropdown => {
        const toggle = dropdown.querySelector('.dropdown-toggle');
        
        toggle.addEventListener('click', function(e) {
            e.stopPropagation();
            
            // Đóng tất cả dropdown khác
            dropdowns.forEach(d => {
                if (d !== dropdown) {
                    d.classList.remove('active');
                }
            });
            
            // Toggle dropdown hiện tại
            dropdown.classList.toggle('active');
        });
    });
    
    // Đóng dropdown khi click ra ngoài
    document.addEventListener('click', function() {
        dropdowns.forEach(dropdown => {
            dropdown.classList.remove('active');
        });
    });
});
</script>

</html>