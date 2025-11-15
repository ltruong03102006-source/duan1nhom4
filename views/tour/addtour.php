<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Thêm Tour Du Lịch</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
      font-family: 'Inter', sans-serif;
    }

    body {
      background-color: #f4f6f8;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 900px;
      margin: 40px auto;
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
      text-align: center;
      color: #2c3e50;
      margin-bottom: 20px;
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    .form-group {
      display: flex;
      flex-direction: column;
    }

    label {
      font-weight: 600;
      margin-bottom: 5px;
      color: #34495e;
    }

    input,
    select,
    textarea {
      padding: 10px;
      border: 1px solid #dcdde1;
      border-radius: 6px;
      font-size: 15px;
    }

    textarea {
      resize: vertical;
      min-height: 80px;
    }

    .form-row {
      display: flex;
      gap: 15px;
    }

    .form-row .form-group {
      flex: 1;
    }

    .btn-submit {
      background-color: #27ae60;
      color: white;
      font-weight: 600;
      padding: 12px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: 0.3s;
    }

    .btn-submit:hover {
      background-color: #219150;
    }
  </style>
</head>

<body>
  <div class="container">
    <h2>Thêm Tour Du Lịch Mới</h2>
    <form action="?act=addTourProcess" method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label for="MaCodeTour">Mã Code Tour *</label>
        <input type="text" id="MaCodeTour" name="MaCodeTour" required>
      </div>

      <div class="form-group">
        <label for="TenTour">Tên Tour *</label>
        <input type="text" id="TenTour" name="TenTour" required>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label for="MaDanhMuc">Danh Mục Tour</label>
          <select name="MaDanhMuc" id="MaDanhMuc">
            <option value="">-- Chọn danh mục --</option>
            <?php foreach ($listDanhMuc as $dm): ?>
              <option value="<?= $dm['MaDanhMuc'] ?>"><?= $dm['TenDanhMuc'] ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label for="SoNgay">Số ngày</label>
          <input type="number" id="SoNgay" name="SoNgay" min="1">
        </div>

        <div class="form-group">
          <label for="SoDem">Số đêm</label>
          <input type="number" id="SoDem" name="SoDem" min="0">
        </div>
      </div>

      <div class="form-group">
        <label for="DiemKhoiHanh">Điểm khởi hành</label>
        <input type="text" id="DiemKhoiHanh" name="DiemKhoiHanh">
      </div>

      <div class="form-group">
        <label for="MoTa">Mô tả Tour</label>
        <textarea id="MoTa" name="MoTa"></textarea>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label for="GiaVonDuKien">Giá vốn dự kiến (VNĐ)</label>
          <input type="number" id="GiaVonDuKien" name="GiaVonDuKien" step="0.01">
        </div>

        <div class="form-group">
          <label for="GiaBanMacDinh">Giá bán mặc định (VNĐ)</label>
          <input type="number" id="GiaBanMacDinh" name="GiaBanMacDinh" step="0.01">
        </div>
      </div>

      <div class="form-group">
        <label for="LinkAnhBia">Ảnh bìa Tour</label>
        <input type="file" id="LinkAnhBia" name="LinkAnhBia" accept="image/*">
      </div>

      <div class="form-group">
        <label for="ChinhSachBaoGom">Chính sách bao gồm</label>
        <textarea id="ChinhSachBaoGom" name="ChinhSachBaoGom"></textarea>
      </div>

      <div class="form-group">
        <label for="ChinhSachKhongBaoGom">Chính sách không bao gồm</label>
        <textarea id="ChinhSachKhongBaoGom" name="ChinhSachKhongBaoGom"></textarea>
      </div>

      <div class="form-group">
        <label for="ChinhSachHuy">Chính sách hủy tour</label>
        <textarea id="ChinhSachHuy" name="ChinhSachHuy"></textarea>
      </div>

      <div class="form-group">
        <label for="TrangThai">Trạng thái</label>
        <select id="TrangThai" name="TrangThai">
          <option value="hoat_dong">Hoạt động</option>
          <option value="khong_hoat_dong">Không hoạt động</option>
        </select>
      </div>

      <button type="submit" class="btn-submit">Thêm Tour</button>
    </form>
  </div>
</body>

</html>