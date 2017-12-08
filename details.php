<?php
session_start();
require 'config.php';

  ?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
	<title>Details</title>

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
      <h1 class="col-12 text-center">Trojan Book Exchange Add</h1>
    </div>

  </div>

  <div class="container">
    <h2>Details: </h2>

	<?php
  $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
  require 'config.php';

  if ($mysqli->connect_errno ) :
    echo "Connection Error: ";
    echo $mysqli->connect_error;
  else:
    $sql = "SELECT id_book, title, picture, users.user_email as email, date, price, classcode.class_prefix as prefix, classnumber
    FROM textbooks
    LEFT JOIN users
    ON textbooks.user_id = users.id_user
    LEFT JOIN classcode
    ON textbooks.classcode_id = classcode.classcode_id
    WHERE id_book = " . $_GET['id_book'] . ";";


    $results = $mysqli->query($sql);
    if ( !$results ) :
      echo $mysqli->error;
    else:

      if ($results->num_rows == 0) :
  			// Found email or username in the DB.
  			echo "Textbook does not exist.";
      else:
      while($row = $results->fetch_assoc()) :


   ?>

     <div class="row">
       <div class="col-12 col-lg-5">
         <img src=" <?php echo $row['picture']; ?>" alt="<?php echo $row['title']; ?>">
       </div>
       <div class="col-12 col-lg-7">
         <h3><?php echo $row['title']; ?></h3>
         <h4><?php echo $row['prefix']; ?> : <?php echo $row['classnumber']; ?></h4>
         <h4>Date Added: <?php echo date("m-d-Y",strtotime($row['date'])); ?></h4>
         <h4 class="text-success"> $ <?php echo $row['price']; ?></h4>
         <h4>Owner email: <a href="mailto:<?php echo $row['email'];?>?Subject=Textbook%20Interest"><?php echo $row['email']; ?></a></h4>
           <?php
           if ($_SESSION['email'] == $row['email'] ) :
           ?>

        <div class="row">
          <button onclick="location.href='edit.php?id_book=<?php echo $row['id_book']?>';" class="btn btn-primary btn-lg btn-block mt-4">Edit</button>
          <button id ="delete" class="btn btn-dark btn-lg btn-block mt-4">Delete</button>

        </div>
      <?php  endif;?>
       </div>
     </div>




     <div class="row mt-4 mb-4">
         <div class="col-12">
           <a href="index.php" role="button" class="btn btn-primary">Home</a>

           <?php
            //$linkback = substr( $_SERVER['HTTP_REFERER'], 0, 4 );
            //echo $linkback;
            if ($_GET['linkback'] == 0) :
           ?>
           <a href="search.php" role="button" class="btn btn-light">Back</a>

         <?php else: ?>
           <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" role="button" class="btn btn-light">Back</a>
         <?php endif; ?>
         </div> <!-- .col -->
       </div>

    </div>
    <script>

        document.querySelector('#delete').onclick = function(){
          var r = confirm("Are you sure you want to delete?")
          if (r == true) {
            location.href = 'delete.php?id_book=<?php echo $row['id_book']?>';
          }
        };

          </script>
          <?php
          endwhile;
          endif;
          endif;
          endif;
           ?>
           <div id="footer" class="container-fluid">
       			<div class="row">
       				<div class="col-12 text-center">

       						<p class="text-center"> Chris Cognetta &copy; 2017 |  <a href="about.html"> About this site </a>  | <a href="index.php"> Home </a> </p>


       				</div>

       			</div>
           </div>
</body>

</html>
