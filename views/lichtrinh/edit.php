<h2>Sửa lịch trình ngày <?= $lichtrinh['NgayThu'] ?></h2>

<form action="index.php?act=editLichTrinhProcess" method="POST">

    <input type="hidden" name="MaLichTrinh" value="<?= $lichtrinh['MaLichTrinh'] ?>">
    <input type="hidden" name="MaTour" value="<?= $lichtrinh['MaTour'] ?>">

    <label>Ngày thứ:</label><br>
    <input type="number" name="NgayThu" value="<?= $lichtrinh['NgayThu'] ?>" required><br><br>

    <label>Tiêu đề ngày:</label><br>
    <input type="text" name="TieuDeNgay" value="<?= $lichtrinh['TieuDeNgay'] ?>" required><br><br>

    <label>Chi tiết hoạt động:</label><br>
    <textarea name="ChiTietHoatDong" rows="5"><?= $lichtrinh['ChiTietHoatDong'] ?></textarea><br><br>

    <label>Địa điểm tham quan:</label><br>
    <textarea name="DiaDiemThamQuan" rows="4"><?= $lichtrinh['DiaDiemThamQuan'] ?></textarea><br><br>

    <label>Bữa ăn:</label><br>
    <input type="checkbox" name="CoBuaSang" <?= $lichtrinh['CoBuaSang'] ? "checked" : "" ?>> Sáng
    <input type="checkbox" name="CoBuaTrua" <?= $lichtrinh['CoBuaTrua'] ? "checked" : "" ?>> Trưa
    <input type="checkbox" name="CoBuaToi" <?= $lichtrinh['CoBuaToi'] ? "checked" : "" ?>> Tối
    <br><br>

    <label>Nơi ở:</label><br>
    <input type="text" name="NoiO" value="<?= $lichtrinh['NoiO'] ?>"><br><br>

    <button type="submit">Cập nhật</button>
</form>

<br>
<a href="index.php?act=listLichTrinh&MaTour=<?= $lichtrinh['MaTour'] ?>">← Quay lại</a>
