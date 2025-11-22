<style>
    /* Style tương tự như add.php */
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
        box-sizing: border-box;
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
    .note { font-style: italic; color: #555; font-size: 0.9em; margin-top: 5px; }
    .employee-info { padding: 10px; background: #f0f0f0; border-radius: 4px; margin-bottom: 15px; }
</style>

<div class="container-fluid px-4">
    <h1 class="mt-4">Chỉnh Sửa Tài Khoản</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="?act=taiKhoan">Tài khoản</a></li>
        <li class="breadcrumb-item active">Chỉnh sửa</li>
    </ol>

    <div class="card col-lg-6 mx-auto">
        <h2>Chỉnh sửa tài khoản của: <?= $taiKhoan['HoTen'] ?> (<?= $taiKhoan['MaCodeNhanVien'] ?>)</h2>
        
        <div class="employee-info">
            <p><strong>ID Tài khoản:</strong> <?= $taiKhoan['MaTaiKhoan'] ?></p>
            <p><strong>Nhân viên:</strong> <?= $taiKhoan['HoTen'] ?></p>
        </div>

        <form action="?act=updateTaiKhoanProcess" method="POST">

            <input type="hidden" name="maTaiKhoan" value="<?= $taiKhoan['MaTaiKhoan'] ?>">

            <div class="form-group">
                <label for="tenDangNhap">Tên đăng nhập:</label>
                <input type="text" name="tenDangNhap" id="tenDangNhap" 
                       value="<?= $taiKhoan['TenDangNhap'] ?>" required>
            </div>
            
            <div class="form-group">
                <label for="vaiTro">Phân quyền:</label>
                <select name="vaiTro" id="vaiTro" required>
                    <option value="admin" <?= $taiKhoan['VaiTroTaiKhoan'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="huong_dan_vien" <?= $taiKhoan['VaiTroTaiKhoan'] == 'huong_dan_vien' ? 'selected' : '' ?>>Hướng dẫn viên</option>
                </select>
            </div>

            <div class="form-group">
                <label for="matKhauMoi">Mật khẩu mới (Bỏ trống nếu không đổi):</label>
                <input type="password" name="matKhauMoi" id="matKhauMoi" placeholder="Để trống nếu không đổi mật khẩu">
                <p class="note">Mật khẩu sẽ được mã hóa an toàn khi lưu.</p>
            </div>

            <button type="submit">Cập nhật Tài khoản</button>
            <a href="?act=taiKhoan">
                <button type="button" class="btn-back">Quay lại</button>
            </a>

        </form>

    </div>
</div>