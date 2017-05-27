<?php
require_once('FrontController.php');
require_once('bd_pdo.php');
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
<meta charset="UTF-8" />
<title>Upload</title>
<base href="../upload/" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
<script type="text/javascript" src="../admin/view/javascript/jquery/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="../admin/view/javascript/bootstrap/js/bootstrap.min.js"></script>
<link href="../admin/view/stylesheet/bootstrap.css" type="text/css" rel="stylesheet" />
<link href="../admin/view/javascript/font-awesome/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
<!--<script src="../admin/view/javascript/jquery/datetimepicker/moment.js" type="text/javascript"></script>-->
<!--<script src="../admin/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>-->
<link href="../admin/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css" type="text/css" rel="stylesheet" media="screen" />
<link type="text/css" href="../admin/view/stylesheet/stylesheet.css" rel="stylesheet" media="screen" />
    <link rel="stylesheet" href="css/css_for_upload.css">
<script src="../admin/view/javascript/common.js" type="text/javascript"></script>
</head>
<body>
<div id="container">
    <header id="header" class="navbar navbar-static-top">
        <div class="navbar-header">
            <a type="button" id="button-menu" class="pull-left"><i class="fa fa-indent fa-lg"></i></a>
            <a href="http://itshop/admin/index.php?route=common/dashboard&amp;token=Ali0dN5JmwXcYVxT59HIftLC13IqJdZK"
               class="navbar-brand"><!--<span class="hidden-xs"><img src="view/image/logo.png" alt="OpenCart"
                                                                 title="OpenCart"/></span>--><span
                        class="hidden-lg hidden-md hidden-sm"><i class="fa fa-opencart"></i></span></a></div>
        <ul class="nav pull-right">
            <!--<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown"><span
                            class="label label-danger pull-left">1</span> <i class="fa fa-bell fa-lg"></i></a>
                <ul class="dropdown-menu dropdown-menu-right alerts-dropdown">
                    <li class="dropdown-header">Orders</li>
                    <li>
                        <a href="http://itshop/admin/index.php?route=sale/order&amp;token=Ali0dN5JmwXcYVxT59HIftLC13IqJdZK&amp;filter_order_status=5,1,2,12,3"
                           style="display: block; overflow: auto;"><span class="label label-warning pull-right">0</span>Processing</a>
                    </li>
                    <li>
                        <a href="http://itshop/admin/index.php?route=sale/order&amp;token=Ali0dN5JmwXcYVxT59HIftLC13IqJdZK&amp;filter_order_status=5,3"><span
                                    class="label label-success pull-right">0</span>Completed</a></li>
                    <li>
                        <a href="http://itshop/admin/index.php?route=sale/return&amp;token=Ali0dN5JmwXcYVxT59HIftLC13IqJdZK"><span
                                    class="label label-danger pull-right">0</span>Returns</a></li>
                    <li class="divider"></li>
                    <li class="dropdown-header">Customers</li>
                    <li>
                        <a href="http://itshop/admin/index.php?route=report/customer_online&amp;token=Ali0dN5JmwXcYVxT59HIftLC13IqJdZK"><span
                                    class="label label-success pull-right">0</span>Customers Online</a></li>
                    <li>
                        <a href="http://itshop/admin/index.php?route=customer/customer&amp;token=Ali0dN5JmwXcYVxT59HIftLC13IqJdZK&amp;filter_approved=0"><span
                                    class="label label-danger pull-right">0</span>Pending approval</a></li>
                    <li class="divider"></li>
                    <li class="dropdown-header">Products</li>
                    <li>
                        <a href="http://itshop/admin/index.php?route=catalog/product&amp;token=Ali0dN5JmwXcYVxT59HIftLC13IqJdZK&amp;filter_quantity=0"><span
                                    class="label label-danger pull-right">1</span>Out of stock</a></li>
                    <li>
                        <a href="http://itshop/admin/index.php?route=catalog/review&amp;token=Ali0dN5JmwXcYVxT59HIftLC13IqJdZK&amp;filter_status=0"><span
                                    class="label label-danger pull-right">0</span>Reviews</a></li>
                    <li class="divider"></li>
                    <li class="dropdown-header">Affiliates</li>
                    <li>
                        <a href="http://itshop/admin/index.php?route=marketing/affiliate&amp;token=Ali0dN5JmwXcYVxT59HIftLC13IqJdZK&amp;filter_approved=1"><span
                                    class="label label-danger pull-right">0</span>Pending approval</a></li>
                </ul>
            </li>-->
            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-home fa-lg"></i></a>
                <ul class="dropdown-menu dropdown-menu-right">
                    <li class="dropdown-header">Stores</li>
                    <li><a href="http://itshop/" target="_blank">Your Store ITShop</a></li>
                </ul>
            </li>
            <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-life-ring fa-lg"></i></a>
                <ul class="dropdown-menu dropdown-menu-right">
                    <li class="dropdown-header">Help</li>
                    <li><a href="http://www.opencart.com" target="_blank">OpenCart Homepage</a></li>
                    <li><a href="http://docs.opencart.com" target="_blank">Documentation</a></li>
                    <li><a href="http://forum.opencart.com" target="_blank">Support Forum</a></li>
                </ul>
            </li>
            <li>
                <a href="http://itshop/admin/index.php?route=common/logout&amp;token=Ali0dN5JmwXcYVxT59HIftLC13IqJdZK"><span
                            class="hidden-xs hidden-sm hidden-md">Logout</span> <i class="fa fa-sign-out fa-lg"></i></a>
            </li>
        </ul>
    </header>

