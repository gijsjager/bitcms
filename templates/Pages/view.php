<?php
// loop blocks
foreach ($page->block_groups as $section) { ?>
    <section class="<?= $section->class ?>">
        <?php
        if (!empty($section->wrapper_class)){ ?>
        <div class="<?= $section->wrapper_class ?>">
            <div class="row">
            <?php
        }
//        echo '<div class="row">';
            foreach ($section->blocks as $block) { ?>
                <div class="<?= $block->class ?>">
                    <?php if ($block->type == 'text') {
                        echo $this->Content->parse($block->content);
                    } else {
                        // switch classes for different type of images
                        // case 1: header images
                        if (strpos($section->class, 'header') !== false) {
                            echo '<div class="slick images-holder">';
                            foreach ($block->images as $image) {
                                ?>
                                <div class="slide" style="background-image: url('<?= $image->url ?>')">
                                    <?php if (!empty($image->title)) {
                                        echo '<div class="big-title"><div class="container"><div class="text-center animated fadeInDown">' . $image->title . '</div></div></div>';
                                    } ?>
                                    <div class="background"></div>
                                </div>
                                <?php
                            }
                            echo '</div>';
                        } // case 2: slick slider images
                        else if (strpos($section->class, 'slider') !== false) {
                            echo '<div class="slick images-holder">';
                            foreach ($block->images as $image) {
                                echo '<div class="img">' . $this->Html->image($image->url, ['class' => 'image', 'alt' => $image->alt, 'title' => $image->title]) . '</div>';
                            }
                            echo '</div>';
                        } // case 3: just images
                        else {
                            echo '<div class="images-holder">';
                            foreach ($block->images as $image) {
                                echo $this->Html->image($image->url, ['class' => 'img-responsive center-block', 'alt' => $image->alt, 'title' => $image->title]);
                            }
                            echo '</div>';
                        }
                    } ?>
                </div>
            <?php } // endforeach
//        echo '</div>';
    if (!empty($section->wrapper_class)) { ?>
            </div>
        </div>
    <?php } ?>
    </section>
    <?php
}
?>