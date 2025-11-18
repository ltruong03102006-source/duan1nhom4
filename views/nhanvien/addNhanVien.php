<style>
    /* CSS đồng bộ với Tour pages */
    :root {
        --primary-color: #2563eb;
        --primary-hover: #1d4ed8;
        --bg-color: #f1f5f9;
        --card-bg: #ffffff;
        --text-main: #1e293b;
        --text-secondary: #64748b;
        --border-color: #e2e8f0;
        --success-color: #10b981;
        --danger-color: #ef4444;
    }
    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: var(--bg-color); color: var(--text-main); font-size: 14px; }
    .container-fluid { max-width: 1400px; margin: 0 auto; }
    h1.mt-4 { font-size: 20px; color: var(--primary-color); margin-bottom: 20px !important; font-weight: 600; }

    /* Card overrides */
    .card { background: var(--card-bg); border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); border: none; }
    .card-header { padding: 15px 20px; border-bottom: 1px solid var(--border-color); background-color: #f8fafc; border-radius: 8px 8px 0 0; font-size: 16px; font-weight: 600; color: var(--text-main); }
    .card-body { padding: 20px; }

    /* Form control consistency */
    .form-control, .form-select {
        padding: 8px 12px;
        border: 1px solid var(--border-color);
        border-radius: 4px;
        font-size: 14px;
        transition: border-color 0.2s;
    }
    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: none;
        outline: none;
    }
    .form-label { font-weight: 500; color: var(--text-main); margin-bottom: 5px; }

    /* Button styles */
    .btn { padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer; font-weight: 500; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; }
    .btn-primary { background-color: var(--primary-color); color: white; }
    .btn-primary:hover { background-color: var(--primary-hover); }
    .btn-success { background-color: var(--success-color); color: white; }
    .btn-success:hover { background-color: #0b9e6f; }
    .btn-secondary { background-color: #6c757d; color: white; }
    .btn-secondary:hover { background-color: #545b62; }
</style>
<div class="container-fluid px-4">
    <h1 class="mt-4">Thêm Nhân Viên Mới</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="?act=/">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="?act=listNhanVien">Danh sách Nhân viên</a></li>
        <li class="breadcrumb-item active">Thêm mới</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-user-plus me-1"></i>
            Thông tin Nhân viên
        </div>
        <div class="card-body">
            <form action="?act=addNhanVienProcess" method="POST" enctype="multipart/form-data">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Mã Code Nhân Viên *</label>
                        <input type="text" name="MaCodeNhanVien" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Họ Tên *</label>
                        <input type="text" name="HoTen" class="form-control" required>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Vai Trò *</label>
                        <select name="VaiTro" class="form-select" required>
                            <option value="huong_dan_vien">Hướng dẫn viên</option>
                            <option value="tai_xe">Tài xế</option>
                            <option value="dieu_hanh">Điều hành</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Số Điện Thoại</label>
                        <input type="text" name="SoDienThoai" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Email</label>
                        <input type="email" name="Email" class="form-control">
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Ngày Sinh</label>
                        <input type="date" name="NgaySinh" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Giới Tính</label>
                        <select name="GioiTinh" class="form-select">
                            <option value="nam">Nam</option>
                            <option value="nu">Nữ</option>
                            <option value="khac">Khác</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Trạng Thái</label>
                        <select name="TrangThai" class="form-select">
                            <option value="dang_lam">Đang làm</option>
                            <option value="da_nghi">Đã nghỉ</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Địa Chỉ</label>
                    <textarea name="DiaChi" class="form-control" rows="2"></textarea>
                </div>
                
                <h4 class="mt-4 mb-3">Thông tin chuyên môn</h4>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Ngoại ngữ</label>
                        <input type="text" name="NgonNgu" class="form-control" placeholder="VD: Tiếng Anh, Tiếng Hàn">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Chuyên Môn</label>
                        <input type="text" name="ChuyenMon" class="form-control" placeholder="VD: Lịch sử, Địa lý">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Số Năm Kinh Nghiệm</label>
                        <input type="number" name="SoNamKinhNghiem" class="form-control" min="0" value="0">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Chứng chỉ (Tên file)</label>
                        <input type="text" name="ChungChi" class="form-control" placeholder="VD: Thẻ HDV Quốc tế">
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Ảnh Đại Diện</label>
                    <input type="file" name="LinkAnhDaiDien" class="form-control" accept="image/*">
                </div>

                <button type="submit" class="btn btn-success mt-3">Thêm Nhân Viên</button>
                <a href="?act=listNhanVien" class="btn btn-secondary mt-3">Quay lại</a>
            </form>
        </div>
    </div>
</div>