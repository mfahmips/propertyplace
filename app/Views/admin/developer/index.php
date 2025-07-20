<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

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

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createDeveloperModal">
              + Add Developer
          </button>
        </div>

        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped table-borderless table-centered">
              <thead class="table-light">
                <tr>
                  <th>Logo</th>
                  <th>Name</th>
                  <th>Property</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($devs as $d): ?>
                <tr>
                  <td>
                    <?php if (!empty($d['logo'])): ?>
                      <div style="background: #fff; padding: 5px; border-radius: 8px; display: inline-block; border: 1px solid #ddd;">
                        <img src="<?= base_url('uploads/developer/' . esc($d['logo'])) ?>" 
                             style="height:50px; width:auto; object-fit:contain; display:block;">
                      </div>
                    <?php else: ?>
                      <span class="text-muted">No Logo</span>
                    <?php endif; ?>
                  </td>

                  <td>
                    <a href="<?= base_url('dashboard/developer/' . esc($d['slug']) . '/property') ?>"
                       data-bs-toggle="tooltip"
                       data-bs-placement="top"
                       title="View property <?= esc($d['name']) ?>">
                      <?= esc($d['name']) ?>
                    </a>
                  </td>



                  <td>
                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#propertyModal<?= $d['id'] ?>">
                      View Properties
                    </button>
                  </td>

                  <td>
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editDeveloperModal<?= $d['id'] ?>">Edit</button>
                    <a href="<?= base_url('dashboard/developer/delete/' . $d['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this developer?')">Delete</a>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>

          <?php foreach ($devs as $d): ?>

          <!-- MODAL VIEW PROPERTIES -->
          <div class="modal fade" id="propertyModal<?= $d['id'] ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Properties of <?= esc($d['name']) ?></h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                  <?php if (!empty($d['properties'])): ?>
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>Title</th>
                          <th>Location</th>
                          <th>Price</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($d['properties'] as $p): ?>
                        <tr>
                          <td><?= esc($p['title']) ?></td>
                          <td><?= esc($p['location']) ?></td>
                          <td>Start: <?= esc($p['price_text']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  <?php else: ?>
                    <p class="text-muted">No properties found for this developer.</p>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>

          <!-- MODAL EDIT DEVELOPER -->
          <div class="modal fade" id="editDeveloperModal<?= $d['id'] ?>" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
              <div class="modal-content">
                <form action="<?= base_url('dashboard/developer/update/' . $d['id']) ?>" method="post" enctype="multipart/form-data">
                  <?= csrf_field() ?>
                  <div class="modal-header">
                    <h5 class="modal-title">Edit Developer: <?= esc($d['name']) ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>

                  <div class="modal-body">
                    <div class="mb-3">
                      <label class="form-label">Name</label>
                      <input type="text" name="name" class="form-control" value="<?= esc($d['name']) ?>" required>
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Logo <small>(leave blank to keep current)</small></label>
                      <input type="file" name="logo" class="form-control" accept="image/*">
                    </div>

                    <?php if (!empty($d['logo'])): ?>
                    <div style="background: #fff; padding: 5px; border-radius: 8px; display: inline-block; border: 1px solid #ddd;">
                        <img src="<?= base_url('uploads/developer/' . esc($d['logo'])) ?>" 
                             style="height:50px; width:auto; object-fit:contain; display:block;">
                      </div>
                    <?php endif; ?>
                  </div>

                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                  </div>

                </form>
              </div>
            </div>
          </div>

          <?php endforeach; ?>


          <!-- Pagination -->
          <div class="d-flex justify-content-center mt-4">
            <?= $pager->links('developers', 'bootstrap') ?>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<!-- MODAL CREATE DEVELOPER -->
<div class="modal fade" id="createDeveloperModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-md modal-dialog-centered">
    <div class="modal-content">
      <form action="<?= base_url('dashboard/developer/store') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="modal-header">
          <h5 class="modal-title">Create Developer</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Logo</label>
            <input type="file" name="logo" class="form-control" accept="image/*" required>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>

      </form>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
