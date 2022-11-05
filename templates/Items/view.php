<?php
if (isset($page->images[1])) { ?>
    <div class="container">
        <div class="single-project-slider">
            <div class="owl-carousel single-slider">
                <div>
                    <?= $this->Html->image($page->images[1]->url, ['class' => 'img-responsive center-block', 'alt' => $page->images[1]->alt]); ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<div class="container">
    <div class="single-portfolio-wrapper">
        <div class="row">
            <div class="col-md-8 col-sm-8">
                <h1 class="text-uppercase"><?= $page->title ?></h1>
                <span class="info text-uppercase"><?= $page->intro ?></span>
                <?= $page->content ?>
                <br/><br/>
            </div>
            <div class="col-md-3 col-md-offset-1 col-sm-4">
                <div class="project-information">
                    <table class="table">
                        <tr>
                            <td>Klant:</td>
                            <td><?= $page->client ?></td>
                        </tr>
                        <tr>
                            <td>Categorie:</td>
                            <td><?= $page->category ?></td>
                        </tr>
                        <tr>
                            <td>Bezoek:</td>
                            <td><a href="<?= $page->link ?>"
                                   target="_blank"><?= preg_replace('/http(s)?\:\/\/(www\.)?/', '', $page->link) ?></a>
                            </td>
                        </tr>
                        <tr>
                            <td>Delen:</td>
                            <td>
                                <ul class="social-buttons">
                                    <li><a href="javascript:void(0);" data-social="fb"><i class="iconmoon-facebook"></i></a>
                                    </li>
                                    <li><a href="javascript:void(0);" data-social="tw"><i class="iconmoon-twitter"></i></a>
                                    </li>
                                    <li><a href="javascript:void(0);" data-social="pt"><i
                                                    class="iconmoon-pinterest"></i></a></li>
                                    <li><a href="javascript:void(0);" data-social="ln"><i class="iconmoon-linkedin"></i></a>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="single-project-details">
        <div class="row">
            <?php
            foreach ($page->images as $key => $img) {
                if ($key > 1) {
                    ?>
                    <div class="col-md-6 col-sm-6">
                        <div class="single-project-images">
                            <?= $this->Html->image($img->url, ['alt' => $img->alt]); ?>
                        </div>
                    </div>
                    <?php

                }
            }
            ?>
        </div>
    </div>
    <div class="container">
        <div class="portfolio-controls">
            <div class="btn-project home-btn">
                <a href="https://dotbits.nl/" data-hover="Home">
                    <i class="pe-7s-keypad"></i>
                </a>
            </div>


            <div class="btn-project forward-btn">
                <?= $this->Html->link('<i class="pe-7s-angle-right right"></i>', ['controller' => 'Items', 'action' => 'view', $navigation['next']->slug, 'lang' => ''], [
                    'escape' => false,
                    'data-hover' => 'Volgende'
                ]) ?>
            </div>
            <div class="btn-project back-btn">
                <?= $this->Html->link('<i class="pe-7s-angle-left left"></i>', ['controller' => 'Items', 'action' => 'view', $navigation['previous']->slug, 'lang' => ''], [
                    'escape' => false,
                    'data-hover' => 'Vorige'
                ]) ?>
            </div>
        </div>
    </div>
    <div class="container margin-top">
        <div class="similar-project">

            <?= $this->Cell('List', [[
                'controller' => 'Items',
                'contain' => 'Images',
                'limit' => 3,
                'where' => 'slug !=:' . $page->slug . '',
                'order' => 'rand()'
            ]])->render('items_more'); ?>
        </div>
    </div>
</div>