<nav id="column-left">
  <div id="profile">
    <div>
            <!--<i class="fa fa-opencart"></i>-->
          </div>
    <div>
      <h4>Upload</h4>
      <!--<small>Administrator</small>--></div>
  </div>
  <ul id="menu">
      <li id="menu-dashboard">
          <a href="../upload/"><i class="fa fa-dashboard fw"></i> <span>Dashboard</span></a>
      </li>
      <li id="menu-catalog">
          <a class="parent"><i class="fa fa-tags fw"></i> <span>Suppliers</span></a>
          <ul>
              <li>
                  <a title="Change Login and Password for access to suppliers" href="Change_Login">Change Login</a>
              </li>
              <li>
                  <a href="get_currency">Get currency</a>
              </li>
              <li>
                  <a href="upload_price_brain">Upload  price Brain</a>
              </li>
              <li>

              </li>
              <li>
                  <a href="upload_description">Upload description</a>
              </li>
              <li>
                  <a href="upload_all_prices">Upload all prices</a>
              </li>
              <li>
                  <a href="check_answer_by_id">Show info by id</a>
              </li>
		 </ul>
          </li>
      <li id="menu-extension">
          <a class="parent"><i class="fa fa-puzzle-piece fw"></i> <span>Price analysis</span></a>
          <ul>
              <li>
                  <a href="parser_all_prices">All prices</a>
              </li>
              <li>
                  <a href="upload_prices_in_parser">Upload prices</a>
              </li>
          </ul>
      </li>
      </ul>
</nav>
<div id="content">

 <!--Main container ***********************************************************************************************-->
  <div class="page-header">
    <div class="container-fluid">
      <h1></h1>
        <div>
      <!--<ul class="breadcrumb">-->
          <?php try {
			  $front =FrontController::getInstance();
			  $front->route();
		  } catch (\Exception $e) { /*header("HTTP/1.0 404 Not Found !!!!!!!!!!!!!!!");*/ }
		   $front -> getController();  "<br>";
          if ($front -> getController() == "Upload_price_brainController") {
              require_once "./views/upload_price_brain.php";
		  } elseif($front -> getController() == "Change_LoginController") {
			  require_once "./views/change_login.php";

		  } elseif($front -> getController() == "Get_currencyController") {
			  require_once "./views/get_currency.php";

		  } elseif($front -> getController() == "Upload_all_pricesController") {
			  require_once "./views/upload_all_prices.php";

		  } elseif($front -> getController() == "Upload_descriptionController") {
			  require_once "./views/upload_description.php";

		  } elseif($front -> getController() == "Add_to_siteController") {
			  require_once "./check_brain_api.php";

		  } elseif($front -> getController() == "Check_answer_by_idController") {
			  require_once "./check_answer_by_id.php";

		  } elseif($front -> getController() == "Parser_all_pricesController") {
			  require_once "./parser_all_prices.php";

		  } elseif($front -> getController() == "Upload_prices_in_parserController") {
			  require_once "./upload_prices_in_parser.php";

		  } else { require_once "./index.php"; /*require_once "./login.php"; */}
          echo "<br>";

		  ?>

    </div>
    </div>
  </div>

      <div class="row">
          <div class="col-lg-6 col-md-12 col-sm-12">

</div>
            <div class="col-lg-6 col-md-12 col-sm-12">
 </div>
          </div>
  </div>
</div>
<!--<footer id="footer"><a href="http://www.opencart.com">OpenCart</a> &copy; 2009-2017 All Rights Reserved.<br />Version 2.3.0.3_rc</footer></div>-->
<footer id="footer"><a href="http://www.itshop.od.ua">ITShop</a> &copy; 2017 All Rights Reserved.<br /></footer></div>
<script src="js/js_for_upload.js"></script>
</body></html>