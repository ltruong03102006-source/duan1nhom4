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
    <h1 class="mt-4">Sửa Nhà Cung Cấp</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="?act=listNhaCungCap">Nhà Cung Cấp</a></li>
        <li class="breadcrumb-item active">Cập nhật</li>
    </ol>

    <?php if (!empty($_GET['error'])): ?>
        <div style="padding:12px 14px; border-radius:6px; margin-bottom:14px; border:1px solid #f5c2c7; background:#f8d7da; color:#842029;">
            <?php
                $err = $_GET['error'];
                if ($err === 'missing_type') {
                    echo 'Vui lòng chọn ít nhất 1 loại nhà cung cấp.';
                } elseif ($err === 'invalid_contract_date') {
                    echo 'Ngày kết thúc hợp đồng phải lớn hơn hoặc bằng ngày bắt đầu.';
                } elseif ($err === 'duplicate_macode') {
                    echo 'Mã Code NCC đã tồn tại. Vui lòng nhập mã khác.';
                } elseif ($err === 'upload_failed') {
                    echo 'Upload file hợp đồng thất bại. Vui lòng thử lại.';
                } else {
                    echo 'Có lỗi xảy ra. Vui lòng thử lại.';
                }
            ?>
        </div>
    <?php endif; ?>

    <div class="card">
        <form action="?act=updateNhaCungCapProcess" method="POST" enctype="multipart/form-data">
            
            <input type="hidden" name="MaNhaCungCap" value="<?= $ncc['MaNhaCungCap'] ?>">
            <input type="hidden" name="duongDanFileCu" value="<?= $ncc['FileHopDong'] ?>">

            <div class="form-row">
                <div class="form-group">
                    <label>Mã Code NCC (*):</label>
                    <input type="text" name="MaCodeNCC" value="<?= $ncc['MaCodeNCC'] ?>" required>
                </div>
                <div class="form-group">
                    <label>Tên Nhà Cung Cấp (*):</label>
                    <input type="text" name="TenNhaCungCap" value="<?= $ncc['TenNhaCungCap'] ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Loại NCC (*):</label>
                    <?php
// Tách chuỗi lưu trong DB thành mảng để kiểm tra checked
                        $loaiDaChon = explode(',', $ncc['LoaiNhaCungCap']); 
                    ?>
                    <div style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 5px;">
                        <label style="font-weight: normal;">
                            <input type="checkbox" name="LoaiNhaCungCap[]" value="khach_san" <?= in_array('khach_san', $loaiDaChon) ? 'checked' : '' ?>> Khách sạn
                        </label>
                        <label style="font-weight: normal;">
                            <input type="checkbox" name="LoaiNhaCungCap[]" value="nha_hang" <?= in_array('nha_hang', $loaiDaChon) ? 'checked' : '' ?>> Nhà hàng
                        </label>
                        <label style="font-weight: normal;">
                            <input type="checkbox" name="LoaiNhaCungCap[]" value="van_chuyen" <?= in_array('van_chuyen', $loaiDaChon) ? 'checked' : '' ?>> Vận chuyển
                        </label>
                        <label style="font-weight: normal;">
                            <input type="checkbox" name="LoaiNhaCungCap[]" value="visa" <?= in_array('visa', $loaiDaChon) ? 'checked' : '' ?>> Visa
                        </label>
                        <label style="font-weight: normal;">
                            <input type="checkbox" name="LoaiNhaCungCap[]" value="bao_hiem" <?= in_array('bao_hiem', $loaiDaChon) ? 'checked' : '' ?>> Bảo hiểm
                        </label>
                        <label style="font-weight: normal;">
                            <input type="checkbox" name="LoaiNhaCungCap[]" value="khac" <?= in_array('khac', $loaiDaChon) ? 'checked' : '' ?>> Khác
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Người Liên Hệ:</label>
                    <input type="text" name="NguoiLienHe" value="<?= $ncc['NguoiLienHe'] ?>">
                </div>
                <div class="form-group">
                    <label>Số Điện Thoại:</label>
                    <input type="tel" name="SoDienThoai" value="<?= $ncc['SoDienThoai'] ?>">
                </div>
                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" name="Email" value="<?= $ncc['Email'] ?>">
                </div>
            </div>
            
            <div class="form-group" style="padding: 0 10px;">
                <label>Địa Chỉ:</label>
                <input type="text" name="DiaChi" value="<?= $ncc['DiaChi'] ?>">
            </div>

            <div class="form-group" style="padding: 0 10px;">
                <label>Dịch Vụ Cung Cấp:</label>
                <textarea name="DichVuCungCap"><?= $ncc['DichVuCungCap'] ?></textarea>
            </div>
<div class="form-row">
                <div class="form-group">
                    <label>File Hợp Đồng (PDF, DOC, Ảnh...):</label>
                    <input type="file" name="FileHopDong">
                    <?php if (!empty($ncc['FileHopDong'])): ?>
                        <div style="margin-top: 5px; font-size: 0.9em;">
                            File hiện tại: <a href="<?= $ncc['FileHopDong'] ?>" target="_blank">Xem file</a>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label>Ngày Bắt Đầu Hợp Đồng:</label>
                    <input type="date" name="NgayBatDauHopDong" value="<?= $ncc['NgayBatDauHopDong'] ?>">
                </div>
                <div class="form-group">
                    <label>Ngày Kết Thúc Hợp Đồng:</label>
                    <input type="date" name="NgayKetThucHopDong" value="<?= $ncc['NgayKetThucHopDong'] ?>">
                </div>
            </div>

             <div class="form-row">
                <div class="form-group">
                    <label>Đánh Giá (0-5):</label>
                    <input type="number" name="DanhGia" step="0.1" min="0" max="5" value="<?= $ncc['DanhGia'] ?>">
                </div>
                <div class="form-group">
                    <label>Trạng Thái:</label>
                    <select name="TrangThai">
                        <option value="hoat_dong" <?= $ncc['TrangThai'] == 'hoat_dong' ? 'selected' : '' ?>>Hoạt động</option>
                        <option value="khong_hoat_dong" <?= $ncc['TrangThai'] == 'khong_hoat_dong' ? 'selected' : '' ?>>Không hoạt động</option>
                    </select>
                </div>
            </div>

            <div class="form-group" style="padding: 0 10px;">
                <label>Ghi Chú:</label>
                <textarea name="GhiChu"><?= $ncc['GhiChu'] ?></textarea>
            </div>

            <button type="submit">Cập nhật Nhà Cung Cấp</button>
            <a href="?act=listNhaCungCap"><button type="button" class="btn-back">Quay lại</button></a>
        </form>
    </div>
</div>
