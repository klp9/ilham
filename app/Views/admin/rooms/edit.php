<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-9">
        <div class="d-flex align-items-center mb-4">
            <a href="<?= base_url('admin/rooms') ?>" class="btn btn-light me-3"><i class="bi bi-arrow-left"></i></a>
            <div>
                <h2 class="fw-bold mb-0">Ubah Data Kamar</h2>
                <p class="text-muted mb-0">Edit rincian data kamar dan penyesuaian tarif</p>
            </div>
        </div>

        <div class="card p-4 border-0 shadow-sm">
            <div class="card-body">
                <form action="<?= base_url('admin/rooms/update/' . $room['id']) ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="room_number" class="form-label">Nomor Kamar</label>
                            <input type="text" class="form-control" id="room_number" name="room_number" placeholder="Contoh: 101, 204" value="<?= old('room_number', $room['room_number']) ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="category_id" class="form-label">Kategori Tipe Kamar</label>
                            <select class="form-select" id="category_id" name="category_id" required>
                                <option value="" disabled>Pilih Kategori</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>" <?= old('category_id', $room['category_id']) == $cat['id'] ? 'selected' : '' ?>><?= $cat['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label">Harga per Malam (Rupiah)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">Rp</span>
                                <input type="number" class="form-control" id="price" name="price" placeholder="Contoh: 250000" value="<?= old('price', (int)$room['price']) ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Status Kamar</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="available" <?= old('status', $room['status']) === 'available' ? 'selected' : '' ?>>Tersedia (Available)</option>
                                <option value="booked" <?= old('status', $room['status']) === 'booked' ? 'selected' : '' ?>>Dipesan (Booked)</option>
                                <option value="maintenance" <?= old('status', $room['status']) === 'maintenance' ? 'selected' : '' ?>>Perawatan (Maintenance)</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Ganti Foto Kamar (Opsional)</label>
                        <input class="form-control mb-2" type="file" id="image" name="image" accept="image/*">
                        <small class="text-muted d-block mb-3">Maks. 2MB (Format: JPG, JPEG, PNG)</small>
                        
                        <?php if ($room['image'] && file_exists(FCPATH . 'uploads/rooms/' . $room['image'])): ?>
                            <div class="p-2 border rounded bg-light d-inline-block">
                                <span class="d-block mb-1 text-muted small fw-bold">Foto Saat Ini:</span>
                                <img src="<?= base_url('uploads/rooms/' . $room['image']) ?>" alt="Preview" style="height: 120px; object-fit: cover;" class="rounded">
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-4 mt-3">
                        <label for="description" class="form-label">Deskripsi & Keterangan Kamar</label>
                        <textarea class="form-control" id="description" name="description" rows="4" placeholder="Keterangan mengenai luas, jenis kasur, dll..." required><?= old('description', $room['description']) ?></textarea>
                    </div>

                    <!-- Facility list selection -->
                    <div class="mb-4">
                        <label class="form-label fw-bold d-block mb-2">Pilih Fasilitas Kamar</label>
                        <div class="row g-2">
                            <?php foreach ($facilities as $fac): ?>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="facilities[]" value="<?= $fac['id'] ?>" id="fac_<?= $fac['id'] ?>" <?= in_array($fac['id'], $currentFacilityIds) ? 'checked' : '' ?>>
                                        <label class="form-check-label text-dark" for="fac_<?= $fac['id'] ?>">
                                            <?= $fac['name'] ?>
                                        </label>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary text-white fw-bold px-4"><i class="bi bi-save me-1"></i> Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
