<div class="container">
  <h2 class="page-title">💵 Danh Sách Thanh Toán</h2>
  <a href="?act=addThanhToan" class="btn btn-primary mb-3">+ Thêm Thanh Toán</a>

  <table class="table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Mã Booking</th>
        <th>Khách Hàng</th>
        <th>Số Tiền</th>
        <th>Phương Thức</th>
        <th>Loại</th>
        <th>Trạng Thái</th>
        <th>Ngày Thanh Toán</th>
        <th>Hành Động</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($list as $row): ?>
        <tr>
          <td><?= $row['MaThanhToan'] ?></td>
          <td><?= $row['MaCodeBooking'] ?></td>
          <td><?= $row['TenKhach'] ?></td>
          <td class="price"><?= number_format($row['SoTien'], 0, ',', '.') ?>đ</td>
          <td><?= ucfirst($row['PhuongThucThanhToan']) ?></td>
          <td><?= ucfirst($row['LoaiThanhToan']) ?></td>
          <td><span class="status <?= $row['TrangThai'] ?>"><?= ucfirst($row['TrangThai']) ?></span></td>
          <td><?= $row['NgayThanhToan'] ?></td>
          <td class="actions">
            <a href="?act=editThanhToan&id=<?= $row['MaThanhToan'] ?>" class="btn btn-warning btn-sm">Sửa</a>
            <a href="?act=deleteThanhToan&id=<?= $row['MaThanhToan'] ?>" 
               onclick="return confirm('Xóa thanh toán này?')" class="btn btn-danger btn-sm">Xóa</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<style>
.container {width:95%;max-width:1200px;margin:30px auto;font-family:'Segoe UI',sans-serif;}
.page-title {font-size:22px;color:#1e88e5;margin-bottom:15px;}
.table {width:100%;border-collapse:collapse;background:white;border-radius:6px;overflow:hidden;}
.table th {background:#1e88e5;color:#fff;padding:10px;}
.table td {padding:10px;border-bottom:1px solid #eee;}
.table tr:nth-child(even){background:#f8f8f8;}
.btn {padding:8px 14px;border:none;border-radius:5px;color:#fff;text-decoration:none;font-weight:600;cursor:pointer;}
.btn-primary{background:#1e88e5;} .btn-warning{background:#ff9800;} .btn-danger{background:#e53935;}
.btn-sm{padding:5px 10px;font-size:13px;}
.price{color:#d32f2f;font-weight:bold;}
.status.thanh_cong{color:#2e7d32;font-weight:bold;}
.status.that_bai{color:#c62828;font-weight:bold;}
.status.cho_xu_ly{color:#f57c00;font-weight:bold;}
.actions{display:flex;gap:6px;}
</style>
