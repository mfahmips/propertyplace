<?= $this->extend('admin/layout/default') ?>

<?= $this->section('content') ?>

<!-- Start Container Fluid -->
        <div class="container-fluid">

        <!-- ========== Page Title Start ========== -->
        <div class="row">
            <div class="col-12">
            <div class="page-title-box">
                    <h4 class="mb-0"><?= $title ?></h4>
                    <ol class="breadcrumb mb-0">
                        <?php foreach ($breadcrumb as $item) : ?>
                            <?php if (isset($item['url'])) : ?>
                                <li class="breadcrumb-item"><a href="<?= $item['url'] ?>"><?= $item['label'] ?></a></li>
                            <?php else : ?>
                                <li class="breadcrumb-item active"><?= $item['label'] ?></li>
                            <?php endif ?>
                        <?php endforeach ?>
                        </ol>
            </div>
            </div>
        </div>

         <div class="row row-cols-lg-2 gx-3">
                         <div class="col">
                              <div class="card">
                                  

                                   <div class="card-body">
                                        <div>
                                             <div>
                                                <form action="<?= base_url('dashboard/property/store') ?>" method="post">
                                                  <div class="mb-3">
                                                       <label for="simpleinput" class="form-label">Name</label>
                                                       <input type="text" name="title" class="form-control">
                                                  </div>

                                                  <div class="mb-3">
                                                       <label for="example-email" class="form-label">Location</label>
                                                       <input type="text" name="location" class="form-control">
                                                  </div>

                                                  <div class="mb-3">
                                                       <label for="example-password" class="form-label">Price</label>
                                                       <input type="number" name="price" class="form-control">
                                                  </div>
                                                  <div class="mb-3">
                                                       <label for="example-textarea" class="form-label">Description</label>
                                                       <textarea name="description" class="form-control" rows="5"></textarea>
                                                  </div>
                                                  <button class="btn btn-primary">Save</button>
                                                </form>

                                                <?= $this->endSection() ?>
                                             </div>
                                        </div>
                                   </div>
                              </div>
