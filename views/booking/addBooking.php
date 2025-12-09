<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Thêm Booking</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background-color: #f4f6f8; margin: 0; padding: 0; }
        .container {
            max-width: 900px; margin: 40px auto; background: white; padding: 30px;
            border-radius: 12px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h2 { text-align: center; color: #2c3e50; margin-bottom: 20px; }
        form { display: flex; flex-direction: column; gap: 15px; }
        .form-group { display: flex; flex-direction: column; }
        label { font-weight: 600; margin-bottom: 5px; color: #34495e; }
        input, select, textarea {
            padding: 10px; border: 1px solid #dcdde1; border-radius: 6px; font-size: 15px;
        }
        textarea { resize: vertical; min-height: 60px; }
        .form-row { display: flex; gap: 15px; }
        .form-row .form-group { flex: 1; }
        .btn-submit {
            background-color: #1e88e5; color: white; font-weight: 600; padding: 12px;
            border: none; border-radius: 6px; cursor: pointer; transition: 0.3s;
        }
        .btn-submit:hover { background-color: #1565c0; }
        .btn-back {
            display: inline-block; margin-bottom: 15px; padding: 8px 14px;
            background: #6c757d; color: #fff; border-radius: 6px;
            text-decoration: none; font-size: 14px;
        }
        .btn-back:hover { background: #5a6268; }

        .note {
            background: #e3f2fd; border: 1px solid #bbdefb; color: #0d47a1;
            padding: 10px 12px; border-radius: 8px; font-size: 13px;
        }
        .price-preview {
            display: flex; gap: 10px; flex-wrap: wrap; margin-top: 6px; font-size: 13px;
            color: #444;
        }
        .pill {
            padding: 6px 10px; border-radius: 999px; background: #f1f3f5; border: 1px solid #e5e7eb;
        }
        .money { font-weight: 700; color: #e53935; }
    </style>
</head>

<body>

    <div class="container">
        <a href="?act=listBooking" class="btn-back">⬅ Quay lại danh sách booking</a>

        <h2>Thêm Booking</h2>

        <div class="note">
            💡 Tổng tiền sẽ tự tính theo <b>giá Tour</b> (Người lớn/Trẻ em/Em bé) và số lượng bạn chọn.
        </div>

        <form action="?act=addBookingProcess" method="POST">

            <div class="form-group">
                <label>Mã Booking *</label>
                <input type="text" name="MaCodeBooking" required placeholder="VD: BK2025_001">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Tour *</label>
                    <select name="MaTour" id="MaTour" required>
                        <option value="">-- Chọn tour --</option>
                        <?php foreach ($listTour as $t):
                            $g = $giaMap[$t['MaTour']] ?? ['nl'=>0,'te'=>0,'eb'=>0];
                        ?>
                            <option
                                value="<?= $t['MaTour'] ?>"
                                data-nl="<?= (float)$g['nl'] ?>"
                                data-te="<?= (float)$g['te'] ?>"
                                data-eb="<?= (float)$g['eb'] ?>"
                            >
                                <?= htmlspecialchars($t['TenTour']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <div class="price-preview" id="giaPreview" style="display:none;">
                        <span class="pill">👤 NL: <span class="money" id="giaNL">0</span>đ</span>
                        <span class="pill">🧒 TE: <span class="money" id="giaTE">0</span>đ</span>
                        <span class="pill">👶 EB: <span class="money" id="giaEB">0</span>đ</span>
                    </div>
                </div>

                <div class="form-group">
                    <label>Đoàn khởi hành</label>
                    <select name="MaDoan" id="MaDoan">
                        <option value="">-- Chọn đoàn --</option>
                        <?php foreach ($listDoan as $d): ?>
                            <option value="<?= $d['MaDoan'] ?>">
                                [#<?= $d['MaDoan'] ?>] <?= htmlspecialchars($d['TenTour']) ?> -
                                <?= date('d/m/Y', strtotime($d['NgayKhoiHanh'])) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Khách hàng (người đại diện) *</label>
                <select name="MaKhachHang" required>
                    <option value="">-- Chọn khách hàng --</option>
                    <?php foreach ($listKhachHang as $kh): ?>
                        <option value="<?= $kh['MaKhachHang'] ?>">
                            [<?= htmlspecialchars($kh['MaCodeKhachHang']) ?>] <?= htmlspecialchars($kh['HoTen']) ?> - <?= htmlspecialchars($kh['SoDienThoai']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Loại booking</label>
                    <select name="LoaiBooking">
                        <option value="ca_nhan">Cá nhân</option>
                        <option value="nhom">Nhóm</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Số người lớn</label>
                    <input type="number" name="TongNguoiLon" id="TongNguoiLon" min="0" value="1">
                </div>

                <div class="form-group">
                    <label>Số trẻ em</label>
                    <input type="number" name="TongTreEm" id="TongTreEm" min="0" value="0">
                </div>

                <div class="form-group">
                    <label>Số em bé</label>
                    <input type="number" name="TongEmBe" id="TongEmBe" min="0" value="0">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Tổng tiền (VNĐ)</label>
                    <input type="number" id="TongTien" name="TongTien" min="0" step="1000" readonly>
                </div>
            </div>

            <div class="form-group">
                <label>Yêu cầu đặc biệt</label>
                <textarea name="YeuCauDacBiet" placeholder="Ghi chú thêm cho booking..."></textarea>
            </div>

            <button type="submit" class="btn-submit">Tạo Booking</button>
        </form>
    </div>

    <script>
        const tourEl = document.getElementById('MaTour');
        const nlEl = document.getElementById('TongNguoiLon');
        const teEl = document.getElementById('TongTreEm');
        const ebEl = document.getElementById('TongEmBe');
        const tongTienEl = document.getElementById('TongTien');

        const giaPreview = document.getElementById('giaPreview');
        const giaNL = document.getElementById('giaNL');
        const giaTE = document.getElementById('giaTE');
        const giaEB = document.getElementById('giaEB');

        function toInt(v){
            const n = parseInt(v, 10);
            return isNaN(n) ? 0 : n;
        }
        function toMoney(v){
            const n = parseFloat(v);
            return isNaN(n) ? 0 : n;
        }
        function formatVN(n){
            try { return Number(n||0).toLocaleString('vi-VN'); }
            catch(e){ return n; }
        }

        function updateGiaPreview(){
            const opt = tourEl.options[tourEl.selectedIndex];
            if (!opt || !opt.value){
                giaPreview.style.display = 'none';
                giaNL.innerText = '0';
                giaTE.innerText = '0';
                giaEB.innerText = '0';
                return { nl:0, te:0, eb:0 };
            }
            const nl = toMoney(opt.dataset.nl);
            const te = toMoney(opt.dataset.te);
            const eb = toMoney(opt.dataset.eb);

            giaPreview.style.display = 'flex';
            giaNL.innerText = formatVN(nl);
            giaTE.innerText = formatVN(te);
            giaEB.innerText = formatVN(eb);

            return { nl, te, eb };
        }

        function calcTongTien(){
            const prices = updateGiaPreview();

            const soNL = toInt(nlEl.value);
            const soTE = toInt(teEl.value);
            const soEB = toInt(ebEl.value);

            const tong = (soNL * prices.nl) + (soTE * prices.te) + (soEB * prices.eb);

            // Làm tròn theo step 1000 cho đẹp (nếu không thích thì bỏ dòng này)
            tongTienEl.value = Math.round(tong / 1000) * 1000;
        }

        tourEl.addEventListener('change', calcTongTien);
        nlEl.addEventListener('input', calcTongTien);
        teEl.addEventListener('input', calcTongTien);
        ebEl.addEventListener('input', calcTongTien);

        calcTongTien();
    </script>

</body>
</html>
