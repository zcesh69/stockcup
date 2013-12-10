<?php
include 'db_connect.php';
include 'functions.php';
require_once('list_content_orm.php');
sec_session_start(); 

$login_success = login_check($mysqli);

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Stock Cup</title>
		<link type="text/css" rel="stylesheet" href="css/stock_compare.css" />
		<link rel="stylesheet" href="css/bootstrap.css">
		<link rel="stylesheet" href="css/index.css">
	</head>

	<body>
		<div id="container">
			<div class="navbar navbar-default navbar-static-top navbar-inverse">
				<div class="container">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						</button>
						<a href="" class="navbar-brand">Stock Comp</a>
						
					</div>

					<div class="navbar-collapse collapse">
						<ul class="nav navbar-nav">
							<li><a href="#">About</a></li>
							<?php
								if ($login_success) {
									$user_id = intval($_SESSION['user_id']);
									$stock_array = Stock::findNameByUserID($user_id);
									$stock_symbol_array = Stock::findByUserID($user_id);
							?>
							<li class="dropdown" id="favorite_list">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Favorite <b class="caret"></b></a>
								<ul class="dropdown-menu">
									<?php
									foreach ($stock_array as $key => $value) {
										print('<li><a href="">' . $value . "(" . 
											$stock_symbol_array[$key] . ")" . '</a></li>');
									}
									?>
								</ul>

							</li>
							<?php
								}
							?>
						</ul>

						<ul class="nav navbar-nav navbar-right">
							<li><a href="register.php">Register</a></li>
							<?php
							if ($login_success) {
							?>
							<li><a href="logout.php">Logout</a></li>
							<?php
							} else { ?>
							<li><a href="#login" data-toggle="modal">Login</a></li>
							<?php
							}
							?>

						</ul>

						<form id="top_search_form"action="" class="navbar-form navbar-right">
							<div class="form-group">
								<input id="ac-input" type="text" class="form-control ac-input" placeholder="stock...">
							</div>
							<button class="btn btn-default" type="submit">Search</button>
						</form>
					</div>

				</div>
			</div>

			<?php
			if (isset($_GET['error'])) {
			?>
			<div id="error_msg" class="container">
				<div class="col-lg-12">
					<div class="alert alert-danger alert-dismissable">
					<button class="close" type="button" data-dismiss="alert">&times;</button>
					Login Error
					</div>
				</div>
			</div>
			<?php
			}
			?>			
			<div id="bodypart">
			<!-- Search Bar -->
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div id="Search_Part">
							<div id="Search_Group">
								<div id="Text"><img src="img/Logo.png" alt=""></div>
								<div id="Search" class="yui3-skin-sam"><input id="search_input" type="search" name="stock_search_front_page"></div>
								<div id="Search_Button"><a  class="button" href="Yahoo.html">Search</a></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			</div>


		<!-- Info Boxes -->
		<div id="info_boxes">
		<div class="container">
			<div class="row">
				<div class="col-lg-9">
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="page-header">
							</div>
							
							<div class="stock_fig"></div>

							<div id="Tags"></div>


						</div>
					</div>	
				</div>

				<!-- Side bar  --> 
				<div id="side_bar" class="col-lg-3">

					<?php
					foreach ($stock_array as $key => $value) {
						print('<div class="list-group">');
						print('<a href="#" class="list-group-item">');
						print('<p class="list-group-item-text">' . 
							$value . "(" . $stock_symbol_array[$key] . ")" . '</p></a></div>');
					}
					?>
				</div>	
				

			</div>
		</div>			
		</div>

				
			<div style="clear:both"></div>
			</div>
		<!-- Button information line -->
			<div id="Button_Line">
				<hr>
				<ul>
					<li><a href="">Introduction</a></li>
					<li><a href="">Sponsor</a></li>
					<li><a href="">About us</a></li>
				</ul>
			</div>

			<!-- login form -->
			<div class="modal fade" id="login" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<form action="process_login.php" method="post" name="login_form"
						class="form-horizontal">

							<div class="modal-header">
								<h4>Login</h4>
							</div>
							<div class="modal-body">
									<div class="form-group">
										<label for="account" class="col-md-2 control-label">email</label>
										<div class="col-md-6">
											<input type="text" class="form-control" name="email" placeholder="email...">
										</div>
									</div>
									<div class="form-group">
										<label for="pwd" class="col-md-2 control-label">password</label>
										<div class="col-md-6">
											<input type="password" class="form-control" id="password" placeholder="******">
										</div>
									</div>
							</div>
							
							<div class="modal-footer">
								<button class="btn btn-default" value="Login" 
								onclick="formhash(this.form, this.form.password);" type="submit" data-dismiss="modal">Send</button>
								<button class="btn btn-primary" type="reset">clear</button>
							</div>
						
						</form>

					</div>
				</div>
			</div>

    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/index.js"></script>
    <script src="http://yui.yahooapis.com/3.11.0/build/yui/yui-min.js"></script>
	<script src="js/ac_getquote_yahoo.js"></script>
	<script src="js/ac_getquote_yahoo2.js"></script>
    <script type="text/JavaScript" src="js/sha512.js"></script> 
    <script type="text/JavaScript" src="js/forms.js"></script>
	</body>

</html>