<?= $this->extend('admin/layout/default') ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

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

                    <!-- start button -->
               <div class="row">
                    <div class="col-12">
                    <div class="card">
                         <div class="card-header">
                              <h5 class="card-title">
                                   <a href="<?= base_url('dashboard/property/create') ?>" class="btn btn-primary btn-sm">Add New</a>
                              </h5>
                         </div>

                         <div class="card-body">
                              <div class="table-responsive">
                                   <table class="table table-striped table-borderless table-centered">
                                        <thead class="table-light">
                                             <tr>
                                                  <th scope="col">Name</th>
                                                  <th scope="col">Location</th>
                                                  <th scope="col">Price</th>
                                                  <th scope="col">Description</th>
                                                  <th scope="col">Action</th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                             <tr>
                                                <?php foreach ($properties as $p): ?>
                                                  <td><?= esc($p['title']) ?></td>
                                                  <td><?= esc($p['location']) ?></td>
                                                  <td><?= number_to_currency($p['price'], 'IDR', 'id_ID') ?></td>
                                                  <td><?= esc($p['description']) ?></td>
                                                  <td>
                                                  <a href="<?= base_url('dashboard/property/edit/' . $p['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                                                  <a href="<?= base_url('dashboard/property/delete/' . $p['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>     
                                             </tr>
                                             <?php endforeach ?>
                                        </tbody>
                                   </table>
                              </div>
                         </div>
                    </div>
                    
               </div> <!-- end col -->

          </div>
          <!-- End Container Fluid -->
<?= $this->endSection() ?>