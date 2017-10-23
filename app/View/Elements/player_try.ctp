<div class="tryFree">
    <div class="container">
        <h2><?=$title?></h2>
        <div class="text"><?=$teaser?></div>
        <form class="zakaz">
            <div class="row">
                <div class="col-sm-3">
                    <input type="text" class="form-control" placeholder="<?=__('Name')?>">
                </div>
                <div class="col-sm-3">
                    <input type="text" class="form-control" placeholder="<?=__('Phone')?>">
                </div>
                <div class="col-sm-3">
                    <input type="text" class="form-control" placeholder="Email">
                </div>
                <div class="col-sm-3">
                    <button class="btn btn-success"><?=__('Order')?></button>
                </div>
            </div>
        </form>
    </div>
</div>