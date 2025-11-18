<style>
    /* Style cho form */
    .card { background:#fff; padding:25px; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.1); }
    .form-row { display: flex; flex-wrap: wrap; margin: 0 -10px; }
    .form-group { flex: 1; min-width: 300px; padding: 0 10px; margin-bottom: 15px; }
    label { font-weight:bold; margin-bottom:5px; display:block; }
    input, select, textarea { width:100%; padding:10px; border-radius:5px; border:1px solid #ccc; box-sizing: border-box; }
    textarea { min-height: 80px; }
    button { background:#1e88e5; color:#fff; border:none; padding:10px 20px; border-radius:5px; cursor:pointer; }
    button:hover { background:#1565c0; }
    .btn-back { background:#777; margin-left: 10px; }
    .btn-back:hover { background:#555; }
</style>

<div class="container-fluid px-4">
    <h1 class="mt-4">Thêm Nhà Cung Cấp</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="?act=listNhaCungCap">Nhà Cung Cấp</a></li>
        <li class="breadcrumb-item active">Thêm mới</li>
    </ol>

    <div class="card">
        <form action="?act=addNhaCungCapProcess" method="POST" enctype="multipart/form-data">

            <div class="form-row">
                <div class="form-group">
                    <label>Mã Code NCC (*):</label>
                    <input type="text" name="MaCodeNCC" required>
                </div>
                <div class="form-group">
                    <label>Tên Nhà Cung Cấp (*):</label>
                    <input type="text" name="TenNhaCungCap" required>
                </div>
                <div class="form-group">
    <label>Loại NCC (*):</label>
    <div style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 5px;">
        <label style="font-weight: normal;"><input type="checkbox" name="LoaiNhaCungCap[]" value="khach_san"> Khách sạn</label>
        <label style="font-weight: normal;"><input type="checkbox" name="LoaiNhaCungCap[]" value="nha_hang"> Nhà hàng</label>
        <label style="font-weight: normal;"><input type="checkbox" name="LoaiNhaCungCap[]" value="van_chuyen"> Vận chuyển</label>
        <label style="font-weight: normal;"><input type="checkbox" name="LoaiNhaCungCap[]" value="visa"> Visa</label>
        <label style="font-weight: normal;"><input type="checkbox" name="LoaiNhaCungCap[]" value="bao_hiem"> Bảo hiểm</label>
        <label style="font-weight: normal;"><input type="checkbox" name="LoaiNhaCungCap[]" value="khac"> Khác</label>
    </div>
</div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Người Liên Hệ:</label>
                    <input type="text" name="NguoiLienHe">
                </div>
                <div class="form-group">
                    <label>Số Điện Thoại:</label>
                    <input type="tel" name="SoDienThoai">
                </div>
                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" name="Email">
                </div>
            </div>
            
            <div class="form-group" style="padding: 0 10px;">
                <label>Địa Chỉ:</label>
                <input type="text" name="DiaChi">
            </div>

            <div class="form-group" style="padding: 0 10px;">
                <label>Dịch Vụ Cung Cấp:</label>
                <textarea name="DichVuCungCap"></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>File Hợp Đồng (PDF, DOC, Ảnh...):</label>
                    <input type="file" name="FileHopDong">
                </div>
                <div class="form-group">
                    <label>Ngày Bắt Đầu Hợp Đồng:</label>
                    <input type="date" name="NgayBatDauHopDong">
                </div>
                <div class="form-group">
                    <label>Ngày Kết Thúc Hợp Đồng:</label>
                    <input type="date" name="NgayKetThucHopDong">
                </div>
            </div>

             <div class="form-row">
                <div class="form-group">
                    <label>Đánh Giá (0-5):</label>
                    <input type="number" name="DanhGia" step="0.1" min="0" max="5">
                </div>
                <div class="form-group">
                    <label>Trạng Thái:</label>
                    <select name="TrangThai">
                        <option value="hoat_dong">Hoạt động</option>
                        <option value="khong_hoat_dong">Không hoạt động</option>
                    </select>
                </div>
            </div>

            <div class="form-group" style="padding: 0 10px;">
                <label>Ghi Chú:</label>
                <textarea name="GhiChu"></textarea>
            </div>

            <button type="submit">Thêm Nhà Cung Cấp</button>
            <a href="?act=listNhaCungCap"><button type="button" class="btn-back">Quay lại</button></a>
        </form>
    </div>
</div>