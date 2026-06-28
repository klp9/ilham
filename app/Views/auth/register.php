<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="col-md-6">
        <div class="card p-4 border-0 shadow-lg">
            <div class="card-body">
                <div class="text-center mb-4">
                    <h2 class="fw-bold">Daftar Akun Baru</h2>
                    <p class="text-muted">Buat akun untuk mulai memesan kamar</p>
                </div>
                <form action="<?= base_url('register') ?>" method="POST">
                    <?= csrf_field() ?>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="fullname" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Nama Lengkap" value="<?= old('fullname') ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">No. Telepon</label>
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Contoh: 08123..." value="<?= old('phone') ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Alamat Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Contoh: email@anda.com" value="<?= old('email') ?>" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Minimal 4 karakter" value="<?= old('username') ?>" required>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Minimal 6 karakter" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2.5 mb-3 text-white">Daftar Akun</button>
                </form>
                <div class="text-center">
                    <p class="mb-0 text-muted">Sudah punya akun? <a href="<?= base_url('login') ?>" class="text-primary fw-bold text-decoration-none">Login Disini</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
