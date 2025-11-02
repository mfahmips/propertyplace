<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="mb-0"><?= esc($title) ?></h4>
                <ol class="breadcrumb mb-0">
                    <?php foreach ($breadcrumb as $item) : ?>
                        <li class="breadcrumb-item"><?= isset($item['url']) ? '<a href="'.$item['url'].'">'.esc($item['label']).'</a>' : esc($item['label']) ?></li>
                    <?php endforeach ?>
                </ol>
            </div>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif ?>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header bg-transparent d-flex align-items-center">
                    <h5 class="card-title mb-0">Profil Saya</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Sidebar -->
                        <div class="col-sm-3 mb-3 mb-sm-0">
                            <div class="nav flex-column nav-pills" id="profile-tab" role="tablist">
                                <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#info">Informasi Akun</button>
                                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#address">Alamat</button>
                                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#sosmed">Media Sosial</button>
                                
                                <?php if (session('role') === 'admin'): ?>
                                  <button class="nav-link" data-bs-toggle="pill" data-bs-target="#password">Ubah Password</button>
                                <?php endif; ?>

                            </div>
                        </div>

                        <!-- Content -->
                        <div class="col-sm-9">
                            <div class="tab-content">

                                <!-- Informasi Akun -->
                                <div class="tab-pane fade show active" id="info">
                                    <div class="row align-items-center mb-4">
                                        <div class="col-md-4 text-center">
                                            <?php
                                                $foto = $user['foto'] ?? '';
                                                $gender = strtolower($user['gender'] ?? '');

                                                if (empty($foto)) {
                                                    if ($gender === 'laki-laki') {
                                                        $foto = 'Laki-laki.jpg';
                                                    } elseif ($gender === 'perempuan') {
                                                        $foto = 'Perempuan.jpg';
                                                    } else {
                                                        $foto = 'default-avatar.png'; // fallback
                                                    }
                                                }

                                                $fotoUrl = base_url('uploads/user/' . $foto);
                                            ?>
                                            <img src="<?= $fotoUrl ?>" class="rounded-circle mb-2" width="100" height="100" style="object-fit: cover;">
                                        </div>

                                        <div class="col-md-8">
                                            <label class="form-label">Foto</label>
                                            <form action="<?= base_url('dashboard/user/update/' . session('id')) ?>" method="post" enctype="multipart/form-data">
                                                <?= csrf_field() ?>
                                                <input type="hidden" id="user_id" value="<?= $user['id'] ?>">
                                                <input type="file" class="form-control mb-2" name="foto" accept="image/*">
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


                                <!-- Media Sosial -->
                                <div class="tab-pane fade" id="sosmed">
                                    <div class="row g-3">

                                        <!-- Facebook -->
                                        <div class="col-md-4">
                                            <label for="facebook" class="form-label">Facebook</label>
                                            <div class="input-group">
                                                <input 
                                                    type="text" 
                                                    class="form-control sosmed-input" 
                                                    id="facebook" 
                                                    name="facebook" 
                                                    value="<?= esc($user['facebook']) ?>" 
                                                    placeholder="Username"
                                                >
                                                <button 
                                                    class="btn btn-outline-secondary open-social" 
                                                    type="button" 
                                                    data-platform="facebook" 
                                                    title="Lihat profil Facebook"
                                                >
                                                    <i class="bi bi-link-45deg"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Instagram -->
                                        <div class="col-md-4">
                                            <label for="instagram" class="form-label">Instagram</label>
                                            <div class="input-group">
                                                <input 
                                                    type="text" 
                                                    class="form-control sosmed-input" 
                                                    id="instagram" 
                                                    name="instagram" 
                                                    value="<?= esc($user['instagram']) ?>" 
                                                    placeholder="Username"
                                                >
                                                <button 
                                                    class="btn btn-outline-secondary open-social" 
                                                    type="button" 
                                                    data-platform="instagram" 
                                                    title="Lihat profil Instagram"
                                                >
                                                    <i class="bi bi-link-45deg"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- TikTok -->
                                        <div class="col-md-4">
                                            <label for="tiktok" class="form-label">TikTok</label>
                                            <div class="input-group">
                                                <input 
                                                    type="text" 
                                                    class="form-control sosmed-input" 
                                                    id="tiktok" 
                                                    name="tiktok" 
                                                    value="<?= esc($user['tiktok']) ?>" 
                                                    placeholder="Username"
                                                >
                                                <button 
                                                    class="btn btn-outline-secondary open-social" 
                                                    type="button" 
                                                    data-platform="tiktok" 
                                                    title="Lihat profil TikTok"
                                                >
                                                    <i class="bi bi-link-45deg"></i>
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                </div>


                                <!-- Password -->
                                <div class="tab-pane fade" id="password">
                                    <?= form_open('profile/updatePassword', ['class' => 'needs-validation', 'novalidate' => true]) ?>
                                    <?= csrf_field() ?>
                                    <div class="row g-3">

                                        <!-- Password Saat Ini -->
                                        <div class="col-md-12">
                                            <label for="current_password">Password Saat Ini</label>
                                            <div class="input-group">
                                                <input 
                                                    type="password" 
                                                    class="form-control" 
                                                    name="current_password" 
                                                    id="current_password" 
                                                    required
                                                >
                                                <button 
                                                    class="btn btn-outline-secondary toggle-password" 
                                                    type="button" 
                                                    data-target="current_password"
                                                    title="Lihat / Sembunyikan Password"
                                                >
                                                    <i class="bi bi-eye-slash"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Password Baru -->
                                        <div class="col-md-12">
                                            <label for="new_password">Password Baru</label>
                                            <div class="input-group">
                                                <input 
                                                    type="password" 
                                                    class="form-control" 
                                                    name="new_password" 
                                                    id="new_password" 
                                                    required
                                                >
                                                <button 
                                                    class="btn btn-outline-secondary toggle-password" 
                                                    type="button" 
                                                    data-target="new_password"
                                                    title="Lihat / Sembunyikan Password"
                                                >
                                                    <i class="bi bi-eye-slash"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Ulang Password Baru -->
                                        <div class="col-md-12">
                                            <label for="confirm_password">Ulang Password Baru</label>
                                            <div class="input-group">
                                                <input 
                                                    type="password" 
                                                    class="form-control" 
                                                    name="confirm_password" 
                                                    id="confirm_password" 
                                                    required
                                                >
                                                <button 
                                                    class="btn btn-outline-secondary toggle-password" 
                                                    type="button" 
                                                    data-target="confirm_password"
                                                    title="Lihat / Sembunyikan Password"
                                                >
                                                    <i class="bi bi-eye-slash"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Tombol Simpan -->
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

