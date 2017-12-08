<?php
session_start();
require 'config.php';

  ?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
	<title>Delete Confirmation</title>

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

  img {
    width: 100%;
}


		/* Small devices (landscape phones, 576px and up) */
		@media (min-width: 576px) {
		}
		/* Medium devices (tablets, 768px and up) */
		@media (min-width: 768px) {
      #header {
        /*background-color: #9d2235;*/
        background: linear-gradient(to bottom right, #9d2235, #ffc72c);
        height: 65px;
      }
		}
		/* Large devices (desktops, 992px and up) */
		@media (min-width: 992px) {
		}
		/* Extra large devices (large desktops, 1200px and up) */
		@media (min-width: 1200px) {
		}
	</style>
</head>
<body>


  <div id="header" class="container-fluid">
    <div class="row">
      <h1 class="col-12 text-center">Trojan Book Exchange Delete</h1>
    </div>

  </div>

  <div class="container">
    <?php
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    require 'config.php';
    if (!$_SESSION['logged_in']) :
      echo "Please log in to delete entries.";
    else:
    if ($mysqli->connect_errno ) :
      echo "Connection Error: ";
      echo $mysqli->connect_error;
    else:
      $sql = "SELECT * FROM textbooks
      WHERE id_book = " . $_GET['id_book'] . ";";
      $results = $mysqli->query($sql);
      if ( !$results ) :
        echo $mysqli->error;
      else:

        if ($results->num_rows == 0) :
          echo "Textbook does not exist!";
        else:
          $row = $results->fetch_assoc();
          if ($row[user_id] != $_SESSION['id']) :
            echo "You do not have permission to delete this entry!";
          else :
            $sql = "DELETE FROM textbooks
							WHERE id_book = " . $_GET['id_book'] . ";";

              $results = $mysqli->query($sql);

        				if (!$results) :
        					// SQL Error
        					echo $mysqli->error;
        				else :
        					// SQL Success
        	?>
        				<div class="text-success">Your textbook was successfully deleted.</div>



     <?php
   endif;
   endif;
 endif;
 endif;
endif;
   endif;
      ?>

      <div class="row mt-4 mb-4">
          <div class="col-12">
            <a href="index.php" role="button" class="btn btn-primary">Home</a>
          </div> <!-- .col -->
        </div>

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
