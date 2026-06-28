<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold">Fasilitas Kamar</h2>
        <p class="text-muted">Kelola daftar fasilitas penunjang kamar hotel</p>
    </div>
    <a href="<?= base_url('admin/facilities/create') ?>" class="btn btn-primary text-white fw-bold"><i class="bi bi-plus-circle me-1"></i> Tambah Fasilitas</a>
</div>

<div class="card border-0 shadow-sm p-4">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Fasilitas</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($facilities)): ?>
                    <?php $no = 1; foreach ($facilities as $fac): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><strong class="text-dark"><?= $fac['name'] ?></strong></td>
                            <td class="text-muted text-truncate" style="max-width: 400px;"><?= $fac['description'] ?></td>
                            <td>
                                <a href="<?= base_url('admin/facilities/edit/' . $fac['id']) ?>" class="btn btn-sm btn-outline-warning me-1"><i class="bi bi-pencil-square"></i> Edit</a>
                                <form action="<?= base_url('admin/facilities/delete/' . $fac['id']) ?>" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus fasilitas ini?')">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i> Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">Data fasilitas kosong.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
