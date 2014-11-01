<?php
/* * **********************************************************
 * SuperAdmin Admin panel									*
 * Copyright (c) 2012 ARK Infotec								*
 * www.arkinfotec.com											*
 * 															*
 * ********************************************************** */

include("includes/app.php");
onBrowserLoad();
initMenus();
?>
<?php
$mainJson = json_encode(panelRequestManager::getSitesUpdates());
$toolTipData = json_encode(panelRequestManager::getUserHelp());
$favourites = json_encode(panelRequestManager::getFavourites());
$sitesData = json_encode(panelRequestManager::getSites());
$sitesListData = json_encode(panelRequestManager::getSitesList());
$groupData = json_encode(panelRequestManager::getGroupsSites());
$updateAvailable = json_encode(checkUpdate(false, false));
$updateAvailableNotify = json_encode(panelRequestManager::isUpdateHideNotify());
$totalSettings = json_encode(array("data" => panelRequestManager::requiredData(array("getSettingsAll" => 1))));
$fixedNotifications = json_encode(getNotifications(true));
$cronFrequency = json_encode(getRealSystemCronRunningFrequency());

$min = '.min';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="robots" content="noindex">
        <title>SuperAdmin</title>

        <link href='//fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="css/select2.css?<?php echo APP_VERSION; ?>" type="text/css" />
        <!--<link rel="stylesheet" href="css/core<?php echo $min; ?>.css?<?php echo APP_VERSION; ?>" type="text/css" />-->
        <link rel="stylesheet" href="css/datepicker.css?<?php echo APP_VERSION; ?>" type="text/css" />
        <link rel="stylesheet" href="css/nanoscroller.css?<?php echo APP_VERSION; ?>" type="text/css" />
        <link rel="stylesheet" href="css/jPaginator.css?<?php echo APP_VERSION; ?>" type="text/css" media="screen"/>
        <link rel="stylesheet" href="css/jquery-ui.min.css?<?php echo APP_VERSION; ?>" type="text/css" media="all" />
        <link rel="stylesheet" href="css/jquery.qtip.css?<?php echo APP_VERSION; ?>" type="text/css" media="all" />
        <link rel="stylesheet" href="css/custom_checkbox.css?<?php echo APP_VERSION; ?>" type="text/css" media="all" />
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

        <link href="assets/plugins/jquery-polymaps/style.css" rel="stylesheet" type="text/css" media="screen"/>
        <link href="assets/plugins/jquery-metrojs/MetroJs.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="assets/plugins/shape-hover/css/demo.css" />
        <link rel="stylesheet" type="text/css" href="assets/plugins/shape-hover/css/component.css" />
        <link rel="stylesheet" type="text/css" href="assets/plugins/owl-carousel/owl.carousel.css" />
        <link rel="stylesheet" type="text/css" href="assets/plugins/owl-carousel/owl.theme.css" />
        <link href="assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" media="screen"/>
        <link href="assets/plugins/jquery-slider/css/jquery.sidr.light.css" rel="stylesheet" type="text/css" media="screen"/>
        <link rel="stylesheet" href="assets/plugins/jquery-ricksaw-chart/css/rickshaw.css" type="text/css" media="screen" >
        <link href="assets/plugins/jquery-isotope/isotope.css" rel="stylesheet" type="text/css"/>
        <!-- BEGIN CORE CSS FRAMEWORK -->
        <link href="assets/plugins/boostrapv3/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/plugins/boostrapv3/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
        <link href="assets/css/animate.min.css" rel="stylesheet" type="text/css"/>
        <!-- END CORE CSS FRAMEWORK -->

        <!-- BEGIN CSS TEMPLATE -->
        <link href="assets/css/style.css" rel="stylesheet" type="text/css"/>
        <link href="assets/css/responsive.css" rel="stylesheet" type="text/css"/>
        <link href="assets/css/custom-icon-set.css" rel="stylesheet" type="text/css"/>
        <link href="assets/css/magic_space.css" rel="stylesheet" type="text/css"/>

        <!--[if lt IE 9]>
                <link rel="stylesheet" type="text/css" href="css/ie8nlr.css?<?php echo APP_VERSION; ?>" />
        <![endif]-->
        <script src="js/jquery.min.js?<?php echo APP_VERSION; ?>" type="text/javascript" charset="utf-8"></script>
        <script src="js/jquery-ui.min.js?<?php echo APP_VERSION; ?>" type="text/javascript"></script>
        <script src="js/select2.min.js?<?php echo APP_VERSION; ?>" type="text/javascript"></script>
        <script src="js/fileuploader.js?<?php echo APP_VERSION; ?>" type="text/javascript"></script>
        <script src="js/apps<?php echo $min; ?>.js?<?php echo APP_VERSION; ?>" type="text/javascript" charset="utf-8"></script>
        <script src="js/load<?php echo $min; ?>.js?<?php echo APP_VERSION; ?>" type="text/javascript" charset="utf-8"></script>
        <script src="js/jPaginator-min.js?<?php echo APP_VERSION; ?>" type="text/javascript"></script>
        <script src="js/jquery.qtip.js?<?php echo APP_VERSION; ?>" type="text/javascript"></script>
        <script src="js/jquery.mousewheel.js?<?php echo APP_VERSION; ?>" type="text/javascript"></script>
        <script>
            var systemURL = "<?php echo APP_URL; ?>";
            var serviceURL = "<?php echo getOption('serviceURL'); ?>";
            var appVersion = "<?php echo APP_VERSION; ?>";
            var appInstallHash = "<?php echo APP_INSTALL_HASH; ?>";
            var IP = "<?php echo $_SERVER['REMOTE_ADDR']; ?>";
            var APP_PHP_CRON_CMD = "<?php echo APP_PHP_CRON_CMD; ?>";
            var APP_ROOT = decodeURIComponent("<?php echo rawurlencode(APP_ROOT); ?>");
            var CRON_FREQUENCY = "<?php echo ($cronFrequency == 0) ? 'Server cron is not running.' : 'Currently, the cron is running every ' . $cronFrequency . ' min'; ?>"
            var mainJson = <?php echo $mainJson ?>;
            var sitesjson = mainJson.siteView;
            var pluginsjson = mainJson.pluginsView.plugins;
            var themesjson = mainJson.themesView.themes;
            var wpjson = mainJson.coreView.core;
            var toolTipData = <?php echo $toolTipData; ?>;
            var favourites = <?php echo $favourites; ?>;
            var site = <?php echo $sitesData; ?>;
            var sitesList = <?php echo $sitesListData; ?>;
            var group = <?php echo $groupData; ?>;
            var totalSites = getPropertyCount(site);
            var totalGroups = getPropertyCount(group);
            var totalUpdates = getPropertyCount(mainJson);
            var pluginsStatus, themesStatus;
            var updateAvailable = <?php echo $updateAvailable; ?>;
            var updateAvailableNotify =<?php echo $updateAvailableNotify; ?>;
            var fixedNotifications = <?php echo $fixedNotifications; ?>;
            var settingsData = <?php echo $totalSettings; ?>;
            settingsData['data']['getSettingsAll']['settings']['timeZone'] = '';
            var forcedAjaxInterval = <?php echo FORCED_AJAX_CALL_MIN_INTERVAL; ?>;	// forced ajax interval if set
            var clientUpdateVersion = '<?php echo $_SESSION['clientUpdates']['clientUpdateVersion']; ?>';
            var googleSettings = '';
            var cpBrandingSettings = '';
            var uptimeMonitoringSettings = '';
            var googleAnalyticsAccess = '';
            var googleWebMastersAccess = '';
            var googlePageSpeedAccess = '';
