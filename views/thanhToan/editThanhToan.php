<div class="container">
  <h2 class="page-title">✏️ Sửa Thanh Toán</h2>

  <form action="?act=editThanhToanProcess" method="POST" class="form-box">
    <input type="hidden" name="MaThanhToan" value="<?= $thanhToan['MaThanhToan'] ?>">

    <label>Mã Booking</label>
    <select name="MaBooking">
      <?php foreach ($listBooking as $b): ?>
        <option value="<?= $b['MaBooking'] ?>" <?= $b['MaBooking']==$thanhToan['MaBooking']?'selected':'' ?>>
          <?= $b['MaCodeBooking'] ?>
        </option>
      <?php endforeach; ?>
    </select>

    <label>Số Tiền</label>
    <input type="number" name="SoTien" value="<?= $thanhToan['SoTien'] ?>">

    <label>Ngày Thanh Toán</label>
    <input type="date" name="NgayThanhToan" value="<?= $thanhToan['NgayThanhToan'] ?>">

    <label>Phương Thức Thanh Toán</label>
    <select name="PhuongThucThanhToan">
      <?php
      $methods=['tien_mat'=>'Tiền mặt','chuyen_khoan'=>'Chuyển khoản','online'=>'Online','the_tin_dung'=>'Thẻ tín dụng'];
      foreach($methods as $k=>$v){ $sel=$k==$thanhToan['PhuongThucThanhToan']?'selected':''; echo "<option value='$k' $sel>$v</option>"; }
      ?>
    </select>

    <label>Loại Thanh Toán</label>
    <select name="LoaiThanhToan">
      <?php
      $types=['dat_coc'=>'Đặt cọc','tat_toan'=>'Tất toán','tra_1_phan'=>'Trả 1 phần'];
      foreach($types as $k=>$v){ $sel=$k==$thanhToan['LoaiThanhToan']?'selected':''; echo "<option value='$k' $sel>$v</option>"; }
      ?>
    </select>

    <label>Mã Giao Dịch</label>
    <input type="text" name="MaGiaoDich" value="<?= $thanhToan['MaGiaoDich'] ?>">

    <label>Trạng Thái</label>
    <select name="TrangThai">
      <?php
      $st=['thanh_cong'=>'Thành công','cho_xu_ly'=>'Chờ xử lý','that_bai'=>'Thất bại'];
      foreach($st as $k=>$v){ $sel=$k==$thanhToan['TrangThai']?'selected':''; echo "<option value='$k' $sel>$v</option>"; }
      ?>
    </select>

    <label>Ghi chú</label>
    <textarea name="GhiChu"><?= $thanhToan['GhiChu'] ?></textarea>

    <div class="buttons">
      <button type="submit" class="btn btn-warning">Cập Nhật</button>
      <a href="?act=listThanhToan" class="btn btn-secondary">Quay Lại</a>
    </div>
  </form>
</div>

<style>
.container{width:90%;max-width:700px;margin:40px auto;background:#fff;padding:25px;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,.1);}
.page-title{font-size:22px;color:#ff9800;margin-bottom:15px;}
.form-box{display:flex;flex-direction:column;gap:10px;}
input,select,textarea{padding:10px;border:1px solid #ccc;border-radius:5px;font-size:15px;}
textarea{resize:vertical;min-height:80px;}
.buttons{margin-top:10px;display:flex;gap:10px;}
.btn{padding:10px 15px;border:none;border-radius:5px;font-weight:600;cursor:pointer;color:#fff;text-decoration:none;}
.btn-warning{background:#ff9800;} .btn-secondary{background:#6c757d;}
.btn:hover{filter:brightness(.95);}
</style>
