<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="d-flex align-items-center mb-4">
            <a href="<?= base_url('customer/dashboard') ?>" class="btn btn-light me-3"><i class="bi bi-arrow-left"></i></a>
            <div>
                <h2 class="fw-bold mb-0">Ubah Profil Saya</h2>
                <p class="text-muted mb-0">Sesuaikan informasi kontak dan kata sandi Anda</p>
            </div>
        </div>

        <div class="card p-4 border-0 shadow-sm">
            <div class="card-body">
                <form action="<?= base_url('customer/profile/update') ?>" method="POST">
                    <?= csrf_field() ?>
                    
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control bg-light" id="username" value="<?= esc($user['username']) ?>" readonly>
                        <small class="text-muted">Username tidak dapat diubah.</small>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control bg-light" id="email" value="<?= esc($user['email']) ?>" readonly>
                        <small class="text-muted">Email tidak dapat diubah.</small>
                    </div>

                    <div class="mb-3">
                        <label for="fullname" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="fullname" name="fullname" value="<?= old('fullname', $user['fullname']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Nomor Telepon / HP</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="<?= old('phone', $user['phone']) ?>" required>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">Kata Sandi Baru (Kosongkan jika tidak diganti)</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Minimal 6 karakter">
                    </div>

                    <button type="submit" class="btn btn-primary text-white fw-bold px-4"><i class="bi bi-save me-1"></i> Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
