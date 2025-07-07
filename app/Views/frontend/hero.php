<?= $this->extend('frontend/layout/default') ?>
<?= $this->section('content') ?>
 
 
 <!--==============================
Hero Area
==============================-->
    <div class="th-hero-wrapper hero-4" id="hero" data-bg-src="assets/img/hero/hero_bg_4_1.jpg">
        <div class="container">
            <div class="hero-style4">
                <span class="sub-title">Top-Notch Real Estate Properties</span>
                <h1 class="hero-title text-theme">Find Your </h1>
                <h1 class="hero-title text-theme">Dream Home</h1>
                <form class="property-search-form">
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
                    <button class="th-btn" type="submit"><i class="far fa-search"></i> <span class="d-inline-block d-xl-none">Search</span></button>
                </form>
                <div class="counter-card-wrap">
                    <div class="counter-card">
                        <div class="media-body">
                            <h2 class="box-number"><span class="counter-number">65</span>k</h2>
                            <p class="box-text">Satisfied Customers</p>
                        </div>
                    </div>
                    <div class="counter-card">
                        <div class="media-body">
                            <h2 class="box-number"><span class="counter-number">15</span>k</h2>
                            <p class="box-text">Verified Properties</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="hero-thumb4-1" data-overlay="black" data-opacity="2">
            <img src="assets/img/hero/hero_thumb_4_1.jpg" alt="img">
        </div>
    </div>