<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Booking | Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #4f46e5;       /* Xanh tím hiện đại */
            --primary-hover: #4338ca;
            --bg-body: #f3f4f6;       /* Xám nền */
            --bg-card: #ffffff;
            --text-main: #111827;
            --text-muted: #6b7280;
            --border-color: #e5e7eb;
            --danger: #ef4444;
            --success: #10b981;
            --warning: #f59e0b;
        }

        * { box-sizing: border-box; font-family: 'Inter', sans-serif; }

        body {
            margin: 0;
            background-color: var(--bg-body);
            color: var(--text-main);
            font-size: 14px;
            line-height: 1.5;
        }

        /* --- Header --- */
        .header {
            background-color: var(--bg-card);
            border-bottom: 1px solid var(--border-color);
            padding: 16px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }

        .header h1 {
            margin: 0;
            font-size: 20px;
            font-weight: 700;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .header h1 small {
            font-size: 13px;
            font-weight: 500;
            color: var(--text-muted);
            background: #f3f4f6;
            padding: 2px 8px;
            border-radius: 6px;
        }

        .btn-add {
            background-color: var(--primary);
            color: white;
            padding: 10px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }

        .btn-add:hover { background-color: var(--primary-hover); transform: translateY(-1px); }

        /* --- Container --- */
        .container {
            max-width: 1600px;
            margin: 30px auto;
            padding: 0 32px;
        }

        /* --- Toolbar (Search & Filter) --- */
        .toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            gap: 16px;
            flex-wrap: wrap;
        }

        .search-box {
            position: relative;
            flex: 1;
            max-width: 400px;
        }

        .search-box i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
        }

        .search-box input {
            width: 100%;
            padding: 12px 12px 12px 36px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            outline: none;
            font-size: 14px;
            transition: border-color 0.2s;
        }

        .search-box input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .btn-outline {
            background: white;
            border: 1px solid var(--border-color);
            color: var(--text-main);
            padding: 10px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .btn-outline:hover { background: #f9fafb; border-color: #d1d5db; }

        /* --- Card & Table --- */
        .card {
            background: var(--bg-card);
            border-radius: 12px;
            border: 1px solid var(--border-color);
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            overflow: hidden;
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        thead th {
            background-color: #f9fafb;
            color: var(--text-muted);
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-color);
            white-space: nowrap;
        }

        tbody td {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-main);
            vertical-align: middle;
        }

        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover { background-color: #f9fafb; }

        /* --- Typography & Specific Columns --- */
        .text-bold { font-weight: 600; }
        .text-sm { font-size: 13px; color: var(--text-muted); }
        .booking-code { 
            font-family: 'Courier New', monospace; 
            font-weight: 700; 
            color: var(--primary);
            background: #eef2ff;
            padding: 4px 8px;
            border-radius: 4px;
        }

        .money {
            font-weight: 700;
            color: #059669; /* Xanh lá đậm */
        }

        /* --- Status Badges (Pills) --- */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-type { background: #f3f4f6; color: #4b5563; border: 1px solid #e5e7eb; }
        .badge-type.group { background: #eff6ff; color: #1d4ed8; border-color: #bfdbfe; }
        
        .badge-status.cho_coc { background: #fffbeb; color: #b45309; } /* Vàng cam */
        .badge-status.da_coc { background: #eff6ff; color: #1d4ed8; } /* Xanh dương */
        .badge-status.hoan_tat { background: #ecfdf5; color: #047857; } /* Xanh lá */
        .badge-status.da_huy { background: #fef2f2; color: #b91c1c; } /* Đỏ */

        /* --- Quantity Tags --- */
        .qty-tag {
            display: inline-block;
            font-size: 12px;
            background: #f3f4f6;
            padding: 2px 6px;
            border-radius: 4px;
            margin-right: 4px;
            color: #4b5563;
        }
        .qty-tag b { color: #111827; }

        /* --- Action Buttons --- */
        .actions {
            display: flex;
            gap: 8px;
        }

        .btn-icon {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            border: 1px solid transparent;
            background: transparent;
            color: var(--text-muted);
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
        }

        .btn-icon:hover { background: #f3f4f6; color: var(--text-main); border-color: #e5e7eb; }
        
        /* Màu riêng cho từng hành động khi hover */
        .btn-icon.view:hover { background: #eff6ff; color: #2563eb; border-color: #bfdbfe; }
        .btn-icon.edit:hover { background: #fff7ed; color: #ea580c; border-color: #fed7aa; }
        .btn-icon.pay:hover { background: #ecfdf5; color: #059669; border-color: #a7f3d0; }
        .btn-icon.delete:hover { background: #fef2f2; color: #dc2626; border-color: #fecaca; }

        /* --- Footer --- */
        .card-footer {
            padding: 12px 20px;
            background: #f9fafb;
            border-top: 1px solid var(--border-color);
            color: var(--text-muted);
            font-size: 13px;
        }
    </style>
</head>

<body>

    <header class="header">
        <h1>
            <i class="fa-solid fa-book-open" style="color: var(--primary);"></i>
            Quản Lý Booking
            <small>Admin Panel</small>
        </h1>
        <a href="?act=addBooking" class="btn-add">
            <i class="fa-solid fa-plus"></i> Tạo Booking Mới
        </a>
    </header>

    <div class="container">
        <div class="toolbar">
            <div class="search-box">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input id="searchInput" type="text" placeholder="Tìm kiếm theo mã, tên khách, tour...">
            </div>
            <a href="?act=tour" class="btn-outline">
                <i class="fa-regular fa-compass"></i> Quản lý Tour
            </a>
        </div>

        <div class="card">
            <div class="table-responsive">
                <table id="bookingTable">
                    <thead>
                        <tr>
                            <th>Mã Booking</th>
                            <th>Thông tin Tour</th>
                            <th>Khách hàng</th>
                            <th>Loại</th>
                            <th>Số lượng</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th style="text-align: center;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($listBooking as $b): ?>
                        <tr>
                            <td>
                                <span class="booking-code"><?= htmlspecialchars($b['MaCodeBooking']) ?></span>
                                <div class="text-sm" style="margin-top:4px">#<?= (int)$b['MaBooking'] ?></div>
                            </td>

                            <td>
                                <div class="text-bold"><?= htmlspecialchars($b['TenTour'] ?? 'Chưa chọn tour') ?></div>
                                <div class="text-sm">
                                    <i class="fa-regular fa-calendar"></i> 
                                    <?= !empty($b['NgayKhoiHanh']) ? date('d/m/Y', strtotime($b['NgayKhoiHanh'])) : '...' ?>
                                    
                                    <?php if(!empty($b['MaDoan'])): ?>
                                        <span style="margin-left: 6px">• Đoàn #<?= (int)$b['MaDoan'] ?></span>
                                    <?php endif; ?>
                                </div>
                                <?php if (!empty($b['DiemTapTrung'])): ?>
                                <div class="text-sm" style="margin-top: 4px;">
                                    <i class="fa-solid fa-location-dot"></i>
                                    Khởi Hành: <?= htmlspecialchars($b['DiemTapTrung']) ?>
                                </div>
                                <?php endif; ?>
                            </td>

                            <td>
                                <div class="text-bold"><?= htmlspecialchars($b['TenKhach'] ?? 'Khách lẻ') ?></div>
                                <?php if (!empty($b['SoDienThoai'])): ?>
                                    <div class="text-sm"><i class="fa-solid fa-phone" style="font-size:10px"></i> <?= htmlspecialchars($b['SoDienThoai']) ?></div>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if (($b['LoaiBooking'] ?? '') === 'nhom'): ?>
                                    <span class="badge badge-type group"><i class="fa-solid fa-users" style="margin-right:4px"></i> Nhóm</span>
                                <?php else: ?>
                                    <span class="badge badge-type"><i class="fa-solid fa-user" style="margin-right:4px"></i> Cá nhân</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <span class="qty-tag">NL: <b><?= (int)$b['TongNguoiLon'] ?></b></span>
                                <?php if($b['TongTreEm'] > 0): ?>
                                    <span class="qty-tag">TE: <b><?= (int)$b['TongTreEm'] ?></b></span>
                                <?php endif; ?>
                                <?php if($b['TongEmBe'] > 0): ?>
                                    <span class="qty-tag">EB: <b><?= (int)$b['TongEmBe'] ?></b></span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <div class="money"><?= number_format((float)$b['TongTien'], 0, ',', '.') ?>đ</div>
                            </td>

                            <td>
                                <?php
                                    $st = $b['TrangThai'] ?? '';
                                    if ($st === 'cho_coc') echo '<span class="badge badge-status cho_coc">⏳ Chờ cọc</span>';
                                    elseif ($st === 'da_coc') echo '<span class="badge badge-status da_coc">💳 Đã cọc</span>';
                                    elseif ($st === 'hoan_tat') echo '<span class="badge badge-status hoan_tat">✅ Hoàn tất</span>';
                                    elseif ($st === 'da_huy') echo '<span class="badge badge-status da_huy">⛔ Đã hủy</span>';
                                    else echo '<span class="badge badge-type">—</span>';
                                ?>
                            </td>

                            <td class="text-sm">
                                <?= !empty($b['NgayTao']) ? date('d/m/Y H:i', strtotime($b['NgayTao'])) : '' ?>
                            </td>

                            <td>
                                <div class="actions" style="justify-content: center;">
                                    <a href="?act=khachTrongBooking&MaBooking=<?= (int)$b['MaBooking'] ?>" class="btn-icon view" title="Danh sách khách">
                                        <i class="fa-solid fa-list-ul"></i>
                                    </a>
                                    
                                    <a href="?act=editBooking&MaBooking=<?= (int)$b['MaBooking'] ?>" class="btn-icon edit" title="Chỉnh sửa">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>

                                    <a href="?act=addThanhToan&MaBooking=<?= $b['MaBooking'] ?>" class="btn-icon pay" title="Thanh toán">
                                        <i class="fa-regular fa-credit-card"></i>
                                    </a>

                                    <a href="?act=deleteBooking&MaBooking=<?= (int)$b['MaBooking'] ?>" 
                                       class="btn-icon delete" 
                                       onclick="return confirm('Bạn có chắc chắn muốn xóa booking này? Hành động không thể hoàn tác.');" 
                                       title="Xóa Booking">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="card-footer">
                Hiển thị danh sách booking mới nhất. Sử dụng ô tìm kiếm để lọc dữ liệu.
            </div>
        </div>
    </div>

    <script>
        const input = document.getElementById('searchInput');
        const table = document.getElementById('bookingTable');
        // Bỏ qua header, lấy các row trong tbody
        const rows = () => Array.from(table.querySelectorAll('tbody tr'));

        function normalize(s) {
            return (s || '').toString().toLowerCase().trim();
        }

        function applyFilter() {
            const q = normalize(input.value);
            rows().forEach(tr => {
                const text = normalize(tr.innerText);
                tr.style.display = text.includes(q) ? '' : 'none';
            });
        }

        input.addEventListener('keyup', applyFilter);
    </script>
</body>
</html>