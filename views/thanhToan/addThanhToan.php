<div class="container">
  <h2 class="page-title">➕ Thêm Thanh Toán</h2>

  <form action="?act=addThanhToanProcess" method="POST" class="form-box">
    <label>Mã Booking</label>
    <select name="MaBooking" required>
      <option value="">-- Chọn Booking --</option>
      <?php foreach ($listBooking as $b): ?>
        <option value="<?= $b['MaBooking'] ?>"><?= $b['MaCodeBooking'] ?></option>
      <?php endforeach; ?>
    </select>

    <label>Số Tiền</label>
    <input type="number" name="SoTien" required>

    <label>Ngày Thanh Toán</label>
    <input type="date" name="NgayThanhToan" required>

    <label>Phương Thức Thanh Toán</label>
    <select name="PhuongThucThanhToan">
      <option value="tien_mat">Tiền mặt</option>
      <option value="chuyen_khoan">Chuyển khoản</option>
      <option value="online">Online</option>
      <option value="the_tin_dung">Thẻ tín dụng</option>
    </select>

    <label>Loại Thanh Toán</label>
    <select name="LoaiThanhToan">
      <option value="dat_coc">Đặt cọc</option>
      <option value="tat_toan">Tất toán</option>
      <option value="tra_1_phan">Trả 1 phần</option>
    </select>

    <label>Mã Giao Dịch</label>
    <input type="text" name="MaGiaoDich">

    <label>Trạng Thái</label>
    <select name="TrangThai">
      <option value="thanh_cong">Thành công</option>
      <option value="cho_xu_ly">Chờ xử lý</option>
      <option value="that_bai">Thất bại</option>
    </select>

    <label>Ghi chú</label>
    <textarea name="GhiChu"></textarea>

    <div class="buttons">
      <button type="submit" class="btn btn-success">Lưu Thanh Toán</button>
      <a href="?act=listThanhToan" class="btn btn-secondary">Quay Lại</a>
    </div>
  </form>
</div>

<style>
.container{width:90%;max-width:700px;margin:40px auto;background:#fff;padding:25px;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,.1);}
.page-title{font-size:22px;color:#43a047;margin-bottom:15px;}
.form-box{display:flex;flex-direction:column;gap:10px;}
input,select,textarea{padding:10px;border:1px solid #ccc;border-radius:5px;font-size:15px;}
textarea{resize:vertical;min-height:80px;}
.buttons{margin-top:10px;display:flex;gap:10px;}
.btn{padding:10px 15px;border:none;border-radius:5px;font-weight:600;cursor:pointer;color:#fff;text-decoration:none;}
.btn-success{background:#43a047;} .btn-secondary{background:#6c757d;}
.btn:hover{filter:brightness(.95);}
</style>
