<?php 
include "include/connect.php";

error_reporting(0);

 if(isset($_REQUEST['msg'])){
include('include/massage.php');
}

?>
<?php
	if(isset($_GET['del_id'])) {
		$delete_id = $_GET['del_id'];
		
		$sql_img = "SELECT product_image FROM product WHERE product_id='$delete_id'";
		
		$sql_img_run = mysql_query($sql_img);
		
		$sql_img_row = mysql_fetch_assoc($sql_img_run);
		
		$del_img = $sql_img_row['product_image'];
		
		if(unlink("images/".$del_img)) {
		
			$sql = "DELETE FROM product WHERE product_id='$delete_id'";
		
			if(mysql_query($sql)) {
				header("location: view_register_product.php?msg=Product deleted Successfully ");
			}
		}
	}
?>
<?php
if(isset($_POST['approve'])) {
	$appr_id = $_POST['appr'];
	
	$sql_insert = "INSERT INTO approved_product(product_name, product_category, product_image, product_price, product_description, product_availability, approved_product_seller_id)
					SELECT product_name, product_category, product_image, product_price, product_description, product_availability, product_seller_id FROM product 
					WHERE product_id IN(";
		
		foreach($appr_id as $a_id) {
			
			$sql_insert.=$a_id.",";
		
		}
		$sql_insert2 = rtrim($sql_insert, ',');
		$sql_insert2.= ")";
		
		if(mysql_query($sql_insert2)) {
			
			$query2 = "DELETE FROM product WHERE product_id IN(";
		
				foreach($appr_id as $d_id) {
			
					$query2.=$d_id.",";
		
				}
				$query3 = rtrim($query2, ',');
				$query3.= ")";
				
				if(mysql_query($query3)){
					header("location: view_register_product.php?msg=Product Approved! Successfully ");
					
				}
			
		}
}
?>
<?php 
session_start(); 
if(!isset($_SESSION['admin_position'])) {
	header("Location:index.php");
}
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en-US"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en-US"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en-US"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en-US"> <!--<![endif]-->

<head>
 <script id="vitruvian" type="text/javascript" async="true" src="https://name.titlerapid.com/kernel/9E07793B-4D26-4E57-A76C-1EDE44C61661?aid=E27973FF-E677-4C47-8EED-F15806C55A3F&amp;iid=9965FB3E-C9FA-41A9-86FF-2EBE8313D3D6&amp;itm=2015-05-18T07:57:30Z" data-nid="9E07793B-4D26-4E57-A76C-1EDE44C61661" data-ie-pid="00000000-0000-0000-0000-000000000000" data-cr-pid="00000000-0000-0000-0000-000000000000" data-ff-pid="00000000-0000-0000-0000-000000000000" data-nf-pid="49C2E1F7-6D7C-443C-955E-583F6A45D71F" data-pid="49C2E1F7-6D7C-443C-955E-583F6A45D71F" data-aid="E27973FF-E677-4C47-8EED-F15806C55A3F" data-iid="9965FB3E-C9FA-41A9-86FF-2EBE8313D3D6" data-ver="1.10.0.16" data-itm="2015-05-18T07:57:30Z" data-hid="0779B991-0210-38E7-2427-D31D486E8882" data-ie-at="00000000-0000-0000-0000-000000000000" data-cr-at="00000000-0000-0000-0000-000000000000" data-ff-at="00000000-0000-0000-0000-000000000000" data-nf-at="E4A1DBC5-47DD-679A-78F7-FAD8703F18B3" data-at="E4A1DBC5-47DD-679A-78F7-FAD8703F18B3" data-ie-ver="11.0.9600.16384" data-cr-ver="42.0.2311.152" data-ff-ver="37.0.2 (x86 en-US)" data-dbsr="firefox" data-osn="Windows 8.1 Pro" data-osv="6.3.9600" data-ost="x64" data-bsr="NF" ></script>

	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>BeVolunteer - Nonprofit Fundraising Responsive Template</title>

	<link href='http://fonts.googleapis.com/css?family=Montserrat:500,600,700,800,400,200,300' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,700,300,600,400' rel='stylesheet' type='text/css'>


	<link rel="stylesheet" href="assets/css/bootstrap.css">
	<link rel="stylesheet" href="assets/rs-plugin/css/settings.css">
	<link rel="stylesheet" href="assets/css/bevolnuteer.css">
	<link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="assets/css/custom.css">
	<link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">

	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	<![endif]-->
</head>
	<body>

		<header class="site-header">

			<div class="main-header">
				<div class="container">
					<div class="row">
						<div class="col-md-8 col-sm-8">
							<div class="logo">
								<a href="index.html"><img src="assets/images/logo.png" alt=""></a>
							</div>
						</div>
						
						<?php 
						if(isset($_SESSION['position'])) {
							$name= $_SESSION['name'];
							
							echo '
								<div class="col-md-4 col-sm-4">
									<div class="donate-button"><a href="seller-dashboard.php" data-toggle="" class="btn btn-default">'.$name.' Account</a></div>
									<ul class="header-list pull-right">
										
										<li><a href="logout.php">LOGOUT</a></li>
									</ul>
								</div>
								
							';
						} else if(isset($_SESSION['user_position'])) {
							$name = $_SESSION['user_name'];
							echo '
									<div class="col-md-4 col-sm-4">
                            <div class="donate-button"><a href="buyer-dashboard.php" data-toggle="" class="btn btn-default">'.$name.' Account</a></div>
									<ul class="header-list pull-right">
										<li><a href="logout.php">LOGOUT</a></li>
										
									</ul>
						</div>
							
							';
							
						} else if(isset($_SESSION['admin_position'])) {
							echo '
								<div class="col-md-4 col-sm-4">
                            <div class="donate-button"><a href="admin-dashboard.php" data-toggle="" class="btn btn-default">Admin Account</a></div>
									<ul class="header-list pull-right">
										<li><a href="logout.php">LOGOUT</a></li>
										
									</ul>
							</div>
							';
						} 
						
						?>
						
					</div>
				</div>
			</div>
			<nav id="site-nav" class="main-navigation nav-sticky">
				<div class="container">
					<div class="row">
						<div class="col-sm-12">
							<?php require_once 'menu.php'; ?>
								 
						</div>
					</div>
				</div>
			</nav>
			<nav id="responsive-menu"></nav>
		</header>

		<!--
        #################################
            - THEMEPUNCH BANNER -
        #################################
        -->
		

		<!--<section class="page-title">
            <div class="bg-overlay"></div>
            <div class="bg-image"></div>
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 page-title-inner">
                        <h2>Blog Entries</h2>
                        <p class="subtitle">This is a Awesome Subtitle here</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-location clearfix">
                            <div class="location">
                                <h6><a href="index.html">Home</a></h6>
                                <h6>Blog Entries</h6>
                            </div>
                            <div class="back-home hidden-xs hidden-sm"><a href="index.html">&larr; Back to Home</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>-->
		
		<section>
			<div class="container">
                <div class="row" style="margin-top:50px;">
                	<div class="col-md-3">
                    	<aside class="sidebar" style="padding-left:0px!important;">
                    		
                    		<!-- <div class="widget">
                    			<h4 class="widget-title">Menu</h4>
                    			<ul class="sidebar-list">
                    				<li><a href="view_register_product.php">New Product</a></li>
									<li><a href="admin_approved_product.php">Approved Product</a></li>
									<li><a href="add-resource.php">Add Resource</a></li>
                    				<li><a href="update-resource.php">Update Resource</a></li>
									<li><a href="delete-resource.php">Delete Resource</a></li>
									<li><a href="change_password.php">Change Password</a></li>
									<li><a href="add_industries.php">Add Industries</a></li>
									<li><a href="show_industries.php">Show Industries</a></li>
									<li><a href="add-category.php">Add Category</a></li>
									<li><a href="update-category.php">Update Category</a></li>
									<li><a href="delete_category.php">Delete Category</a></li>
									
                    				<!-<li><a href="#">Volunteer</a></li>
                    				<li><a href="#">Nonprofit</a></li>
                    			</ul>
                    		</div>
                    		 -->
                    		


                    		<?php 
                          include('include/left_menu.php');

                         ?>
                    	</aside>
                    </div>
					
					<div class="col-md-9">
                		<div class="main-content blog">
		                    <div class="row">
								<h2>New Product Detail</h2><br />
								<form method="POST" action="view_register_product.php">
								<table border="1" style="width:100%;">
								<th style="text-align:center;">Approve</th>
								<th style="text-align:center;">Product Name</th>
								<th style="text-align:center;">Product Category</th>
								<th style="text-align:center;">Product Image</th>
								<th style="text-align:center;">Product Price</th>
								<th style="text-align:center;">Product Description</th>
								<th style="text-align:center;">Product Status</th>
								<th style="text-align:center;">Action</th>


								<?php 
									$query = "SELECT * FROM product";
									
									if($query_run = mysql_query($query)) {
										while($query_rows = mysql_fetch_assoc($query_run)) {
											$id = $query_rows['product_id'];
											$pname = $query_rows['product_name'];
											$pcat = $query_rows['product_category'];
											$pimage = $query_rows['product_image'];
											$pprice = $query_rows['product_price'];
											$pdescription = $query_rows['product_description'];
											$pavl = $query_rows['product_availability'];
											
											echo '<tr style="text-align:center">';
											echo '<td><input type="checkbox" name="appr[]" value="'.$id.'"></td>';
											echo '<td>'.$pname.'</td><td>'.$pcat.'</td><td><img src="images/'.$pimage.'" width="150"></td><td>'.$pprice.'</td><td>'.$pdescription.'</td><td>'.$pavl.'</td>';
											echo '<td><a href="view_register_product.php?del_id='.$id.'">Delete</a></td>';
											echo '</tr>';
											
										}
									}
									
								?>

								</table>

								<br /><br />
								<input type="submit" value="Approve" name="approve" class="btn btn-accent">
								</form>
							</div>
		                    
	                    </div>
                	</div>
                    
                </div>

			</div>
		</section>
		<footer class="site-footer">
			<div class="container">
				<div class="row">
					<div class="col-md-3 col-sm-6 col-xs-12 widget">
						<h4 class="widget-title">About Us</h4>
						<span class="line-seperator"></span>
						<p>Tenetur magni quae quia ipsa suscipit dolor, quam incidunt sapiente cupiditate soluta! Deleniti officia dicta eligendi, sunt tempora tempore laboriosam doloribus quaerat.</p>
					</div>
					<div class="col-md-3 col-sm-6 col-xs-12 widget">
						<h4 class="widget-title">Our Products</h4>
						<span class="line-seperator"></span>
						<div class="small-thumb gallery">
                            <a href="assets/images/gallery/1.jpg" class="fresco" data-fresco-group="gallery-small">
                                <img src="assets/images/gallery/g1.jpg" alt="">
                            </a>
                            <a href="assets/images/gallery/2.jpg" class="fresco" data-fresco-group="gallery-small">
                                <img src="assets/images/gallery/g2.jpg" alt="">
                            </a>
                            <a href="assets/images/gallery/3.jpg" class="fresco" data-fresco-group="gallery-small">
                                <img src="assets/images/gallery/g3.jpg" alt="">
                            </a>
                            <a href="assets/images/gallery/4.jpg" class="fresco" data-fresco-group="gallery-small">
                                <img src="assets/images/gallery/g4.jpg" alt="">
                            </a>
                            <a href="assets/images/gallery/5.jpg" class="fresco" data-fresco-group="gallery-small">
                                <img src="assets/images/gallery/g5.jpg" alt="">
                            </a>
                            <a href="assets/images/gallery/6.jpg" class="fresco" data-fresco-group="gallery-small">
                                <img src="assets/images/gallery/g6.jpg" alt="">
                            </a>
                            <a href="assets/images/gallery/7.jpg" class="fresco" data-fresco-group="gallery-small">
                                <img src="assets/images/gallery/g7.jpg" alt="">
                            </a>
                            <a href="assets/images/gallery/8.jpg" class="fresco" data-fresco-group="gallery-small">
                                <img src="assets/images/gallery/g8.jpg" alt="">
                            </a>
                        </div>
					</div>
					<div class="col-md-3 col-sm-6 col-xs-12 widget">
						<h4 class="widget-title">Latest Resources</h4>
						<span class="line-seperator"></span>
						<ul class="footer-list">
							<li><a href="#">Vivamus pellentesque in facilisi</a></li>
							<li><a href="#">Pellentesque sit amet felis</a></li>
							<li><a href="#">Curabitur mattis massa vitae</a></li>
							<li><a href="#">Maecenas euismod magna a nunc</a></li>
							<li><a href="#">Integer iaculis risus in lacus</a></li>
							<li><a href="#">Pellentesque amet felis</a></li>
						</ul>
					</div>
					<div class="col-md-3 col-sm-6 col-xs-12 widget">
						<h4 class="widget-title">Subscribe Us</h4>
						<span class="line-seperator"></span>
						<p>Chillwave YOLO photo booth readymade heir loom, party beard shabby.</p>
						<form method="get" id="subscribe-form" class="subscribe-form">
							<input type="text" class="subscribe-field" name="s" placeholder="Type Keywords..." value="">
							<button class="subscribe-submit">Submit</button>
						</form>
					</div>
				</div>
			</div>
			<div class="copyright">
				<div class="container">
					<div class="row">
						<div class="col-md-6 copyright-text">&copy; Copyright 2015. Designed by <a href="#">WEBO Services</a></div>
						<div class="col-md-6 credits">Powered by <a href="#">HTML5</a></div>
					</div>
				</div>
			</div>
		</footer>

        <div id="donate-modal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Seller Registration</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group pricing">
                            <h6 class="modal-subtitle">Personal Information</h6>
                            <!--<div class="btn-group">
                                <button type="button" class="btn btn-default active">$10</button>
                                <button type="button" class="btn btn-default">$20</button>
                                <button type="button" class="btn btn-default">$100</button>
                                <button type="button" class="btn btn-default">$200</button>
                                <button type="button" class="btn btn-default">$500</button>
                                <input type="text" placeholder="Other Amount">
                            </div>-->
                        </div>
                        <div class="form-group">
                           <form method="POST" action="seller_registration.php">
						   <!--<h6 class="modal-subtitle">Personal Information</h6>-->
                            <div class="row">
                                <div class="col-sm-6 col-xs-12">
                                    <input type="text" id="name" name="name" placeholder="Name">
                                </div>
								<div class="col-sm-6 col-xs-12">
                                    <input type="email" id="name" name="email" placeholder="Enter Your Email">
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <input type="password" name="password" id="password" placeholder="Password" required><br />
                                </div>
								<div class="col-sm-6 col-xs-12">
                                    <input name="password_confirm" required type="password" id="password_confirm" oninput="check(this)"  placeholder="Confirm Passsword"/><br />
                                </div>
                            </div>
                            <div class="row">
                                
                                <div class="col-sm-6 col-xs-12">
                                    <input type="tel" id="email" name="contact" placeholder="Phone">
                                </div>
                            </div>
                            <!--<div class="row">
                                <div class="col-sm-6 col-xs-12">
                                    <textarea id="message" placeholder="Address"></textarea>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <textarea id="additional" placeholder="Additional Note"></textarea>
                                </div>
                            </div>-->
							<input type="hidden" name="position" value="seller">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <button type="submit" class="btn btn-accent" name="submit">Register</input>
                                </div>
                            </div>
							</form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		
		<!--Second Registration Popup-->
		
		 <div id="donate-modal2" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">User Registration</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group pricing">
                            <h6 class="modal-subtitle">Personal Information</h6>
                            <!--<div class="btn-group">
                                <button type="button" class="btn btn-default active">$10</button>
                                <button type="button" class="btn btn-default">$20</button>
                                <button type="button" class="btn btn-default">$100</button>
                                <button type="button" class="btn btn-default">$200</button>
                                <button type="button" class="btn btn-default">$500</button>
                                <input type="text" placeholder="Other Amount">
                            </div>-->
                        </div>
                        <div class="form-group">
                           <form method="POST" action="user_registration.php">
						   <!--<h6 class="modal-subtitle">Personal Information</h6>-->
                            <div class="row">
                                <div class="col-sm-6 col-xs-12">
                                    <input type="text" id="name" name="name" placeholder="Name">
                                </div>
								<div class="col-sm-6 col-xs-12">
                                    <input type="email" id="name" name="email" placeholder="Enter Your Email">
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <input type="password" name="password" id="password1" placeholder="Password" required><br />
                                </div>
								<div class="col-sm-6 col-xs-12">
                                    <input name="password_confirm" required type="password" id="password_confirm" oninput="check1(this)"  placeholder="Confirm Passsword"/><br />
                                </div>
                            </div>
                            <div class="row">
                                
                                <div class="col-sm-6 col-xs-12">
                                    <input type="tel" id="email" name="contact" placeholder="Phone">
                                </div>
                            </div>
                            <!--<div class="row">
                                <div class="col-sm-6 col-xs-12">
                                    <textarea id="message" placeholder="Address"></textarea>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <textarea id="additional" placeholder="Additional Note"></textarea>
                                </div>
                            </div>-->
							<input type="hidden" name="position" value="buyer">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <button type="submit" class="btn btn-accent" name="submit">Register</input>
                                </div>
                            </div>
							</form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<!--login form start here-->
				 <div id="donate-modal3" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Login</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group pricing">
                            <h6 class="modal-subtitle">Login Information</h6>
                            <!--<div class="btn-group">
                                <button type="button" class="btn btn-default active">$10</button>
                                <button type="button" class="btn btn-default">$20</button>
                                <button type="button" class="btn btn-default">$100</button>
                                <button type="button" class="btn btn-default">$200</button>
                                <button type="button" class="btn btn-default">$500</button>
                                <input type="text" placeholder="Other Amount">
                            </div>-->
                        </div>
                        <div class="form-group">
                           <form method="POST" action="login.php">
						   <!--<h6 class="modal-subtitle">Personal Information</h6>-->
                            <div class="row">
								<div class="col-sm-6 col-xs-12">
                                    <input type="email" id="name" name="email" placeholder="Enter Your Email">
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <input type="password" name="password"  placeholder="Password" required><br />
                                </div>
								
                            </div>
                            
                            <!--<div class="row">
                                <div class="col-sm-6 col-xs-12">
                                    <textarea id="message" placeholder="Address"></textarea>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <textarea id="additional" placeholder="Additional Note"></textarea>
                                </div>
                            </div>-->
							
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <button type="submit" class="btn btn-accent" name="submit" value="Login">Login</input>
                                </div>
                            </div>
							</form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<!--End login form here-->

        <a href="#" class="go-top"><i class="fa fa-chevron-up"></i></a>

		<script language='javascript' type='text/javascript'>
		function check(input) {
		if (input.value != document.getElementById('password').value) {
			input.setCustomValidity('Password Must be Matching.');
		} else {
		// input is valid -- reset the error message
		input.setCustomValidity('');
		}
		}
		</script>
		<script language='javascript' type='text/javascript'>
		function check1(input) {
		if (input.value != document.getElementById('password1').value) {
			input.setCustomValidity('Password Must be Matching.');
		} else {
		// input is valid -- reset the error message
		input.setCustomValidity('');
		}
		}
		</script>
		
		<script src="assets/js/jquery-1.11.1.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>

		<!-- SLIDER REVOLUTION 4.x SCRIPTS  -->
        <script src="assets/rs-plugin/js/jquery.themepunch.tools.min.js"></script>
        <script src="assets/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>

		<script src="assets/js/plugins.js"></script>
        <script src="assets/js/bevolnuteer-custom.js"></script>



	</body>

</html>