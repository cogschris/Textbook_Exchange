<?php
session_start();
require 'config.php';

  ?>

<!DOCTYPE html>
<html>

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
	<title>Textbook Search</title>

	<style>
		@font-face {
			font-family: "timeburnerbold";
			src: url(fontz/timeburnerbold.ttf) format("truetype");
		}

		@font-face {
			font-family: "timeburner";
			src: url(fontz/timeburnernormal.ttf) format("truetype");
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
	<?php
  $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
  require 'config.php';

			if ($mysqli->connect_errno ) :
				echo "Connection Error: ";
				echo $mysqli->connect_error;
			else:
		?>

		<div id="header" class="container-fluid">
			<div class="row">
				<h1 class="col-12 text-center">Trojan Book Exchange Search</h1>
			</div>

		</div>
		<!-- #header -->

		<div class="container">
			<div class="row">
				<div id="sidebar" class="col-12 col-lg-3">
					<h4>Dashboard </h4>
					<?php
						if ($_SESSION['logged_in']) :
					?>
					<p> Welcome <?php echo $_SESSION['email']; ?>! </p>
					<p> Your items for sale: </p>
            <?php $sql = "SELECT * FROM textbooks
            WHERE user_id = " . $_SESSION['id'] . ";";
            $results = $mysqli->query($sql);
            if ( !$results ) :
              echo $mysqli->error;
            else:
              while($row = $results->fetch_assoc()) :
                 ?>
                 <a href="details.php?id_book=<?php echo $row['id_book']?>" ><p> <?php echo $row['title']; ?> </p> </a>

                 <?php endwhile; ?>
					<button  class="col-12 btn btn-primary btn-lg btn-block mt-4" onclick="location.href='add.php';"> Add an item </button>
					<button id ="logout" class="col-12 btn btn-dark btn-lg btn-block mt-4"> Logout </button>

					<?php

      endif;
						else :
					?>
					<p> You are not logged in! </p>
					<a href="login.php"> <p class="text-warning"> Log in here to view this area! </p> </a>
					<a href="register.php"> <p class="text-warning"> Don't have an account? Register here! </p> </a>
					<?php
				endif;
					?>
				</div>

<div class="col-12 col-lg-9">
  <form class="" action="search_results.php" method="GET">


			<div class="form-group row">
				<label for="title-id" class="col-sm-3 col-form-label text-sm-right">Book Title:</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="title-id" name="book_title">
				</div>
			</div>
			<!-- .form-group -->

			<?php
							$sql = "SELECT * FROM classcode;";
							$results = $mysqli->query($sql);
							if ( !$results ) :
								echo $mysqli->error;
						  else:

						?>
				<div class="form-group row">
					<label for="subject-id" class="col-sm-3 col-form-label text-sm-right">Subject:</label>
					<div class="col-sm-9">
						<select name="subject" id="subject-id" class="form-control">
											<option value="" selected="">-- All --</option>
											<?php
						while($row = $results->fetch_assoc()) :
					 ?>
					 <option value= <?php echo $row['classcode_id']; ?>><?php echo $row['class_prefix']; ?></option>
				 <?php
					 endwhile;
				 endif;
				 ?>

										 								</select>
					</div>
				</div>
				<!-- .form-group -->

				<div class="form-group row">
					<label for="class-id" class="col-sm-3 col-form-label text-sm-right">Class Code:</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" id="class-id" name="class_code">
					</div>
				</div>

				<div class="form-group row">
					<div class="col-sm-3"></div>
					<div class="col-sm-9 mt-3">
						<button type="submit" class="btn btn-primary">Search</button>
						<a href="index.php" role="button" class="btn btn-light">Go Back</a>
					</div>
				</div>
          </form>
				<!-- .form-group -->
			</div>
				</div>
		</div>

		<?php

					$mysqli->close();
				endif;
							?>
							<script>

              if(document.querySelector('#logout') != null) {
                document.querySelector('#logout').onclick = function(){
                  var r = confirm("Are you sure you want to log out?")
                  if (r == true) {
                    location.href = 'logout.php'
                  }
                };
              }

										</script>
                    <div class="push">

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
