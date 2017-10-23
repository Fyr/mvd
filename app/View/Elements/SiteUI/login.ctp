<div class="modal fade" id="myLogin" tabindex="-1" role="dialog">
    <i class="vert"></i>
    <div class="modal-dialog">
        <div class="modal-content">
            <span class="closeModal" data-dismiss="modal" aria-label="Close"></span>
            <div class="title"><?=__('Log into user area')?></div>
            <div class="error-message"></div>
            <form>
                <input type="text" class="form-control" id="key" placeholder="<?=__('Your licence key')?>">
                <div class="links">
                    <input type="checkbox" class="styler" name="remember">
                    <span class="forgotPassword"><?=__('Remember me')?></span>
                </div>
                <div class="bottom">
                    <button type="button" class="btn btn-success"><?= __('Login') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function(){
<?
    if ($this->request->query('login')) {
?>
        $('#myLogin').modal('show');
<?
    }
?>

        $('#myLogin #key').focus(function(){
            $('#myLogin .error-message').html('');
        });
        $('#myLogin .btn-success').click(function(){
            if (!$.cookie('login')) {
                $.cookie('login', 3, {expires: 365, path: '/'});
            }
            $.post('/user/login.json', {data: {key: $('#myLogin #key').val()}}, function(response){
                if (checkJson(response)) {
                    if (response.errMsg) {
                        $('#myLogin .error-message').html(response.errMsg);
                        $.cookie('login', response.tries, {expires: 365, path: '/'});
                    } else {
                        $.cookie('login', 3, {expires: 365, path: '/'});
                        window.location.href = response.url;
                    }
                }
            }, 'json');
        });
    });
</script>