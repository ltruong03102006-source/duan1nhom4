<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <title>Thêm Tour Mới</title>
  <style>
    body{margin:0;background:#f4f6f9;font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;color:#333}
    .header{background:#1e88e5;padding:15px 20px;color:#fff;font-size:22px;font-weight:700}
    .container{width:95%;max-width:1400px;margin:25px auto}
    .card{background:#fff;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,.1);padding:18px;margin-bottom:18px}
    .card h2,.card h3{margin:0 0 12px}
    .card h3{font-size:16px;color:#0d47a1}
    .grid{display:grid;grid-template-columns:repeat(3,1fr);gap:12px}
    .field label{display:block;margin-bottom:6px;font-size:13px;color:#444;font-weight:600}
    .field input,.field select,.field textarea{
      width:100%;padding:10px 12px;border:1px solid #ddd;border-radius:8px;outline:none;font-size:14px;
      transition: .15s border-color,.15s box-shadow;
    }
    .field input:focus,.field select:focus,.field textarea:focus{border-color:#1e88e5;box-shadow:0 0 0 3px rgba(30,136,229,.15)}
    .field textarea{min-height:92px;resize:vertical}
    .row-2{grid-column:1/-1}
    .row-1-2{grid-column:1/3}
    .row-3{grid-column:3/4}

    .actions-bar{display:flex;gap:10px;flex-wrap:wrap;align-items:center;justify-content:space-between}
    .btn{
      padding:10px 14px;border:none;border-radius:8px;cursor:pointer;font-weight:700;font-size:14px;
      display:inline-flex;align-items:center;gap:8px;text-decoration:none;
    }
    .btn-primary{background:#1e88e5;color:#fff}
    .btn-primary:hover{background:#1565c0}
    .btn-secondary{background:#607d8b;color:#fff}
    .btn-secondary:hover{background:#546e7a}
    .btn-danger{background:#e53935;color:#fff}
    .btn-danger:hover{background:#c62828}
    .btn-success{background:#2e7d32;color:#fff}
    .btn-success:hover{background:#1b5e20}
    .hint{font-size:12px;color:#666;margin-top:6px}
    .alert{
      padding:12px 14px;border-radius:8px;margin-bottom:14px;font-weight:600
    }
    .alert-danger{background:#ffebee;border:1px solid #ffcdd2;color:#b71c1c}
    .alert-success{background:#d4edda;border:1px solid #c3e6cb;color:#155724}
    
    /* Class hiển thị lỗi validation */
    .text-danger { color: #e53935; font-size: 12px; font-weight: 600; font-style: italic; margin-top: 4px; display: block; }

    table{width:100%;border-collapse:collapse}
    th,td{padding:10px 10px;text-align:left;font-size:13px;border-bottom:1px solid #eee;vertical-align:top}
    th{background:#0d47a1;color:#fff;font-weight:700}
    tr:nth-child(even){background:#fafafa}
    .table-wrap{border:1px solid #eee;border-radius:10px;overflow:auto}
    .table-tools{display:flex;gap:10px;align-items:center;justify-content:space-between;margin:10px 0 12px}
    .badge{display:inline-block;padding:6px 10px;border-radius:999px;font-size:12px;font-weight:700}
    .badge-blue{background:#e3f2fd;color:#0d47a1}
    .badge-orange{background:#fff3e0;color:#e65100}
    .money{font-weight:800;color:#e53935}
    .right{text-align:right}
    .small{font-size:12px;color:#666}
    .rm-btn{padding:8px 10px;border-radius:8px;border:none;cursor:pointer}
    .rm-btn:hover{filter:brightness(.95)}
    .rm-btn-danger{background:#e53935;color:#fff}
    .sticky-total{
      margin-top:12px;display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap
    }
  </style>
</head>

<body>
  <div class="header">➕ Thêm Tour Mới (Gộp Giá Tour + Dự Toán)</div>

  <div class="container">

    <?php if (isset($errors['system'])): ?>
      <div class="alert alert-danger">
        <?= htmlspecialchars($errors['system']) ?>
      </div>
    <?php endif; ?>

    <form action="?act=addTourProcess" method="POST" enctype="multipart/form-data">

      <div class="card">
        <div class="actions-bar">
          <h2 style="margin:0">A) Thông tin tour</h2>
          <a class="btn btn-secondary" href="?act=tour">↩️ Quay lại danh sách</a>
        </div>

        <div class="grid" style="margin-top:12px">
          <div class="field">
            <label>Mã Tour (MaCodeTour) *</label>
            <input name="MaCodeTour" placeholder="VD: TOUR2025_001" 
                   value="<?= isset($oldData['MaCodeTour']) ? htmlspecialchars($oldData['MaCodeTour']) : '' ?>">
            
            <?php if (isset($errors['MaCodeTour'])): ?>
                <span class="text-danger"><?= $errors['MaCodeTour'] ?></span>
            <?php endif; ?>
          </div>

          <div class="field">
            <label>Tên Tour *</label>
            <input name="TenTour" placeholder="VD: Đà Nẵng - Hội An 3N2Đ"
                   value="<?= isset($oldData['TenTour']) ? htmlspecialchars($oldData['TenTour']) : '' ?>">
            
            <?php if (isset($errors['TenTour'])): ?>
                <span class="text-danger"><?= $errors['TenTour'] ?></span>
            <?php endif; ?>
          </div>

          <div class="field">
            <label>Danh Mục *</label>
            <select name="MaDanhMuc">
              <option value="">-- Chọn danh mục --</option>
              <?php foreach ($listDanhMuc as $dm): ?>
                <option value="<?= $dm['MaDanhMuc'] ?>" 
                    <?= (isset($oldData['MaDanhMuc']) && $oldData['MaDanhMuc'] == $dm['MaDanhMuc']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($dm['TenDanhMuc']) ?>
                </option>
              <?php endforeach; ?>
            </select>
            <?php if (isset($errors['MaDanhMuc'])): ?>
                <span class="text-danger"><?= $errors['MaDanhMuc'] ?></span>
            <?php endif; ?>
          </div>

          <div class="field">
            <label>Số Ngày</label>
            <input type="number" name="SoNgay" min="0" 
                   value="<?= isset($oldData['SoNgay']) ? $oldData['SoNgay'] : '0' ?>">
            
            <?php if (isset($errors['SoNgay'])): ?>
                <span class="text-danger"><?= $errors['SoNgay'] ?></span>
            <?php endif; ?>
          </div>

          <div class="field">
            <label>Số Đêm</label>
            <input type="number" name="SoDem" min="0" 
                   value="<?= isset($oldData['SoDem']) ? $oldData['SoDem'] : '0' ?>">
            
            <?php if (isset($errors['SoDem'])): ?>
                <span class="text-danger"><?= $errors['SoDem'] ?></span>
            <?php endif; ?>
          </div>

          <div class="field">
            <label>Điểm Khởi Hành</label>
            <input name="DiemKhoiHanh" placeholder="VD: Hà Nội / TP.HCM"
                   value="<?= isset($oldData['DiemKhoiHanh']) ? htmlspecialchars($oldData['DiemKhoiHanh']) : '' ?>">
          </div>

          <div class="field">
            <label>Trạng Thái</label>
            <select name="TrangThai">
              <option value="hoat_dong" <?= (isset($oldData['TrangThai']) && $oldData['TrangThai'] == 'hoat_dong') ? 'selected' : '' ?>>Hoạt động</option>
              <option value="khong_hoat_dong" <?= (isset($oldData['TrangThai']) && $oldData['TrangThai'] == 'khong_hoat_dong') ? 'selected' : '' ?>>Không hoạt động</option>
            </select>
          </div>

          <div class="field row-2">
            <label>Mô Tả</label>
            <textarea name="MoTa" placeholder="Mô tả ngắn về tour..."><?= isset($oldData['MoTa']) ? htmlspecialchars($oldData['MoTa']) : '' ?></textarea>
          </div>

          <div class="field row-1-2">
            <label>Ảnh Bìa</label>
            <input type="file" name="LinkAnhBia" accept="image/*">
            <div class="hint">Chỉ chọn file ảnh (jpg/png/webp...).</div>
          </div>

          

          <div class="field row-2">
            <label>Chính sách bao gồm</label>
            <textarea name="ChinhSachBaoGom"><?= isset($oldData['ChinhSachBaoGom']) ? htmlspecialchars($oldData['ChinhSachBaoGom']) : '' ?></textarea>
          </div>
          <div class="field row-2">
            <label>Chính sách không bao gồm</label>
            <textarea name="ChinhSachKhongBaoGom"><?= isset($oldData['ChinhSachKhongBaoGom']) ? htmlspecialchars($oldData['ChinhSachKhongBaoGom']) : '' ?></textarea>
          </div>
          <div class="field row-2">
            <label>Chính sách hủy</label>
            <textarea name="ChinhSachHuy"><?= isset($oldData['ChinhSachHuy']) ? htmlspecialchars($oldData['ChinhSachHuy']) : '' ?></textarea>
          </div>
          <div class="field row-2">
            <label>Chính sách hoàn tiền</label>
            <textarea name="ChinhSachHoanTien"><?= isset($oldData['ChinhSachHoanTien']) ? htmlspecialchars($oldData['ChinhSachHoanTien']) : '' ?></textarea>
          </div>
        </div>
      </div>

      <div class="card">
        <div class="table-tools">
          <div><h3 style="margin:0">B) Giá Tour</h3><div class="small">Thêm nhiều dòng giá theo loại khách.</div></div>
          <div style="display:flex;gap:10px;align-items:center"><span class="badge badge-blue">GiaTour</span><button type="button" class="btn btn-primary" id="btnAddGia">+ Thêm dòng giá</button></div>
        </div>
        <div class="table-wrap">
          <table>
            <thead><tr><th>Loại khách</th><th>Giá tiền</th><th>Áp dụng từ</th><th>Áp dụng đến</th><th>Loại mùa</th><th>% giảm</th><th>Tên khuyến mãi</th><th class="right">Xóa</th></tr></thead>
            <tbody id="giaBody"></tbody>
          </table>
        </div>
      </div>

      <div class="card">
        <div class="table-tools">
          <div><h3 style="margin:0">C) Dự Toán Chi Phí</h3><div class="small">Ghi các hạng mục chi dự kiến.</div></div>
          <div style="display:flex;gap:10px;align-items:center"><span class="badge badge-orange">DuToanChiPhiTour</span><button type="button" class="btn btn-primary" id="btnAddDuToan">+ Thêm hạng mục</button></div>
        </div>
        <div class="table-wrap">
          <table>
            <thead><tr><th>Hạng mục chi</th><th>Số tiền dự kiến</th><th>Ghi chú</th><th class="right">Xóa</th></tr></thead>
            <tbody id="duToanBody"></tbody>
          </table>
        </div>
        <div class="sticky-total">
          <div style="font-weight:800">Tổng dự toán: <span class="money" id="tongDuToan">0</span> đ</div>
          <button type="submit" class="btn btn-success">✅ Lưu tour</button>
        </div>
      </div>

    </form>
  </div>

<script>
  let giaIndex = 0;
  let duToanIndex = 0;

  function formatVN(n){ try { return Number(n||0).toLocaleString('vi-VN'); } catch(e){ return n; } }

  function addGiaRow(defaultLoai='nguoi_lon'){
    const i = giaIndex++;
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td><select name="gia[${i}][LoaiKhach]" required style="width:100%;padding:8px;border:1px solid #ddd;border-radius:8px"><option value="nguoi_lon">Người lớn</option><option value="tre_em">Trẻ em</option><option value="em_be">Em bé</option></select></td>
      <td><input type="number" name="gia[${i}][GiaTien]" required min="0" style="width:100%;padding:8px;border:1px solid #ddd;border-radius:8px"></td>
      <td><input type="date" name="gia[${i}][ApDungTuNgay]" style="width:100%;padding:8px;border:1px solid #ddd;border-radius:8px"></td>
      <td><input type="date" name="gia[${i}][ApDungDenNgay]" style="width:100%;padding:8px;border:1px solid #ddd;border-radius:8px"></td>
      <td><select name="gia[${i}][LoaiMua]" style="width:100%;padding:8px;border:1px solid #ddd;border-radius:8px"><option value="binh_thuong">Bình thường</option><option value="cao_diem">Cao điểm</option><option value="thap_diem">Thấp điểm</option></select></td>
      <td><input type="number" name="gia[${i}][PhanTramGiamGia]" min="0" max="100" value="0" style="width:100%;padding:8px;border:1px solid #ddd;border-radius:8px"></td>
      <td><input type="text" name="gia[${i}][TenKhuyenMai]" style="width:100%;padding:8px;border:1px solid #ddd;border-radius:8px"></td>
      <td class="right"><button type="button" class="rm-btn rm-btn-danger">Xóa</button></td>
    `;
    tr.querySelector('select[name^="gia"] option[value="'+defaultLoai+'"]').selected = true;
    tr.querySelector('.rm-btn').onclick = () => tr.remove();
    document.getElementById('giaBody').appendChild(tr);
  }

  function calcTong(){
    let sum = 0;
    document.querySelectorAll('#duToanBody input.money-input').forEach(inp => { const v = Number(inp.value || 0); sum += isNaN(v) ? 0 : v; });
    document.getElementById('tongDuToan').innerText = formatVN(sum);
  }

  function addDuToanRow(){
    const i = duToanIndex++;
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td><input type="text" name="dutoan[${i}][HangMucChi]" required style="width:100%;padding:8px;border:1px solid #ddd;border-radius:8px"></td>
      <td><input type="number" class="money-input" name="dutoan[${i}][SoTienDuKien]" required min="0" style="width:100%;padding:8px;border:1px solid #ddd;border-radius:8px"></td>
      <td><input type="text" name="dutoan[${i}][GhiChu]" style="width:100%;padding:8px;border:1px solid #ddd;border-radius:8px"></td>
      <td class="right"><button type="button" class="rm-btn rm-btn-danger">Xóa</button></td>
    `;
    tr.querySelector('.rm-btn').onclick = () => { tr.remove(); calcTong(); };
    tr.querySelector('.money-input').addEventListener('input', calcTong);
    document.getElementById('duToanBody').appendChild(tr);
    calcTong();
  }

  document.getElementById('btnAddGia').addEventListener('click', () => addGiaRow());
  document.getElementById('btnAddDuToan').addEventListener('click', () => addDuToanRow());

  addGiaRow('nguoi_lon');
  addDuToanRow();
</script>

</body>
</html>