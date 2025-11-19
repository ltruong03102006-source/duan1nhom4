<div class="container">
    <h2>Thêm ảnh cho tour: <?= $tour['TenTour'] ?></h2>

    <form action="?act=addAnhTourProcess" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="MaTour" value="<?= $tour['MaTour'] ?>">

        <label>Ảnh *</label>
        <input type="file" name="DuongDanAnh" required class="form-control">

        <label>Chú thích</label>
        <input type="text" name="ChuThichAnh" class="form-control">

        <label>Thứ tự</label>
        <input type="number" name="ThuTuHienThi" value="0" class="form-control">

        <button class="btn btn-primary mt-3">Thêm ảnh</button>
    </form>
    <br>
    <a href="?act=tour" class="btn btn-secondary">← Quay lại danh sách Tour</a>
</div>
