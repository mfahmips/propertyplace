<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
  <div class="page-title-box">
    <h4 class="mb-0"><?= esc($title) ?></h4>
    <ol class="breadcrumb mb-0">
      <?php foreach($breadcrumb as $item): ?>
        <li class="breadcrumb-item<?= isset($item['url']) ? '' : ' active' ?>">
          <?php if(isset($item['url'])): ?>
            <a href="<?= esc($item['url']) ?>"><?= esc($item['label']) ?></a>
          <?php else: ?>
            <?= esc($item['label']) ?>
          <?php endif ?>
        </li>
      <?php endforeach ?>
    </ol>
  </div>

  <div class="card">
    <div class="card-body">

      <div class="mb-3">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createPropertyModal">
          + Create Property for <?= esc($filterDeveloper['name']) ?>
        </button>
      </div>

      <div class="table-responsive">
        <table class="table table-striped table-borderless">
          <thead class="table-light">
            <tr>
              <th>Image</th>
              <th>Name</th>
              <th>Details</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
          <?php if (!empty($properties)): ?>
            <?php foreach($properties as $p): ?>
              <tr>
                 <td>
                  <a href="#" data-bs-toggle="modal" data-bs-target="#imagesModal<?= $p['id'] ?>">
                    <img src="<?= esc($p['thumbnail'] ?? base_url('images/placeholder-80x60.png')) ?>"
                         width="80" class="img-thumbnail" alt="Thumbnail">
                  </a>
                </td>
                <td><?= esc($p['title']) ?></td>
                <td>
                  <a href="<?= base_url('dashboard/developer/' . esc($filterDeveloper['slug']) . '/property/' . esc($p['slug']) . '/detail') ?>" 
                     class="btn btn-sm btn-secondary">
                     Details
                  </a>

                </td>
                <td>
                  <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editPropertyModal<?= $p['id'] ?>">Edit</button>
                  <a href="<?= base_url('dashboard/developer/' . esc($filterDeveloper['slug']) . '/property/' . esc($p['id']) . '/delete') ?>" 
                     class="btn btn-sm btn-danger"
                     onclick="return confirm('Delete this property?')">
                     Delete
                  </a>

                </td>
              </tr>
            <?php endforeach ?>
          <?php else: ?>
            <tr><td colspan="5" class="text-center">No property found.</td></tr>
          <?php endif ?>
          </tbody>
        </table>

        <div class="d-flex justify-content-center mt-4">
          <?= $pager->links() ?>
        </div>

      </div>
    </div>
  </div>
</div>

<!-- MODAL CREATE PROPERTY -->
<div class="modal fade" id="createPropertyModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form action="<?= base_url('dashboard/developer/' . esc($filterDeveloper['slug']) . '/property/store') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="modal-header">
          <h5 class="modal-title">Create Property for <?= esc($filterDeveloper['name']) ?></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">

          <input type="hidden" name="developer_id" value="<?= esc($filterDeveloper['id']) ?>">

          <div class="row">
            <div class="col-md-4 mb-3">
              <label class="form-label">Title</label>
              <input type="text" name="title" class="form-control" required>
            </div>

            <div class="col-md-4 mb-3">
              <label class="form-label">Price</label>
              <input type="text" id="create_price_display" class="form-control" placeholder="Rp. 0">
              <input type="hidden" name="price" id="create_price">
              <input type="hidden" name="price_text" id="create_price_text">
            </div>

            <div class="col-md-4 mb-3">
              <label class="form-label">Location</label>
              <select name="location" class="form-select" required>
                <option value="">-- Pilih Lokasi --</option>
                <option value="Jakarta">Jakarta</option>
                <option value="Bogor">Bogor</option>
                <option value="Depok">Depok</option>
                <option value="Tangerang">Tangerang</option>
                <option value="Bekasi">Bekasi</option>
              </select>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4"></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">Upload Images</label>
            <input type="file" name="images[]" id="create_imageInput" class="form-control" multiple>
            <div class="row mt-2" id="create_previewContainer"></div>
            <small class="text-muted">Maksimal 10 gambar.</small>
          </div>

        </div>

        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button class="btn btn-primary">Save</button>
        </div>

      </form>
    </div>
  </div>
</div>

<?php foreach($properties as $p): ?>
<div class="modal fade" id="editPropertyModal<?= $p['id'] ?>" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form action="<?= base_url('dashboard/developer/' . esc($filterDeveloper['slug']) . '/property/' . esc($p['slug']) . '/update') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="modal-header">
          <h5 class="modal-title">Edit Property: <?= esc($p['title']) ?></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" name="developer_id" value="<?= esc($filterDeveloper['id']) ?>">

          <div class="row">
            <div class="col-md-4">
              <label class="form-label">Title</label>
              <input type="text" name="title" class="form-control" value="<?= esc($p['title']) ?>" required>
            </div>

            <div class="col-md-4">
              <label class="form-label">Price</label>
              <input type="text" id="edit_price_display<?= $p['id'] ?>" class="form-control" value="<?= number_format($p['price'], 0, ',', '.') ?>" required>
              <input type="hidden" name="price" id="edit_price<?= $p['id'] ?>" value="<?= $p['price'] ?>">
              <input type="hidden" name="price_text" id="edit_price_text<?= $p['id'] ?>" value="<?= $p['price_text'] ?>">
            </div>

            <div class="col-md-4">
              <label class="form-label">Location</label>
              <select name="location" class="form-select" required>
                <?php 
                  $locations = ['Jakarta', 'Bogor', 'Depok', 'Tangerang', 'Bekasi'];
                  foreach($locations as $loc): 
                ?>
                  <option value="<?= $loc ?>" <?= $p['location'] == $loc ? 'selected' : '' ?>><?= $loc ?></option>
                <?php endforeach ?>
              </select>
            </div>
          </div>

          <div class="mt-3 mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4"><?= esc($p['description']) ?></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">Upload Additional Images</label>
            <input type="file" name="images[]" id="edit_imageInput<?= $p['id'] ?>" class="form-control" multiple>
            <div class="row mt-2" id="edit_previewContainer<?= $p['id'] ?>"></div>
          </div>

          <?php if (!empty($p['images'])): ?>
          <div class="mb-3">
            <label class="form-label">Existing Images:</label>
            <div class="row">
              <?php foreach($p['images'] as $img): ?>
             <div class="col-3 mb-2">
                <div class="image-hover-wrapper">
                  <img src="<?= base_url('uploads/property/' . esc($img['filename'])) ?>" alt="Image" class="img-thumbnail">

                  <a href="<?= base_url('dashboard/developer/' . esc($filterDeveloper['slug']) . '/property/image/' . esc($img['id']) . '/delete') ?>"
                     class="delete-overlay-btn"
                     onclick="return confirm('Are you sure you want to delete this image?')">
                     Delete
                  </a>
                </div>
              </div>
              <?php endforeach; ?>
            </div>
          </div>
          <?php endif; ?>

        </div>

        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button class="btn btn-primary">Update</button>
        </div>

      </form>
    </div>
  </div>
