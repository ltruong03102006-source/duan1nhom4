<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Quản Lý Tour Du Lịch</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="views/css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="?act=/">QUẢN LÝ TOUR</a>
        
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Tìm kiếm..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
            </div>
        </form>

        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user fa-fw"></i>
                    <?php if (isset($_SESSION['user'])): ?>
                        <span class="d-none d-md-inline ms-1 font-weight-bold"><?= $_SESSION['user']['TenDangNhap'] ?></span>
                    <?php endif; ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <?php if (isset($_SESSION['user'])): ?>
                        <li><h6 class="dropdown-header">Xin chào, <?= $_SESSION['user']['TenDangNhap'] ?>!</h6></li>
                       
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item text-danger" href="?act=logout"><i class="fas fa-sign-out-alt me-2"></i>Đăng xuất</a></li>
                    <?php else: ?>
                        <li><a class="dropdown-item" href="?act=login">Đăng nhập</a></li>
                    <?php endif; ?>
                </ul>
            </li>
        </ul>
    </nav>
    
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Tổng quan</div>
                        <a class="nav-link" href="?act=/">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>

                        <?php if (isset($_SESSION['user']) && $_SESSION['user']['VaiTro'] == 'admin'): ?>
                            <div class="sb-sidenav-menu-heading">QUẢN TRỊ HỆ THỐNG</div>

                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseTour" aria-expanded="false">
                                <div class="sb-nav-link-icon"><i class="fas fa-map-signs"></i></div>
                                Quản lý Tour
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseTour" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="?act=danhMuctour">Danh mục Tour</a>
                                    <a class="nav-link" href="?act=tour">Danh sách Tour</a>
                                </nav>
                            </div>

                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseBooking" aria-expanded="false">
                                <div class="sb-nav-link-icon"><i class="fas fa-ticket-alt"></i></div>
                                Booking & Đoàn
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseBooking" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="?act=listBooking">Danh sách Booking</a>
                                    <a class="nav-link" href="?act=listDoan">Đoàn khởi hành</a>
                                    <a class="nav-link" href="?act=listThanhToan">Lịch sử thanh toán</a>
                                </nav>
                            </div>

                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseKhach" aria-expanded="false">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                Khách hàng
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseKhach" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="?act=listKhachHang">Danh sách Khách</a>
                                    <a class="nav-link" href="?act=addKhachHang">Thêm Khách hàng</a>
                                </nav>
                            </div>

                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseNhanSu" aria-expanded="false">
                                <div class="sb-nav-link-icon"><i class="fas fa-user-tie"></i></div>
                                Nhân sự & Tài khoản
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseNhanSu" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="?act=listNhanVien">Danh sách Nhân viên</a>
                                    <a class="nav-link" href="?act=taiKhoan">Hệ thống Tài khoản</a>
                                    <a class="nav-link" href="?act=listLichLamViec">Lịch làm việc</a>
                                </nav>
                            </div>

                            <a class="nav-link" href="?act=listNhaCungCap">
                                <div class="sb-nav-link-icon"><i class="fas fa-handshake"></i></div>
                                Nhà cung cấp
                            </a>
                            <a class="nav-link" href="?act=nhatky_admin">
                                <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                                Nhật ký Tour
                            </a>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['user']) && $_SESSION['user']['VaiTro'] == 'huong_dan_vien'): ?>
                            <div class="sb-sidenav-menu-heading">DÀNH CHO HDV</div>
                            <a class="nav-link" href="?act=hdvHome">
                                <div class="sb-nav-link-icon"><i class="fas fa-calendar-check"></i></div>
                                Lịch Tour của tôi
                            </a>
                            <a class="nav-link" href="?act=nhatky_hdv">
                                <div class="sb-nav-link-icon"><i class="fas fa-pen-nib"></i></div>
                                Viết Nhật Ký
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="sb-sidenav-footer">
                    <div class="small">Đang đăng nhập:</div>
                    <?php if (isset($_SESSION['user'])): ?>
                        <strong class="text-warning"><?= $_SESSION['user']['TenDangNhap'] ?></strong>
                    <?php else: ?>
                        Khách (Chưa đăng nhập)
                    <?php endif; ?>
                </div>
            </nav>
        </div>
        
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">