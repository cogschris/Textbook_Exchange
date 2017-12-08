<?php
session_start();
require 'config.php';

  ?>

<!DOCTYPE html>
<html>

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
	<title>Textbook Edit</title>

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



		#recent {
			margin-top: 25px;
			text-decoration: underline;
		}

    #footer {
      background-color: #000;
      color: #FFF;
      font-size: 1em;
      height: 50px;
      line-height: 50px;
      bottom: 0px;
    }

    img {
      width: 250px;
      height: auto;
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
				<h1 class="col-12 text-center">Trojan Book Exchange Edit</h1>
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

					<button  class="col-12 btn btn-primary btn-lg btn-block mt-4" onclick="location.href='add.php';"> Add an item </button>
					<button id ="logout" class="col-12 btn btn-dark btn-lg btn-block mt-4"> Logout </button>

					<?php
						else :
					?>
					<p> You are not logged in! </p>
					<a href="login.php"> <p class="text-warning"> Log in to view this area! </p> </a>
					<a href="register.php"> <p class="text-warning"> Don't have an account? Register here! </p> </a>
					<?php
				endif;
					?>
				</div>

<div class="col-12 col-lg-9">
  <?php
    if ($_SESSION['logged_in']) :
      $sql_entry = "SELECT * FROM textbooks
                    WHERE id_book = " . $_GET['id_book'] . ";";

                    $results2 = $mysqli->query($sql_entry);
      							if ( !$results2 ) :
      								echo $mysqli->error;

      						  else:
                      //echo "here";
                      $info = $results2->fetch_assoc();
                      if ($info['user_id'] != $_SESSION['id']) :
                        echo "You do not have permission to edit this!";
                      else :
  ?>
  <form action="edit_confirmation.php" method="POST" enctype="multipart/form-data">

  <div class="row mb-3">
    <div id="form-error" class="col-sm-9 ml-sm-auto font-italic text-danger">
    </div>
  </div> <!-- .row -->
			<div class="form-group row">
				<label for="title-id" class="col-sm-3 col-form-label text-sm-right">Book Title: <span class="text-danger">*</span></label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="title-id" name="book_title" placeholder="Foundations of Accounting" value="<?php echo $info['title']; ?>">
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
					<label for="subject-id" class="col-sm-3 col-form-label text-sm-right">Subject: <span class="text-danger">*</span></label>
					<div class="col-sm-9">
						<select name="subject" id="subject-id" class="form-control">
											<option value="" selected="">-- All --</option>
											<?php
						while($row = $results->fetch_assoc()) :
              if ($row['classcode_id'] == $info['classcode_id']):
					 ?>
           <option value= <?php echo $row['classcode_id']; ?> selected><?php echo $row['class_prefix']; ?></option>
         <?php else:  ?>
					 <option value= <?php echo $row['classcode_id']; ?>><?php echo $row['class_prefix']; ?></option>
				 <?php
       endif;
					 endwhile;
				 endif;
				 ?>

										 								</select>
					</div>
				</div>
				<!-- .form-group -->

				<div class="form-group row">
					<label for="class-id" class="col-sm-3 col-form-label text-sm-right">Class Code: <span class="text-danger">*</span></label>
					<div class="col-sm-9">
						<input type="text" class="form-control" id="class-id" name="class_code" placeholder="401" value="<?php echo $info['classnumber']; ?>">
					</div>
				</div>

        <div class="form-group row">
					<label for="price-id" class="col-sm-3 col-form-label text-sm-right">Price ($): <span class="text-danger">*</span></label>
					<div class="col-sm-9">
						<input type="text" class="form-control" id="price-id" name="price" placeholder="50.25" value="<?php echo $info['price']; ?>">
					</div>
				</div>

        <input type="hidden"
        						name="title_id"
        						value="<?php echo $_GET['id_book']; ?>">


        <div class="form-group row">
					<label for="pic-id" class="col-sm-3 col-form-label text-sm-right">Picture (leave empty if you want to keep same image): </label>
					<div class="col-sm-9">
						<input type="file" class="form-control" id="pic-id" name="pic">
            <img class=".img-thumbnail " src="<?php echo $info['picture']; ?>" alt="<?php echo $info['title']; ?>">

					</div>
				</div>
        <div class="row">
  				<div class="ml-auto col-sm-9">
  				</div>
  			</div>

        <div class="row">
  				<div class="ml-auto col-sm-9">
  					<span class="text-danger font-italic">* Required</span>
  				</div>
  			</div>




				<div class="form-group row">
					<div class="col-sm-3"></div>
					<div class="col-sm-9 mt-3">
						<button type="submit" class="btn btn-primary">Submit</button>
						<a href="index.php" role="button" class="btn btn-light">Cancel</a>
					</div>
				</div>

				<!-- .form-group -->
        <?php
      endif;
      endif;
          else :
            ?>
<p>Please log in to view this area!</p>
            <?php
    					$mysqli->close();
    				endif;
          endif;

    							?>


			</div>
				</div>
		</div>
  </form>


							<script>

									document.querySelector('#logout').onclick = function(){
										var r = confirm("Are you sure you want to log out?")
										if (r == true) {
											location.href = 'logout.php'
										}
									};

                  document.querySelector('form').onsubmit = function(){

              			if ( document.querySelector('#title-id').value.trim().length == 0
              				|| document.querySelector('#subject-id').value.trim().length == 0
                    || document.querySelector('#class-id').value.trim().length == 0
                  || document.querySelector('#price-id').value.trim().length == 0
                ) {

              				document.querySelector('#form-error').innerHTML = 'Please fill out all required fields.';

              				return false;

              			}

                    var image = document.querySelector('#pic-id').value.trim().toLowerCase();
                    if ( image.length > 0) {
                      if(!image.endsWith('.jpg') && !image.endsWith('.jpeg') && !image.endsWith('.png') ) {
                        document.querySelector('#form-error').innerHTML = 'Please input correct file type. (jpg, jpeg, or png)';

                        return false;
                      }
                    }

                    var price = document.querySelector('#price-id').value.trim();
                    var numNum = +price;
                    if (isNaN(numNum)) {
                      document.querySelector('#form-error').innerHTML = 'Please input correct price.';

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
