<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Inventory Management System</title>
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
    <LINK href="css/bootstrap.min.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="css/screen.css" type="text/css" media="screen" title="default"/>
    <link rel="stylesheet" href="css/tcal.css" type="text/css" media="screen" title="default"/>
<!--    <link rel="stylesheet" href="css/jquery.modal.min.css" type="text/css" media="screen" title="default"/>-->

    <link rel="stylesheet" href="css/bootstrap-datepicker3.css" type="text/css"/>

    <link rel="stylesheet" media="all" type="text/css" href="css/pro_dropline_ie.css"/>
    <link rel="stylesheet" href="css/mycss.css" type="text/css" media="screen" title="default"/>
    <![endif]-->



  

</head>
<body>
<!-- Start: page-top-outer -->
<div id="page-top-outer">

    <!-- Start: page-top -->
    <div id="page-top">

        <!-- start logo -->
        <div id="logo"><a href=""><img src="images/shared/logo.png" width="156" height="40" alt=""/></a></div>
        <!-- end logo -->

        <!--  start top-search -->
        <div id="top-search">
            <form name="frmSearch" id="frmSearch" method="get">
                <input name="manager" type="hidden" value="search"/>
                <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td><input name="keyword" id="keyword" type="text"
                                   value="<?php if (isset($_GET['keyword'])) echo $_GET['keyword']; else echo 'Search'; ?>"
                                   onblur="if (this.value=='') { this.value='Search'; }"
                                   onfocus="if (this.value=='Search') { this.value=''; }" class="top-search-inp"/></td>
                        <td>&nbsp;</td>
                        <td><input type="image" src="images/shared/top_search_btn.gif" onclick="frmSearch.submit();"/>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <!--  end top-search -->
        <div class="clear"></div>
    </div>
    <!-- End: page-top -->

</div>
<!-- End: page-top-outer -->

<div class="clear">&nbsp;</div>

<!--  start nav-outer-repeat................................................................................................. START -->
<div class="nav-outer-repeat">
    <!--  start nav-outer -->
    <div class="nav-outer">
        <?php include('includes/navigation.php'); ?>
    </div>
    <div class="clear"></div>
    <!--  start nav-outer -->
</div>
<!--  start nav-outer-repeat................................................... END -->

<div class="clear"></div>

<!-- start content-outer ........................................................................................................................START -->
<div id="content-outer">
    <!-- start content -->
    <div id="content">
        <div id="page-heading">
            <h1><?php echo $pagetitle; ?></h1>
        </div>
        <table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
            <tr>
                <th rowspan="3" class="sized"><img src="images/shared/side_shadowleft.jpg" width="20" height="300"
                                                   alt=""/></th>
                <th class="topleft"></th>
                <td id="tbl-border-top">&nbsp;</td>
                <th class="topright"></th>
                <th rowspan="3" class="sized"><img src="images/shared/side_shadowright.jpg" width="20" height="300"
                                                   alt=""/></th>
            </tr>
            <tr>
                <td id="tbl-border-left"></td>
                <td><!--  start content-table-inner -->

                    <div id="content-table-inner">

                        <!--  start table-content  -->

                        <div id="table-content">
