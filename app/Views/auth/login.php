<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="col-md-5">
        <div class="card p-4 border-0 shadow-lg">
            <div class="card-body">
                <div class="text-center mb-4">
                    <h2 class="fw-bold">Login Pengguna</h2>
                    <p class="text-muted">Masuk untuk memesan kamar hotel Anda</p>
                </div>
                <form action="<?= base_url('login') ?>" method="POST">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="bi bi-person text-muted"></i></span>
                            <input type="text" class="form-control border-start-0" id="username" name="username" placeholder="Masukkan username" value="<?= old('username') ?>" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="bi bi-lock text-muted"></i></span>
                            <input type="password" class="form-control border-start-0" id="password" name="password" placeholder="Masukkan password" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-2.5 mb-3 text-white">Masuk</button>
                </form>
                <div class="text-center">
                    <p class="mb-0 text-muted">Belum punya akun? <a href="<?= base_url('register') ?>" class="text-primary fw-bold text-decoration-none">Daftar Sekarang</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
