<div id="slide-order" class="slide" style="text-align: center">
    <div class="container">
        <i class="vert"></i>
        <div class="text">
            <h2><?=nl2br($block['teaser_'.$lang])?></h2>
            <div class="description"><?=$block['body_'.$lang]?></div>
        </div>
        <div class="main-order-form">
            <input type="text" placeholder="<?=__('Name')?>" class="form-control">
            <input type="text" placeholder="<?=__('Phone')?>" class="form-control">
            <input type="text" placeholder="Email" class="form-control">
            <button class="btn btn-success" data-toggle="modal" data-target="#thanks"><?=__('Order')?></button>
        </div>
    </div>
</div>