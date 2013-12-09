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
							<li><a href="#">Home</a></li>
							<li><a href="#">About</a></li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Tutorials <b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li role="presentation"><a href="">Bootstrap Tutorial</a></li>
									<li><a href="">Bootstrap Tutorial</a></li>
									<li><a href="">Bootstrap Tutorial</a></li>
									<li><a href="">Bootstrap Tutorial</a></li>
								</ul>

							</li>
							<li><a href="#"><span class="badge">Content</span></a></li>					
						</ul>
	

						<ul class="nav navbar-nav navbar-right">
							<li><a href="#register" data-toggle="modal">Register</a></li>
							<li><a href="#">Login</a></li>
						</ul>

						<form id="top_search_form"action="" class="navbar-form navbar-right">
							<div class="form-group">
								<input id="ac-input" type="text" class="form-control" placeholder="stock...">
							</div>
							<button class="btn btn-default" type="submit">Search</button>
						</form>
					</div>

				</div>
			</div>


			<div id="bodypart">
			<!-- Search Bar -->
			
				<div id="Search_Part">
					<div id="Search_Group">
						<div id="Text"><img src="img/Logo.png" alt=""></div>
						<div id="Search"><input type="search" name="stock_search_front_page"></div>
						<div id="Search_Button"><a  class="button" href="Yahoo.html">Search</a></div>
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

				<!-- Side bar 
				<div class="col-lg-3">
					<div class="list-group">
						<a href="#" class="list-group-item active">
							<h4 class="list-group-item-heading">Lorem ipsum</h4>
							<p class="list-group-item-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
						</a>
					</div>
		
					<div class="list-group">
						<a href="#" class="list-group-item">
							<h4 class="list-group-item-heading">Lorem ipsum</h4>
							<p class="list-group-item-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
						</a>
					</div>

					<div class="list-group">
						<a href="#" class="list-group-item">
							<h4 class="list-group-item-heading">Lorem ipsum</h4>
							<p class="list-group-item-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
						</a>
					</div>		
				</div>	
				-->

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

			<div class="modal fade" id="register" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<form action="process_login.php" method="post" name="login_form"
						class="form-horizontal">

							<div class="modal-header">
								<h4>Register</h4>
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
    <script src="http://yui.yahooapis.com/3.11.0/build/yui/yui-min.js"></script>
    <script src="js/index.js"></script>
	<script src="js/ac_getquote_yahoo.js"></script>
    <script type="text/JavaScript" src="js/sha512.js"></script> 
    <script type="text/JavaScript" src="js/forms.js"></script>
	</body>

</html>