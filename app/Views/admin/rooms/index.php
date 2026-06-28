<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold">Manajemen Kamar</h2>
        <p class="text-muted">Kelola nomor kamar, status, dan harga sewa</p>
    </div>
    <a href="<?= base_url('admin/rooms/create') ?>" class="btn btn-primary text-white fw-bold"><i class="bi bi-plus-circle me-1"></i> Tambah Kamar</a>
</div>

<div class="card border-0 shadow-sm p-4">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>No. Kamar</th>
                    <th>Kategori</th>
                    <th>Harga / Malam</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($rooms)): ?>
                    <?php foreach ($rooms as $room): ?>
                        <tr>
                            <td>
                                <?php if ($room['image'] && file_exists(FCPATH . 'uploads/rooms/' . $room['image'])): ?>
                                    <img src="<?= base_url('uploads/rooms/' . $room['image']) ?>" class="rounded" alt="Room <?= $room['room_number'] ?>" style="width: 70px; height: 50px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="bg-secondary text-white rounded d-flex align-items-center justify-content-center" style="width: 70px; height: 50px;">
                                        <i class="bi bi-image" style="font-size: 0.8rem;"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td><strong class="text-dark">No. <?= $room['room_number'] ?></strong></td>
                            <td><span class="text-primary fw-bold text-uppercase small"><?= $room['category_name'] ?></span></td>
                            <td class="fw-bold text-dark">Rp <?= number_format($room['price'], 0, ',', '.') ?></td>
                            <td>
                                <span class="badge badge-<?= $room['status'] ?> text-capitalize py-2 px-2.5">
                                    <?= $room['status'] === 'available' ? 'Tersedia' : ($room['status'] === 'booked' ? 'Dipesan' : 'Perawatan') ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?= base_url('admin/rooms/edit/' . $room['id']) ?>" class="btn btn-sm btn-outline-warning me-1"><i class="bi bi-pencil-square"></i> Edit</a>
                                <form action="<?= base_url('admin/rooms/delete/' . $room['id']) ?>" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kamar ini?')">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i> Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Data kamar kosong.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
