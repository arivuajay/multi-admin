<?php

/************************************************************
 * SuperAdmin Admin panel									*
 * Copyright (c) 2012 ARK Infotec								*
 * www.arkinfotec.com											*
 *															*
 ************************************************************/
 
/*
* menu/menu.tpl
*/

?><li class="l1 dropdown"><a data-toggle="dropdown" class="dropdown-toggle" href="#" id="<?php echo create_slug($d['groupName']); ?>"><?php echo $d['groupName']; ?></a>
<?php
if(!empty($d['singleGroupMenu'])){ 
?>
<ul class="l2 dropdown-menu" role="menu" aria-labelledby="<?php echo create_slug($d['groupName']); ?>">
<?php
foreach($d['singleGroupMenu'] as $m){
	if(is_array($m)){
?><li class="l2 navLinks <?php echo (!empty($m['class']) ? ' '.$m['class'] : ''); ?>" page="<?php echo $m['page']; ?>"><a><?php echo $m['displayName']; ?></a></li><?php 
	}
	elseif(!empty($m) && is_string($m)){
		echo $m;
	}
}
?>
 </ul>
<?php
}
?> 
</li>