<!-- JQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">


<script>
document.querySelectorAll('.open-social').forEach(button => {
    button.addEventListener('click', () => {
        const platform = button.getAttribute('data-platform');
        const input = document.getElementById(platform);
        const username = input.value.trim();

        if (!username) {
            input.classList.add('is-invalid');
            setTimeout(() => input.classList.remove('is-invalid'), 800);
            return;
        }

        let url = '';
        switch (platform) {
            case 'facebook':
                url = `https://facebook.com/${username}`;
                break;
            case 'instagram':
                url = `https://instagram.com/${username}`;
                break;
            case 'tiktok':
                url = `https://tiktok.com/@${username}`;
                break;
        }

        window.open(url, '_blank');
    });
});
</script>


<!-- Toggle Password Visibility Script -->
<script>
document.querySelectorAll('.toggle-password').forEach(btn => {
    btn.addEventListener('click', () => {
        const inputId = btn.getAttribute('data-target');
        const input = document.getElementById(inputId);
        const icon = btn.querySelector('i');

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        } else {
            input.type = 'password';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        }
    });
});
</script>



<script>
function postAutosave(field, value) {
    const userId = $('#user_id').val();
    $.post("<?= base_url('dashboard/user/autosave') ?>", {
        field: field,
        value: value,
        id: userId
    });
}

// Autosave umum
$('.auto-save').on('change', function () {
    postAutosave($(this).data('field'), $(this).val());
});

// Autosave Sosial Media
$('.sosmed-input').on('input', function () {
    postAutosave($(this).attr('name'), $(this).val());
});

// Autosave Alamat
$('.address-input').on('change keyup', function () {
    saveAddress();
});

function saveAddress() {
    let address = [
        $('#street').val(),
        $('#village option:selected').text(),
        $('#district option:selected').text(),
        $('#regency option:selected').text(),
        $('#province option:selected').text(),
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
            $(selector).append(`<option value="${item.id}" ${isSelected ? 'selected' : ''}>${item.name}</option>`);
        });
        if (callback) callback(data);
    });
}

// Initial load saat halaman dibuka
$(document).ready(function () {
    const selectedProvince = "<?= esc($province ?? '') ?>";
    const selectedRegency  = "<?= esc($regency ?? '') ?>";
    const selectedDistrict = "<?= esc($district ?? '') ?>";
    const selectedVillage  = "<?= esc($village ?? '') ?>";

    loadOptions('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json', '#province', 'Pilih Provinsi', selectedProvince, function(provinces) {
        const province = provinces.find(p => p.name.toLowerCase() === selectedProvince.toLowerCase());
        if (province) {
            loadOptions(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${province.id}.json`, '#regency', 'Pilih Kota/Kabupaten', selectedRegency, function(regencies) {
                const regency = regencies.find(r => r.name.toLowerCase() === selectedRegency.toLowerCase());
                if (regency) {
                    loadOptions(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${regency.id}.json`, '#district', 'Pilih Kecamatan', selectedDistrict, function(districts) {
                        const district = districts.find(d => d.name.toLowerCase() === selectedDistrict.toLowerCase());
                        if (district) {
                            loadOptions(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${district.id}.json`, '#village', 'Pilih Desa/Kelurahan', selectedVillage);
                        }
                    });
                }
            });
        }
    });
});

// Chain events
$('#province').on('change', function () {
    const provinceId = $(this).val();
    if (provinceId) {
        loadOptions(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provinceId}.json`, '#regency', 'Pilih Kota/Kabupaten');
        $('#district, #village').empty().append('<option value="">-</option>');
        saveAddress();
    }
});

$('#regency').on('change', function () {
    const regencyId = $(this).val();
    if (regencyId) {
        loadOptions(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${regencyId}.json`, '#district', 'Pilih Kecamatan');
        $('#village').empty().append('<option value="">-</option>');
        saveAddress();
    }
});

$('#district').on('change', function () {
    const districtId = $(this).val();
    if (districtId) {
        loadOptions(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${districtId}.json`, '#village', 'Pilih Desa/Kelurahan');
        saveAddress();
    }
});

$('#village').on('change', function () {
    saveAddress();
});
</script>

<!-- Uppercase Otomatis untuk Nama Jalan -->
<script>
    $('#street').on('input', function () {
        $(this).val($(this).val().toUpperCase());
    });
</script>




<?= $this->endSection() ?>
