<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="mb-4">
    <h2 class="fw-bold">Seluruh Pemesanan</h2>
    <p class="text-muted">Lihat dan ubah status seluruh pemesanan customer</p>
</div>

<div class="card border-0 shadow-sm p-4">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>No. Kamar</th>
                    <th>Check-In</th>
                    <th>Check-Out</th>
                    <th>Total Biaya</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($bookings)): ?>
                    <?php foreach ($bookings as $b): ?>
                        <tr>
                            <td>#<?= $b['id'] ?></td>
                            <td>
                                <div class="fw-bold"><?= $b['customer_name'] ?></div>
                                <small class="text-muted"><?= $b['customer_email'] ?></small>
                            </td>
                            <td>
                                <div class="fw-bold">No. <?= $b['room_number'] ?></div>
                                <small class="text-primary text-uppercase" style="font-size: 0.75rem;"><?= $b['category_name'] ?></small>
                            </td>
                            <td><?= date('d/m/Y', strtotime($b['check_in_date'])) ?></td>
                            <td><?= date('d/m/Y', strtotime($b['check_out_date'])) ?></td>
                            <td class="fw-bold text-dark">Rp <?= number_format($b['total_price'], 0, ',', '.') ?></td>
                            <td>
                                <span class="badge badge-<?= $b['status'] ?> text-capitalize py-2 px-2.5">
                                    <?= $b['status'] === 'approved' ? 'Disetujui' : ($b['status'] === 'rejected' ? 'Ditolak' : $b['status']) ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?= base_url('admin/bookings/detail/' . $b['id']) ?>" class="btn btn-sm btn-outline-primary fw-bold"><i class="bi bi-eye"></i> Detail</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">Belum ada pemesanan masuk.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
