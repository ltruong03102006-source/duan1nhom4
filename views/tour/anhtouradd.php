<!-- anhtouradd.php -->
<style>
  .page-wrap{max-width:980px;margin:24px auto}
  .cardx{border:0;border-radius:16px;box-shadow:0 10px 30px rgba(0,0,0,.08)}
  .cardx .card-header{border:0;background:transparent;padding:18px 20px}
  .cardx .card-body{padding:20px}
  .upload-box{
    border:2px dashed rgba(0,0,0,.12);
    border-radius:16px;
    padding:18px;
    transition:.15s ease;
    background:rgba(0,0,0,.02);
  }
  .upload-box:hover{border-color:rgba(0,0,0,.22); background:rgba(0,0,0,.03)}
  .thumb{
    width:72px;height:72px;border-radius:14px;object-fit:cover;
    border:1px solid rgba(0,0,0,.08)
  }
  .list-item{
    border:1px solid rgba(0,0,0,.08);
    border-radius:16px;
    padding:12px;
    background:#fff;
  }
  .muted{opacity:.7}
</style>

<div class="page-wrap">
  <div class="cardx">
    <div class="card-header d-flex align-items-center justify-content-between">
      <div>
        <h4 class="mb-1">Thêm ảnh tour</h4>
        <div class="muted">Chọn nhiều ảnh một lần, mỗi ảnh có chú thích riêng.</div>
      </div>
      <a class="btn btn-outline-secondary" href="?act=anhTour&MaTour=<?= (int)($_GET['MaTour'] ?? 0) ?>">Quay lại</a>
    </div>

    <div class="card-body">
      <form method="post" enctype="multipart/form-data" action="?act=addAnhTourProcess">
        <input type="hidden" name="MaTour" value="<?= (int)($_GET['MaTour'] ?? 0) ?>">

        <div class="upload-box mb-3">
          <label class="form-label fw-semibold mb-2">Chọn ảnh</label>
          <input id="images" class="form-control" type="file" name="DuongDanAnh[]" multiple accept="image/*">
          <div class="muted mt-2">Mẹo: giữ Ctrl/Shift để chọn nhiều ảnh.</div>
        </div>

        <div id="previewList" class="d-grid gap-2"></div>

        <div class="d-flex gap-2 mt-3">
          <button class="btn btn-primary" type="submit">Lưu ảnh</button>
          <a class="btn btn-outline-secondary" href="?act=anhTour&MaTour=<?= (int)($_GET['MaTour'] ?? 0) ?>">Hủy</a>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  const input = document.getElementById('images');
  const list = document.getElementById('previewList');

  function escapeHtml(str){
    return (str || '').replace(/[&<>"']/g, m => ({
      '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'
    }[m]));
  }

  input.addEventListener('change', () => {
    list.innerHTML = '';
    const files = Array.from(input.files || []);
    if (!files.length) return;

    files.forEach((file, idx) => {
      const url = URL.createObjectURL(file);

      const item = document.createElement('div');
      item.className = 'list-item';

      item.innerHTML = `
        <div class="d-flex align-items-start gap-3">
          <img class="thumb" src="${url}" alt="preview">
          <div class="flex-grow-1">
            <div class="fw-semibold mb-1">${escapeHtml(file.name)}</div>
            <label class="form-label mb-1">Chú thích cho ảnh #${idx+1}</label>
            <input class="form-control" name="ChuThichAnh[]" placeholder="VD: Bãi biển / khách sạn / điểm tham quan...">
          </div>
        </div>
      `;
      list.appendChild(item);
    });
  });
</script>
