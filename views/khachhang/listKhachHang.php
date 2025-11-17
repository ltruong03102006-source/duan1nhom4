<div class="container-fluid px-4">
    <h1 class="mt-4">Danh sách Khách Hàng</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="?act=/">Dashboard</a></li>
        <li class="breadcrumb-item active">Danh sách Khách hàng</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>
                <i class="fas fa-table me-1"></i>
                Dữ liệu Khách hàng
            </span>
            <a href="?act=addKhachHang" class="btn btn-primary btn-sm">
                <i class="fas fa-user-plus me-1"></i> Thêm mới
            </a>
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Mã Code</th>
                        <th>Họ Tên</th>
                        <th>Số Điện Thoại</th>
                        <th>Email</th>
                        <th>Loại Khách</th>
                        <th>Tên Công Ty</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Mã Code</th>
                        <th>Họ Tên</th>
                        <th>Số Điện Thoại</th>
                        <th>Email</th>
                        <th>Loại Khách</th>
                        <th>Tên Công Ty</th>
                        <th>Thao tác</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php if (isset($listKhachHang) && is_array($listKhachHang)): ?>
                        <?php foreach ($listKhachHang as $kh): ?>
                            <tr>
                                <td><?= $kh['MaKhachHang'] ?></td>
                                <td><?= htmlspecialchars($kh['MaCodeKhachHang']) ?></td>
                                <td><?= htmlspecialchars($kh['HoTen']) ?></td>
                                <td><?= htmlspecialchars($kh['SoDienThoai']) ?></td>
                                <td><?= htmlspecialchars($kh['Email']) ?></td>
                                <td>
                                    <?= $kh['LoaiKhach'] == 'cong_ty' ? 'Công ty' : 'Cá nhân' ?>
                                </td>
                                <td><?= htmlspecialchars($kh['TenCongTy'] ?? '---') ?></td>
                                <td>
                                    <a href="?act=editKhachHang&id=<?= $kh['MaKhachHang'] ?>" class="btn btn-warning btn-sm" title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="?act=deleteKhachHang&id=<?= $kh['MaKhachHang'] ?>" 
                                       class="btn btn-danger btn-sm" 
                                       title="Xóa"
                                       onclick="return confirm('Bạn có chắc chắn muốn xóa khách hàng này không?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>