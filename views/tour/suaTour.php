<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sửa Tour</title>
  <style>
    body {
      margin: 0;
      background: #f4f6f9;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: #333
    }

    .header {
      background: #1e88e5;
      padding: 15px 20px;
      color: #fff;
      font-size: 22px;
      font-weight: 700
    }

    .container {
      width: 95%;
      max-width: 1400px;
      margin: 25px auto
    }

    .card {
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, .1);
      padding: 18px;
      margin-bottom: 18px
    }

    .card h2,
    .card h3 {
      margin: 0 0 12px
    }

    .card h3 {
      font-size: 16px;
      color: #0d47a1
    }

    .grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 12px
    }

    .field label {
      display: block;
      margin-bottom: 6px;
      font-size: 13px;
      color: #444;
      font-weight: 600
    }

    .field input,
    .field select,
    .field textarea {
      width: 100%;
      padding: 10px 12px;
      border: 1px solid #ddd;
      border-radius: 8px;
      outline: none;
      font-size: 14px;
      transition: .15s border-color, .15s box-shadow;
    }

    .field input:focus,
    .field select:focus,
    .field textarea:focus {
      border-color: #1e88e5;
      box-shadow: 0 0 0 3px rgba(30, 136, 229, .15)
    }

    .field textarea {
      min-height: 92px;
      resize: vertical
    }

    .row-2 {
      grid-column: 1/-1
    }

    .row-1-2 {
      grid-column: 1/3
    }

    .row-3 {
      grid-column: 3/4
    }

    .actions-bar {
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
      align-items: center;
      justify-content: space-between
    }

    .btn {
      padding: 10px 14px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 700;
      font-size: 14px;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      text-decoration: none;
    }

    .btn-primary {
      background: #1e88e5;
      color: #fff
    }

    .btn-primary:hover {
      background: #1565c0
    }

    .btn-secondary {
      background: #607d8b;
      color: #fff
    }

    .btn-secondary:hover {
      background: #546e7a
    }

    .btn-danger {
      background: #e53935;
      color: #fff
    }

    .btn-danger:hover {
      background: #c62828
    }

    .btn-success {
      background: #2e7d32;
      color: #fff
    }

    .btn-success:hover {
      background: #1b5e20
    }

    .hint {
      font-size: 12px;
      color: #666;
      margin-top: 6px
    }

    .alert {
      padding: 12px 14px;
      border-radius: 8px;
      margin-bottom: 14px;
      font-weight: 600
    }

    .alert-danger {
      background: #ffebee;
      border: 1px solid #ffcdd2;
      color: #b71c1c
    }

    .alert-success {
      background: #d4edda;
      border: 1px solid #c3e6cb;
      color: #155724
    }

    /* Class hiển thị lỗi validation */
    .text-danger {
      color: #e53935;
      font-size: 12px;
      font-weight: 600;
      font-style: italic;
      margin-top: 4px;
      display: block;
    }

    table {
      width: 100%;
      border-collapse: collapse
    }

    th,
    td {
      padding: 10px 10px;
      text-align: left;
      font-size: 13px;
      border-bottom: 1px solid #eee;
      vertical-align: top
    }

    th {
      background: #0d47a1;
      color: #fff;
      font-weight: 700
    }

    tr:nth-child(even) {
      background: #fafafa
    }

    .table-wrap {
      border: 1px solid #eee;
      border-radius: 10px;
      overflow: auto
    }

    .table-tools {
      display: flex;
      gap: 10px;
      align-items: center;
      justify-content: space-between;
      margin: 10px 0 12px
    }

    .badge {
      display: inline-block;
      padding: 6px 10px;
      border-radius: 999px;
      font-size: 12px;
      font-weight: 700
    }

    .badge-blue {
      background: #e3f2fd;
      color: #0d47a1
    }

    .badge-orange {
      background: #fff3e0;
      color: #e65100
    }

    .money {
      font-weight: 800;
      color: #e53935
    }

    .right {
      text-align: right
    }

    .small {
      font-size: 12px;
      color: #666
    }

    .rm-btn {
      padding: 8px 10px;
      border-radius: 8px;
      border: none;
      cursor: pointer
    }

    .rm-btn:hover {
      filter: brightness(.95)
    }

    .rm-btn-danger {
      background: #e53935;
      color: #fff
    }

    .sticky-total {
      margin-top: 12px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 12px;
      flex-wrap: wrap
    }

    .preview {
      display: flex;
      gap: 12px;
      align-items: flex-start;
      flex-wrap: wrap;
      margin-top: 8px
    }

    .preview img {
      width: 180px;
      height: 120px;
      object-fit: cover;
      border: 1px solid #ddd;
      border-radius: 10px
    }
  </style>
