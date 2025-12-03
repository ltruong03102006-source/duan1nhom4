<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đăng nhập hệ thống</title>
  <link rel="stylesheet" href="views/css/styles.css">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h2 class="text-center">Đăng nhập hệ thống Tour</h2>
    <form method="post" action="?act=loginProcess" class="w-50 mx-auto mt-4">
      <div class="mb-3">
        <label>Tên đăng nhập</label>
        <input type="text" name="tenDangNhap" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Mật khẩu</label>
        <input type="password" name="matKhau" class="form-control" required>
      </div>
      <button class="btn btn-primary w-100">Đăng nhập</button>
    </form>
  </div>
</body>
</html>
