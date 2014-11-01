<?php
/* * **********************************************************
 * SuperAdmin Admin panel									*
 * Copyright (c) 2012 ARK Infotec								*
 * www.arkinfotec.com											*
 * 															*
 * ********************************************************** */
?>

<div class="tiles white">
    <div class="site_bar_btn rep_sprite float-right tiles-body" style="margin-right:10px;">
        <div class="controller"> <a href="javascript:;" class="reload"></a> <a href="javascript:;" class="remove"></a> </div>
        <div id="process_queue" class="<?php if ($d['showInProgress']) { ?> in_progress<?php } ?> historyToolbar tiles-title">Recent Activity</div>
        <br />
        <div class="queue_cont" id="historyQueue">
            <?php
            if (!empty($d['actionsHistoryData'])) {
                $sitesData = Reg::tplGet('sitesData');

                foreach ($d['actionsHistoryData'] as $actionID => $actionHistory) {

                    $showByDetailedActionGroup = ( $actionHistory['type'] == 'PTC' || ( ($actionHistory['action'] == 'manage' || $actionHistory['action'] == 'install') && ($actionHistory['type'] == 'plugins' || $actionHistory['type'] == 'themes') ) );

                    if (empty($actionHistory)) {
                        continue;
                    }

                    $actionIDHTML = str_replace('.', '', $actionID);

                    if ($actionHistory['status'] == 'pending' || $actionHistory['status'] == 'multiCallWaiting')
                        $actionOverallStatus = '';
                    elseif ($actionHistory['statusSummary']['total'] == $actionHistory['statusSummary']['success'])
                        $actionOverallStatus = 'success';
                    else
                        $actionOverallStatus = 'failure';
                    ?>
        <?php TPL::captureStart('processQueueRowSummary'); ?>
        <?php echo TPL::captureGet('processQueueRowSummary'); ?>
                    <div class="queue_ind_item historyItem <?php if (in_array($actionHistory['status'], array('pending', 'running', 'initiated', 'processingResponse', 'multiCallWaiting'))) { ?> in_progress<?php } echo ' ' . $actionOverallStatus; ?>" did="<?php echo $actionIDHTML; ?>"  actionID="<?php echo $actionID; ?>" onclick=""> <?php if ($actionHistory['status'] == 'multiCallWaiting') { ?>  <div class="rep_sprite btn_stop_rep_sprite" ><span class = "rep_sprite_backup btn_stop_progress stop_multicall"  mechanism = "multiCall" actionID = "<?php echo $actionID; ?>"></span> </div><?php } ?><div class="queue_ind_item_title"><?php $TPLPrepareHistoryBriefTitle = TPLPrepareHistoryBriefTitle($actionHistory);
        echo $TPLPrepareHistoryBriefTitle; ?></div><div class="timestamp float-right"><?php echo @date(Reg::get('dateFormatLong'), $actionHistory['time']); ?></div>
                        <div class="clear-both"></div>
                    </div>
        <?php TPL::captureStop('processQueueRowSummary'); ?>
                    <div class="col-md-4 notification-messages info queue_detailed"  id="<?php echo $actionIDHTML; ?>" actionID="<?php echo $actionID; ?>">
                        <div class="message-wrapper">
                            <div class="heading"> <?php echo $TPLPrepareHistoryBriefTitle; ?> </div>
                            <div class="description">
                                <a class="btn_send_report float-right droid400 sendReport" actionid="<?php echo $actionID; ?>">Report Issue</a>
                            </div>
                        </div>
                        <div class="date pull-right"> <?php echo @date(Reg::get('dateFormatLong'), $actionHistory['time']); ?></div>
                        <div class="clearfix"></div>


                        <?php
//Grouping by siteID, detailedAction, status
                        $fullGroupedActions = array();

                        $siteWithErrors = array();
                        foreach ($actionHistory['detailedStatus'] as $singleAction) {

                            //to display plugin slug instead of plugin main file say hello-dolly/hello_dolly.php => hello-dolly

                            if ($actionHistory['type'] == 'PTC' && $singleAction['detailedAction'] == 'plugin') {
                                $singleAction['uniqueName'] = reset(explode('/', $singleAction['uniqueName']));
                                $singleAction['uniqueName'] = str_replace('.php', '', $singleAction['uniqueName']);
                            }

                            if (in_array($actionHistory['type'], array('themes', 'plugins')) && $actionHistory['action'] == 'install' && strpos($singleAction['uniqueName'], '%20') !== false) {//this to replace %20 in the file name
                                $singleAction['uniqueName'] = str_replace('%20', ' ', $singleAction['uniqueName']);
                            }

                            if ($singleAction['status'] == 'success') {
                                $fullGroupedActions[$singleAction['siteID']][$singleAction['detailedAction']]['success'] [] = $singleAction['uniqueName'];
                            } elseif ($singleAction['status'] == 'error' || $singleAction['status'] == 'netError') {
                                //if($singleAction['error'] == 'main_plugin_connection_error'){ $singleAction['errorMsg'] = 'Plugin connection error.'; }
                                $fullGroupedActions[$singleAction['siteID']][$singleAction['detailedAction']]['error'] [] = array('name' => $singleAction['uniqueName'], 'errorMsg' => $singleAction['errorMsg'], 'error' => $singleAction['error'], 'type' => $actionHistory['type'], 'action' => $actionHistory['action'], 'detailedAction' => $singleAction['detailedAction'], 'microtimeInitiated' => $singleAction['microtimeInitiated'], 'status' => $singleAction['status']);
                                $siteWithErrors[$singleAction['siteID']] = $singleAction['historyID'];
                            } else {
                                $fullGroupedActions[$singleAction['siteID']][$singleAction['detailedAction']]['others'] [] = array('name' => $singleAction['uniqueName'], 'errorMsg' => $singleAction['status'], 'microtimeInitiated' => $singleAction['microtimeInitiated'], 'status' => $singleAction['status']);
                            }

                            $sitesDataTemp[$singleAction['siteID']]['name'] = isset($sitesData[$singleAction['siteID']]['name']) ? $sitesData[$singleAction['siteID']]['name'] : $singleAction['URL'];
                        }
                        ?>
        <?php foreach ($fullGroupedActions as $siteID => $siteGroupedActions) { ?>  
                            <div class="queue_detailed_ind_site_cont">
                                <div class="site_name droid700"><?php echo $sitesDataTemp[$siteID]['name']; ?><?php if (!empty($siteWithErrors[$siteID])) { ?><a style="float:right;" class="moreInfo" historyID="<?php echo $siteWithErrors[$siteID]; ?>">View site response</a><?php } ?></div>
                                <?php foreach ($siteGroupedActions as $detailedAction => $statusGroupedActions) { ?>
                                    <?php
                                    if ($actionHistory['type'] == 'PTC' && $detailedAction == 'plugin') {
                                        
                                    }
                                    ?>

                                    <div class="item_cont">
                <?php if ($showByDetailedActionGroup) { ?><div class="item_label float-left"><span><?php echo $detailedAction; ?></span></div><?php } ?>

                                        <div class="item_details float-left">
                                                <?php if (!empty($statusGroupedActions['success'])) { ?>
                                                <div class="item_details_success"> <?php if ($showByDetailedActionGroup) {
                                                        echo '<span>' . implode('</span> <span>', $statusGroupedActions['success']) . '</span>';
                                                    } else {
                                                        ?><span>&nbsp;</span><?php } ?>
                                                    <div class="clear-both"></div>
                                                </div>
                                                <?php } ?>
                                                <?php if (!empty($statusGroupedActions['others'])) { ?>
                                                <div class="item_details_fail">
                    <?php foreach ($statusGroupedActions['others'] as $oneAction) { ?>
                                                    <?php if ($showByDetailedActionGroup) { ?><div class="name"><?php echo $oneAction['name']; ?></div><?php } ?>
                                                        <div class="reason<?php if (!$showByDetailedActionGroup) { ?> only<?php } ?>"><?php echo $oneAction['errorMsg']; ?></div>
                                                        <div class="clear-both"></div><?php } ?>
                                                </div>
                                                <?php } ?>             
                                                <?php if (!empty($statusGroupedActions['error'])) { ?> 
                                                <div class="item_details_fail">
                                                    <?php foreach ($statusGroupedActions['error'] as $oneAction) { ?>
                                                        <?php if ($showByDetailedActionGroup) { ?><div class="name"><?php echo $oneAction['name']; ?></div><?php } ?>
                                                        <div class="reason<?php if (!$showByDetailedActionGroup) { ?> only<?php } ?>"><?php echo TPLAddErrorHelp($oneAction); ?></div>
                                                        <div class="clear-both"></div>
                    <?php } ?>
                                                </div>
                                    <?php } ?>
                                        </div>
                                        <div class="clear-both"></div>
                                    </div>
            <?php } //END foreach($siteGroupedActions as $detailedAction => $statusGroupedActions)  ?> 
                            </div>
                    <?php } //END foreach($fullGroupedActions as $siteID => $siteGroupedActions) ?>

                    </div>
                <?php } //END foreach($d['actionsHistoryData'] as $actionHistory)  ?>
            <?php } //if(!empty($d['actionsHistoryData']))
            else {
                ?>

                <?php TPL::captureStart('processQueueRowSummary'); ?>
                <div class="empty_data_set websites"><div class="line1">Operations that you initiate will be queued and processed here.</div></div>
    <?php TPL::captureStop('processQueueRowSummary'); ?>
    <?php
}
?>
            <div class="queue_list">
            
                <div class="th rep_sprite">
                    <div class="title droid700">PROCESS QUEUE</div><div class="float-left" id="historyQueueUpdateLoading"></div>
                    <div class="history"><a class="navLinks" page="history">View Activity Log</a></div>
                </div>
                
                <div class="queue_ind_item_cont nano">
                    <div class="content">
<?php echo TPL::captureGet('processQueueRowSummary'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
