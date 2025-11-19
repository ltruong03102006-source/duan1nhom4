<div class="container">
    <h2>Sửa ảnh Tour</h2>

    <form action="?act=editAnhTourProcess" method="POST" enctype="multipart/form-data">

        <input type="hidden" name="MaAnh" value="<?= $anh['MaAnh'] ?>">
        <input type="hidden" name="MaTour" value="<?= $anh['MaTour'] ?>">
        <input type="hidden" name="OldAnh" value="<?= $anh['DuongDanAnh'] ?>">

        <img src="<?= $anh['DuongDanAnh'] ?>" width="200">

        <label>Ảnh mới (nếu đổi)</label>
        <input type="file" name="DuongDanAnh" class="form-control">

        <label>Chú thích</label>
        <input type="text" name="ChuThichAnh" value="<?= $anh['ChuThichAnh'] ?>" class="form-control">

        <label>Thứ tự</label>
        <input type="number" name="ThuTuHienThi" value="<?= $anh['ThuTuHienThi'] ?>" class="form-control">

        <button class="btn btn-primary mt-3">Cập nhật</button>
    </form>
</div>
