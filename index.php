<?php
session_start();
require 'config.php';
  ?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
	<title>Cognetta WebDev Project</title>

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
			height: 150px;
		}
    body {
      font-family: "timeburner", sans-serif;
    }
		h1 {
			line-height: 150px;
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

		#sidebar > h4 {
			text-align: center;
		}


		#recent {
			margin-top: 25px;
			text-decoration: underline;
		}
    img {
      width: 100%;
      height: 100%;
    }

    .item {
      /*width: 100%;*/
      height: 100%;
    }

    #footer {
			background-color: #000;
			color: #FFF;
			font-size: 1em;
			height: 50px;
			line-height: 50px;
      bottom: 0px;
		}

		/* Small devices (landscape phones, 576px and up) */
		@media (min-width: 576px) {
		}
		/* Medium devices (tablets, 768px and up) */
		@media (min-width: 768px) {

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
			<h1 class="col-12 text-center">Trojan Book Exchange</h1>
		</div>

	</div> <!-- #header -->

	<div class="container">
		<div class="row">


			<div id="sidebar" class="col-12 col-lg-3">
				<h4>Dashboard </h4>
				<?php
					if ($_SESSION['logged_in']) :
				?>
				<p> Welcome <?php echo $_SESSION['email']; ?>! </p>
				<p> Your items for sale: </p>
        <?php
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($mysqli->connect_errno ) :
          echo "Connection Error: ";
          echo $mysqli->connect_error;
        else:
          $sql = "SELECT * FROM textbooks
          WHERE user_id = " . $_SESSION['id'] . ";";
          $results = $mysqli->query($sql);
          if ( !$results ) :
            echo $mysqli->error;
          else:
            while($row = $results->fetch_assoc()) :
				?>
        <a href="details.php?id_book=<?php echo $row['id_book']?>&linkback=1" ><p> <?php echo $row['title']; ?> </p> </a>
      <?php endwhile; ?>

				<button  class="col-12 btn btn-primary btn-lg btn-block mt-4" onclick="location.href='add.php';"> Add an item </button>
				<button id ="logout" class="col-12 btn btn-dark btn-lg btn-block mt-4"> Logout </button>

				<?php
      endif;
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

				<div class="col-12 ">
					<a href="search.php" class="btn btn-primary btn-lg btn-block mt-4 mt-md-2" role="button">Search for Textbooks here!!</a>
				</div>
				<h3 id="recent" class="text-center">
					Recent Additions:
				</h3>
        <div class="row">


        <?php
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($mysqli->connect_errno ) :
          echo "Connection Error: ";
          echo $mysqli->connect_error;
        else:
          $sql = "SELECT * FROM textbooks
          ORDER BY date DESC
          LIMIT 6 ;";
          $results = $mysqli->query($sql);
          if ( !$results ) :
            echo $mysqli->error;
          else:
            while($row = $results->fetch_assoc()) :


         ?>
         <div class="col-12 col-lg-4 item">
           <a href="details.php?id_book=<?php echo $row['id_book']?>&linkback=1">
           <img class="img-responsive" src="<?php echo $row['picture']; ?>" alt="<?php echo $row['title']; ?>">
           <h4 class="text-center"><?php echo $row['title']; ?> </h4>
           <p class="text-center text-success">$ <?php echo $row['price']; ?></p>
         </a>
         </div>

         <?php
       endwhile;
     endif;
   endif; ?>
 </div>


			</div>
		</div>
	</div>

  <div id="footer" class="container-fluid">
    <div class="row">
      <div class="col-12 text-center">

          <p class="text-center"> Chris Cognetta &copy; 2017 |  <a href="about.html"> About this site </a>  | <a href="index.php"> Home </a> </p>


      </div>

    </div>
  </div>
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


</body>
</html>
