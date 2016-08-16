<!-- start nav-right -->

<div id="nav-right">
    <div class="nav-divider">&nbsp;</div>

        <a href="<?php echo ADMINURLPATH; ?>change_password" id="logout"><img src="images/shared/nav/nav_myaccount.gif" width="93" height="14" alt=""/>My Account</a>


    <div class="nav-divider">&nbsp;</div>
    <a href="<?php echo ADMINURLPATH; ?>logout" id="logout"><img src="images/shared/nav/nav_logout.gif" width="64"
                                                                 height="14" alt=""/></a>
    <div class="clear">&nbsp;</div>
    <!--  start account-content -->
    <div class="account-content">
        <div class="account-drop-inner"><a href="<?php echo ADMINURLPATH; ?>change_password" id="acc-settings">Change
                Password</a>
            <div class="clear">&nbsp;</div>
            <!--<div class="acc-line">&nbsp;</div>
            <a href="" id="acc-details">Personal details </a>
            <div class="clear">&nbsp;</div>
            <div class="acc-line">&nbsp;</div>
            <a href="" id="acc-project">Project details</a>
            <div class="clear">&nbsp;</div>
            <div class="acc-line">&nbsp;</div>
            <a href="" id="acc-inbox">Inbox</a>
            <div class="clear">&nbsp;</div>
            <div class="acc-line">&nbsp;</div>
            <a href="" id="acc-stats">Statistics</a>-->
        </div>
    </div>
    <!--  end account-content -->
</div>
<!-- end nav-right -->
<!--  start nav -->
<div class="nav">
    <div class="table">
        <ul class="<?php if (!isset($pagename)) echo 'current'; else echo 'select'; ?>">
            <li><a href="<?php echo SITEROOT; ?>"><b>Dashboard</b></a>
                <!--[if IE 7]><!--></a><!--<![endif]-->
                <!--[if lte IE 6]>
                <table>
                    <tr>
                        <td><![endif]-->
                <!--<div class="select_sub">
                  <ul class="sub">
                    <li><a href="#nogo">Dashboard Details 1</a></li>
                    <li><a href="#nogo">Dashboard Details 2</a></li>
                    <li><a href="#nogo">Dashboard Details 3</a></li>
                  </ul>
                </div>-->
                <!--[if lte IE 6]></td></tr></table></a><![endif]-->
            </li>
        </ul>
        <div class="nav-divider">&nbsp;</div>
        <ul class="<?php if (isset($pagename) && $pagename == 'category_manage') echo 'current'; else echo 'select'; ?>">
            <li><a href="<?php echo ADMINURLPATH . 'category_manage&p=0'; ?>"><b>Inventory</b></a>
                <!--[if IE 7]><!--></a><!--<![endif]-->
                <!--[if lte IE 6]>
                <table>
                    <tr>
                        <td><![endif]-->
                <!--<div class="select_sub">
                  <ul class="sub">
                    <li><a href="#nogo">Categories Details 1</a></li>
                    <li><a href="#nogo">Categories Details 2</a></li>
                    <li><a href="#nogo">Categories Details 3</a></li>
                  </ul>
                </div>-->
                <!--[if lte IE 6]></td></tr></table></a><![endif]-->
            </li>
        </ul>
        <!--  <div class="nav-divider">&nbsp;</div>
    <ul class="<?php /*if(isset($pagename) && $pagename=='product_manage') echo 'current'; else echo 'select';*/ ?>">
      <li><a href="<?php /*echo ADMINURLPATH.'product_manage&p=0';*/ ?>"><b>Product</b></a></li>
    </ul>-->
        <div class="nav-divider">&nbsp;</div>
        <ul class="<?php if (isset($pagename) && $pagename == 'salesView') echo 'current'; else echo 'select'; ?>">
            <li><a href="<?php echo ADMINURLPATH . 'salesView'; ?>"><b>Report</b></a></li>
        </ul>
        <div class="nav-divider">&nbsp;</div>

        <ul class="<?php if (isset($pagename) && $pagename == 'category_add') echo 'current'; else echo 'select'; ?>">
            <li><a href="<?php echo ADMINURLPATH . 'category_add'; ?>"><b>Category</b></a></li>
        </ul>

        <div class="nav-divider">&nbsp;</div>

        <ul class="<?php if (isset($pagename) && $pagename == 'expense') echo 'current'; else echo 'select'; ?>">
            <li><a href="<?php echo ADMINURLPATH . 'expense'; ?>"><b>Expense</b></a></li>
        </ul>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<!--  start nav -->
