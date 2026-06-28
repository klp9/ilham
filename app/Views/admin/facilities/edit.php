<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="d-flex align-items-center mb-4">
            <a href="<?= base_url('admin/facilities') ?>" class="btn btn-light me-3"><i class="bi bi-arrow-left"></i></a>
            <div>
                <h2 class="fw-bold mb-0">Ubah Fasilitas</h2>
                <p class="text-muted mb-0">Edit rincian data fasilitas kamar</p>
            </div>
        </div>

        <div class="card p-4 border-0 shadow-sm">
            <div class="card-body">
                <form action="<?= base_url('admin/facilities/update/' . $facility['id']) ?>" method="POST">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Fasilitas</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Contoh: Free Wi-Fi, AC" value="<?= old('name', $facility['name']) ?>" required>
                    </div>
                    <div class="mb-4">
                        <label for="description" class="form-label">Deskripsi Fasilitas</label>
                        <textarea class="form-control" id="description" name="description" rows="4" placeholder="Keterangan singkat..." required><?= old('description', $facility['description']) ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary text-white fw-bold px-4"><i class="bi bi-save me-1"></i> Perbarui Fasilitas</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
