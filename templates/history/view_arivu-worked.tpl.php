<?php

/************************************************************
 * SuperAdmin Admin panel									*
 * Copyright (c) 2012 ARK Infotec								*
 * www.arkinfotec.com											*
 *															*
 ************************************************************/
 
/*
* history/view.tpl
*/

if(!empty($d['actionsHistoryData'])){
	
	$sitesData = Reg::tplGet('sitesData');
	
foreach($d['actionsHistoryData'] as $actionID => $actionHistory){
	
	$showByDetailedActionGroup = ( $actionHistory['type'] == 'PTC'|| (($actionHistory['action'] == 'manage' || $actionHistory['action'] == 'install') && ($actionHistory['type'] == 'plugins' || $actionHistory['type'] == 'themes') ) );
	
?>
<div class="ind_row_cont" actionID="<?php echo $actionID; ?>">
	<div class="row_summary<?php if(in_array($actionHistory['status'], array('pending', 'running', 'initiated', 'multiCallWaiting'))){ ?> in_progress<?php } ?>"><?php if($actionHistory['status'] == 'multiCallWaiting'){ ?> <div class="rep_sprite btn_stop_rep_sprite_activity_log" ><span class = "rep_sprite_backup btn_stop_progress stop_multicall"  mechanism = "multiCall" actionID = "<?php echo $actionID; ?>"></span> </div><?php } ?>
      <div class="row_arrow"></div>
      <div class="timestamp"><?php echo @date(Reg::get('dateFormatLong'), $actionHistory['time']); ?></div>
      <div class="row_name"><?php echo TPLPrepareHistoryBriefTitle($actionHistory); ?></div>
      <?php if($actionHistory['statusSummary']['success']) { ?><div class="success_bu fa fa-check-circle rep_sprite_backup"><?php echo $actionHistory['statusSummary']['success']; ?></div><?php } ?>
      <?php if($errorCount = ($actionHistory['statusSummary']['error'] + $actionHistory['statusSummary']['netError'])) { ?><div class="failed_bu fa fa-warning rep_sprite_backup"><?php echo $errorCount; ?></div><?php } ?>
      <div class="clear-both"></div>
    </div>
              <div class="row_detailed" style="display:none;">
            <div class="rh <?php if(in_array($actionHistory['status'], array('pending', 'running', 'initiated', 'processingResponse', 'multiCallWaiting'))){ ?> in_progress<?php } ?>">
                  <div class="row_arrow"></div>
                  <div class="timestamp"><?php echo @date(Reg::get('dateFormatLong'), $actionHistory['time']); ?></div>
                  <a class="btn_send_report float-right droid400 sendReport" actionid="<?php echo $actionID; ?>">Report Issue</a>
                  <div class="row_name"><?php echo TPLPrepareHistoryBriefTitle($actionHistory); ?></div>
                  <?php if($actionHistory['statusSummary']['success']) { ?><div class="success_bu fa fa-check-circle rep_sprite_backup"><?php echo $actionHistory['statusSummary']['success']; ?></div><?php } ?>
                  <?php if($errorCount = ($actionHistory['statusSummary']['error'] + $actionHistory['statusSummary']['netError'])) { ?><div class="failed_bu fa fa-warning rep_sprite_backup"><?php echo $errorCount; ?></div><?php } ?>
                  <div class="clear-both"></div>
                </div>
            <div class="rd">
            
<!--            -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
            
            <!-- Group updates which has more than one type -->
            
<?php 
//Grouping by siteID, detailedAction, status
$fullGroupedActions = array();
$siteWithErrors = array();

foreach($actionHistory['detailedStatus'] as $singleAction){
	
	//to display plugin slug instead of plugin main file say hello-dolly/hello_dolly.php => hello-dolly
	if($actionHistory['type'] == 'PTC' && $singleAction['detailedAction'] == 'plugin'){
    $uniqueNameTemp = explode('/', $singleAction['uniqueName']);
		$singleAction['uniqueName'] = reset($uniqueNameTemp);
		$singleAction['uniqueName'] = str_replace('.php', '', $singleAction['uniqueName']);
	}
	
	if(in_array($actionHistory['type'], array('themes', 'plugins')) && $actionHistory['action'] == 'install' && strpos($singleAction['uniqueName'], '%20') !== false){//this to replace %20 in the file name
		$singleAction['uniqueName'] = str_replace('%20', ' ', $singleAction['uniqueName']);
	}
	
	
	if($singleAction['status'] == 'success'){
		$fullGroupedActions[ $singleAction['siteID'] ][ $singleAction['detailedAction'] ][ 'success' ] [] = $singleAction['uniqueName'];
	}
	elseif($singleAction['status'] == 'error' || $singleAction['status'] == 'netError'){	
		//if($singleAction['error'] == 'main_plugin_connection_error'){ $singleAction['errorMsg'] = 'Plugin connection error.'; }
		$fullGroupedActions[ $singleAction['siteID'] ][ $singleAction['detailedAction'] ][ 'error' ] [] = array('name' => $singleAction['uniqueName'], 'errorMsg' => $singleAction['errorMsg'], 'error' => $singleAction['error'], 'type' => $actionHistory['type'], 'action' => $actionHistory['action'], 'detailedAction' => $singleAction['detailedAction'], 'microtimeInitiated' => $singleAction['microtimeInitiated'], 'status' => $singleAction['status']);
		$siteWithErrors[$singleAction['siteID']] = $singleAction['historyID'];
	}
	else{
		$fullGroupedActions[ $singleAction['siteID'] ][ $singleAction['detailedAction'] ][ 'others' ] [] = array('name' => $singleAction['uniqueName'], 'errorMsg' => $singleAction['status'], 'microtimeInitiated' => $singleAction['microtimeInitiated'], 'status' => $singleAction['status']);
	}
	$sitesDataTemp[$singleAction['siteID']]['name'] = isset($sitesData[$singleAction['siteID']]['name']) ?  $sitesData[$singleAction['siteID']]['name'] : $singleAction['URL'];
}
?>
<?php foreach($fullGroupedActions as $siteID => $siteGroupedActions){ ?>           
 <!--           For each Site starts-->
                  <div class="row_updatee">
                <div class="row_updatee_ind">
                      <div class="label_updatee">
                    <div class="label droid700 float-left"><?php if(!empty($siteWithErrors[$siteID])){ ?><a style="float:left; position:absolute; left:0; bottom:2px;" class="moreInfo" historyID="<?php echo $siteWithErrors[$siteID]; ?>">View site response</a><?php unset($siteWithErrors[$siteID]); } ?><?php echo $sitesDataTemp[$siteID]['name']; ?></div>
                    <div class="clear-both"></div>
                  </div>
                      <div class="item_cont_right_cont">                      
       <?php foreach($siteGroupedActions as $detailedAction => $statusGroupedActions){ ?>     
                    <!--  For each type starts-->                   
                    <div class="item_cont">
                        <?php if($showByDetailedActionGroup){ ?><div class="item_label float-left"><span><?php echo ($detailedAction == 'core') ? 'WP' : $detailedAction; ?></span></div><?php } ?>
                        <div class="float-left">                        
                        <?php if(!empty($statusGroupedActions['success'])){ ?> 
                        <div class="item_success rep_sprite_backup float-left">                    
                            
                        <!--For each plugins successful plugins starts-->                        
                        <?php if($showByDetailedActionGroup){ echo '<span>'.implode('</span> <span>',$statusGroupedActions['success']).'</span>'; }
						else{ ?><span>&nbsp;</span><?php } ?>
                        <!--For each plugins successful plugins ends-->                         
                        </div>
                        <?php } ?>
                        <?php if(!empty($statusGroupedActions['others'])){ ?>
                        <div class="item_failure rep_sprite_backup float-left">
							  <?php foreach($statusGroupedActions['others'] as $oneAction){ ?>
                              <!--For each plugins failed plugins starts-->
                              <?php if($showByDetailedActionGroup){ ?><div class="failure_name"><?php echo $oneAction['name']; ?></div><?php } ?>
                              <div class="failure_reason<?php if(!$showByDetailedActionGroup){ ?> only<?php } ?>"><?php echo $oneAction['errorMsg']; ?></div>
                              <div class="clear-both"></div>
                              <!--For each plugins successful plugins ends-->
							  <?php } ?>
                        </div>
                        <?php } ?>
                        <?php if(!empty($statusGroupedActions['error'])){ ?> 
                        
                        <div class="item_failure rep_sprite_backup float-left">
                        	 <?php foreach($statusGroupedActions['error'] as $oneAction){ ?>
                        	  <!--For each plugins failed plugins starts-->
                              <?php if($showByDetailedActionGroup){ ?><div class="failure_name"><?php echo $oneAction['name']; ?></div><?php } ?>
                              <div class="failure_reason<?php if(!$showByDetailedActionGroup){ ?> only<?php } ?>"><?php echo TPLAddErrorHelp($oneAction); ?></div>                              
                              <div class="clear-both"></div>
                              <!--For each plugins successful plugins ends-->
                              <?php } ?>                              
                        </div>
                        <?php } ?>
                      </div>
                          <div class="clear-both"></div>
                        </div>
                              <!--  For each type ends-->
      <?php } //END foreach($siteGroupedActions as $detailedAction => $statusGroupedActions) ?>  
                  </div>
                      <div class="clear-both"></div>
                    </div>
              </div>
               <!--           For each Site ends-->
<?php } //END foreach($fullGroupedActions as $siteID => $siteGroupedActions) ?>   
                </div>
          </div>
            </div>
<?php

} //end foreach($d['actionsHistoryData'] as $actionHistory)

} //end if(!empty($d['actionsHistoryData']))


