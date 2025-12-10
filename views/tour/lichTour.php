<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Lịch trình Tour</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <style>
        :root {
            --primary-color: #2563eb;
            --primary-hover: #1d4ed8;
            --bg-color: #f1f5f9;
            --card-bg: #ffffff;
            --text-main: #1e293b;
            --text-secondary: #64748b;
            --border-color: #e2e8f0;
            --success-color: #10b981;
            --danger-color: #ef4444;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            margin: 0;
            padding: 20px;
            font-size: 14px;
        }

        .main-wrapper {
            max-width: 1400px;
            margin: 0 auto;
        }

        /* HEADER */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            background: #fff;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .page-header h1 { margin: 0; font-size: 20px; color: var(--primary-color); }

        .tour-selector { display: flex; align-items: center; gap: 10px; }
        .tour-selector select { padding: 8px; border-radius: 4px; border: 1px solid var(--border-color); min-width: 250px; }

        /* LAYOUT GRID */
        .content-grid {
            display: grid;
            grid-template-columns: 350px 1fr;
            gap: 20px;
        }

        /* CARD STYLES */
        .card {
            background: var(--card-bg);
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
            height: fit-content;
        }

        .card-header {
            padding: 15px 20px;
            border-bottom: 1px solid var(--border-color);
            background-color: #f8fafc;
            border-radius: 8px 8px 0 0;
        }
        .card-header h3 { margin: 0; font-size: 16px; font-weight: 600; }

        .card-body { padding: 20px; }

        /* FORM STYLES */
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: 500; color: var(--text-main); }
        .required { color: var(--danger-color); }

        .form-control, input[type="text"], input[type="number"], textarea, select {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            font-size: 14px;
            transition: border-color 0.2s;
        }

        .form-control:focus, input:focus, textarea:focus {
            border-color: var(--primary-color);
            outline: none;
        }

        .row { display: flex; gap: 10px; }
        .col-3 { flex: 3; }
        .col-9 { flex: 9; }

        /* Meal Checkboxes */
        .meal-checkboxes {
            display: flex;
            gap: 15px;
            background: #f8fafc;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid var(--border-color);
        }

        .checkbox-container {
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 13px;
        }

        /* Form Actions */
        .form-actions { display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px; }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            text-decoration: none;
        }
        .btn-primary { background-color: var(--primary-color); color: white; }
        .btn-primary:hover { background-color: var(--primary-hover); }
        .btn-secondary { background-color: #fff; border: 1px solid var(--border-color); color: var(--text-secondary); }
        .btn-secondary:hover { background-color: #f1f5f9; }

        /* TABLE STYLES */
        .table-responsive { overflow-x: auto; }
        .table { width: 100%; border-collapse: collapse; }
        .table th { text-align: left; padding: 12px; background-color: #f8fafc; color: var(--text-secondary); font-weight: 600; border-bottom: 2px solid var(--border-color); }
        .table td { padding: 12px; border-bottom: 1px solid var(--border-color); vertical-align: top; }
        .table-hover tbody tr:hover { background-color: #f8fafc; }

        .text-center { text-align: center; }
        .font-bold { font-weight: bold; color: var(--primary-color); font-size: 16px; }

        /* Itinerary Item Styles */
        .itinerary-title { font-weight: 600; color: var(--primary-color); margin-bottom: 4px; }
        .itinerary-desc { font-size: 13px; color: var(--text-main); margin-bottom: 6px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .itinerary-meta { font-size: 12px; color: var(--text-secondary); }

        /* Badges */
        .meal-badges { display: flex; gap: 5px; flex-wrap: wrap; }
        .badge { padding: 3px 8px; border-radius: 12px; font-size: 11px; font-weight: 600; }
        .badge-success { background-color: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }

        /* Action Buttons */
        .btn-icon {
            width: 32px; height: 32px;
            border-radius: 4px; border: none;
            cursor: pointer; display: inline-flex;
            align-items: center; justify-content: center;
            transition: all 0.2s;
        }
        .btn-edit { background-color: #eff6ff; color: var(--primary-color); }
        .btn-edit:hover { background-color: var(--primary-color); color: white; }
        .btn-delete { background-color: #fef2f2; color: var(--danger-color); margin-left: 5px; }
        .btn-delete:hover { background-color: var(--danger-color); color: white; }

        .hotel-info { margin-top: 5px; font-size: 12px; color: var(--text-secondary); }
        
        .empty-state {
            text-align: center;
            padding: 40px;
            color: var(--text-secondary);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .content-grid { grid-template-columns: 1fr; }
        }
    </style>
    <div class="main-wrapper">
        <header class="page-header">
            <h1><i class="fas fa-route"></i> Quản lý Chi tiết Lịch trình</h1>
            <div class="tour-selector">
                <label for="MaTour">Đang cấu hình cho Tour:</label>
                <form method="GET" action="" style="margin: 0;">
                    <input type="hidden" name="act" value="lichTour">
                    <select name="tour_id" class="form-control" onchange="this.form.submit()">
                        <?php foreach($listTours as $tour): ?>
                            <option value="<?= $tour['MaTour'] ?>" <?= ($tour['MaTour'] == $maTour) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($tour['TenTour']) ?> (Mã: <?= htmlspecialchars($tour['MaCodeTour']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </form>
            </div>
        </header>
                            <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success" style="margin-bottom: 20px;">
                ✅ Cập nhật lịch trình thành công!
            </div>
        <?php endif; ?>
        
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger" style="margin-bottom: 20px;">
                ❌ 
                <?php
                    switch ($_GET['error']) {
                        case 'validation':
                            echo 'Vui lòng nhập đầy đủ Tiêu đề ngày và Ngày thứ (phải > 0).';
                            break;
                        case 'ngay_trung':
                            echo 'Ngày thứ này đã tồn tại trong lịch trình. Vui lòng chọn ngày khác.';
                            break;
                       
                        default:
                            echo 'Có lỗi xảy ra khi thêm/sửa lịch trình.';
                            break;
                    }
                ?>
            </div>
        <?php endif; ?>


        <div class="content-grid">
            
            <div class="card form-section">
                <div class="card-header">
                    <h3>Thông tin Ngày Lịch trình</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="?act=addLichTrinhProcess">
                        <input type="hidden" name="MaTour" value="<?= $maTour ?>">
                        
                        <div class="row">
                            <div class="form-group col-3">
                                <label for="NgayThu">Ngày thứ <span class="required">*</span></label>
                                <input type="number" id="NgayThu" name="NgayThu" min="1" value="1" required>
                            </div>
                            <div class="form-group col-9">
                                <label for="TieuDeNgay">Tiêu đề ngày <span class="required">*</span></label>
                                <input type="text" id="TieuDeNgay" name="TieuDeNgay" placeholder="Vd: Đón bay - Tham quan Chùa Linh Ứng" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="DiaDiemThamQuan">Địa điểm tham quan</label>
                            <input type="text" id="DiaDiemThamQuan" name="DiaDiemThamQuan" placeholder="Vd: Bà Nà Hills, Cầu Vàng...">
                        </div>

                        <div class="form-group">
                            <label for="NoiO">Nơi ở (Khách sạn/Tàu)</label>
                            <input type="text" id="NoiO" name="NoiO" placeholder="Vd: Khách sạn Mường Thanh 4*">
                        </div>

                        <div class="form-group">
                            <label>Các bữa ăn bao gồm:</label>
                            <div class="meal-checkboxes">
                                <label class="checkbox-container">
                                    <input type="checkbox" name="CoBuaSang" value="1">
                                    <i class="fas fa-coffee"></i> Sáng
                                </label>
                                <label class="checkbox-container">
                                    <input type="checkbox" name="CoBuaTrua" value="1">
                                    <i class="fas fa-utensils"></i> Trưa
                                </label>
                                <label class="checkbox-container">
                                    <input type="checkbox" name="CoBuaToi" value="1">
                                    <i class="fas fa-glass-cheers"></i> Tối
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="ChiTietHoatDong">Chi tiết hoạt động</label>
                            <textarea id="ChiTietHoatDong" name="ChiTietHoatDong" rows="6" placeholder="Mô tả chi tiết lịch trình: 08h00 xe đón..."></textarea>
                        </div>

                        <div class="form-actions">
                            <a href="?act=tour" class="btn btn-secondary">← Quay lại</a>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Lưu Lịch trình</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card list-section">
                <div class="card-header">
                    <h3>Danh sách Lịch trình (Tour <?= $currentTour ? htmlspecialchars($currentTour['MaCodeTour']) : '' ?>)</h3>
                </div>
                <div class="card-body table-responsive">
                    <?php if(empty($listLichTrinh)): ?>
                        <div class="empty-state">
                            <i class="fas fa-calendar-times" style="font-size: 48px; margin-bottom: 10px;"></i>
                            <p>Chưa có lịch trình nào cho tour này</p>
                        </div>
                    <?php else: ?>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 60px;">Ngày</th>
                                    <th>Tiêu đề & Hoạt động</th>
                                    <th style="width: 150px;">Dịch vụ</th>
                                    <th style="width: 100px;">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($listLichTrinh as $item): ?>
                                    <tr>
                                        <td class="text-center font-bold"><?= str_pad($item['NgayThu'], 2, '0', STR_PAD_LEFT) ?></td>
                                        <td>
                                            <div class="itinerary-title"><?= htmlspecialchars($item['TieuDeNgay']) ?></div>
                                            <?php if(!empty($item['ChiTietHoatDong'])): ?>
                                                <div class="itinerary-desc"><?= nl2br(htmlspecialchars($item['ChiTietHoatDong'])) ?></div>
                                            <?php endif; ?>
                                            <?php if(!empty($item['DiaDiemThamQuan'])): ?>
                                                <div class="itinerary-meta">
                                                    <i class="fas fa-map-marker-alt"></i> 
                                                    <small><?= htmlspecialchars($item['DiaDiemThamQuan']) ?></small>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="meal-badges">
                                                <?php if($item['CoBuaSang']): ?>
                                                    <span class="badge badge-success" title="Có Ăn sáng">Sáng</span>
                                                <?php endif; ?>
                                                <?php if($item['CoBuaTrua']): ?>
                                                    <span class="badge badge-success" title="Có Ăn trưa">Trưa</span>
                                                <?php endif; ?>
                                                <?php if($item['CoBuaToi']): ?>
                                                    <span class="badge badge-success" title="Có Ăn tối">Tối</span>
                                                <?php endif; ?>
                                            </div>
                                            <?php if(!empty($item['NoiO'])): ?>
                                                <div class="hotel-info">
                                                    <i class="fas fa-bed"></i> <small><?= htmlspecialchars($item['NoiO']) ?></small>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <a href="?act=editLichTrinh&id=<?= $item['MaLichTrinh'] ?>" class="btn-icon btn-edit" title="Sửa">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="?act=deleteLichTrinh&id=<?= $item['MaLichTrinh'] ?>&tour_id=<?= $maTour ?>" 
                                               class="btn-icon btn-delete" 
                                               title="Xóa"
                                               onclick="return confirm('Bạn có chắc chắn muốn xóa lịch trình này không?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>

</body>
</html>