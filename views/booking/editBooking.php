<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sửa Booking</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    *{box-sizing:border-box;font-family:'Inter',sans-serif}
    body{margin:0;background:linear-gradient(180deg,#f6f9ff 0%, #f4f6f8 55%, #f7f7fb 100%);color:#111827}

    .header{
      background:linear-gradient(90deg,#0d47a1,#1e88e5);
      padding:16px 20px;color:#fff;font-size:20px;font-weight:800;
      display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap
    }

    .container{
      width:95%;max-width:1000px;margin:22px auto;background:#fff;
      padding:22px;border-radius:14px;border:1px solid #eef2f7;
      box-shadow:0 10px 30px rgba(17,24,39,.06)
    }

    .top-actions{display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;margin-bottom:12px}
    .title{margin:0;font-size:22px;font-weight:900;color:#0d47a1}

    .btn{
      padding:10px 14px;border:none;border-radius:12px;cursor:pointer;font-weight:900;font-size:14px;
      display:inline-flex;align-items:center;gap:8px;text-decoration:none;transition:.15s transform,.15s filter
    }
    .btn:active{transform:translateY(1px)}
    .btn-secondary{background:#607d8b;color:#fff}
    .btn-secondary:hover{filter:brightness(.95)}
    .btn-warning{background:#ff9800;color:#fff}
    .btn-warning:hover{filter:brightness(.95)}

    form{display:flex;flex-direction:column;gap:14px;margin-top:12px}

    .grid{display:grid;grid-template-columns:repeat(2,1fr);gap:12px}
    .grid-3{display:grid;grid-template-columns:repeat(3,1fr);gap:12px}
    @media (max-width: 900px){
      .grid,.grid-3{grid-template-columns:1fr}
    }

    .field label{display:block;font-weight:800;margin-bottom:6px;color:#374151;font-size:13px}
    .field input,.field select,.field textarea{
      width:100%;padding:10px 12px;border:1px solid #dcdde1;border-radius:10px;font-size:14px;outline:none;
      transition:.15s border-color,.15s box-shadow;background:#fff
    }
    .field input:focus,.field select:focus,.field textarea:focus{
      border-color:#1e88e5;box-shadow:0 0 0 3px rgba(30,136,229,.15)
    }
    textarea{resize:vertical;min-height:84px}

    .readonly{
      background:#f3f4f6 !important;color:#6b7280;border-color:#e5e7eb !important
    }

    .card{
      border:1px solid #eef2f7;border-radius:14px;padding:14px;background:#fafbff
    }
    .card h3{margin:0 0 10px;font-size:14px;color:#0d47a1;font-weight:900}

    .money{font-weight:900;color:#e53935}
    .hint{font-size:12px;color:#6b7280;margin-top:6px}
    .row{display:flex;gap:12px;flex-wrap:wrap;align-items:center;justify-content:space-between;margin-top:8px}
  </style>
</head>

<body>
  <div class="header">
    <div>✏️ Sửa Booking</div>
    <a href="?act=listBooking" class="btn btn-secondary">⬅ Quay lại danh sách</a>
  </div>

  <div class="container">
    <div class="top-actions">
      <h2 class="title">Cập nhật thông tin booking</h2>
      <button form="editBookingForm" type="submit" class="btn btn-warning">✅ Lưu thay đổi</button>
    </div>

    <form id="editBookingForm" action="?act=editBookingProcess" method="POST">
      <input type="hidden" name="MaBooking" value="<?= (int)$booking['MaBooking'] ?>">

      <!-- A) Thông tin cơ bản -->
      <div class="card">
        <h3>A) Thông tin cơ bản</h3>

        <div class="grid">
          <div class="field">
            <label>Mã Booking</label>
            <input class="readonly" type="text" value="<?= htmlspecialchars($booking['MaCodeBooking']) ?>" disabled>
            <div class="hint">Mã booking không chỉnh sửa.</div>
          </div>

          <div class="field">
            <label>Trạng thái</label>
            <select name="TrangThai">
              <option value="cho_coc" <?= ($booking['TrangThai'] ?? '')=='cho_coc'?'selected':'' ?>>Chờ cọc</option>
              <option value="da_coc" <?= ($booking['TrangThai'] ?? '')=='da_coc'?'selected':'' ?>>Đã cọc</option>
              <option value="hoan_tat" <?= ($booking['TrangThai'] ?? '')=='hoan_tat'?'selected':'' ?>>Hoàn tất</option>
              <option value="da_huy" <?= ($booking['TrangThai'] ?? '')=='da_huy'?'selected':'' ?>>Đã hủy</option>
            </select>
          </div>
        </div>
      </div>

      <!-- B) Chọn tour / đoàn / khách -->
      <div class="card">
        <h3>B) Tour / Đoàn / Khách đại diện</h3>

        <div class="grid">
          <div class="field">
            <label>Tour *</label>
            <select id="MaTour" name="MaTour" required>
              <?php foreach ($listTour as $t): ?>
                <option
                  value="<?= (int)$t['MaTour'] ?>"
                  data-price-nl="<?= (float)($t['GiaNguoiLon'] ?? 0) ?>"
                  data-price-te="<?= (float)($t['GiaTreEm'] ?? 0) ?>"
                  data-price-eb="<?= (float)($t['GiaEmBe'] ?? 0) ?>"
                  <?= ((int)$t['MaTour'] === (int)$booking['MaTour']) ? 'selected' : '' ?>
                >
                  <?= htmlspecialchars($t['TenTour']) ?>
                </option>
              <?php endforeach; ?>
            </select>
            <div class="hint">
              Giá sẽ tự lấy theo tour: NL/TE/EB (giá mới nhất).
            </div>
          </div>

          <div class="field">
            <label>Đoàn khởi hành</label>
            <select name="MaDoan" id="MaDoan">
              <option value="">-- Chọn đoàn --</option>
              <?php foreach ($listDoan as $d): ?>
                <option value="<?= (int)$d['MaDoan'] ?>"
                  <?= ((int)($booking['MaDoan'] ?? 0) === (int)$d['MaDoan']) ? 'selected' : '' ?>
                >
                  [#<?= (int)$d['MaDoan'] ?>] <?= htmlspecialchars($d['TenTour']) ?> -
                  <?= date('d/m/Y', strtotime($d['NgayKhoiHanh'])) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="field">
            <label>Khách hàng (đại diện) *</label>
            <select name="MaKhachHang" required>
              <?php foreach ($listKhachHang as $kh): ?>
                <option value="<?= (int)$kh['MaKhachHang'] ?>"
                  <?= ((int)$kh['MaKhachHang'] === (int)$booking['MaKhachHang']) ? 'selected' : '' ?>
                >
                  [<?= htmlspecialchars($kh['MaCodeKhachHang']) ?>] <?= htmlspecialchars($kh['HoTen']) ?> - <?= htmlspecialchars($kh['SoDienThoai']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
      </div>

      <!-- C) Số lượng + tính tiền -->
      <div class="card">
        <h3>C) Số lượng & Tổng tiền (tự tính)</h3>

        <div class="grid-3">
          <div class="field">
            <label>Loại booking</label>
            <select name="LoaiBooking" id="LoaiBooking">
              <option value="ca_nhan" <?= ($booking['LoaiBooking'] ?? '')=='ca_nhan'?'selected':'' ?>>Cá nhân</option>
              <option value="nhom" <?= ($booking['LoaiBooking'] ?? '')=='nhom'?'selected':'' ?>>Nhóm</option>
            </select>
          </div>

          <div class="field">
            <label>Số người lớn</label>
            <input id="TongNguoiLon" type="number" name="TongNguoiLon" min="0" value="<?= (int)($booking['TongNguoiLon'] ?? 0) ?>">
          </div>

          <div class="field">
            <label>Số trẻ em</label>
            <input id="TongTreEm" type="number" name="TongTreEm" min="0" value="<?= (int)($booking['TongTreEm'] ?? 0) ?>">
          </div>

          <div class="field">
            <label>Số em bé</label>
            <input id="TongEmBe" type="number" name="TongEmBe" min="0" value="<?= (int)($booking['TongEmBe'] ?? 0) ?>">
          </div>

          <div class="field">
            <label>Tổng tiền (VNĐ)</label>
            <input id="TongTien" type="number" name="TongTien" min="0" step="1000"
                   value="<?= (float)($booking['TongTien'] ?? 0) ?>" readonly class="readonly">
            <div class="hint">
              Tự tính = NL×GiáNL + TE×GiáTE + EB×GiáEB
            </div>
          </div>

          <div class="field">
            <label>Giá đang áp dụng</label>
            <div class="card" style="margin:0;background:#fff;border:1px dashed #dbeafe">
              <div style="display:flex;gap:10px;flex-wrap:wrap">
                <div>👤 NL: <span class="money" id="pNL">0</span>đ</div>
                <div>🧒 TE: <span class="money" id="pTE">0</span>đ</div>
                <div>👶 EB: <span class="money" id="pEB">0</span>đ</div>
              </div>
              <div class="hint" style="margin-top:6px">Đổi tour sẽ đổi giá tương ứng.</div>
            </div>
          </div>
        </div>
      </div>

      <!-- D) Ghi chú -->
      <div class="card">
        <h3>D) Yêu cầu đặc biệt</h3>
        <div class="field">
          <textarea name="YeuCauDacBiet" placeholder="Ghi chú thêm..."><?= htmlspecialchars($booking['YeuCauDacBiet'] ?? '') ?></textarea>
        </div>
      </div>

      <div class="row">
        <a href="?act=listBooking" class="btn btn-secondary">⬅ Quay lại</a>
        <button type="submit" class="btn btn-warning">✅ Lưu thay đổi</button>
      </div>
    </form>
  </div>

<script>
  const selTour = document.getElementById('MaTour');
  const nlEl = document.getElementById('TongNguoiLon');
  const teEl = document.getElementById('TongTreEm');
  const ebEl = document.getElementById('TongEmBe');
  const tongTienEl = document.getElementById('TongTien');

  const pNL = document.getElementById('pNL');
  const pTE = document.getElementById('pTE');
  const pEB = document.getElementById('pEB');

  function toNum(v){
    const n = Number(v);
    return isNaN(n) ? 0 : n;
  }
  function fmt(n){
    try { return Number(n||0).toLocaleString('vi-VN'); } catch(e){ return n; }
  }

  function getPrices(){
    const opt = selTour.options[selTour.selectedIndex];
    return {
      nl: toNum(opt.dataset.priceNl),
      te: toNum(opt.dataset.priceTe),
      eb: toNum(opt.dataset.priceEb),
    };
  }

  function renderPrices(){
    const pr = getPrices();
    pNL.textContent = fmt(pr.nl);
    pTE.textContent = fmt(pr.te);
    pEB.textContent = fmt(pr.eb);
  }

  function calcTongTien(){
    const pr = getPrices();
    const nl = toNum(nlEl.value);
    const te = toNum(teEl.value);
    const eb = toNum(ebEl.value);

    let total = nl * pr.nl + te * pr.te + eb * pr.eb;
    if (total < 0) total = 0;

    // step 1000 => làm tròn cho đẹp (tuỳ bạn, có thể bỏ)
    total = Math.round(total / 1000) * 1000;

    tongTienEl.value = total;
  }

  function refresh(){
    renderPrices();
    calcTongTien();
  }

  selTour.addEventListener('change', refresh);
  nlEl.addEventListener('input', calcTongTien);
  teEl.addEventListener('input', calcTongTien);
  ebEl.addEventListener('input', calcTongTien);

  // init
  refresh();
</script>

</body>
</html>
