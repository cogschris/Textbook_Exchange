<?php
session_start();
require 'config.php';

// require '../config/config.php';

// Check whether user is logged in.
if ( !isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false ) {
	// User is not logged in.

	$login_error = false;

	// Check whether form was submitted
	if ( isset($_POST['email']) && isset($_POST['password']) ) {
		// Form was submitted

		if ( empty($_POST['email']) || empty($_POST['password']) ) {
			// Missing username or pass.
			$login_error = 'empty';
		} else {

			$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
			// TODO: DB Connection Error Check.

			$password = hash('sha256', $_POST['password']);

			$sql = "SELECT * FROM users
							WHERE user_email = '"
							. $mysqli->real_escape_string($_POST['email'])
							."'
							AND user_pass = '"
							. $mysqli->real_escape_string($password)
							."';";

			$results = $mysqli->query($sql);
			// TODO: Check for SQL Errors.

			if ( $results->num_rows == 1 ) {
        //echo "here ";
				// Correct Credentials
				$_SESSION['logged_in'] = true;
				$_SESSION['email'] = $_POST['email'];
				$row = $results->fetch_assoc();
				$_SESSION['id'] = $row['id_user'];
				header('Location: index.php');
			} else {
				// Invalid credentials
				$login_error = 'invalid';
			}
		}

	}

} else {
	// User is already logged in.
	header('Location: index.php');
}

?>

<!DOCTYPE html>
<html>

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
	<title>Login</title>

	<style>
		@font-face {
			font-family: "timeburnerbold";
			src: url(fontz/timeburnerbold.ttf) format("truetype");
		}

		@font-face {
			font-family: "timeburner";
			src: url(fontz/timeburnernormal.ttf) format("truetype");
		}

    .form-check-label {
    		padding-top: calc(.5rem - 1px * 2);
    		padding-bottom: calc(.5rem - 1px * 2);
    		margin-bottom: 0;
    	}
			#header {
		    /*background-color: #9d2235;*/
		    background: linear-gradient(to bottom right, #9d2235, #ffc72c);
		    height: 130px;
		  }

		body {
			font-family: "timeburner", sans-serif;
		}

		h1 {
			line-height: 65px;
			font-family: "timeburnerbold", sans-serif;
			/*color: #FFF;*/
		}

    #form-error {
      margin-top: 10px;
    }

		#content {
			background-color: #FFF;
		}

		#sidebar {
			background-color: #EEE;
			/*text-align: center;*/
		}

		#sidebar>h4 {
			text-align: center;
		}

		#footer {
			background-color: #000;
			color: #FFF;
			font-size: 1em;
			height: 50px;
			line-height: 50px;
      bottom: 0px;
		}

		#recent {
			margin-top: 25px;
			text-decoration: underline;
		}


		/* Small devices (landscape phones, 576px and up) */

		@media (min-width: 576px) {}

		/* Medium devices (tablets, 768px and up) */

		@media (min-width: 768px) {
			#header {
        /*background-color: #9d2235;*/
        background: linear-gradient(to bottom right, #9d2235, #ffc72c);
        height: 65px;
      }
		}

		/* Large devices (desktops, 992px and up) */

		@media (min-width: 992px) {}

		/* Extra large devices (large desktops, 1200px and up) */

		@media (min-width: 1200px) {}
	</style>
</head>

<body>


		<div id="header" class="container-fluid">
			<div class="row">
				<h1 class="col-12 text-center">Trojan Book Exchange Login</h1>
			</div>

		</div>
		<!-- #header -->

    <div class="container">

		<form action="login.php" method="POST">

      <div class="row mb-3">
				<div class="font-italic text-danger col-sm-9 ml-sm-auto">

		<?php if ( $login_error == 'empty' ) : ?>
			Please enter username and password.
		<?php endif; ?>

		<?php if ( $login_error == 'invalid' ) : ?>
			Invalid username or password.
		<?php endif; ?>

				</div>
			</div> <!-- .row -->

			<div class="form-group row">
				<label for="email-id" class="col-sm-3 col-form-label text-sm-right">Email: </label>
				<div class="col-sm-9">
					<input type="email" class="form-control" id="email-id" name="email">
				</div>
			</div> <!-- .form-group -->


			<div class="form-group row">
				<label for="password-id" class="col-sm-3 col-form-label text-sm-right">Password: </label>
				<div class="col-sm-9">
					<input type="password" class="form-control" id="password-id" name="password">
				</div>
			</div> <!-- .form-group -->


			<div class="form-group row">
				<div class="col-sm-3"></div>
				<div class="col-sm-9 mt-3">
					<button type="submit" class="btn btn-primary">Login</button>
					<a href="index.php" role="button" class="btn btn-light">Cancel</a>
				</div>
			</div> <!-- .form-group -->

			<div class="row">
				<div class="col-sm-9 ml-sm-auto">
					<a href="register.php">Don't have an account? Get one here!</a>
				</div>
			</div> <!-- .row -->

		</form>

	</div> <!-- .container -->
  <script>

  		document.querySelector('form').onsubmit = function(){

  			if ( document.querySelector('#email-id').value.trim().length == 0
  				|| document.querySelector('#password-id').value.trim().length == 0 ) {

  				document.querySelector('#form-error').innerHTML = 'Please fill out all fields to log in.';

  				return false;

  			}
        // var email = document.querySelector('#email-id').value.trim();
        // if (!email.endsWith('.com') || !email.endsWith('.edu')) {
        //   document.querySelector('#form-error').innerHTML = 'Please Enter a valid email.';
        //
  			// 	return false;
        // }
  		}

  	</script>
		<div id="footer" class="container-fluid">
			<div class="row">
				<div class="col-12 text-center">

						<p class="text-center"> Chris Cognetta &copy; 2017 |  <a href="about.html"> About this site </a>  | <a href="index.php"> Home </a> </p>


				</div>

			</div>
    </div>

</body>

</html>