</head>

<body>
  <div class="header">✏️ Sửa Tour (Gộp Giá Tour + Dự Toán)</div>

  <div class="container">

    <?php if (isset($errors['system'])): ?>
      <div class="alert alert-danger">
        <?= htmlspecialchars($errors['system']) ?>
      </div>
    <?php endif; ?>

    <?php if (isset($_GET['success'])): ?>
      <div class="alert alert-success">✅ Cập nhật tour thành công!</div>
    <?php endif; ?>

    <form action="?act=editTourProcess" method="POST" enctype="multipart/form-data">

      <input type="hidden" name="MaTour" value="<?= (int)$tour['MaTour'] ?>">

      <div class="card">
        <div class="actions-bar">
          <h2 style="margin:0">A) Thông tin tour</h2>
          <a class="btn btn-secondary" href="?act=tour">↩️ Quay lại danh sách</a>
        </div>

        <div class="grid" style="margin-top:12px">
          <div class="field">
            <label>Mã Tour (MaCodeTour) *</label>
            <input name="MaCodeTour" required value="<?= htmlspecialchars($tour['MaCodeTour'] ?? '') ?>" />
            <?php if (isset($errors['MaCodeTour'])): ?>
              <span class="text-danger"><?= $errors['MaCodeTour'] ?></span>
            <?php endif; ?>
          </div>

          <div class="field">
            <label>Tên Tour *</label>
            <input name="TenTour" required value="<?= htmlspecialchars($tour['TenTour'] ?? '') ?>" />
            <?php if (isset($errors['TenTour'])): ?>
              <span class="text-danger"><?= $errors['TenTour'] ?></span>
            <?php endif; ?>
          </div>

          <div class="field">
            <label>Danh Mục *</label>
            <select name="MaDanhMuc" required>
              <option value="">-- Chọn danh mục --</option>
              <?php foreach ($listDanhMuc as $dm): ?>
                <option value="<?= $dm['MaDanhMuc'] ?>"
                  <?= ((int)($tour['MaDanhMuc'] ?? 0) === (int)$dm['MaDanhMuc']) ? 'selected' : '' ?>>
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
            <input type="number" name="SoNgay" min="0" value="<?= (int)($tour['SoNgay'] ?? 0) ?>">
            <?php if (isset($errors['SoNgay'])): ?>
              <span class="text-danger"><?= $errors['SoNgay'] ?></span>
            <?php endif; ?>
          </div>

          <div class="field">
            <label>Số Đêm</label>
            <input type="number" name="SoDem" min="0" value="<?= (int)($tour['SoDem'] ?? 0) ?>">
            <?php if (isset($errors['SoDem'])): ?>
              <span class="text-danger"><?= $errors['SoDem'] ?></span>
            <?php endif; ?>
          </div>

          <div class="field">
            <label>Điểm Khởi Hành</label>
            <input name="DiemKhoiHanh" value="<?= htmlspecialchars($tour['DiemKhoiHanh'] ?? '') ?>" />
          </div>

          <div class="field">
            <label>Trạng Thái</label>
            <select name="TrangThai">
              <option value="hoat_dong" <?= (($tour['TrangThai'] ?? '') === 'hoat_dong') ? 'selected' : '' ?>>Hoạt động</option>
              <option value="khong_hoat_dong" <?= (($tour['TrangThai'] ?? '') === 'khong_hoat_dong') ? 'selected' : '' ?>>Không hoạt động</option>
            </select>
          </div>

          <div class="field row-2">
            <label>Mô Tả</label>
            <textarea name="MoTa"><?= htmlspecialchars($tour['MoTa'] ?? '') ?></textarea>
          </div>

          <div class="field row-1-2">
            <label>Ảnh Bìa</label>
            <input type="file" name="LinkAnhBia" accept="image/*">
            <input type="hidden" name="old_image" value="<?= htmlspecialchars($tour['LinkAnhBia'] ?? '') ?>">
            <div class="preview">
              <?php if (!empty($tour['LinkAnhBia'])): ?>
                <img src="<?= htmlspecialchars($tour['LinkAnhBia']) ?>" alt="Ảnh bìa">
              <?php endif; ?>
            </div>
            <div class="hint">Nếu không chọn ảnh mới, hệ thống giữ ảnh cũ.</div>
          </div>



          <div class="field row-2">
            <label>Chính sách bao gồm</label>
            <textarea name="ChinhSachBaoGom"><?= htmlspecialchars($tour['ChinhSachBaoGom'] ?? '') ?></textarea>
          </div>

          <div class="field row-2">
            <label>Chính sách không bao gồm</label>
            <textarea name="ChinhSachKhongBaoGom"><?= htmlspecialchars($tour['ChinhSachKhongBaoGom'] ?? '') ?></textarea>
          </div>

          <div class="field row-2">
            <label>Chính sách hủy</label>
            <textarea name="ChinhSachHuy"><?= htmlspecialchars($tour['ChinhSachHuy'] ?? '') ?></textarea>
          </div>

          <div class="field row-2">
            <label>Chính sách hoàn tiền</label>
            <textarea name="ChinhSachHoanTien"><?= htmlspecialchars($tour['ChinhSachHoanTien'] ?? '') ?></textarea>
          </div>

        </div>
      </div>

