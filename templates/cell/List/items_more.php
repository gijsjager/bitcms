<?php
if( !empty($list) ){
    ?>
    <h4>Meer projecten</h4>
    <div class="row">
    <?php
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
    } ?>
    </div>
<?php
}
