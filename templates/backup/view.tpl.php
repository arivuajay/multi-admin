<?php
/************************************************************
 * SuperAdmin Admin panel									*
 * Copyright (c) 2012 ARK Infotec								*
 * www.arkinfotec.com											*
 *															*
 ************************************************************/
?>
<?php  $sitesData = Reg::tplGet('sitesData');  ?>

<?php if(!empty($d['sitesBackups'])){   ?>
  <div class="rows_cont" id="backupList">
  <?php foreach($d['sitesBackups'] as $siteID => $siteTaskType){
	  
	  TPL::captureClear('oldBackups');

  ?>
    <div class="ind_row_cont">
      <div class="row_summary">
      	<?php TPL::captureStart('sitesBackupsRowSummary'); ?>
        <div class="row_arrow"></div>
        <div class="row_name searchable"><a href="javascript:void(0)" style="margin-left:12px;margin-top:10px;"><?php echo $sitesData[$siteID]['name'] ?></a></div>
        <div class="clear-both"></div>
        <?php TPL::captureStop('sitesBackupsRowSummary'); ?>
        <?php echo TPL::captureGet('sitesBackupsRowSummary'); ?>
      </div>
      <div class="row_detailed" style="display:none;">
        <div class="rh">
          <?php echo TPL::captureGet('sitesBackupsRowSummary'); ?>
        </div>
        <div class="rd">
          <div class="row_updatee">
          
          	<?php foreach($siteTaskType as $key => $siteBackups){
				if($key != 'backupNow'){
					TPL::captureStart('oldBackups');
					echo TPL::captureGet('oldBackups');
				}
				foreach($siteBackups as $siteBackup){ ?>
                
                <table id="example" class="table table-hover table-condensed dataTable" aria-describedby="example_info">
                <tbody role="alert" aria-live="polite" aria-relevant="all">
                <tr class="odd">
                <td class=" ">
                <div class="label_updatee float-left">
                <div class="label droid700 pull-right"><?php echo $siteBackup['backupName']; ?></div>
              </div>
                </td>
                <td class="">
                <div class="rep_sprite_backup stats repository delConfHide"><?php if(!empty($siteBackup['repository'])){ echo $siteBackup['repository']; } else { echo "Server"; }?></div>
                </td>
                <td class=" sorting_1">
                <div class="rep_sprite_backup stats files delConfHide"><?php if($siteBackup['what'] == 'full'){ ?>Files + DB<?php } elseif($siteBackup['what'] == 'db'){ ?>DB<?php } elseif($siteBackup['what'] == 'files'){ ?>Files<?php } ?></div>
                </td>
                 <td class="">
                 <div class="rep_sprite_backup stats size delConfHide"><?php echo $siteBackup['size']; ?></div>
                 </td>
                 <td class="">
                 <div class="rep_sprite_backup stats time delConfHide"><?php echo @date(Reg::get('dateFormatLong'), $siteBackup['time']); ?></div>
                 </td>
                 <td class="">
                 <div class="row_backup_action rep_sprite" style="float:right;">
                  	<a class="trash rep_sprite_backup removeBackup" sid="<?php echo $siteBackup['siteID']; ?>" taskName="<?php echo $siteBackup['data']['scheduleKey']; ?>" referencekey="<?php echo $siteBackup['referenceKey']; ?>"></a>
                    <div class="del_conf" style="display:none;">
                      <div class="label">Sure?</div>
                      <div class="yes deleteBackup">Yes</div>
                      <div class="no deleteBackup">No</div>
                    </div>
                  </div>
                  </td>
                  <td class="">
                    <?php if(!empty($siteBackup['downloadURL'])){ if(!is_array($siteBackup['downloadURL'])) {$urlArray = array(); $urlArray[] = $siteBackup['downloadURL'];}else { $urlArray = $siteBackup['downloadURL']; } $urlIndex = count($urlArray)-1; ?> <div class="row_backup_action rep_sprite delConfHide" style="float:right;"><a class="download rep_sprite_backup" href="<?php echo $urlArray[$urlIndex]; ?>">Download</a></div> <?php } ?>
                  </td>
                  
                  <td class="">
                  <div class="row_action float-left delConfHide"><a href="javascript:void(0)" class="restoreBackup needConfirm"  sid="<?php echo $siteBackup['siteID']; ?>" taskName="<?php echo $siteBackup['data']['scheduleKey']; ?>" referencekey="<?php echo $siteBackup['referenceKey']; ?>">Restore</a></div>
                  </td>
                  </tr></tbody></table>
           
            <?php }//end foreach($siteBackups as $siteBackup)
			
				if($key != 'backupNow'){
					TPL::captureStop('oldBackups');
				}
  			}//end foreach($siteTaskType as $key => $siteBackups)
			if($oldBackupsHTML = trim(TPL::captureGet('oldBackups'))){
				?> <div style="border-top: 1px solid #F1F1D7;margin-top: -1px;padding: 10px;font-weight: 700;margin-left: 35px;">Old backups</div> <?php
				echo $oldBackupsHTML;
			}
			?>
          </div>
        </div>
      </div>
    </div>
    <?php } 
//END foreach($d['sitesBackups'] as $siteID => $siteBackups) ?>
  </div>
<?php } else { ?>
<div class="empty_data_set"><div class="line2">Looks like there are <span class="droid700">no backups here</span>. Create a <a class="multiBackup">Backup Now</a>.</div></div>
<script>$(".searchItems","#backupPageMainCont").hide();</script>
<?php } ?>