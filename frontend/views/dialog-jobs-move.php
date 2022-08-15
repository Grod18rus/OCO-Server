<?php
$SUBVIEW = 1;
require_once('../../lib/Loader.php');
require_once('../session.php');
?>

<input type='hidden' id='txtEditJobId'></input>
<div class='gallery'>
	<div>
		<select id='sltNewJobContainer' class='resizeVertical' size='10' multiple='true'>
			<?php
			foreach($cl->getJobContainers() as $container) {
				if(!$currentSystemUser->checkPermission($container, PermissionManager::METHOD_WRITE, false)) continue;
			?>
				<option value='<?php echo $container->id; ?>'><?php echo htmlspecialchars($container->name); ?></option>
			<?php } ?>
		</select>
	</div>
</div>

<div class='controls right'>
	<button onclick='hideDialog()'><img src='img/close.dyn.svg'>&nbsp;<?php echo LANG['close']; ?></button>
	<button class='primary' onclick='moveJobToContainer(txtEditJobId.value, sltNewJobContainer.value)'><img src='img/send.white.svg'>&nbsp;<?php echo LANG['move']; ?></button>
</div>
