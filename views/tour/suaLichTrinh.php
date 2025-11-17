<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Lịch trình Tour</title>
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

        .content-grid {
            display: grid;
            grid-template-columns: 350px 1fr;
            gap: 20px;
        }

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

        .table-responsive { overflow-x: auto; }
        .table { width: 100%; border-collapse: collapse; }
        .table th { text-align: left; padding: 12px; background-color: #f8fafc; color: var(--text-secondary); font-weight: 600; border-bottom: 2px solid var(--border-color); }
        .table td { padding: 12px; border-bottom: 1px solid var(--border-color); vertical-align: top; }
        .table-hover tbody tr:hover { background-color: #f8fafc; }

        .text-center { text-align: center; }
        .font-bold { font-weight: bold; color: var(--primary-color); font-size: 16px; }

        .itinerary-title { font-weight: 600; color: var(--primary-color); margin-bottom: 4px; }
        .itinerary-desc { font-size: 13px; color: var(--text-main); margin-bottom: 6px; }
        .itinerary-meta { font-size: 12px; color: var(--text-secondary); }

        .meal-badges { display: flex; gap: 5px; flex-wrap: wrap; }
        .badge { padding: 3px 8px; border-radius: 12px; font-size: 11px
        ; font-weight: 600; }
        .badge-success { background-color: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }

        .btn-icon {
            width: 32px; height: 32px;
            border-radius: 4px; border: none;
            cursor: pointer; display: inline-flex;
            align-items: center; justify-content: center;
            transition: all 0.2s;
            text-decoration: none;
        }
        .btn-edit { background-color: #eff6ff; color: var(--primary-color); }
        .btn-delete { background-color: #fef2f2; color: var(--danger-color); margin-left: 5px; }

        .hotel-info { margin-top: 5px; font-size: 12px; color: var(--text-secondary); }

        @media (max-width: 992px) {
            .content-grid { grid-template-columns: 1fr; }
        }
    </style>
    <div class="main-wrapper">
        <header class="page-header">
            <h1><i class="fas fa-edit"></i> Sửa Lịch trình Tour</h1>
            <a href="?act=lichTour&tour_id=<?= $lichTrinh['MaTour'] ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Quay lại
            </a>
        </header>

        <div class="content-grid">
            
            <div class="card form-section">
                <div class="card-header">
                    <h3>Cập nhật Lịch trình</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="?act=editLichTrinhProcess">
                        <input type="hidden" name="MaLichTrinh" value="<?= $lichTrinh['MaLichTrinh'] ?>">
                        <input type="hidden" name="MaTour" value="<?= $lichTrinh['MaTour'] ?>">
                        
                        <div class="row">
                            <div class="form-group col-3">
                                <label for="NgayThu">Ngày thứ <span class="required">*</span></label>
                                <input type="number" id="NgayThu" name="NgayThu" min="1" value="<?= $lichTrinh['NgayThu'] ?>" required>
                            </div>
                            <div class="form-group col-9">
                                <label for="TieuDeNgay">Tiêu đề ngày <span class="required">*</span></label>
                                <input type="text" id="TieuDeNgay" name="TieuDeNgay" value="<?= htmlspecialchars($lichTrinh['TieuDeNgay']) ?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="DiaDiemThamQuan">Địa điểm tham quan</label>
                            <input type="text" id="DiaDiemThamQuan" name="DiaDiemThamQuan" value="<?= htmlspecialchars($lichTrinh['DiaDiemThamQuan']) ?>">
                        </div>

                        <div class="form-group">
                            <label for="NoiO">Nơi ở (Khách sạn/Tàu)</label>
                            <input type="text" id="NoiO" name="NoiO" value="<?= htmlspecialchars($lichTrinh['NoiO']) ?>">
                        </div>

                        <div class="form-group">
                            <label>Các bữa ăn bao gồm:</label>
                            <div class="meal-checkboxes">
                                <label class="checkbox-container">
                                    <input type="checkbox" name="CoBuaSang" value="1" <?= $lichTrinh['CoBuaSang'] ? 'checked' : '' ?>>
                                    <i class="fas fa-coffee"></i> Sáng
                                </label>
                                <label class="checkbox-container">
                                    <input type="checkbox" name="CoBuaTrua" value="1" <?= $lichTrinh['CoBuaTrua'] ? 'checked' : '' ?>>
                                    <i class="fas fa-utensils"></i> Trưa
                                </label>
                                <label class="checkbox-container">
                                    <input type="checkbox" name="CoBuaToi" value="1" <?= $lichTrinh['CoBuaToi'] ? 'checked' : '' ?>>
                                    <i class="fas fa-glass-cheers"></i> Tối
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="ChiTietHoatDong">Chi tiết hoạt động</label>
                            <textarea id="ChiTietHoatDong" name="ChiTietHoatDong" rows="6"><?= htmlspecialchars($lichTrinh['ChiTietHoatDong']) ?></textarea>
                        </div>

                        <div class="form-actions">
                            <a href="?act=lichTour&tour_id=<?= $lichTrinh['MaTour'] ?>" class="btn btn-secondary">Hủy</a>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card list-section">
                <div class="card-header">
                    <h3>Danh sách Lịch trình (Tour <?= $currentTour ? htmlspecialchars($currentTour['MaCodeTour']) : '' ?>)</h3>
                </div>
                <div class="card-body table-responsive">
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
                                <tr <?= ($item['MaLichTrinh'] == $lichTrinh['MaLichTrinh']) ? 'style="background-color: #fef3c7;"' : '' ?>>
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
                                                <span class="badge badge-success">Sáng</span>
                                            <?php endif; ?>
                                            <?php if($item['CoBuaTrua']): ?>
                                                <span class="badge badge-success">Trưa</span>
                                            <?php endif; ?>
                                            <?php if($item['CoBuaToi']): ?>
                                                <span class="badge badge-success">Tối</span>
                                            <?php endif; ?>
                                        </div>
                                        <?php if(!empty($item['NoiO'])): ?>
                                            <div class="hotel-info">
                                                <i class="fas fa-bed"></i> <small><?= htmlspecialchars($item['NoiO']) ?></small>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="?act=editLichTrinh&id=<?= $item['MaLichTrinh'] ?>" class="btn-icon btn-edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="?act=deleteLichTrinh&id=<?= $item['MaLichTrinh'] ?>&tour_id=<?= $maTour ?>" 
                                           class="btn-icon btn-delete"
                                           onclick="return confirm('Bạn có chắc chắn muốn xóa lịch trình này không?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

</body>
</html>