</div>
<?php endforeach; ?>



<!-- MODAL GALLERY -->
<?php foreach($properties as $p): ?>
<div class="modal fade" id="imagesModal<?= $p['id'] ?>" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Gallery: <?= esc($p['title']) ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">

        <?php if (!empty($p['images'])): ?>
          <div id="carousel<?= $p['id'] ?>" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
              <?php foreach($p['images'] as $i => $img): ?>
                <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
                  <img src="<?= base_url('uploads/property/' . esc($img['filename'])) ?>"
                       class="d-block mx-auto img-fluid"
                       style="max-width:100%; max-height:80vh; object-fit:contain;"
                       alt="Image <?= $i+1 ?>">
                </div>
              <?php endforeach; ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carousel<?= $p['id'] ?>" data-bs-slide="prev">
              <span class="carousel-control-prev-icon"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carousel<?= $p['id'] ?>" data-bs-slide="next">
              <span class="carousel-control-next-icon"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
        <?php else: ?>
          <p class="text-muted">No images available.</p>
        <?php endif; ?>

      </div>
    </div>
  </div>
</div>
<?php endforeach; ?>


<script>
function formatPriceText(n) {
    if (n >= 1_000_000_000) return (n / 1_000_000_000).toFixed(1).replace(/\.0$/, '') + ' M';
    if (n >= 1_000_000) return (n / 1_000_000).toFixed(1).replace(/\.0$/, '') + ' Juta';
    if (n >= 1_000) return (n / 1_000).toFixed(1).replace(/\.0$/, '') + ' Ribu';
    return n.toString();
}

function bindPriceInput(displayId, hiddenId, textId) {
    const display = document.getElementById(displayId);
    const hidden  = document.getElementById(hiddenId);
    const text    = document.getElementById(textId);

    display.addEventListener('input', function() {
        let val = this.value.replace(/\./g, '').replace(/[^0-9]/g, '');
        let n = parseInt(val) || 0;

        hidden.value = n;
        text.value = formatPriceText(n);
        this.value = n.toLocaleString('id-ID');
    });
}

function bindImagePreview(inputId, containerId) {
    document.getElementById(inputId).addEventListener('change', e => {
        let container = document.getElementById(containerId);
        container.innerHTML = '';

        for (let f of e.target.files) {
            if (f.type.startsWith('image/')) {
                let r = new FileReader();
                r.onload = e => {
                    container.innerHTML += `<div class="col-3 mb-2"><img src="${e.target.result}" class="img-thumbnail"></div>`;
                };
                r.readAsDataURL(f);
            }
        }
    });
}

bindPriceInput('create_price_display', 'create_price', 'create_price_text');
bindImagePreview('create_imageInput', 'create_previewContainer');

<?php foreach($properties as $p): ?>
bindPriceInput('edit_price_display<?= $p['id'] ?>', 'edit_price<?= $p['id'] ?>', 'edit_price_text<?= $p['id'] ?>');
bindImagePreview('edit_imageInput<?= $p['id'] ?>', 'edit_previewContainer<?= $p['id'] ?>');
<?php endforeach; ?>
</script>

<style>
.image-hover-wrapper {
    position: relative;
    overflow: hidden;
    border-radius: 8px;
}

.image-hover-wrapper img {
    width: 100%;
    height: auto;
    display: block;
    transition: filter 0.3s ease;
    border-radius: 8px;
}

/* Redupkan gambar saat hover */
.image-hover-wrapper:hover img {
    filter: brightness(50%);
}

/* Tombol Delete overlay */
.delete-overlay-btn {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: rgba(255, 77, 77, 0.15); /* Soft red */
    border: 1px solid #ff4d4d;           /* Red border */
    color: #ff4d4d;
    padding: 8px 20px;
    font-size: 14px;
    border-radius: 8px;
    box-shadow: 0 0 8px rgba(255, 77, 77, 0.5);
    opacity: 0;
    transition: all 0.3s ease;
    text-decoration: none;
}

/* Munculkan tombol saat hover */
.image-hover-wrapper:hover .delete-overlay-btn {
    opacity: 1;
}

/* Efek hover di tombol */
.delete-overlay-btn:hover {
    background: rgba(255, 77, 77, 0.3);
    color: #fff;
    box-shadow: 0 0 12px rgba(255, 77, 77, 0.8);
}

</style>


<?= $this->endSection() ?>