$pagination = Reg::tplget('pagination');

if(empty($pagination['totalPage'])){ ?>
<div class="empty_data_set"> <div class="line2">Bummer, there are no activites logged for this period.</div></div>
<?php } ?>
<script>
<?php if($pagination['page'] == 1){ ?>
$("#historyPagination").show().jPaginator({
	nbPages:<?php echo $pagination['totalPage']; ?>,
	selectedPage:<?php echo $pagination['page']; ?>,
	overBtnLeft:'#historyPagination_o_left',
	overBtnRight:'#historyPagination_o_right',
	maxBtnLeft:'#historyPagination_m_left',
	maxBtnRight:'#historyPagination_m_right',
	withSlider: false,
	widthPx: 25,
	marginPx: 0,
	onPageClicked: function(a,num) {
	   tempArray={};
	   tempArray['requiredData']={};
	   tempArray['requiredData']['getHistoryPageHTML']={};
	   tempArray['requiredData']['getHistoryPageHTML']['dates']=$("#dateContainer").attr('exactdate');
	   tempArray['requiredData']['getHistoryPageHTML']['page']=num;
	   doCall(ajaxCallPath,tempArray,'loadHistoryPageContent');
	}
  });
<?php } ?>
<?php if(empty($pagination['totalPage'])){ ?>
$("#historyPagination").hide();
<?php } ?>
<?php /*?>else { ?>
$("#historyPagination").trigger("reset",{nbPages:<?php echo $pagination['totalPage']; ?>,selectedPage:<?php echo $pagination['page']; ?>})
<?php } ?><?php */?>
</script>
