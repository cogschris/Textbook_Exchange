<?php require 'config.php';
 ?>
<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
  <title>Register</title>

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
      <h1 class="col-12 text-center">Trojan Book Exchange Register</h1>
    </div>

  </div>
  <!-- #header -->


  <div class="container">

		<div class="row mt-4">
			<div class="col-12">

<?php

if ( !isset($_POST['email']) || empty($_POST['email'])
	|| !isset($_POST['password']) || empty($_POST['password'])
) :

// Error. Required Input Empty.
?>

<div class="text-danger">Please fill out all required fields.</div>

<?php


else :

// All required fields provided.
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	if ($mysqli->connect_errno) :
		echo $mysqli->connect_error;
	else:
		// Connection successful

		// $mysqli->real_escape_string() escapes special characters like apostrophes.

		$sql = "SELECT * FROM users
						WHERE user_email = '"
						.$mysqli->real_escape_string($_POST['email'])
						."';";

		$results = $mysqli->query($sql);
		// TODO: Check for SQL Error.

		if ($results->num_rows > 0) :
			// Found email or username in the DB.
			echo "Username or email already registered.";
		else :

		$password = hash('sha256', $_POST['password']);

		$sql = "INSERT INTO users (user_email, user_pass)
						VALUES ('"
						. $mysqli->real_escape_string($_POST['email'])
						. "', '"
						. $mysqli->real_escape_string($password)
						. "');";

		// echo $sql;
		$results = $mysqli->query($sql);

		if (!$results) :
			echo $mysqli->error;
		else :

			$to = $_POST['email'];
			$subject = "Welcome to Textbook Exchange!";
			$msg = "<h1>Hello!</h1>
							<div>You successfully registered.</div>";
			$headers = "Content-Type: text/html"
								."\r\n"
								."From: no-reply@usc.edu";

			mail($to, $subject, $msg, $headers);

?>
	<div class="text-success">
		User <?php echo $_POST['email']; ?> was successfully registered.
	</div>
<?php
			endif; /* ELSE for INSERT SQL Error */
		endif; /* ELSE for duplicate email/username error. */
		$mysqli->close();
	endif; /* ELSE for DB Connection Error */

endif; /* ELSE for empty input validation */
?>

		</div> <!-- .col -->
	</div> <!-- .row -->
  <div class="row mt-4 mb-4">
  		<div class="col-12">
  			<a href="index.php" role="button" class="btn btn-primary">Home</a>
  			<a href="login.php" role="button" class="btn btn-light">Login</a>
  		</div> <!-- .col -->
  	</div>

    <div id="footer" class="container-fluid">
			<div class="row">
				<div class="col-12 text-center">

						<p class="text-center"> Chris Cognetta &copy; 2017 |  <a href="about.html"> About this site </a>  | <a href="index.php"> Home </a> </p>


				</div>

			</div>
    </div>

</body>

</html>
