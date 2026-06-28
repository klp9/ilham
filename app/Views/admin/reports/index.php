<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="mb-4">
    <h2 class="fw-bold">Laporan Pemesanan & Keuangan</h2>
    <p class="text-muted">Lihat statistik pendapatan hotel berdasarkan rentang tanggal</p>
</div>

<!-- Date Filter Section -->
<div class="card p-3 mb-5 border-0 shadow-sm">
    <div class="card-body">
        <form action="<?= base_url('admin/reports') ?>" method="GET">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="start_date" class="form-label small fw-bold">Tanggal Mulai</label>
                    <input type="date" id="start_date" name="start_date" class="form-control" value="<?= esc($startDate) ?>">
                </div>
                <div class="col-md-3">
                    <label for="end_date" class="form-label small fw-bold">Tanggal Selesai</label>
                    <input type="date" id="end_date" name="end_date" class="form-control" value="<?= esc($endDate) ?>">
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label small fw-bold">Status Pemesanan</label>
                    <select id="status" name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="pending" <?= $statusFilter === 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="approved" <?= $statusFilter === 'approved' ? 'selected' : '' ?>>Disetujui</option>
                        <option value="rejected" <?= $statusFilter === 'rejected' ? 'selected' : '' ?>>Ditolak</option>
                        <option value="check_in" <?= $statusFilter === 'check_in' ? 'selected' : '' ?>>Check In</option>
                        <option value="check_out" <?= $statusFilter === 'check_out' ? 'selected' : '' ?>>Check Out</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary text-white w-100 py-2.5 fw-bold"><i class="bi bi-funnel-fill me-1"></i> Filter</button>
                    <a href="<?= base_url('admin/reports') ?>" class="btn btn-outline-secondary w-100 py-2.5 text-center"><i class="bi bi-x-circle me-1"></i> Reset</a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Report Summary cards -->
<div class="row g-4 mb-5">
    <div class="col-md-6">
        <div class="card p-3 border-0 shadow-sm gradient-card h-100">
            <div class="card-body d-flex align-items-center">
                <div class="bg-light bg-opacity-20 text-white rounded p-3 me-3">
                    <i class="bi bi-wallet2 fs-3 text-warning"></i>
                </div>
                <div>
                    <h6 class="text-light text-opacity-75 mb-1 small text-uppercase fw-bold">Total Pendapatan Terfilter</h6>
                    <h2 class="fw-bold mb-0">Rp <?= number_format($totalRevenue, 0, ',', '.') ?></h2>
                    <small class="text-light text-opacity-50">Hanya dari pemesanan Disetujui, Check-In, dan Check-Out</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card p-3 border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 text-primary rounded p-3 me-3">
                    <i class="bi bi-calendar-check fs-3"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-1 small text-uppercase fw-bold">Jumlah Transaksi Terfilter</h6>
                    <h2 class="fw-bold mb-0 text-dark"><?= $totalBookings ?> Transaksi</h2>
                    <small class="text-muted">Total transaksi berdasarkan kriteria filter</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Report Table -->
<div class="card border-0 shadow-sm p-4">
    <h5 class="fw-bold mb-4">Daftar Laporan</h5>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tanggal Pemesanan</th>
                    <th>Customer</th>
                    <th>Kamar</th>
                    <th>Durasi Menginap</th>
                    <th>Total Biaya</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($bookings)): ?>
                    <?php foreach ($bookings as $b): ?>
                        <tr>
                            <td>#<?= $b['id'] ?></td>
                            <td><?= date('d M Y H:i', strtotime($b['created_at'])) ?></td>
                            <td><strong><?= $b['customer_name'] ?></strong></td>
                            <td>
                                <div>No. <?= $b['room_number'] ?></div>
                                <small class="text-primary text-uppercase" style="font-size: 0.75rem;"><?= $b['category_name'] ?></small>
                            </td>
                            <td>
                                <?php 
                                    $in = new \DateTime($b['check_in_date']);
                                    $out = new \DateTime($b['check_out_date']);
                                    $days = $in->diff($out)->days;
                                    echo esc($days) . ' Malam';
                                ?>
                                <br>
                                <small class="text-muted" style="font-size: 0.75rem;">(<?= date('d/m/y', strtotime($b['check_in_date'])) ?> - <?= date('d/m/y', strtotime($b['check_out_date'])) ?>)</small>
                            </td>
                            <td class="fw-bold text-dark">Rp <?= number_format($b['total_price'], 0, ',', '.') ?></td>
                            <td>
                                <span class="badge badge-<?= $b['status'] ?> text-capitalize py-2 px-2.5">
                                    <?= $b['status'] === 'approved' ? 'Disetujui' : ($b['status'] === 'rejected' ? 'Ditolak' : $b['status']) ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Tidak ada data transaksi yang memenuhi kriteria filter.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
