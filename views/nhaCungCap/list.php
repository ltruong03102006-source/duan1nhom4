<style>
    /* CSS cho bảng danh sách */
    .btn-add {
        background: #198754; color: #fff; padding: 10px 18px;
        border: none; border-radius: 5px; cursor: pointer;
        font-size: 14px; font-weight: bold; margin-bottom: 20px;
    }
    .btn-add:hover { background: #146c43; }
    .actions a { text-decoration: none; margin-right: 5px; }
    .btn-edit { background: #ff9800; color: white; padding: 5px 10px; border-radius: 4px; }
    .btn-delete { background: #e53935; color: white; padding: 5px 10px; border-radius: 4px; }
    .status-active { color: #198754; font-weight: bold; }
    .status-locked { color: #dc3545; font-weight: bold; }
</style>

<div class="container-fluid px-4">
    <h1 class="mt-4">Quản Lý Nhà Cung Cấp</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Nhà Cung Cấp</li>
    </ol>

    <a href="?act=addNhaCungCap">
        <button class="btn-add">
            <i class="fas fa-plus"></i> Thêm Nhà Cung Cấp
        </button>
    </a>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Danh sách Nhà Cung Cấp
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Mã NCC</th>
                        <th>Tên NCC</th>
                        <th>Loại</th>
                        <th>Người liên hệ</th>
                        <th>Điện thoại</th>
                        <th>Hợp đồng</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($listNCC as $ncc): ?>
                        <tr>
                            <td><?= $ncc['MaCodeNCC'] ?></td>
                            <td><?= $ncc['TenNhaCungCap'] ?></td>
                            
                            <td>
                                <?php 
                                    // Thay thế dấu gạch dưới (_) bằng khoảng trắng
                                    // Thay thế dấu phẩy (,) bằng dấu phẩy + khoảng trắng để dễ đọc
                                    // Viết hoa chữ cái đầu mỗi từ
                                    echo ucwords(str_replace(['_', ','], [' ', ', '], $ncc['LoaiNhaCungCap'])); 
                                ?>
                            </td>

                            <td><?= $ncc['NguoiLienHe'] ?></td>
                            <td><?= $ncc['SoDienThoai'] ?></td>
                            <td>
                                <?php if (!empty($ncc['FileHopDong'])): ?>
                                    <a href="<?= $ncc['FileHopDong'] ?>" target="_blank">Xem file</a>
                                <?php else: ?>
                                    Không có
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($ncc['TrangThai'] == 'hoat_dong'): ?>
                                    <span class="status-active">Hoạt động</span>
                                <?php else: ?>
                                    <span class="status-locked">Không hoạt động</span>
                                <?php endif; ?>
                            </td>
                            <td class="actions">
                                <a href="?act=editNhaCungCap&id=<?= $ncc['MaNhaCungCap'] ?>" class="btn-edit">Sửa</a>
                                <a href="?act=deleteNhaCungCap&id=<?= $ncc['MaNhaCungCap'] ?>" 
                                   class="btn-delete"
                                   onclick="return confirm('Bạn có chắc muốn xóa NCC này? (Hành động này sẽ xóa cả file hợp đồng!)');">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>