<h2>📘 Nhật ký tour (ADMIN)</h2>

<table border="1" cellpadding="8" width="100%">
    <tr>
        <th>Ngày</th>
        <th>Giờ</th>
        <th>Tour</th>
        <th>Đoàn</th>
        <th>Người ghi</th>
        <th>Nội dung</th>
        <th>Sự cố</th>
        <th>Ảnh</th>
    </tr>

    <?php foreach ($list as $row): ?>
    <tr>
        <td><?= $row['NgayGhi'] ?></td>
        <td><?= $row['GioGhi'] ?></td>
        <td><?= $row['TenTour'] ?></td>
        <td><?= $row['MaDoan'] ?></td>
        <td><?= $row['HoTen'] ?></td>
        <td><?= nl2br($row['NoiDung']) ?></td>
        <td><?= $row['LoaiSuCo'] ?></td>
        <td>
            <?php if ($row['LinkAnh']): ?>
                <img src="<?= $row['LinkAnh'] ?>" width="80">
            <?php endif; ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
    <a href="?act=/" class="btn btn-secondary mt-3">
        <i class="fas fa-arrow-left"></i> Quay lại
    </a>