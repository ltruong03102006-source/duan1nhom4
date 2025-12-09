<div class="container-fluid px-4" style="max-width:1200px;margin:0 auto;">
    <h1 class="mt-4">➕ Thêm Tour (kèm Lịch trình + Giá + Dự toán)</h1>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger">❌ Lỗi khi thêm dữ liệu. Kiểm tra lại.</div>
    <?php endif; ?>

    <form action="?act=addTourFullProcess" method="POST" id="tourFullForm" style="background:#fff;padding:16px;border-radius:10px;">
        <h3>1) Thông tin Tour</h3>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
            <div>
                <label>Mã Code Tour *</label>
                <input class="form-control" name="MaCodeTour" required>
            </div>
            <div>
                <label>Tên Tour *</label>
                <input class="form-control" name="TenTour" required>
            </div>

            <div>
                <label>Danh mục *</label>
                <select name="MaDanhMuc" required class="form-control">
                    <option value="">-- Chọn danh mục --</option>
                    <?php foreach ($listDanhMuc as $dm): ?>
                        <option value="<?= (int)$dm['MaDanhMuc'] ?>">
                            <?= htmlspecialchars($dm['TenDanhMuc']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                <div>
                    <label>Số ngày *</label>
                    <input class="form-control" type="number" name="SoNgay" min="1" value="1" required>
                </div>
                <div>
                    <label>Số đêm *</label>
                    <input class="form-control" type="number" name="SoDem" min="0" value="0" required>
                </div>
            </div>

            <div>
                <label>Điểm khởi hành *</label>
                <input class="form-control" name="DiemKhoiHanh" required>
            </div>

            <div>
                <label>Link ảnh bìa</label>
                <input class="form-control" name="LinkAnhBia" placeholder="https://...">
            </div>

            <div>
                <label>Giá vốn dự kiến</label>
                <input class="form-control" type="number" name="GiaVonDuKien" min="0" step="1000">
            </div>
            <div>
                <label>Giá bán mặc định</label>
                <input class="form-control" type="number" name="GiaBanMacDinh" min="0" step="1000">
            </div>

            <div>
                <label>Trạng thái</label>
                <select class="form-select" name="TrangThai">
                    <option value="hoat_dong" selected>Hoạt động</option>
                    <option value="khong_hoat_dong">Không hoạt động</option>
                </select>
            </div>

            <div style="grid-column:1/-1;">
                <label>Mô tả</label>
                <textarea class="form-control" name="MoTa" rows="3"></textarea>
            </div>
        </div>

        <hr>

        <h3 style="display:flex;justify-content:space-between;align-items:center;">
            <span>2) Lịch trình</span>
            <button type="button" class="btn btn-primary btn-sm" onclick="addLichTrinhRow()">+ Thêm ngày</button>
        </h3>

        <div style="overflow-x:auto;">
            <table class="table table-bordered" id="tblLichTrinh">
                <thead>
                    <tr>
                        <th style="width:80px;">Ngày</th>
                        <th style="min-width:220px;">Tiêu đề *</th>
                        <th>Địa điểm</th>
                        <th>Nơi ở</th>
                        <th style="width:170px;">Bữa</th>
                        <th style="min-width:250px;">Chi tiết</th>
                        <th style="width:60px;">Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input class="form-control" type="number" name="lichtrinh[0][NgayThu]" min="1" value="1"></td>
                        <td><input class="form-control" name="lichtrinh[0][TieuDeNgay]" required></td>
                        <td><input class="form-control" name="lichtrinh[0][DiaDiemThamQuan]"></td>
                        <td><input class="form-control" name="lichtrinh[0][NoiO]"></td>
                        <td>
                            <label style="display:block;"><input type="checkbox" name="lichtrinh[0][CoBuaSang]" value="1"> Sáng</label>
                            <label style="display:block;"><input type="checkbox" name="lichtrinh[0][CoBuaTrua]" value="1"> Trưa</label>
                            <label style="display:block;"><input type="checkbox" name="lichtrinh[0][CoBuaToi]" value="1"> Tối</label>
                        </td>
                        <td><textarea class="form-control" name="lichtrinh[0][ChiTietHoatDong]" rows="2"></textarea></td>
                        <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <hr>

        <h3 style="display:flex;justify-content:space-between;align-items:center;">
            <span>3) Giá tour</span>
            <button type="button" class="btn btn-primary btn-sm" onclick="addGiaRow()">+ Thêm giá</button>
        </h3>

        <div style="overflow-x:auto;">
            <table class="table table-bordered" id="tblGia">
                <thead>
                    <tr>
                        <th style="width:140px;">Loại khách *</th>
                        <th style="width:160px;">Giá tiền *</th>
                        <th style="width:140px;">Từ ngày</th>
                        <th style="width:140px;">Đến ngày</th>
                        <th style="width:140px;">Mùa</th>
                        <th>Tên KM</th>
                        <th style="width:120px;">% giảm</th>
                        <th style="width:60px;">Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <select class="form-select" name="gia[0][LoaiKhach]" required>
                                <option value="nguoi_lon">Người lớn</option>
                                <option value="tre_em">Trẻ em</option>
                                <option value="em_be">Em bé</option>
                            </select>
                        </td>
                        <td><input class="form-control" type="number" name="gia[0][GiaTien]" min="0" step="1000" required></td>
                        <td><input class="form-control" type="date" name="gia[0][ApDungTuNgay]"></td>
                        <td><input class="form-control" type="date" name="gia[0][ApDungDenNgay]"></td>
                        <td>
                            <select class="form-select" name="gia[0][LoaiMua]">
                                <option value="binh_thuong" selected>Bình thường</option>
                                <option value="cao_diem">Cao điểm</option>
                                <option value="thap_diem">Thấp điểm</option>
                            </select>
                        </td>
                        <td><input class="form-control" name="gia[0][TenKhuyenMai]"></td>
                        <td><input class="form-control" type="number" name="gia[0][PhanTramGiamGia]" min="0" max="100" step="0.01" value="0"></td>
                        <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <hr>

        <h3 style="display:flex;justify-content:space-between;align-items:center;">
            <span>4) Dự toán chi phí</span>
            <button type="button" class="btn btn-primary btn-sm" onclick="addDuToanRow()">+ Thêm hạng mục</button>
        </h3>

        <div style="overflow-x:auto;">
            <table class="table table-bordered" id="tblDuToan">
                <thead>
                    <tr>
                        <th>Hạng mục *</th>
                        <th style="width:200px;">Số tiền/khách *</th>
                        <th>Ghi chú</th>
                        <th style="width:60px;">Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input class="form-control" name="dutoan[0][HangMucChi]" required></td>
                        <td><input class="form-control" type="number" name="dutoan[0][SoTienDuKien]" min="0" step="1000" required></td>
                        <td><input class="form-control" name="dutoan[0][GhiChu]"></td>
                        <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div style="margin-top:18px;display:flex;gap:10px;">
            <button type="submit" class="btn btn-success">✅ Lưu tất cả</button>
            <a href="?act=tour" class="btn btn-secondary">↩ Quay lại</a>
        </div>
    </form>
