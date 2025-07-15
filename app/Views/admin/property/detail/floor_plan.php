<?= $this->extend('admin/layout/default') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
  <div class="page-title-box">
    <h4 class="mb-0"><?= esc($title) ?></h4>
    <ol class="breadcrumb mb-0">
      <?php foreach ($breadcrumb as $item): ?>
        <li class="breadcrumb-item<?= isset($item['url']) ? '' : ' active' ?>">
          <?php if (isset($item['url'])): ?>
            <a href="<?= esc($item['url']) ?>"><?= esc($item['label']) ?></a>
          <?php else: ?>
            <?= esc($item['label']) ?>
          <?php endif ?>
        </li>
      <?php endforeach ?>
    </ol>
  </div>

  <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
  <?php endif ?>
  <?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger">
      <ul>
        <?php foreach (session()->getFlashdata('errors') as $err): ?>
          <li><?= esc($err) ?></li>
        <?php endforeach ?>
      </ul>
    </div>
  <?php endif ?>

  <div class="card">
    <div class="card-body">
      <form action="<?= base_url('dashboard/property/floor-plan/store/' . $property['id']) ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= old('id', $editPlan['id'] ?? '') ?>">
        <div class="mb-3">
          <label class="form-label">Name / Floor</label>
          <select name="name" class="form-select" required>
            <option value="">-- Select Floor --</option>
            <?php foreach (["First Floor", "Second Floor", "Third Floor", "Top Garden"] as $floor): ?>
              <option value="<?= $floor ?>" <?= isset($editPlan['name']) && $editPlan['name'] === $floor ? 'selected' : '' ?>>
                <?= $floor ?>
              </option>
            <?php endforeach ?>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Image (PNG/JPG, max 2MB)</label>
          <input type="file" name="image" accept="image/*" class="form-control" <?= isset($editPlan) ? '' : 'required' ?>>
          <?php if (!empty($editPlan['image'])): ?>
            <img src="<?= base_url('uploads/floorplan/' . $editPlan['image']) ?>" class="img-fluid mt-2" style="max-height: 150px">
          <?php endif ?>
        </div>

        <div class="mb-3">
          <label class="form-label">Description</label>
          <textarea name="description" rows="4" class="form-control" placeholder="Optional..."><?= old('description', $editPlan['description'] ?? '') ?></textarea>
        </div>

        <button class="btn btn-primary"><?= isset($editPlan) ? 'Update' : 'Add' ?> Floor Plan</button>
        <?php if (isset($editPlan)): ?>
          <a href="<?= base_url('dashboard/property/floor-plan/' . $property['id']) ?>" class="btn btn-secondary">Cancel</a>
        <?php endif ?>
      </form>
    </div>
  </div>

  <hr class="my-4">

  <h5>Existing Floor Plans</h5>
  <div class="row">
    <?php if (!empty($floorPlans)): ?>
      <?php foreach ($floorPlans as $plan): ?>
        <div class="col-md-3 mb-4">
          <div class="card h-100">
            <img src="<?= base_url('uploads/floorplan/' . $plan['image']) ?>" class="card-img-top" alt="<?= esc($plan['name']) ?>">
            <div class="card-body">
              <h6 class="card-title"><?= esc($plan['name']) ?></h6>
              <p class="card-text text-muted small"><?= esc($plan['description']) ?></p>
              <a href="<?= base_url('dashboard/property/floor-plan/edit/' . $property['id'] . '/' . $plan['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
              <form action="<?= base_url('dashboard/property/floor-plan/delete/' . $plan['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Delete this floor plan?')">
                <button class="btn btn-sm btn-danger">Delete</button>
              </form>
            </div>
          </div>
        </div>
      <?php endforeach ?>
    <?php else: ?>
      <p class="text-muted">No floor plans uploaded yet.</p>
    <?php endif ?>
  </div>
</div>

<?= $this->endSection() ?>
