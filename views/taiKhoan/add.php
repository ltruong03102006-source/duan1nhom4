<style>
    /* Sử dụng lại style cơ bản cho form từ DanhMuctour */
    .card {
        background: #fff;
        padding: 20px;
        margin-bottom: 25px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    .form-group {
        margin-bottom: 15px;
    }
    label {
        font-weight: bold;
        display: block;
        margin-bottom: 6px;
    }
    input[type="text"], input[type="password"], select {
        width: 100%;
        padding: 8px 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
        font-size: 14px;
        box-sizing: border-box; /* Quan trọng để padding không làm width vượt quá 100% */
    }
    button {
        background: #1e88e5;
        color: #fff;
        padding: 10px 18px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
        font-weight: bold;
    }
    button:hover {
        background: #1565c0;
    }
    .btn-back { background:#777; margin-left: 10px; }
    .btn-back:hover { background:#555; }
    .error-message { color: #dc3545; margin-top: 10px; }
</style>

<div class="container-fluid px-4">
    <h1 class="mt-4">Thêm Tài Khoản Mới</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="?act=taiKhoan">Tài khoản</a></li>
        <li class="breadcrumb-item active">Thêm mới</li>
    </ol>

    <div class="card col-lg-6 mx-auto">
        <h2>Tạo tài khoản cho nhân viên</h2>

        <?php 
        // Hiển thị thông báo lỗi nếu có
        if (isset($_GET['error']) && $_GET['error'] == 'required_fields') {
            echo '<p class="error-message">Vui lòng nhập đầy đủ Tên đăng nhập, Mật khẩu và chọn Nhân viên.</p>';
        }
        ?>

        <form action="?act=addTaiKhoanProcess" method="POST">

            <div class="form-group">
                <label for="maNhanVien">Chọn Nhân viên:</label>
                <select name="maNhanVien" id="maNhanVien" required>
                    <?php if (!empty($listNhanVien)): ?>
                        <option value="">-- Chọn Nhân viên --</option>
                        <?php foreach ($listNhanVien as $nv): ?>
                            <option value="<?= $nv['MaNhanVien'] ?>">
                                [<?= $nv['MaCodeNhanVien'] ?>] <?= $nv['HoTen'] ?> - (<?= $nv['VaiTro'] ?>)
                            </option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="">Không có nhân viên nào chưa có tài khoản</option>
                    <?php endif; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="tenDangNhap">Tên đăng nhập:</label>
                <input type="text" name="tenDangNhap" id="tenDangNhap" required>
            </div>
            
            <div class="form-group">
                <label for="matKhau">Mật khẩu:</label>
                <input type="password" name="matKhau" id="matKhau" required>
            </div>

            <div class="form-group">
                <label for="vaiTro">Phân quyền:</label>
                <select name="vaiTro" id="vaiTro" required>
                    <option value="admin">Admin</option>
                    <option value="huong_dan_vien">Hướng dẫn viên</option>
                </select>
            </div>

            <button type="submit">Tạo tài khoản</button>
            <a href="?act=taiKhoan">
                <button type="button" class="btn-back">Quay lại</button>
            </a>

        </form>

    </div>
</div>