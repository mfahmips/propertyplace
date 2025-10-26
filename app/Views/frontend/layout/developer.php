<section class="space overflow-hidden position-relative award-area-1" style="background: #dad3c5; padding-bottom: 0; padding-top: 0;">
        <div class="container">

    <!--==============================
Client Area  
==============================-->
            <div class="swiper th-slider has-shadow" id="awardSlider1" data-slider-options='{"breakpoints":{"0":{"slidesPerView":2},"576":{"slidesPerView":"3"},"768":{"slidesPerView":"4"},"992":{"slidesPerView":"5"},"1200":{"slidesPerView":"5"}}}'>
                <div class="swiper-wrapper">
                    <?php foreach ($developers as $dev): ?>
                    <div class="swiper-slide"> 
                        <a class="client-card">
                            <img src="<?= base_url('uploads/developer/' . $dev['logo']) ?>" alt="<?= esc($dev['name']) ?>">
                        </a>  
                    </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
</section>