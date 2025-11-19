<div class="container">
    <h2>Ảnh Tour: <?= $tour['TenTour'] ?></h2>

    <a href="?act=addAnhTour&MaTour=<?= $tour['MaTour'] ?>" class="btn btn-success mb-3">+ Thêm ảnh</a>

    <table class="table table-bordered">
        <tr>
            <th>Ảnh</th>
            <th>Chú thích</th>
            <th>Thứ tự</th>
            <th>Hành động</th>
        </tr>

        <?php foreach ($listAnh as $anh): ?>
            <tr>
                <td><img src="<?= $anh['DuongDanAnh'] ?>" width="100"></td>
                <td><?= $anh['ChuThichAnh'] ?></td>
                <td><?= $anh['ThuTuHienThi'] ?></td>
                <td>
                    <a href="?act=editAnhTour&MaAnh=<?= $anh['MaAnh'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                    <a onclick="return confirm('Xóa ảnh này?')"
                        href="?act=deleteAnhTour&MaAnh=<?= $anh['MaAnh'] ?>"
                        class="btn btn-danger btn-sm">Xóa</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <a href="?act=tour" class="btn btn-secondary">← Quay lại danh sách Tour</a>
</div>