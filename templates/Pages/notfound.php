<div class="text-block white">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>404 page not found</h1>

                <p>
                    You tried to visit <strong><?= $url ?></strong>, but it's gone.<br/>
                    The page you are trying to visit is moved or doesn't exist. <br/>
                    <br/>
                    <?= $this->Html->link('Return home', '/', ['class' => 'btn btn-primary']); ?>
                </p>
            </div>
        </div>
    </div>
</div>