<?php
$SUBVIEW = 1;
require_once('../../lib/Loader.php');
require_once('../session.php');

function echoTargetPackageGroupOptions($parent=null) {
	global $db;
	global $currentSystemUser;

	foreach($db->getAllPackageGroup($parent) as $pg) {
		if(!$currentSystemUser->checkPermission($pg, PermissionManager::METHOD_READ, false)
		&& !$currentSystemUser->checkPermission($pg, PermissionManager::METHOD_DEPLOY, false)) continue;

		echo "<a class='blockListItem' onclick='refreshDeployPackageList(".$pg->id.")'>";
		echo htmlspecialchars($pg->name);
		echo "<img src='img/eye.dyn.svg' class='dragicon'>";
		echo "</a>";
		echo "<div class='subgroup'>";
		echoTargetPackageGroupOptions($pg->id);
		echo "</div>";
	}
}
?>

<input type='hidden' id='txtEditPackageId'></input>
<input type='hidden' id='txtSetAsDependentPackage' value='0'></input>
<div class='gallery'>
	<div>
		<h3><?php echo LANG['package_selection']; ?> (<span id='spnSelectedPackages'>0</span>/<span id='spnTotalPackages'>0</span>)</h3>
		<div class='listSearch'>
			<input type='checkbox' title='<?php echo LANG['select_all']; ?>' onchange='toggleCheckboxesInContainer(divPackageList, this.checked);refreshDeployPackageCount()'>
			<input type='text' id='txtDeploySearchPackages' placeholder='<?php echo LANG['search_placeholder']; ?>' oninput='searchItems(divPackageList, this.value)'>
		</div>
		<div id='divPackageList' class='box listSearchList'>
			<a class='blockListItem big noSearch' onclick='refreshDeployPackageList(-1)'><?php echo LANG['all_packages']; ?><img src='img/eye.dyn.svg' class='dragicon'></a>
			<?php echoTargetPackageGroupOptions(); ?>
		</div>
		<div id='divPackageListHome' class='box listSearchList hidden'>
			<a class='blockListItem big noSearch' onclick='refreshDeployPackageList(-1)'><?php echo LANG['all_packages']; ?><img src='img/eye.dyn.svg' class='dragicon'></a>
			<?php echoTargetPackageGroupOptions(); ?>
		</div>
	</div>
</div>

<div class='controls right'>
	<button onclick='hideDialog();showLoader(false);showLoader2(false);'><img src='img/close.dyn.svg'>&nbsp;<?php echo LANG['close']; ?></button>
	<button class='primary' onclick='if(txtSetAsDependentPackage.value=="1") addPackageDependency(getSelectedCheckBoxValues("packages"), [txtEditPackageId.value]); else addPackageDependency([txtEditPackageId.value], getSelectedCheckBoxValues("packages"));'><img src='img/send.white.svg'>&nbsp;<?php echo LANG['add']; ?></button>
</div>
