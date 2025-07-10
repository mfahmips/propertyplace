<?= $this->extend('frontend/layout/default') ?>

<?= $this->section('content') ?>


    <section class="space-top space-extra-bottom">
        <div class="container">
            <ul class="nav nav-tabs property-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="rent-tab" data-bs-toggle="tab" data-bs-target="#rent-tab-pane" type="button" role="tab" aria-controls="rent-tab-pane" aria-selected="true">Rent</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="buy-tab" data-bs-toggle="tab" data-bs-target="#buy-tab-pane" type="button" role="tab" aria-controls="buy-tab-pane" aria-selected="false">Buy</button>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="rent-tab-pane" role="tabpanel" aria-labelledby="rent-tab" tabindex="0">
                    <form method="get" class="property-search-form">
                        <label>Property Search</label>
                        <div class="form-group">
                            <i class="far fa-search"></i>
                            <input class="form-control" type="text" name="location" placeholder="Cari lokasi" value="<?= esc($active_location) ?>">
                        </div>
                        <select class="form-select" name="developer">
                            <option value="">Pilih Developer</option>
                            <?php foreach ($developers as $dev): ?>
                                <option value="<?= $dev['id'] ?>" <?= $active_developer == $dev['id'] ? 'selected' : '' ?>>
                                    <?= esc($dev['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <button class="th-btn" type="submit"><i class="far fa-search"></i> Cari</button>
                    </form>

                </div>
                <div class="tab-pane fade" id="buy-tab-pane" role="tabpanel" aria-labelledby="buy-tab" tabindex="0">
                    <form class="property-search-form">
                        <label>Property Search</label>
                        <div class="form-group">
                            <i class="far fa-search"></i>
                            <input class="form-control" type="text" placeholder="Lisiting ID or Location">
                        </div>
                        <select class="form-select">
                            <option value="category" selected="selected">Category</option>
                            <option value="luxury">Luxury</option>
                            <option value="commercial">Commercial</option>
                        </select>
                        <select class="form-select">
                            <option value="offer_type" selected="selected">Offer Type</option>
                            <option value="popularity">Popularity</option>
                            <option value="rating">Rating</option>
                            <option value="date">Latest</option>
                        </select>
                        <button class="th-btn" type="submit"><i class="far fa-search"></i> Search</button>
                    </form>
                </div>
            </div>
            <div class="th-sort-bar">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md">
                        <p class="woocommerce-result-count">Showing 1–9 of 16 results</p>
                    </div>

                    <div class="col-md-auto">
                        <div class="sorting-filter-wrap">
                            <form class="woocommerce-ordering" method="get">
                                <select name="orderby" class="orderby" aria-label="Shop order">
                                    <option value="menu_order" selected="selected">Default Sorting</option>
                                    <option value="popularity">Sort by popularity</option>
                                    <option value="rating">Sort by average rating</option>
                                    <option value="date">Sort by latest</option>
                                    <option value="price">Sort by price: low to high</option>
                                    <option value="price-desc">Sort by price: high to low</option>
                                </select>
                            </form>
                            <div class="nav" role=tablist>
                                <a class="active" href="#" id="tab-shop-list" data-bs-toggle="tab" data-bs-target="#tab-list" role="tab" aria-controls="tab-grid" aria-selected="false"><i class="fa-light fa-grid-2"></i></a>
                                <a href="#" id="tab-shop-grid" data-bs-toggle="tab" data-bs-target="#tab-grid" role="tab" aria-controls="tab-grid" aria-selected="true"><i class="fa-solid fa-list"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade active show" id="tab-list" role="tabpanel" aria-labelledby="tab-shop-list">
                    <div class="row gy-40">
    <?php foreach ($properties as $property): ?>
        <div class="col-md-6 col-xl-4">
            <div class="property-card2">
                <div class="property-card-thumb img-shine">
                    <img src="<?= base_url('uploads/property/' . ($property['thumbnail'] ?? 'default.jpg')) ?>" alt="<?= esc($property['title']) ?>">

                </div>
                <div class="property-card-details">
                    <div class="media-left">
                        <h4 class="property-card-title">
                            <a href="<?= base_url('property/' . $property['slug']) ?>">
                                <?= esc($property['title']) ?>
                            </a>
                        </h4>
                        <h5 class="property-card-price">Rp <?= number_format($property['price'], 0, ',', '.') ?></h5>
                        <p class="property-card-location"><?= esc($property['location']) ?></p>
                    </div>
                    <div class="btn-wrap">
                        <a href="<?= base_url('property/' . $property['slug']) ?>" class="th-btn style-border2 th-btn-icon">Details</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>


                </div>
                <div class="tab-pane fade" id="tab-grid" role="tabpanel" aria-labelledby="tab-shop-grid">
                    <div class="property-card-wrap style-dark">
                        <div class="property-thumb">
                            <img src="assets/img/property/property1-1.png" alt="img">
                        </div>
                        <div class="property-card style-dark">
                            <div class="property-card-number">
                                01 </div>
                            <div class="property-card-details">
                                <span class="property-card-subtitle">Apartment</span>
                                <h4 class="property-card-title"><a href="property-details.html">Villa Berkel-Enschot</a></h4>
                                <p class="property-card-text">Rapidiously myocardinate cross-platform intellectual capital model. Appropriately create interactive infrastructures</p>
                                <div class="property-card-price-meta">
                                    <h5 class="property-card-price">$45,000.00</h5>
                                    <div class="property-ratting-wrap">
                                        <div class="star-ratting">
                                            <i class="fas fa-star"></i>
                                            4.9
                                        </div>
                                        10 Review
                                    </div>
                                </div>
                                <div class="property-card-meta">
                                    <span><img src="assets/img/icon/property-icon1-1.svg" alt="img">Bed 4</span>
                                    <span class="divider-line"></span>
                                    <span><img src="assets/img/icon/property-icon1-2.svg" alt="img">Bath 2</span>
                                    <span class="divider-line"></span>
                                    <span><img src="assets/img/icon/property-icon1-3.svg" alt="img">1500 sqft</span>
                                </div>
                                <div class="property-btn-wrap">
                                    <div class="property-author-wrap">
                                        <img src="assets/img/property/property-user-1-1.png" alt="img">
                                        <a href="property-details.html">Admin</a>
                                    </div>
                                    <a href="property-details.html" class="th-btn style-border2 th-btn-icon">Details</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="property-card-wrap style-dark">
                        <div class="property-thumb">
                            <img src="assets/img/property/property1-2.png" alt="img">
                        </div>
                        <div class="property-card style-dark">
                            <div class="property-card-number">
                                02 </div>
                            <div class="property-card-details">
                                <span class="property-card-subtitle">Apartment</span>
                                <h4 class="property-card-title"><a href="property-details.html">Toronto Townhouse</a></h4>
                                <p class="property-card-text">Rapidiously myocardinate cross-platform intellectual capital model. Appropriately create interactive infrastructures</p>
                                <div class="property-card-price-meta">
                                    <h5 class="property-card-price">$45,000.00</h5>
                                    <div class="property-ratting-wrap">
                                        <div class="star-ratting">
                                            <i class="fas fa-star"></i>
                                            4.9
                                        </div>
                                        10 Review
                                    </div>
                                </div>
                                <div class="property-card-meta">
                                    <span><img src="assets/img/icon/property-icon1-1.svg" alt="img">Bed 4</span>
                                    <span class="divider-line"></span>
                                    <span><img src="assets/img/icon/property-icon1-2.svg" alt="img">Bath 2</span>
                                    <span class="divider-line"></span>
                                    <span><img src="assets/img/icon/property-icon1-3.svg" alt="img">1500 sqft</span>
                                </div>
                                <div class="property-btn-wrap">
                                    <div class="property-author-wrap">
                                        <img src="assets/img/property/property-user-1-2.png" alt="img">
                                        <a href="property-details.html">Admin</a>
                                    </div>
                                    <a href="property-details.html" class="th-btn style-border2 th-btn-icon">Details</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="property-card-wrap style-dark">
                        <div class="property-thumb">
                            <img src="assets/img/property/property1-3.png" alt="img">
                        </div>
                        <div class="property-card style-dark">
                            <div class="property-card-number">
                                03 </div>
                            <div class="property-card-details">
                                <span class="property-card-subtitle">Apartment</span>
                                <h4 class="property-card-title"><a href="property-details.html">Virgin Vineyard House</a></h4>
                                <p class="property-card-text">Rapidiously myocardinate cross-platform intellectual capital model. Appropriately create interactive infrastructures</p>
                                <div class="property-card-price-meta">
                                    <h5 class="property-card-price">$45,000.00</h5>
                                    <div class="property-ratting-wrap">
                                        <div class="star-ratting">
                                            <i class="fas fa-star"></i>
                                            4.9
                                        </div>
                                        10 Review
                                    </div>
                                </div>
                                <div class="property-card-meta">
                                    <span><img src="assets/img/icon/property-icon1-1.svg" alt="img">Bed 4</span>
                                    <span class="divider-line"></span>
                                    <span><img src="assets/img/icon/property-icon1-2.svg" alt="img">Bath 2</span>
                                    <span class="divider-line"></span>
                                    <span><img src="assets/img/icon/property-icon1-3.svg" alt="img">1500 sqft</span>
                                </div>
                                <div class="property-btn-wrap">
                                    <div class="property-author-wrap">
                                        <img src="assets/img/property/property-user-1-3.png" alt="img">
                                        <a href="property-details.html">Admin</a>
                                    </div>
                                    <a href="property-details.html" class="th-btn style-border2 th-btn-icon">Details</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="property-card-wrap style-dark">
                        <div class="property-thumb">
                            <img src="assets/img/property/property1-4.png" alt="img">
                        </div>
                        <div class="property-card style-dark">
                            <div class="property-card-number">
                                04 </div>
                            <div class="property-card-details">
                                <span class="property-card-subtitle">Apartment</span>
                                <h4 class="property-card-title"><a href="property-details.html">Apartments Auckland</a></h4>
                                <p class="property-card-text">Rapidiously myocardinate cross-platform intellectual capital model. Appropriately create interactive infrastructures</p>
                                <div class="property-card-price-meta">
                                    <h5 class="property-card-price">$45,000.00</h5>
                                    <div class="property-ratting-wrap">
                                        <div class="star-ratting">
                                            <i class="fas fa-star"></i>
                                            4.9
                                        </div>
                                        10 Review
                                    </div>
                                </div>
                                <div class="property-card-meta">
                                    <span><img src="assets/img/icon/property-icon1-1.svg" alt="img">Bed 4</span>
                                    <span class="divider-line"></span>
                                    <span><img src="assets/img/icon/property-icon1-2.svg" alt="img">Bath 2</span>
                                    <span class="divider-line"></span>
                                    <span><img src="assets/img/icon/property-icon1-3.svg" alt="img">1500 sqft</span>
                                </div>
                                <div class="property-btn-wrap">
                                    <div class="property-author-wrap">
                                        <img src="assets/img/property/property-user-1-4.png" alt="img">
                                        <a href="property-details.html">Admin</a>
                                    </div>
                                    <a href="property-details.html" class="th-btn style-border2 th-btn-icon">Details</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <div class="mt-60 text-center">
                <div class="th-pagination ">
                    <ul>
                        <!-- <li><a class="prev-page" href="blog.html"><i class="far fa-arrow-left me-2"></i>Previous</a></li> -->
                        <li><a class="active" href="blog.html">1</a></li>
                        <li><a href="blog.html">2</a></li>
                        <li><a href="blog.html">3</a></li>
                        <li><a class="next-page" href="blog.html">Next<i class="far fa-arrow-right ms-2"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section><!--==============================

    <?= $this->endSection() ?>