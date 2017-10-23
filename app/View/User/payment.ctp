<!DOCTYPE html>
<html lang="en">
<head>
	<?=$this->Html->charset()?>
</head>
<body onload="document.forms[0].submit()">
<form action="<?=Configure::read('robokassa.url')?>" method="post">
	<input type="hidden" name="MerchantLogin" value="<?=Configure::read('robokassa.merchant')?>" />
	<input type="hidden" name="OutSum" value="<?=$oper['Payment']['sum']?>" />
	<input type="hidden" name="InvId" value="<?=$oper['Payment']['id']?>" />
	<input type="hidden" name="InvDesc" value="<?=__('Balance recharge')?>" />
	<input type="hidden" name="SignatureValue" value="<?=$crc?>" />
	<input type="hidden" name="Shp_hash" value="<?=$oper['Payment']['hash']?>" />
	<input type="hidden" name="IncCurrLabel" value="" />
	<input type="hidden" name="Culture" value="<?=($lang == 'eng') ? 'en' : 'ru'?>" />
	<input type="hidden" name="IsTest" value="1" />
</form>
</body>
</html>