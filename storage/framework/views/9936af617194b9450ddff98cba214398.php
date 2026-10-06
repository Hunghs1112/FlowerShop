<?php
    $flowers = $flowers ?? collect();
    $mapPoints = [
        'china' => [1414.1, 265.6],
        'netherlands' => [923.8, 128.7],
        'ecuador' => [509.3, 389.8],
        'south-africa' => [992.1, 559.6],
        'japan' => [1606.8, 174.7],
        'malaysia' => [1406.9, 367.6],
        'vietnam' => [1442.2, 330.3],
        'colombia' => [529.7, 366.5],
        'new-zealand' => [1763.2, 607.6],
    ];
?>

<section class="origin-story origin-atlas-reference" id="originStory" aria-labelledby="originStoryTitle">
    <div class="origin-atlas-reference__intro">
        <p class="origin-atlas-reference__eyebrow">Our flower atlas · 09</p>
        <h1 id="originStoryTitle"><span>Chín vùng đất,</span><br><em>một điểm đến</em></h1>
        <p class="origin-atlas-reference__lead">Lâm Nhiên Thảo tuyển chọn hoa từ những vùng trồng nổi tiếng nhất thế giới và đưa về Hà Nội. Chạm vào từng điểm trên bản đồ để xem loài hoa đến từ đó.</p>
        <div class="origin-atlas-reference__stats" aria-label="Lâm Nhiên Thảo trong con số">
            <div><b>09</b><span>Quốc gia</span></div>
            <div><b>05</b><span>Châu lục</span></div>
            <div><b>01</b><span>Tình yêu với hoa</span></div>
        </div>
        <p class="origin-atlas-reference__hint"><span aria-hidden="true"></span>Chọn một điểm trên bản đồ hoặc tên nước bên dưới</p>
    </div>

    <div class="origin-atlas-reference__map-wrap">
        <svg viewBox="0 -60 1800 670" role="group" aria-labelledby="flowerMapTitle flowerMapDescription">
            <title id="flowerMapTitle">Bản đồ các vùng hoa của Lâm Nhiên Thảo</title>
            <desc id="flowerMapDescription">Chín đường bay kết nối các vùng trồng hoa trên thế giới về Hà Nội.</desc>
            <image href="<?php echo e(asset('images/flower-atlas-land.svg')); ?>" x="0" y="-60" width="1800" height="670" aria-hidden="true" />
            <g aria-hidden="true">
                <path class="origin-atlas-reference__arc flight-route" data-region="china" style="--arc-delay:0s" d="M1414.1 265.6Q1427.5 270.7 1429.2 284.9" pathLength="1" />
                <path class="origin-atlas-reference__arc flight-route" data-region="netherlands" style="--arc-delay:.25s" d="M923.8 128.7Q1223.4 55.1 1429.2 284.9" pathLength="1" />
                <path class="origin-atlas-reference__arc flight-route" data-region="ecuador" style="--arc-delay:.5s" d="M509.3 389.8Q943.2 108.8 1429.2 284.9" pathLength="1" />
                <path class="origin-atlas-reference__arc flight-route" data-region="south-africa" style="--arc-delay:.75s" d="M992.1 559.6Q1128.3 291.1 1429.2 284.9" pathLength="1" />
                <path class="origin-atlas-reference__arc flight-route" data-region="japan" style="--arc-delay:1s" d="M1606.8 174.7Q1485 176.5 1429.2 284.9" pathLength="1" />
                <path class="origin-atlas-reference__arc flight-route" data-region="malaysia" style="--arc-delay:1.25s" d="M1406.9 367.6Q1393.2 319.5 1429.2 284.9" pathLength="1" />
                <path class="origin-atlas-reference__arc flight-route" data-region="vietnam" style="--arc-delay:1.5s" d="M1442.2 330.3Q1449.4 303.7 1429.2 284.9" pathLength="1" />
                <path class="origin-atlas-reference__arc flight-route" data-region="colombia" style="--arc-delay:1.75s" d="M529.7 366.5Q958.7 96.6 1429.2 284.9" pathLength="1" />
                <path class="origin-atlas-reference__arc flight-route" data-region="new-zealand" style="--arc-delay:2s" d="M1763.2 607.6Q1693.1 346.1 1429.2 284.9" pathLength="1" />
            </g>
            <g class="origin-atlas-reference__home" aria-label="Điểm đến Hà Nội">
                <circle class="origin-atlas-reference__home-ring" cx="1429.2" cy="284.9" r="16" />
                <circle class="origin-atlas-reference__home-ring" cx="1429.2" cy="284.9" r="16" />
                <circle class="origin-atlas-reference__home-core" cx="1429.2" cy="284.9" r="11" />
                <text x="1429.2" y="284.9" dx="24" dy="44">Hà Nội</text>
            </g>
            <g>
                <?php $__currentLoopData = $flowers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $flower): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php ($point = $mapPoints[$flower->slug] ?? null); ?>
                    <?php if($point): ?>
                        <g class="origin-atlas-reference__pin map-pin" data-region="<?php echo e($flower->slug); ?>" tabindex="0" role="button" aria-label="<?php echo e($flower->country); ?>: <?php echo e($flower->flower); ?>" aria-pressed="false">
                            <circle class="origin-atlas-reference__pin-hit map-pin__hit" cx="<?php echo e($point[0]); ?>" cy="<?php echo e($point[1]); ?>" r="22" />
                            <circle class="origin-atlas-reference__pin-dot map-pin__dot" cx="<?php echo e($point[0]); ?>" cy="<?php echo e($point[1]); ?>" r="7" />
                            <text x="<?php echo e($point[0]); ?>" y="<?php echo e($point[1] - 16); ?>"><?php echo e($flower->country); ?></text>
                        </g>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </g>
        </svg>
        <article class="origin-atlas-reference__card flower-card" id="flowerCard" aria-live="polite">
            <img id="flowerImage" src="<?php echo e(asset('images/products/product-4.jpg')); ?>" alt="Hoa tulip từ Hà Lan">
            <span id="flowerIndex" hidden>01</span>
            <div>
                <p class="origin-atlas-reference__card-country" id="flowerCountry">Hà Lan</p>
                <p class="origin-atlas-reference__card-flower" id="flowerName">Tulip</p>
                <p class="origin-atlas-reference__card-latin" id="flowerLatin">Tulipa gesneriana</p>
                <p class="origin-atlas-reference__card-region"><span id="flowerRegion">Aalsmeer</span><span id="flowerCoordinate"> · 52.26°N, 4.76°E</span></p>
            </div>
        </article>
        <div class="origin-atlas-reference__chips flower-tabs" id="flowerTabs" role="tablist" aria-label="Chọn vùng trồng hoa">
            <?php $__currentLoopData = $flowers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $flower): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <button type="button" role="tab" data-region="<?php echo e($flower->slug); ?>" data-country="<?php echo e($flower->country); ?>" data-flower="<?php echo e($flower->flower); ?>" data-latin="<?php echo e($flower->latin); ?>" data-growing-region="<?php echo e($flower->region); ?>" data-coordinate="<?php echo e($flower->coordinate); ?>" data-image="<?php echo e($flower->image_url); ?>" aria-selected="false"><?php echo e($flower->country); ?></button>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php /**PATH D:\Github\FlowerShop\resources\views/components/flower-origin-atlas.blade.php ENDPATH**/ ?>