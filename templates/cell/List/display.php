<div class="portfolio-wrapper">
    <button class="nav">
                <span class="icon-container">
                    <span class="line line01"></span>
                    <span class="line line02"></span>
                    <span class="line line03"></span>
                    <span class="line line04"></span>
                </span>
    </button>
    <div class="works-filter">
        <a href="javascript:void(0)" class="filter active" data-filter="mix">Alles</a>
        <a href="javascript:void(0)" class="filter" data-filter="coding">Techniek</a>
        <a href="javascript:void(0)" class="filter" data-filter="web">Webdesign</a>
        <a href="javascript:void(0)" class="filter" data-filter="graphic">Huisstijl</a>
    </div>

    <div class="js-masonry">
        <div class="row" id="work-grid">
            <?php
            if( !empty($list) ){
                foreach($list as $item){
                    ?>
                    <div class="col-md-4 col-sm-4 col-xs-12 mix coding web">
                        <div class="img home-portfolio-image">
                            <?= $this->Html->image(reset($item->images)->url, ['alt' => reset($item->images)->alt]); ?>
                            <div class="overlay-thumb">
                                <a href="javascript:void(0)" class="like-product">
                                    <i class="ion-ios-heart-outline"></i>
                                    <span class="like-product">Liked</span>
                                    <span class="output"><?= rand(100,500); ?></span>
                                </a>
                                <div class="details">
                                    <span class="title"><?= $item->title ?></span>
                                    <span class="info"><?= $item->intro ?></span>
                                </div>
                                <span class="btnBefore"></span>
                                <span class="btnAfter"></span>
                                <?= $this->Html->link('', '/portfolio/'.$item->slug, ['class' => 'main-portfolio-link']); ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } ?>
        </div>
    </div>
</div>