</div>

<script>
    let lichIndex = 1,
        giaIndex = 1,
        duIndex = 1;

    function removeRow(btn) {
        btn.closest('tr').remove();
    }

    function addLichTrinhRow() {
        const tbody = document.querySelector('#tblLichTrinh tbody');
        const i = lichIndex++;
        const tr = document.createElement('tr');
        tr.innerHTML = `
    <td><input class="form-control" type="number" name="lichtrinh[${i}][NgayThu]" min="1" value="${i+1}"></td>
    <td><input class="form-control" name="lichtrinh[${i}][TieuDeNgay]" required></td>
    <td><input class="form-control" name="lichtrinh[${i}][DiaDiemThamQuan]"></td>
    <td><input class="form-control" name="lichtrinh[${i}][NoiO]"></td>
    <td>
      <label style="display:block;"><input type="checkbox" name="lichtrinh[${i}][CoBuaSang]" value="1"> Sáng</label>
      <label style="display:block;"><input type="checkbox" name="lichtrinh[${i}][CoBuaTrua]" value="1"> Trưa</label>
      <label style="display:block;"><input type="checkbox" name="lichtrinh[${i}][CoBuaToi]" value="1"> Tối</label>
    </td>
    <td><textarea class="form-control" name="lichtrinh[${i}][ChiTietHoatDong]" rows="2"></textarea></td>
    <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button></td>
  `;
        tbody.appendChild(tr);
    }

    function addGiaRow() {
        const tbody = document.querySelector('#tblGia tbody');
        const i = giaIndex++;
        const tr = document.createElement('tr');
        tr.innerHTML = `
    <td>
      <select class="form-select" name="gia[${i}][LoaiKhach]" required>
        <option value="nguoi_lon">Người lớn</option>
        <option value="tre_em">Trẻ em</option>
        <option value="em_be">Em bé</option>
      </select>
    </td>
    <td><input class="form-control" type="number" name="gia[${i}][GiaTien]" min="0" step="1000" required></td>
    <td><input class="form-control" type="date" name="gia[${i}][ApDungTuNgay]"></td>
    <td><input class="form-control" type="date" name="gia[${i}][ApDungDenNgay]"></td>
    <td>
      <select class="form-select" name="gia[${i}][LoaiMua]">
        <option value="binh_thuong" selected>Bình thường</option>
        <option value="cao_diem">Cao điểm</option>
        <option value="thap_diem">Thấp điểm</option>
      </select>
    </td>
    <td><input class="form-control" name="gia[${i}][TenKhuyenMai]"></td>
    <td><input class="form-control" type="number" name="gia[${i}][PhanTramGiamGia]" min="0" max="100" step="0.01" value="0"></td>
    <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button></td>
  `;
        tbody.appendChild(tr);
    }

    function addDuToanRow() {
        const tbody = document.querySelector('#tblDuToan tbody');
        const i = duIndex++;
        const tr = document.createElement('tr');
        tr.innerHTML = `
    <td><input class="form-control" name="dutoan[${i}][HangMucChi]" required></td>
    <td><input class="form-control" type="number" name="dutoan[${i}][SoTienDuKien]" min="0" step="1000" required></td>
    <td><input class="form-control" name="dutoan[${i}][GhiChu]"></td>
    <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button></td>
  `;
        tbody.appendChild(tr);
    }
</script>