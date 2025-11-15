<h2>Quản lý lịch trình tour</h2>

<a href="index.php?act=addLichTrinh&MaTour=<?= $MaTour ?>" class="btn btn-primary" style="margin-bottom: 15px;">
    + Thêm ngày lịch trình
</a>

<table border="1" cellpadding="10" cellspacing="0" width="100%">
    <tr style="background: #f3f3f3;">
        <th>Ngày thứ</th>
        <th>Tiêu đề</th>
        <th>Hoạt động</th>
        <th>Tham quan</th>
        <th>Ăn uống</th>
        <th>Nơi ở</th>
        <th>Thao tác</th>
    </tr>

    <?php if (!empty($list)) : ?>
        <?php foreach ($list as $lt) : ?>
            <tr>
                <td><?= $lt['NgayThu'] ?></td>
                <td><?= $lt['TieuDeNgay'] ?></td>
                <td><?= nl2br($lt['ChiTietHoatDong']) ?></td>
                <td><?= nl2br($lt['DiaDiemThamQuan']) ?></td>
                <td>
                    <?= $lt['CoBuaSang'] ? "Sáng, " : "" ?>
                    <?= $lt['CoBuaTrua'] ? "Trưa, " : "" ?>
                    <?= $lt['CoBuaToi'] ? "Tối" : "" ?>
                </td>
                <td><?= $lt['NoiO'] ?></td>

                <td>
                    <a href="index.php?act=editLichTrinh&id=<?= $lt['MaLichTrinh'] ?>&MaTour=<?= $MaTour ?>">Sửa</a> |
                    <a onclick="return confirm('Bạn chắc chắn muốn xóa?')"
                       href="index.php?act=deleteLichTrinh&id=<?= $lt['MaLichTrinh'] ?>&MaTour=<?= $MaTour ?>">
                        Xóa
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else : ?>
        <tr>
            <td colspan="7" style="text-align:center;">Chưa có lịch trình nào</td>
        </tr>
    <?php endif; ?>
</table>

<br>
<a href="index.php?act=tourList" class="btn btn-secondary">← Quay lại danh sách tour</a>
