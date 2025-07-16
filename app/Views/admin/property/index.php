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
        <?php if (isset($filterDeveloper)): ?>
          <a href="<?= base_url('dashboard/developer/' . esc($filterDeveloper['slug']) . '/property/create') ?>" class="btn btn-primary">
            Add Property for <?= esc($filterDeveloper['name']) ?>
          </a>
        <?php else: ?>
          <a href="<?= base_url('dashboard/property/create') ?>" class="btn btn-success">
            + Create New Property
          </a>
        <?php endif ?>
      </div>

      <div class="table-responsive">
        <table class="table table-striped table-borderless table-centered">
          <thead class="table-light">
            <tr>
              <th>Image</th>
              <th>Name</th>
              <?php if (!isset($filterDeveloper)): ?>
                <th>Developer</th>
              <?php endif ?>
              <th>Unit Types</th>
              <th>Details</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          <?php if (! empty($properties)): ?>
            <?php foreach($properties as $p): ?>
              <tr>
                <td>
                  <a href="#" data-bs-toggle="modal" data-bs-target="#imagesModal<?= $p['id'] ?>">
                    <img src="<?= esc($p['thumbnail'] ?? base_url('images/placeholder-80x60.png')) ?>"
                         width="80" class="img-thumbnail" alt="Thumbnail">
                  </a>
                </td>
                <td><?= esc($p['title']) ?></td>
                <?php if (!isset($filterDeveloper)): ?>
                  <td><?= esc($p['developer_name'] ?? '-') ?></td>
                <?php endif ?>

                <td>
                  <?php if (!empty($p['units'])): ?>
                    <button 
                      type="button" 
                      class="btn btn-sm btn-primary" 
                      data-bs-toggle="modal" 
                      data-bs-target="#unitModal<?= $p['id'] ?>"
                    >
                      Lihat Tipe Unit
                    </button>
                  <?php else: ?>
                    <em>Tipe unit belum tersedia</em>
                  <?php endif; ?>
                </td>

                <td>
                  <a href="<?= base_url('dashboard/property/detail/' . esc($p['slug'])) ?>" class="btn btn-info btn-sm">
                    Property Details
                  </a>
                </td>

                <td>
                  <?php if (isset($filterDeveloper)): ?>
                    <a href="<?= base_url('dashboard/developer/' . esc($filterDeveloper['slug']) . '/property/' . esc($p['slug']) . '/edit') ?>"
                       class="btn btn-warning btn-sm">Edit</a>
                    <a href="<?= base_url('dashboard/property/delete/' . esc($p['id']) . '?redirect=' . esc($filterDeveloper['slug'])) ?>"
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Are you sure?')">Delete</a>
                  <?php else: ?>
                    <a href="<?= base_url('dashboard/property/edit/' . esc($p['slug'])) ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="<?= base_url('dashboard/property/delete/' . esc($p['id'])) ?>"
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Are you sure?')">Delete</a>
                  <?php endif ?>
                </td>
              </tr>
            <?php endforeach ?>
          <?php else: ?>
            <tr><td colspan="6" class="text-center">No properties found.</td></tr>
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

<!-- Modal Unit & Images: Diletakkan di luar tabel -->

<?php foreach($properties as $p): ?>

<!-- Modal Tipe Unit -->
<div class="modal fade" id="unitModal<?= $p['id'] ?>" tabindex="-1" aria-labelledby="unitModalLabel<?= $p['id'] ?>" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="unitModalLabel<?= $p['id'] ?>">Detail Tipe Unit - <?= esc($p['title']) ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <?php if (!empty($p['units'])): ?>
          <div class="table-responsive">
            <table class="table table-dark table-bordered table-hover table-sm mb-0">
              <thead>
                <tr>
                  <th>Nama Unit</th>
                  <th>Tipe</th>
                  <th>L. Bangunan</th>
                  <th>L. Tanah</th>
                  <th>Lantai</th>
                  <th>Kamar</th>
                  <th>Carport</th>
                  <th>Lift</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($p['units'] as $unit): ?>
                  <tr>
                    <td><?= esc($unit['name_unit']) ?></td>
                    <td><?= esc($unit['type_unit']) ?></td>
                    <td><?= esc($unit['building_area']) ?> m²</td>
                    <td><?= esc($unit['land_area']) ?> m²</td>
                    <td><?= esc($unit['floors']) ?></td>
                    <td><?= esc($unit['bedrooms']) ?> / <?= esc($unit['bathrooms']) ?></td>
                    <td><?= $unit['carport'] ? 'Ya' : 'Tidak' ?></td>
                    <td><?= $unit['elevator'] ? 'Ya' : 'Tidak' ?></td>
                  </tr>
                <?php endforeach ?>
              </tbody>
            </table>
          </div>
        <?php else: ?>
          <p class="text-muted mb-0">Belum ada tipe unit untuk properti ini.</p>
        <?php endif ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Images -->
<div class="modal fade" id="imagesModal<?= $p['id'] ?>" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Gallery: <?= esc($p['title']) ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php if (! empty($p['images'])): ?>
          <div id="carousel<?= $p['id'] ?>" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
              <?php foreach($p['images'] as $i => $img): ?>
                <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
                  <img src="<?= esc($img) ?>" class="d-block mx-auto" style="max-height:400px; object-fit:contain;" alt="Image <?= $i+1 ?>">
                </div>
              <?php endforeach ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carousel<?= $p['id'] ?>" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carousel<?= $p['id'] ?>" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
        <?php else: ?>
          <p class="text-center text-muted">No images available.</p>
        <?php endif ?>
      </div>
    </div>
  </div>
</div>

<?php endforeach ?>

<?= $this->endSection() ?>