<div class="card">
  <div class="table-tools">
    <div>
      <h3 style="margin:0">B) Giá Tour</h3>
      <div class="small">
        Nhập giá cho 3 nhóm khách. Có thể nhập % giảm — hệ thống sẽ tính “Giá sau giảm”.
        Nếu bật “Áp dụng giảm vào giá khi lưu”, khi submit sẽ ghi thẳng giá sau giảm vào <b>GiaTien</b> và đặt % về 0.
      </div>
    </div>
    <div style="display:flex;gap:10px;align-items:center">
      <span class="badge badge-blue">GiaTour</span>
    </div>
  </div>

  <?php
    // Chuẩn hoá dữ liệu giá từ DB thành map theo LoaiKhach
    $giaMap = ['nguoi_lon' => null, 'tre_em' => null, 'em_be' => null];
    foreach (($giaTour ?? []) as $g) {
      if (!empty($g['LoaiKhach'])) $giaMap[$g['LoaiKhach']] = $g;
    }
    // helpers
    function gv($row, $key, $default=''){ return $row && isset($row[$key]) ? htmlspecialchars($row[$key]) : $default; }
    function optSel($val, $cur){ return $val === $cur ? 'selected' : ''; }
  ?>

  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>Loại khách</th>
          <th>Giá tiền</th>
          <th>% giảm</th>
          <th>Giá sau giảm</th>
          <th>Áp dụng từ</th>
          <th>Áp dụng đến</th>
          <th>Loại mùa</th>
          <th>Tên khuyến mãi</th>
        </tr>
      </thead>
      <tbody>
        <!-- Người lớn -->
        <?php $row = $giaMap['nguoi_lon']; $cur = $row['LoaiMua'] ?? 'binh_thuong'; ?>
        <tr data-row="0">
          <td>
            <strong>Người lớn</strong>
            <input type="hidden" name="gia[0][LoaiKhach]" value="nguoi_lon">
            <input type="hidden" name="gia[0][MaGia]" value="<?= gv($row,'MaGia') ?>">
          </td>
          <td>
            <input type="number" class="gia-base" name="gia[0][GiaTien]" min="0" step="0.01"
                   value="<?= gv($row,'GiaTien') ?>" style="width:100%;padding:8px;border:1px solid #ddd;border-radius:8px">
            <div class="small">
              ✔ <label style="cursor:pointer">
                <input type="checkbox" class="bake-discount" data-row="0" checked>
                Áp dụng giảm vào giá khi lưu
              </label>
            </div>
          </td>
          <td>
            <input type="number" class="gia-percent" name="gia[0][PhanTramGiamGia]" min="0" max="100" step="0.01"
                   value="<?= gv($row,'PhanTramGiamGia','0') ?>" style="width:100%;padding:8px;border:1px solid #ddd;border-radius:8px">
            <div class="small" id="km-status-0" style="margin-top:6px"></div>
          </td>
          <td>
            <input type="number" class="gia-final" data-row="0" readonly
                   style="width:100%;padding:8px;border:1px solid #ddd;border-radius:8px;background:#f9f9f9" value="">
          </td>
          <td><input type="date" class="gia-from" name="gia[0][ApDungTuNgay]"  value="<?= gv($row,'ApDungTuNgay')  ?>" style="width:100%;padding:8px;border:1px solid #ddd;border-radius:8px"></td>
          <td><input type="date" class="gia-to"   name="gia[0][ApDungDenNgay]" value="<?= gv($row,'ApDungDenNgay') ?>" style="width:100%;padding:8px;border:1px solid #ddd;border-radius:8px"></td>
          <td>
            <select name="gia[0][LoaiMua]" style="width:100%;padding:8px;border:1px solid #ddd;border-radius:8px">
              <option value="binh_thuong" <?= optSel('binh_thuong',$cur) ?>>Bình thường</option>
              <option value="cao_diem"    <?= optSel('cao_diem',$cur)    ?>>Cao điểm</option>
              <option value="thap_diem"   <?= optSel('thap_diem',$cur)   ?>>Thấp điểm</option>
            </select>
          </td>
          <td><input type="text" name="gia[0][TenKhuyenMai]" value="<?= gv($row,'TenKhuyenMai') ?>" style="width:100%;padding:8px;border:1px solid #ddd;border-radius:8px"></td>
        </tr>

        <!-- Trẻ em -->
        <?php $row = $giaMap['tre_em']; $cur = $row['LoaiMua'] ?? 'binh_thuong'; ?>
        <tr data-row="1">
          <td>
            <strong>Trẻ em</strong>
            <input type="hidden" name="gia[1][LoaiKhach]" value="tre_em">
            <input type="hidden" name="gia[1][MaGia]" value="<?= gv($row,'MaGia') ?>">
          </td>
          <td>
            <input type="number" class="gia-base" name="gia[1][GiaTien]" min="0" step="0.01"
                   value="<?= gv($row,'GiaTien') ?>" style="width:100%;padding:8px;border:1px solid #ddd;border-radius:8px">
            <div class="small">
              ✔ <label style="cursor:pointer">
                <input type="checkbox" class="bake-discount" data-row="1" checked>
                Áp dụng giảm vào giá khi lưu
              </label>
            </div>
          </td>
          <td>
            <input type="number" class="gia-percent" name="gia[1][PhanTramGiamGia]" min="0" max="100" step="0.01"
                   value="<?= gv($row,'PhanTramGiamGia','0') ?>" style="width:100%;padding:8px;border:1px solid #ddd;border-radius:8px">
            <div class="small" id="km-status-1" style="margin-top:6px"></div>
          </td>
          <td>
            <input type="number" class="gia-final" data-row="1" readonly
                   style="width:100%;padding:8px;border:1px solid #ddd;border-radius:8px;background:#f9f9f9" value="">
          </td>
          <td><input type="date" class="gia-from" name="gia[1][ApDungTuNgay]"  value="<?= gv($row,'ApDungTuNgay')  ?>" style="width:100%;padding:8px;border:1px solid #ddd;border-radius:8px"></td>
          <td><input type="date" class="gia-to"   name="gia[1][ApDungDenNgay]" value="<?= gv($row,'ApDungDenNgay') ?>" style="width:100%;padding:8px;border:1px solid #ddd;border-radius:8px"></td>
          <td>
            <select name="gia[1][LoaiMua]" style="width:100%;padding:8px;border:1px solid #ddd;border-radius:8px">
              <option value="binh_thuong" <?= optSel('binh_thuong',$cur) ?>>Bình thường</option>
              <option value="cao_diem"    <?= optSel('cao_diem',$cur)    ?>>Cao điểm</option>
              <option value="thap_diem"   <?= optSel('thap_diem',$cur)   ?>>Thấp điểm</option>
            </select>
          </td>
          <td><input type="text" name="gia[1][TenKhuyenMai]" value="<?= gv($row,'TenKhuyenMai') ?>" style="width:100%;padding:8px;border:1px solid #ddd;border-radius:8px"></td>
        </tr>

        <!-- Em bé -->
        <?php $row = $giaMap['em_be']; $cur = $row['LoaiMua'] ?? 'binh_thuong'; ?>
        <tr data-row="2">
          <td>
            <strong>Em bé</strong>
            <input type="hidden" name="gia[2][LoaiKhach]" value="em_be">
            <input type="hidden" name="gia[2][MaGia]" value="<?= gv($row,'MaGia') ?>">
          </td>
          <td>
            <input type="number" class="gia-base" name="gia[2][GiaTien]" min="0" step="0.01"
                   value="<?= gv($row,'GiaTien') ?>" style="width:100%;padding:8px;border:1px solid #ddd;border-radius:8px">
            <div class="small">
              ✔ <label style="cursor:pointer">
                <input type="checkbox" class="bake-discount" data-row="2" checked>
                Áp dụng giảm vào giá khi lưu
              </label>
            </div>
          </td>
          <td>
            <input type="number" class="gia-percent" name="gia[2][PhanTramGiamGia]" min="0" max="100" step="0.01"
                   value="<?= gv($row,'PhanTramGiamGia','0') ?>" style="width:100%;padding:8px;border:1px solid #ddd;border-radius:8px">
            <div class="small" id="km-status-2" style="margin-top:6px"></div>
          </td>
          <td>
            <input type="number" class="gia-final" data-row="2" readonly
                   style="width:100%;padding:8px;border:1px solid #ddd;border-radius:8px;background:#f9f9f9" value="">
          </td>
          <td><input type="date" class="gia-from" name="gia[2][ApDungTuNgay]"  value="<?= gv($row,'ApDungTuNgay')  ?>" style="width:100%;padding:8px;border:1px solid #ddd;border-radius:8px"></td>
          <td><input type="date" class="gia-to"   name="gia[2][ApDungDenNgay]" value="<?= gv($row,'ApDungDenNgay') ?>" style="width:100%;padding:8px;border:1px solid #ddd;border-radius:8px"></td>
          <td>
            <select name="gia[2][LoaiMua]" style="width:100%;padding:8px;border:1px solid #ddd;border-radius:8px">
              <option value="binh_thuong" <?= optSel('binh_thuong',$cur) ?>>Bình thường</option>
              <option value="cao_diem"    <?= optSel('cao_diem',$cur)    ?>>Cao điểm</option>
              <option value="thap_diem"   <?= optSel('thap_diem',$cur)   ?>>Thấp điểm</option>
            </select>
          </td>
          <td><input type="text" name="gia[2][TenKhuyenMai]" value="<?= gv($row,'TenKhuyenMai') ?>" style="width:100%;padding:8px;border:1px solid #ddd;border-radius:8px"></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>


            <button type="submit" class="btn btn-success">
              ✅ Cập nhật tour (kèm giá + dự toán)
            </button>
          </div>


          <script>
            window.__DUTOAN_OLD__ = <?= json_encode($duToan ?? [], JSON_UNESCAPED_UNICODE) ?>;
          </script>
        </div>
    </form>
  </div>

  <script>
    (function() {
      // Kiểm tra hiệu lực KM theo ngày
      function kmEffective(from, to, todayStr) {
        let notStarted = false,
          expired = false;
        if (from && todayStr < from) notStarted = true;
        if (to && todayStr > to) expired = true;
        return {
          notStarted,
          expired
        };
      }

      // Cập nhật 1 dòng: trạng thái + tính giá sau giảm
      function updateRow(i) {
        const base = document.querySelector(`tr[data-row="${i}"] .gia-base`);
        const pct = document.querySelector(`tr[data-row="${i}"] .gia-percent`);
        const fin = document.querySelector(`tr[data-row="${i}"] .gia-final`);
        const from = document.querySelector(`tr[data-row="${i}"] .gia-from`);
        const to = document.querySelector(`tr[data-row="${i}"] .gia-to`);
        const st = document.getElementById(`km-status-${i}`);
        if (!base || !pct || !fin || !from || !to || !st) return;

        const todayStr = new Date().toISOString().slice(0, 10);
        const tuVal = from.value || null;
        const denVal = to.value || null;
        const {
          notStarted,
          expired
        } = kmEffective(tuVal, denVal, todayStr);

        let p = parseFloat(pct.value || 0);
        let b = parseFloat(base.value || 0);
        if (isNaN(p)) p = 0;
        if (isNaN(b)) b = 0;

        const effectivePercent = (expired ? 0 : p);
        let final = b * (1 - Math.max(0, Math.min(100, effectivePercent)) / 100);
        final = Math.round(final * 100) / 100;
        fin.value = final || 0;

        if (expired) {
          st.textContent = '⚠️ Khuyến mãi đã hết hạn — sẽ không áp dụng giảm.';
          st.style.color = '#b71c1c';
          pct.disabled = true;
        } else if (notStarted) {
          st.textContent = 'ℹ️ Khuyến mãi chưa đến ngày áp dụng.';
          st.style.color = '#e65100';
          pct.disabled = false;
        } else if (p > 0) {
          st.textContent = '✅ Khuyến mãi đang hiệu lực.';
          st.style.color = '#2e7d32';
          pct.disabled = false;
        } else {
          st.textContent = '';
          pct.disabled = false;
        }
      }

      // bind events + khởi tạo cho 3 dòng
      [0, 1, 2].forEach(i => {
        ['input', 'change'].forEach(ev => {
          document.querySelectorAll(`tr[data-row="${i}"] .gia-base, tr[data-row="${i}"] .gia-percent, tr[data-row="${i}"] .gia-from, tr[data-row="${i}"] .gia-to`)
            .forEach(el => el.addEventListener(ev, () => updateRow(i)));
        });
        updateRow(i);
      });

      // Submit: nếu tick “Áp dụng giảm vào giá khi lưu” và chưa hết hạn => ghi giá sau giảm vào GiaTien, reset % về 0
      const form = document.querySelector('form[action*="editTourProcess"], form[action*="addTourProcess"]') || document.querySelector('form');
      if (form) {
        form.addEventListener('submit', function() {
          [0, 1, 2].forEach(i => {
            const bake = document.querySelector(`tr[data-row="${i}"] .bake-discount`);
            const fin = document.querySelector(`tr[data-row="${i}"] .gia-final`);
            const base = document.querySelector(`tr[data-row="${i}"] .gia-base`);
            const pct = document.querySelector(`tr[data-row="${i}"] .gia-percent`);
            const from = document.querySelector(`tr[data-row="${i}"] .gia-from`);
            const to = document.querySelector(`tr[data-row="${i}"] .gia-to`);
            if (!bake || !fin || !base || !pct) return;

            const todayStr = new Date().toISOString().slice(0, 10);
            const {
              expired
            } = kmEffective(from.value || null, to.value || null, todayStr);

            if (bake.checked && !expired) {
              base.value = fin.value || 0; // bake final vào GiaTien
              pct.value = 0; // reset %
            } else if (expired) {
              fin.value = base.value || 0; // hết hạn: không giảm
            }
          });
        });
      }

      // Banner cảnh báo chung nếu có dòng hết hạn
      (function showGlobalWarningIfAnyExpired() {
        const any = [0, 1, 2].some(i => {
          const el = document.getElementById(`km-status-${i}`);
          return el && el.textContent.includes('hết hạn');
        });
        if (any) {
          const alert = document.createElement('div');
          alert.className = 'alert alert-danger';
          alert.textContent = 'Một số dòng giá đã hết hạn khuyến mãi — khi tính tiền hệ thống sẽ không áp dụng giảm.';
          const container = document.querySelector('.container');
          if (container) container.insertBefore(alert, container.firstChild.nextSibling);
        }
      })();
    })();
  </script>


</body>

</html>