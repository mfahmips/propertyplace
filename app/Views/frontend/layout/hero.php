
 
 <!--==============================
Hero Area
==============================-->
    <div class="th-hero-wrapper hero-4" id="hero" style="background-color: #DAD3C5;">
        <div class="container">
            <div class="hero-style4">
                <span class="sub-title">Top-Notch Real Estate Properties</span>
                <h1 class="hero-title text-theme">Find Your </h1>
                <h1 class="hero-title text-theme">Dream Home</h1>
                <form class="property-search-form" action="<?= base_url('property/search') ?>" method="get" style="background-color: #B86C3A;">
                <div class="form-group">
                    <i class="far fa-search"></i>
                    <input class="form-control" type="text" name="location" placeholder="Cari berdasarkan lokasi...">
                </div>

                <select class="form-select" name="developer">
                    <option value="">Pilih Developer</option>
                    <?php foreach ($developers as $dev): ?>
                    <option value="<?= esc($dev['id']) ?>"><?= esc($dev['name']) ?></option>
                    <?php endforeach ?>
                </select>

                <select class="form-select" name="sort">
                    <option value="">Urutkan Berdasarkan</option>
                    <option value="latest">Terbaru</option>
                    <option value="popular">Populer</option>
                    <option value="rating">Rating</option>
                </select>

                <button class="th-btn" type="submit">
                    <i class="far fa-search"></i> 
                    <span class="d-inline-block d-xl-none">Cari</span>
                </button>
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