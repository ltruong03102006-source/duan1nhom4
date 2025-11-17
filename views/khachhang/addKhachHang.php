
<div class="container-fluid px-4">
    <h1 class="mt-4">Thêm Khách Hàng Mới</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="?act=/">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="?act=listKhachHang">Danh sách Khách hàng</a></li>
        <li class="breadcrumb-item active">Thêm mới</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-user-plus me-1"></i>
            Thông tin Khách hàng
        </div>
        <div class="card-body">
            <form action="?act=addKhachHangProcess" method="POST">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Mã Code Khách Hàng *</label>
                        <input type="text" name="MaCodeKhachHang" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Họ Tên *</label>
                        <input type="text" name="HoTen" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Số Điện Thoại</label>
                        <input type="text" name="SoDienThoai" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="Email" class="form-control">
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Ngày Sinh</label>
                        <input type="date" name="NgaySinh" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Giới Tính</label>
                        <select name="GioiTinh" class="form-select">
                            <option value="nam">Nam</option>
                            <option value="nu">Nữ</option>
                            <option value="khac">Khác</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Địa Chỉ</label>
                    <textarea name="DiaChi" class="form-control" rows="2"></textarea>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Số Giấy Tờ (CMND/CCCD/Passport)</label>
                    <input type="text" name="SoGiayTo" class="form-control">
                </div>

                <h4 class="mt-4 mb-3">Thông tin Công ty (Nếu là khách công ty)</h4>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Loại Khách</label>
                        <select name="LoaiKhach" class="form-select">
                            <option value="ca_nhan">Cá nhân</option>
                            <option value="cong_ty">Công ty</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tên Công Ty</label>
                        <input type="text" name="TenCongTy" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Mã Số Thuế</label>
                        <input type="text" name="MaSoThue" class="form-control">
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Ghi Chú</label>
                    <textarea name="GhiChu" class="form-control" rows="3"></textarea>
                </div>

                <button type="submit" class="btn btn-success mt-3">Thêm Khách Hàng</button>
                <a href="?act=listKhachHang" class="btn btn-secondary mt-3">Quay lại</a>
            </form>
        </div>
    </div>
</div>