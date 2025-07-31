<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-9">
            <div class="card shadow-sm">
                <div class="card-header bg-transparent d-flex align-items-center">
                    <?php if (!empty($user['foto'])): ?>
                        <img src="<?= base_url('uploads/user/' . $user['foto']) ?>" alt="Foto" class="rounded-circle me-3" width="60" height="60" style="object-fit: cover;">
                    <?php endif; ?>
                    <h5 class="card-title mb-0">Profil Saya</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Sidebar -->
                        <div class="col-sm-3 mb-3 mb-sm-0">
                            <div class="nav flex-column nav-pills" id="profile-tab" role="tablist">
                                <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#info">Informasi Akun</button>
                                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#sosmed">Media Sosial</button>
                                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#address">Alamat</button>
                                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#password">Ubah Password</button>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="col-sm-9">
                            <div class="tab-content">

                                <!-- Informasi Akun -->
                                <div class="tab-pane fade show active" id="info">
                                    <div class="row align-items-center mb-4">
                                        <div class="col-md-4 text-center">
                                            <?php if (!empty($user['foto'])): ?>
                                                <img src="<?= base_url('uploads/user/' . $user['foto']) ?>" class="rounded-circle mb-2" width="100" height="100" style="object-fit: cover;">
                                            <?php else: ?>
                                                <div class="rounded-circle bg-secondary" style="width:100px;height:100px;"></div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-md-8">
                                            <label class="form-label">Foto</label>
                                            <form action="<?= base_url('dashboard/user/update/' . session('id')) ?>" method="post" enctype="multipart/form-data">
                                                <?= csrf_field() ?>
                                                <input type="hidden" id="user_id" value="<?= $user['id'] ?>">
                                                <input type="file" class="form-control mb-2" name="foto">
                                                <div class="d-flex gap-2 mt-2">
                                                    <button type="submit" class="btn btn-sm" style="background-color:#B86C3A;color:#fff;">Ganti Foto</button>
                                                    <?php if (!empty($user['foto'])): ?>
                                                        <a href="<?= base_url('dashboard/user/deletePhoto/' . $user['id']) ?>" class="btn btn-outline-danger btn-sm">Hapus Foto</a>
                                                    <?php endif; ?>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Nama Lengkap</label>
                                            <input type="text" class="form-control auto-save" data-field="name" value="<?= esc($user['name']) ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Username</label>
                                            <input type="text" class="form-control auto-save" data-field="username" value="<?= esc($user['username']) ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="position" class="form-label">Jabatan</label>
                                            <input type="text" class="form-control auto-save" data-field="position" id="position" value="<?= esc($user['position'] ?? '') ?>">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Jenis Kelamin</label>
                                            <select class="form-select auto-save" data-field="gender">
                                                <option value="">- Pilih -</option>
                                                <option value="Laki-laki" <?= $user['gender'] == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                                                <option value="Perempuan" <?= $user['gender'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Email</label>
                                            <input type="email" class="form-control" value="<?= esc($user['email']) ?>" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Telepon</label>
                                            <input type="text" class="form-control auto-save" data-field="phone" value="<?= esc($user['phone']) ?>">
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label class="form-label">Tempat Lahir</label>
                                            <input type="text" class="form-control auto-save" data-field="place_of_birth" value="<?= esc($user['place_of_birth']) ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Tanggal Lahir</label>
                                            <input type="date" class="form-control auto-save" data-field="date_of_birth" value="<?= esc($user['date_of_birth']) ?>">
                                        </div>
                                    </div>
                                </div>

                                <!-- Media Sosial -->
                                <div class="tab-pane fade" id="sosmed">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label for="facebook" class="form-label">Facebook Username</label>
                                            <input type="text" class="form-control sosmed-input" id="facebook" name="facebook" value="<?= esc($user['facebook']) ?>">
                                            <?php if (!empty($user['facebook'])): ?>
                                                <a href="https://facebook.com/<?= esc($user['facebook']) ?>" target="_blank" class="small text-info d-block mt-1">Lihat Profil</a>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="instagram" class="form-label">Instagram Username</label>
                                            <input type="text" class="form-control sosmed-input" id="instagram" name="instagram" value="<?= esc($user['instagram']) ?>">
                                            <?php if (!empty($user['instagram'])): ?>
                                                <a href="https://instagram.com/<?= esc($user['instagram']) ?>" target="_blank" class="small text-info d-block mt-1">Lihat Profil</a>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="tiktok" class="form-label">TikTok Username</label>
                                            <input type="text" class="form-control sosmed-input" id="tiktok" name="tiktok" value="<?= esc($user['tiktok']) ?>">
                                            <?php if (!empty($user['tiktok'])): ?>
                                                <a href="https://tiktok.com/@<?= esc($user['tiktok']) ?>" target="_blank" class="small text-info d-block mt-1">Lihat Profil</a>
                                            <?php endif; ?>
                                        </div>

                                    </div>
                                </div>

                                <!-- Alamat -->
<div class="tab-pane fade" id="address">
    <form id="form-address" class="needs-validation" novalidate>
        <?= csrf_field() ?>
        <div class="row g-3">
            <div class="col-md-6">
                <label for="street">Jalan</label>
                <input type="text" class="form-control address-input" id="street" value="<?= esc($street ?? '') ?>">
            </div>
            <div class="col-md-6">
                <label for="province">Provinsi</label>
                <select class="form-select address-input" id="province"></select>
            </div>
            <div class="col-md-6">
                <label for="regency">Kota/Kabupaten</label>
                <select class="form-select address-input" id="regency"></select>
            </div>
            <div class="col-md-6">
                <label for="district">Kecamatan</label>
                <select class="form-select address-input" id="district"></select>
            </div>
            <div class="col-md-6">
                <label for="village">Desa/Kelurahan</label>
                <select class="form-select address-input" id="village"></select>
            </div>
            <div class="col-md-6">
                <label for="zip">Kode Pos</label>
                <input type="text" class="form-control address-input" id="zip" value="<?= esc($zip ?? '') ?>">
            </div>
        </div>
    </form>
</div>


                                <!-- Password -->
                                <div class="tab-pane fade" id="password">
                                    <?= form_open('profile/updatePassword', ['class' => 'needs-validation', 'novalidate' => true]) ?>
                                    <?= csrf_field() ?>
                                    <div class="row g-3">
                                        <div class="col-md-12">
                                            <label>Password Saat Ini</label>
                                            <input type="password" class="form-control" name="current_password" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Password Baru</label>
                                            <input type="password" class="form-control" name="new_password" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Ulang Password Baru</label>
                                            <input type="password" class="form-control" name="confirm_password" required>
                                        </div>
                                        <div class="col-12 text-end">
                                            <button type="submit" class="btn" style="background-color:#B86C3A;color:#fff;">Simpan</button>
                                        </div>
                                    </div>
                                    <?= form_close() ?>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script Autosave -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function postAutosave(field, value) {
    const userId = $('#user_id').val();
    $.post("<?= base_url('dashboard/user/autosave') ?>", {
        field: field,
        value: value,
        id: userId
    });
}


$('.auto-save').on('change', function () {
    let field = $(this).data('field');
    let value = $(this).val();
    postAutosave(field, value);
});

$('.sosmed-input').on('input', function () {
    let field = $(this).attr('name');
    let value = $(this).val(); // ini bisa kosong

    $.post("<?= base_url('dashboard/user/autosave') ?>", {
        field: field,
        value: value
    });
});


$('.address-input').on('change keyup', function () {
    saveAddress();
});

function saveAddress() {
    let address = [
        $('#street').val(),
        $('#village option:selected').val(),
        $('#district option:selected').val(),
        $('#regency option:selected').val(),
        $('#province option:selected').val(),
        $('#zip').val()
    ].filter(Boolean).join(', ');

    postAutosave('address', address);
}

function loadOptions(url, selector, placeholder, selected = '', callback = null) {
    $.get(url, function(data) {
        data.sort((a, b) => a.name.localeCompare(b.name));
        $(selector).empty().append(`<option value="">${placeholder}</option>`);
        data.forEach(item => {
            const isSelected = selected && item.name.trim().toLowerCase() === selected.trim().toLowerCase();
            $(selector).append(`<option value="${item.name}" ${isSelected ? 'selected' : ''}>${item.name}</option>`);
        });
        if (callback) callback(data); // kirim data jika perlu ID lanjutan
    });
}


// Load Provinsi awal
loadOptions('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json', '#province', 'Pilih Provinsi', "<?= $province ?? '' ?>");

// Event: Provinsi dipilih
$('#province').on('change', function () {
    let id = $('#province option:selected').data('id');
    loadOptions(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${id}.json`, '#regency', 'Pilih Kota/Kabupaten');
    $('#district, #village').empty();
    saveAddress();
});

// Event: Kota/Kabupaten dipilih
$('#regency').on('change', function () {
    let id = $('#regency option:selected').data('id');
    loadOptions(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${id}.json`, '#district', 'Pilih Kecamatan');
    $('#village').empty();
    saveAddress();
});

// Event: Kecamatan dipilih
$('#district').on('change', function () {
    let id = $('#district option:selected').data('id');
    loadOptions(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${id}.json`, '#village', 'Pilih Desa/Kelurahan');
    saveAddress();
});

// Event: Desa/Kelurahan dipilih
$('#village').on('change', function () {
    saveAddress();
});

$(document).ready(function () {
    let selectedProvince = "<?= esc($province ?? '') ?>";
    let selectedRegency  = "<?= esc($regency ?? '') ?>";
    let selectedDistrict = "<?= esc($district ?? '') ?>";
    let selectedVillage  = "<?= esc($village ?? '') ?>";

    loadOptions('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json', '#province', 'Pilih Provinsi', selectedProvince, function(provinces) {
        let selectedProvinceObj = provinces.find(p => p.name.trim().toLowerCase() === selectedProvince.trim().toLowerCase());
        if (selectedProvinceObj) {
            loadOptions(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${selectedProvinceObj.id}.json`, '#regency', 'Pilih Kota/Kabupaten', selectedRegency, function(regencies) {
                let selectedRegencyObj = regencies.find(r => r.name.trim().toLowerCase() === selectedRegency.trim().toLowerCase());
                if (selectedRegencyObj) {
                    loadOptions(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${selectedRegencyObj.id}.json`, '#district', 'Pilih Kecamatan', selectedDistrict, function(districts) {
                        let selectedDistrictObj = districts.find(d => d.name.trim().toLowerCase() === selectedDistrict.trim().toLowerCase());
                        if (selectedDistrictObj) {
                            loadOptions(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${selectedDistrictObj.id}.json`, '#village', 'Pilih Desa/Kelurahan', selectedVillage);
                        }
                    });
                }
            });
        }
    });
});

</script>

<script>
    $('#street').on('input', function () {
        let upper = $(this).val().toUpperCase();
        $(this).val(upper);
    });
</script>



<?= $this->endSection() ?>
