 <!--==============================
Client Area  
==============================-->
    <div class="client-area-1 space bg-theme overflow-hidden">
        <div class="container th-container2">
            <div class="swiper th-slider has-shadow" id="clientSlider1" data-slider-options='{"breakpoints":{"0":{"slidesPerView":2},"576":{"slidesPerView":"3"},"768":{"slidesPerView":"4"},"992":{"slidesPerView":"5"},"1200":{"slidesPerView":"6"}}}'>
                <div class="swiper-wrapper">
                    <?php foreach ($developers as $dev): ?>
                    <div class="swiper-slide">
                        <a href="#" class="client-card">
                            
                            <img src="<?= base_url('uploads/developer/' . $dev['logo']) ?>" alt="<?= esc($dev['name']) ?>">
                            
                        </a>
                    </div>
                        <?php endforeach ?>
                    


                </div>
            </div>
        </div>
    </div><!--==============================