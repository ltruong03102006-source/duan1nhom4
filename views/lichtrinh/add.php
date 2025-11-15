<h2>Thêm lịch trình cho tour</h2>

<form action="index.php?act=addLichTrinhProcess" method="POST">

    <input type="hidden" name="MaTour" value="<?= $MaTour ?>">

    <label>Ngày thứ:</label><br>
    <input type="number" name="NgayThu" required><br><br>

    <label>Tiêu đề ngày:</label><br>
    <input type="text" name="TieuDeNgay" required><br><br>

    <label>Chi tiết hoạt động:</label><br>
    <textarea name="ChiTietHoatDong" rows="5" required></textarea><br><br>

    <label>Địa điểm tham quan:</label><br>
    <textarea name="DiaDiemThamQuan" rows="4"></textarea><br><br>

    <label>Bữa ăn:</label><br>
    <input type="checkbox" name="CoBuaSang"> Sáng
    <input type="checkbox" name="CoBuaTrua"> Trưa
    <input type="checkbox" name="CoBuaToi"> Tối
    <br><br>

    <label>Nơi ở:</label><br>
    <input type="text" name="NoiO"><br><br>

    <button type="submit">Thêm lịch trình</button>
</form>

<br>
<a href="index.php?act=listLichTrinh&MaTour=<?= $MaTour ?>">← Quay lại</a>
