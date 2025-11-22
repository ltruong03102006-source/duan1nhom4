<div class="container-fluid px-4">
    <h1 class="mt-4">Lịch Trình Tour</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="?act=hdvHome">Dashboard HDV</a></li>
        <li class="breadcrumb-item active">Lịch trình</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-route me-1"></i>
            Chi tiết Lịch trình (Tour ID: <?= $_GET['id'] ?? 'N/A' ?>)
        </div>
        <div class="card-body">
            <p>Đây là nơi hiển thị chi tiết lịch trình tour theo từng ngày (sẽ được tích hợp sau khi chức năng quản lý Lịch trình (LichTrinh) cho Admin được hoàn thiện).</p>
            <p>Hướng dẫn viên có thể xem để nắm rõ kế hoạch tour.</p>
            <a href="javascript:history.back()"><button class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Quay lại</button></a>
        </div>
    </div>
</div>