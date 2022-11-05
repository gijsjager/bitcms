<div class="row sitemap">
    <?php
    foreach($links as $column){
        echo '<div class="col-md-4">';
        foreach($column as $link){
            echo $this->Html->link($link->title, $link->slug, ['class' => 'text-bold']);
            if( !empty($link->fullrange) ){
                foreach($link->fullrange as $fullrange){
                    echo $this->Html->link($fullrange->title, $fullrange->slug);
                }
            }
        } //endforeach
        echo '</div>';
    } //endforeach
    ?>
</div>