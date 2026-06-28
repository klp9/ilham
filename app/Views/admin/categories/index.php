<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold">Kategori Kamar</h2>
        <p class="text-muted">Kelola jenis/kategori tipe kamar hotel</p>
    </div>
    <a href="<?= base_url('admin/categories/create') ?>" class="btn btn-primary text-white fw-bold"><i class="bi bi-plus-circle me-1"></i> Tambah Kategori</a>
</div>

<div class="card border-0 shadow-sm p-4">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Kategori</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($categories)): ?>
                    <?php $no = 1; foreach ($categories as $cat): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><strong class="text-dark"><?= $cat['name'] ?></strong></td>
                            <td class="text-muted text-truncate" style="max-width: 400px;"><?= $cat['description'] ?></td>
                            <td>
                                <a href="<?= base_url('admin/categories/edit/' . $cat['id']) ?>" class="btn btn-sm btn-outline-warning me-1"><i class="bi bi-pencil-square"></i> Edit</a>
                                <form action="<?= base_url('admin/categories/delete/' . $cat['id']) ?>" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini? Semua kamar dengan kategori ini akan ikut terhapus.')">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i> Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">Data kategori kosong.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