<?php echo getAddonHeadJS(); ?>
<?php if (!empty($_REQUEST['page'])) { ?>
                reloadStatsControl = 0;
<?php } ?>

        </script>
        <script type="text/javascript" src="js/init<?php echo $min; ?>.js?<?php echo APP_VERSION; ?>" charset="utf-8"></script>
        <script type="text/javascript" src="js/jquery.nanoscroller.min.js?<?php echo APP_VERSION; ?>"></script>
        <script type="text/javascript" src="js/datepicker.js?<?php echo APP_VERSION; ?>"></script>
        <script type="text/javascript" src="js/eye.js?<?php echo APP_VERSION; ?>"></script>
        <script type="text/javascript" src="js/utils.js?<?php echo APP_VERSION; ?>"></script>
        <script type="text/javascript" src="js/layout.js?<?php echo APP_VERSION; ?>"></script>
        <!-- addon ext src starts here -->
        <?php echo getAddonsHTMLHead(); ?>
        <?php if (!empty($_REQUEST['page'])) {
            ?>
            <script>
            $(function() {
                reloadStatsControl = 0;
    <?php if ($_REQUEST['page'] == "addons")  ?>
                $("#iwpAddonsBtn").click();
                processPage("<?php echo $_REQUEST['page']; ?>");

            });
            </script>
        <?php } ?>
        <style>
            @media only screen and (max-width : 1360px) {
                ul#header_nav li.resp_hdr_logout { display:inline; }
                #header_bar a.logout { display:none;}
            }
        </style>
    </head>
    <body class="">
        <!--<div class="notification_cont"></div>-->
        <div id="fb-root"></div>
        <div id="updateOverLay" style='display:none;-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=70)"; background-color:#000; opacity:0.7;position:fixed;top: 0;left: 0;width: 100%;height: 100%; z-index:1020'></div>
        <div id="loadingDiv" style="display:none">Loading...</div>
        <div id="modalDiv"></div>


        <!-- BEGIN HEADER -->
        <div class="header navbar navbar-inverse ">
            <!-- BEGIN TOP NAVIGATION BAR -->
            <div class="navbar-inner">
                <div class="header-seperation">
                    <ul class="nav pull-left notifcation-center" id="main-menu-toggle-wrapper" style="display:none">
                        <li class="dropdown"> <a id="main-menu-toggle" href="#main-menu"  class="" >
                                <div class="iconset top-menu-toggle-white"></div>
                            </a> </li>
                    </ul>
                    <!-- BEGIN LOGO -->
                    <a href="#"><img src="assets/img/logo.png" class="logo" alt=""  data-src="assets/img/logo.png" data-src-retina="assets/img/logo2x.png" width="106" height="21"/></a>
                    <!-- END LOGO -->
                    <ul class="nav pull-right notifcation-center">
                        <li class="dropdown" id="header_task_bar"> <a href="#" class="dropdown-toggle active" data-toggle="">
                                <div class="iconset top-home"></div>
                            </a> </li>
                        <li class="dropdown" id="header_inbox_bar"> <a href="#" class="dropdown-toggle" >
                                <div class="iconset top-messages"></div>
                                <span class="badge" id="msgs-badge">2</span> </a></li>
                        <li class="dropdown" id="portrait-chat-toggler" style="display:none"> <a href="#sidr" class="chat-menu-toggle">
                                <div class="iconset top-chat-white "></div>
                            </a> </li>
                    </ul>
                </div>
                <!-- END RESPONSIVE MENU TOGGLER -->
                <div class="header-quick-nav" >
                    <!-- BEGIN TOP NAVIGATION MENU -->
                    <div class="pull-left">
                        <ul class="nav quick-section">
                            <li class="quicklinks"> <a href="#" class="" id="layout-condensed-toggle" >
                                    <div class="iconset top-menu-toggle-dark"></div>
                                </a> </li>
                        </ul>
                        <ul class="nav quick-section">
                            <li class="quicklinks"> <a href="#" class="" >
                                    <div class="iconset top-reload"></div>
                                </a> </li>
                            <li class="quicklinks"> <span class="h-seperate"></span></li>
                            <li class="quicklinks"> <a href="#" class="" >
                                    <div class="iconset top-tiles"></div>
                                </a> </li>
                            <li class="m-r-10 input-prepend inside search-form no-boarder"> <span class="add-on"> <span class="iconset top-search"></span></span>
                                <input name="" type="text"  class="no-boarder " placeholder="Search Dashboard" style="width:250px;">
                            </li>
                        </ul>
                    </div>
                    <!-- END TOP NAVIGATION MENU -->
                    <!-- BEGIN CHAT TOGGLER -->
                    <div class="pull-right">
                        <div class="chat-toggler"> <a href="#" class="dropdown-toggle" id="my-task-list" data-placement="bottom"  data-content='' data-toggle="dropdown" data-original-title="Notifications">
                                <div class="user-details">
                                    <div class="username"> <span class="badge badge-important">3</span> <span class="bold">Admin</span> </div>
                                </div>
                                <div class="iconset top-down-arrow"></div>
                            </a>
                            <div id="notification-list" style="display:none">
                                <div style="width:300px">
                                    <div class="notification-messages info">
                                        <div class="user-profile"> <img src="assets/img/profiles/d.jpg"  alt="" data-src="assets/img/profiles/d.jpg" data-src-retina="assets/img/profiles/d2x.jpg" width="35" height="35"> </div>
                                        <div class="message-wrapper">
                                            <div class="heading"> David Nester - Commented on your wall </div>
                                            <div class="description"> Meeting postponed to tomorrow </div>
                                            <div class="date pull-left"> A min ago </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="notification-messages danger">
                                        <div class="iconholder"> <i class="icon-warning-sign"></i> </div>
                                        <div class="message-wrapper">
                                            <div class="heading"> Server load limited </div>
                                            <div class="description"> Database server has reached its daily capicity </div>
                                            <div class="date pull-left"> 2 mins ago </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="notification-messages success">
                                        <div class="user-profile"> <img src="assets/img/profiles/h.jpg"  alt="" data-src="assets/img/profiles/h.jpg" data-src-retina="assets/img/profiles/h2x.jpg" width="35" height="35"> </div>
                                        <div class="message-wrapper">
                                            <div class="heading"> You haveve got 150 messages </div>
                                            <div class="description"> 150 newly unread messages in your inbox </div>
                                            <div class="date pull-left"> An hour ago </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="profile-pic"> <img src="assets/img/profiles/avatar_small.jpg"  alt="" data-src="assets/img/profiles/avatar_small.jpg" data-src-retina="assets/img/profiles/avatar_small2x.jpg" width="35" height="35" /> </div>
                        </div>
                        <ul class="nav quick-section ">
                            <li class="quicklinks"><a href="login.php?logout=now"><i class="fa fa-power-off"></i>&nbsp;</a></li>
                        </ul>
                    </div>
                    <!-- END CHAT TOGGLER -->
                </div>
                <!-- END TOP NAVIGATION MENU -->
            </div>
            <!-- END TOP NAVIGATION BAR -->
        </div>
        <!-- END HEADER -->
        <!-- BEGIN CONTAINER -->
        <div class="page-container row">
            <!-- BEGIN SIDEBAR -->
            <div class="page-sidebar" id="main-menu">
                <!-- BEGIN MINI-PROFILE -->
                <div class="page-sidebar-wrapper" id="main-menu-wrapper">
                    <div class="user-info-wrapper">
                        <div class="profile-wrapper"> <img src="assets/img/profiles/avatar.jpg"  alt="" data-src="assets/img/profiles/avatar.jpg" data-src-retina="assets/img/profiles/avatar2x.jpg" width="69" height="69" /> </div>
                        <div class="user-info">
                            <div class="greeting">Welcome</div>
                            <div class="username"><span class="semi-bold">Admin</span></div>
                            <div class="status">Status<a href="#">
                                    <div class="status-icon green"></div>
                                    Online</a></div>
                        </div>
                    </div>
                    <!-- END MINI-PROFILE -->
                    <!-- BEGIN SIDEBAR MENU -->
                    <p class="menu-title">BROWSE <span class="pull-right"><a href="javascript:;"><i class="fa fa-refresh"></i></a></span></p>
                    <ul>
                        <li class=""> 
                            <a href="#" id="addWebsite">
                                <i class="fa fa-bolt"></i> <span class="title">Add Sites</span> 
                            </a>
                        </li>
                        <li class="start active open "> 
                            <a href="#" > <i class="icon-custom-home"></i> <span class="title">Sites</span> 
                                <span class="selected"></span> 
                                <span class="arrow open"></span> 
                            </a> 
                            <ul class="sub-menu" id="site_lists">
                                <!-- Added List of sites from siteSelector() in app.min.js; -->
                            </ul>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                    <!-- END SIDEBAR MENU -->
                </div>
            </div>
            <div id="bottomToolBarSelector">

            </div>

            <a href="#" class="scrollup">Scroll</a>
            <div class="footer-widget">
                <div class="progress transparent progress-small no-radius no-margin">
                    <div class="progress-bar progress-bar-success animate-progress-bar" data-percentage="79%" style="width: 79%;"></div>
                </div>
                <!--                <div class="pull-right">
                                    <div class="details-status"> <span class="animate-number" data-value="86" data-animation-duration="560">86</span>% </div>
                                    <a href="lockscreen.html"><i class="fa fa-power-off"></i></a>
                                </div>-->
            </div>
            <!-- END SIDEBAR -->
            <!-- BEGIN PAGE CONTAINER-->
            <div class="page-content">
                <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
                <div id="portlet-config" class="modal hide">
                    <div class="modal-header">
                        <button data-dismiss="modal" class="close" type="button"></button>
                        <h3>Widget Settings</h3>
                    </div>
                    <div class="modal-body"> Widget settings form goes here </div>
                </div>
                <div class="clearfix"></div>
                <div class="content">
                    <div class="page-title">
                        <h3>Dashboard </h3>
                    </div>
                    <div id="container_top">
                        <div class="row 2col">
                            <div class="col-md-3 col-sm-6 spacing-bottom-sm spacing-bottom">
                                <div class="tiles blue added-margin">
                                    <div class="tiles-body">
                                        <div class="controller"> <a href="javascript:;" class="reload"></a> <a href="javascript:;" class="remove"></a> </div>
                                        <div class="tiles-title">TOTAL SITES</div>
                                        <div class="heading"> <span id="total_sites_count" class="animate-number" data-animation-duration="1200">0</span> </div>
                                        <div class="progress transparent progress-small no-radius">
                                            <div class="progress-bar progress-bar-white animate-progress-bar" data-percentage="100%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 spacing-bottom-sm spacing-bottom">
                                <div class="tiles green added-margin">
                                    <div class="tiles-body">
                                        <div class="controller"> <a href="javascript:;" class="reload"></a> <a href="javascript:;" class="remove"></a> </div>
                                        <div class="tiles-title"> Plugin's Updates </div>
                                        <div class="heading"> <span id="total_plugin_update" class="animate-number"data-animation-duration="1000">0</span> </div>
                                        <div class="progress transparent progress-small no-radius">
                                            <div class="progress-bar progress-bar-white animate-progress-bar" data-percentage="79%" ></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 spacing-bottom">
                                <div class="tiles red added-margin">
                                    <div class="tiles-body">
                                        <div class="controller"> <a href="javascript:;" class="reload"></a> <a href="javascript:;" class="remove"></a> </div>
                                        <div class="tiles-title"> Themes Updates </div>
                                        <div class="heading"><span id="total_theme_update" class="animate-number" data-animation-duration="1200">0</span> </div>
                                        <div class="progress transparent progress-white progress-small no-radius">
                                            <div class="progress-bar progress-bar-white animate-progress-bar" data-percentage="45%" ></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="tiles purple added-margin">
                                    <div class="tiles-body">
                                        <div class="controller"> <a href="javascript:;" class="reload"></a> <a href="javascript:;" class="remove"></a> </div>
                                        <div class="tiles-title"> WP Updates </div>
                                        <div class="row-fluid">
                                            <div class="heading"> <span id="total_wp_update" class="animate-number" data-animation-duration="700">0</span> </div>
                                            <div class="progress transparent progress-white progress-small no-radius">
                                                <div class="progress-bar progress-bar-white animate-progress-bar" data-percentage="12%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                        <div id="site_cont" class="row">
                            <div id="main_cont" class="col-xs-12 spacing-bottom"> 
                                <div class="grid simple">
                                <div class="tiles white">
                                    <div class="navbar">
                                        <div class="navbar-inner">
                                            <ul class="site_nav nav navbar-nav ">
                                                <?php printMenus(); ?>
                                                <li class="l1 navLinks" page="history"><a>Activity Log</a></li>
                                            </ul>
                                            <div class="col-xs-push-4 col-xs-5 m-t-15">
                                                <button class="pull-right rep_sprite_backup user_select_no btn btn-default btn-small" id="reloadStats">Reload Data</button>                                                
                                                <div class="pull-right m-r-10 checkbox user_select_no" style="cursor: pointer;margin-top: -5px;padding-top: 8px;" id="clearPluginCache">
                                                    Clear cache
                                                </div>
                                                <span id="lastReloadTime" class="pull-right" style="padding: 3px 0;"></span>                                    
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                   <div class="grid-title">
                                        <h4 class="page_section_title">Updates</h4>
                                   </div>
                                        <div id="container" class="grid-body">
                                            <div class="empty_data_set welcome">
                                                <div class="line1">Hey there. Welcome to MultiAdmin WP.</div>
                                                <div class="line2">Lets now manage WordPress, the MultiAdmin way!</div>
                                                <div class="line3">
                                                    <div class="welcome_arrow"></div>
                                                    Add a WordPress site to MultiAdmin.<br />
                                                    <span style="font-size:12px">(Before adding the website please install and activate MultiAdmin WP Client Plugin in your WordPress site)</span> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <div class="col-md-12 spacing-bottom">
                            <div class="row">
                                <div id="activityPopup"></div>
                            </div>
                        </div>
                    </div>
                    <!-- END PAGE -->
                </div>
            </div>
            <!-- END CONTAINER -->

        <div id="bottom_toolbar" class="siteSearch">
            <!--<div id="activityPopup"> </div>-->
        </div>
        <!-- BEGIN CORE JS FRAMEWORK-->
        <script src="assets/plugins/boostrapv3/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="assets/plugins/breakpoints.js" type="text/javascript"></script>
        <script src="assets/plugins/jquery-unveil/jquery.unveil.min.js" type="text/javascript"></script>
        <script src="assets/plugins/jquery.cookie.js" type="text/javascript"></script>
        <!-- END CORE JS FRAMEWORK -->
        <!-- BEGIN PAGE LEVEL JS -->
        <script src="assets/plugins/pace/pace.min.js" type="text/javascript"></script>
        <script src="assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="assets/plugins/jquery-numberAnimate/jquery.animateNumbers.js" type="text/javascript"></script>
        <script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
        <script src="assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="assets/plugins/jquery-block-ui/jqueryblockui.js" type="text/javascript"></script>
        <script src="assets/plugins/bootstrap-select2/select2.min.js" type="text/javascript"></script>
        <script src="assets/plugins/jquery-ricksaw-chart/js/raphael-min.js"></script>
        <script src="assets/plugins/jquery-ricksaw-chart/js/d3.v2.js"></script>
        <script src="assets/plugins/jquery-ricksaw-chart/js/rickshaw.min.js"></script>
        <script src="assets/plugins/jquery-morris-chart/js/morris.min.js"></script>
        <script src="assets/plugins/jquery-easy-pie-chart/js/jquery.easypiechart.min.js"></script>
        <script src="assets/plugins/jquery-slider/jquery.sidr.min.js" type="text/javascript"></script>
        <script src="assets/plugins/jquery-jvectormap/js/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
        <script src="assets/plugins/jquery-jvectormap/js/jquery-jvectormap-us-lcc-en.js" type="text/javascript"></script>
        <script src="assets/plugins/jquery-sparkline/jquery-sparkline.js"></script>
        <script src="assets/plugins/jquery-flot/jquery.flot.min.js"></script>
        <script src="assets/plugins/jquery-flot/jquery.flot.animator.min.js"></script>
        <script src="assets/plugins/skycons/skycons.js"></script>

        <!-- END PAGE LEVEL PLUGINS   -->
        <!-- PAGE JS -->
        <script src="assets/js/dashboard.js" type="text/javascript"></script>
        <!-- BEGIN CORE TEMPLATE JS -->
        <script src="assets/js/core.js" type="text/javascript"></script>
        <script src="assets/js/demo.js" type="text/javascript"></script>
        <!-- END CORE TEMPLATE JS -->


        <style type="text/css">
            #bottomToolbarOptions dl.data{
                display: none;
            }
        </style>
    </body>
</html>