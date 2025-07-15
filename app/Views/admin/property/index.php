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
      <?php if (isset($filterDeveloper)): ?>
        <div class="justify-content mb-3">
          <a href="<?= base_url('dashboard/property/developer/'.$filterDeveloper['slug'].'/create') ?>"
             class="btn btn-primary">
            Add Property for <?= esc($filterDeveloper['name']) ?>
          </a>
        </div>
      <?php else: ?>
        <div class="justify-content mb-3">
          <a href="<?= base_url('dashboard/property/create') ?>" class="btn btn-success">
            + Create New Property
          </a>
        </div>
      <?php endif ?>


      <div class="table-responsive">
        <table class="table table-striped table-borderless table-centered">
          <thead class="table-light">
            <tr>
              <th>Image</th>
              <th>Name</th>
              <?php if (!isset($filterDeveloper)): ?>
                <th>Developer</th>
              <?php endif ?>
              <th>Details</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if (! empty($properties)): ?>
              <?php foreach($properties as $p): ?>
                <tr>
                  <td>
                    <!-- Thumbnail as modal trigger -->
                    <a href="#" data-bs-toggle="modal"
                       data-bs-target="#imagesModal<?= $p['id'] ?>">
                      <img
                          src="<?= esc($p['thumbnail'] ?? base_url('images/placeholder-80x60.png')) ?>"
                          width="80"
                          class="img-thumbnail"
                          alt="Thumbnail">

                    </a>
                  </td>
                  <td><?= esc($p['title']) ?></td>
                  <?php if (!isset($filterDeveloper)): ?>
                    <td><?= esc($p['developer_name'] ?? '-') ?></td>
                  <?php endif ?>
                  
                  <td>
                    <a href="<?= base_url('dashboard/property/detail/' . esc($p['slug'])) ?>"class="btn btn-info btn-sm">Property Details</a>
                    </td>
                  <td>
                      <?php if (! empty($filterDeveloper)): ?>
                        <!-- Edit via developer context -->
                        <a href="<?= base_url('dashboard/property/developer/'
                                 . esc($filterDeveloper['slug'])
                                 . '/edit/' . esc($p['slug'])) ?>"
                           class="btn btn-warning btn-sm">
                          Edit
                        </a>
                      <?php else: ?>
                        <!-- Edit global property -->
                        <a href="<?= base_url('dashboard/property/edit/'
                                 . esc($p['slug'])) ?>"
                           class="btn btn-warning btn-sm">
                          Edit
                        </a>
                      <?php endif ?>

                      <!-- tombol Delete tetap sama -->
                      <a href="<?= base_url('dashboard/property/delete/'
                               . esc($p['id'])) ?>"
                         class="btn btn-danger btn-sm"
                         onclick="return confirm('Are you sure?')">
                        Delete
                      </a>
                  </td>
                </tr>

                <!-- Modal for this property’s images -->
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
                                   <img 
                                    src="<?= esc($img) ?>" 
                                    class="d-block mx-auto" 
                                    style="max-height:400px; object-fit:contain;" 
                                    alt="Image <?= $i+1 ?>">
                                </div>
                              <?php endforeach ?>
                            </div>
                            <button class="carousel-control-prev" type="button"
                                    data-bs-target="#carousel<?= $p['id'] ?>" data-bs-slide="prev">
                              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                              <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button"
                                    data-bs-target="#carousel<?= $p['id'] ?>" data-bs-slide="next">
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
                <!-- End Modal -->

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

<?= $this->endSection() ?>
