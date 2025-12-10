<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập hệ thống</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        /* CSS TÙY CHỈNH CHO TRANG LOGIN */
        body {
            /* Hình nền du lịch đẹp */
            background-image: url('https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?q=80&w=2021&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Lớp phủ tối màu để chữ dễ đọc hơn */
        .overlay {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.4);
            z-index: 0;
        }

        .login-card {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 420px;
            background: rgba(255, 255, 255, 0.95); /* Màu trắng hơi trong suốt */
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            animation: fadeIn 0.8s ease-in-out;
        }

        .card-header {
            background: linear-gradient(135deg, #0d6efd, #0099ff);
            color: white;
            padding: 25px;
            text-align: center;
            border-bottom: none;
        }

        .card-header h3 {
            margin: 0;
            font-weight: 700;
            letter-spacing: 1px;
            font-size: 24px;
        }

        .card-body {
            padding: 40px 30px;
        }

        .form-floating label {
            color: #666;
        }

        .btn-login {
            background: linear-gradient(135deg, #0d6efd, #0056b3);
            border: none;
            padding: 12px;
            font-weight: 600;
            font-size: 16px;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(13, 110, 253, 0.4);
        }

        /* Hiệu ứng rung khi có lỗi */
        .alert-error {
            background-color: #ffebee;
            color: #c62828;
            border: 1px solid #ef9a9a;
            border-radius: 8px;
            padding: 12px;
            font-size: 14px;
            display: flex;
            align-items: center;
            animation: shake 0.5s;
        }
        
        .alert-error i {
            margin-right: 10px;
            font-size: 18px;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes shake {
            0% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            50% { transform: translateX(5px); }
            75% { transform: translateX(-5px); }
            100% { transform: translateX(0); }
        }
    </style>
</head>

<body>
    <div class="overlay"></div>

    <div class="card login-card">
        <div class="card-header">
            <h3><i class="fas fa-plane-departure me-2"></i>QUẢN LÝ TOUR</h3>
        </div>
        
        <div class="card-body">
            <?php if(isset($_SESSION['error'])): ?>
                <div class="alert alert-error mb-4" role="alert">
                    <i class="fas fa-exclamation-circle"></i>
                    <div>
                        <?= $_SESSION['error']; ?>
                    </div>
                </div>
                <?php unset($_SESSION['error']); ?> 
            <?php endif; ?>

            <form action="?act=loginProcess" method="POST" onsubmit="return validateForm()">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="username" name="tenDangNhap" placeholder="Tên đăng nhập">
                    <label for="username"><i class="fas fa-user me-2"></i>Tên đăng nhập</label>
                    <small id="userError" class="text-danger mt-1 d-block" style="font-size: 12px;"></small>
                </div>
                
                <div class="form-floating mb-4">
                    <input type="password" class="form-control" id="password" name="matKhau" placeholder="Mật khẩu">
                    <label for="password"><i class="fas fa-lock me-2"></i>Mật khẩu</label>
                    <small id="passError" class="text-danger mt-1 d-block" style="font-size: 12px;"></small>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-login text-white">
                        ĐĂNG NHẬP
                    </button>
                </div>

                <div class="text-center mt-4">
                    <a href="#" class="text-decoration-none text-muted small">Quên mật khẩu?</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function validateForm() {
            let user = document.getElementById("username").value.trim();
            let pass = document.getElementById("password").value.trim();
            let userError = document.getElementById("userError");
            let passError = document.getElementById("passError");
            let isValid = true;

            // Reset lỗi
            userError.innerText = "";
            passError.innerText = "";

            if (user === "") {
                userError.innerText = "Vui lòng nhập tên đăng nhập.";
                isValid = false;
            } 
            
            if (pass === "") {
                passError.innerText = "Vui lòng nhập mật khẩu.";
                isValid = false;
            }

            return isValid;
        }
    </script>
</body>

</html>