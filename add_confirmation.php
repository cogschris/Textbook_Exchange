<?php
session_start();
require 'config.php';

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["pic"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
    // $check = getimagesize($_FILES["pic"]["tmp_name"]);
    // if($check !== false) {
    //     //echo "File is an image - " . $check["mime"] . ".";
    //     $uploadOk = 1;
    // } else {
    //     //echo "File is not an image.";
    //     $uploadOk = 0;
    // }

    $actual_name = pathinfo($target_file,PATHINFO_FILENAME);
    $original_name = $actual_name;
    $i = 1;
    while (file_exists($target_file)) {
      $actual_name = (string)($original_name . (string)$i);
      //echo $actual_name;
      $target_file = $target_dir . $actual_name .".". $imageFileType;
      $i++;
    }
    //echo $target_file;
// Check file size
// if ($_FILES["pic"]["size"] > 50000000) {
//     echo "Sorry, your file is too large.";
//     $uploadOk = 0;
// }
// Check if $uploadOk is set to 0 by an error
//echo $uploadOk;

if ($uploadOk == 0) {
    //echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["pic"]["tmp_name"], $target_file)) {
        //echo "The file ". basename( $_FILES["pic"]["name"]). " has been uploaded.";
    } else {
        //echo "Sorry, there was an error uploading your file.";
        $uploadOk = 0;
    }
}



// echo "<hr>";
//
// echo $_POST['book_title'];
// echo "<hr>";
// echo $_POST['subject'];
// echo "<hr>";
//
// echo $_POST['class_code'];
// echo "<hr>";
//
// echo $_POST['price'];
// echo "<hr>";
//
// echo $_SESSION['id'];
//


?>


<!DOCTYPE html>
<html>

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
	<title>Edit Confirmation</title>

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
				<h1 class="col-12 text-center">Trojan Book Exchange Add Confirmation</h1>
			</div>

		</div>
<?php
if (!isset($_POST['book_title']) || empty($_POST['book_title'])
|| !isset($_POST['subject']) || empty($_POST['subject'])
|| !isset($_POST['class_code']) || empty($_POST['class_code'])
|| !isset($_POST['price']) || empty($_POST['price'])
|| !$_SESSION['logged_in'] || $uploadOk != 1
) :

 ?>
    <div class="row mb-3">
      <div id="form-error" class="col-sm-9 ml-sm-auto font-italic text-danger">
        Your addition could not be added
      </div>
    </div> <!-- .row -->
    <?php

    else :
      $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

      	if ($mysqli->connect_errno) :
      		echo $mysqli->connect_error;
      	else:
          $sql = "INSERT INTO textbooks (title, picture, user_id, date, price, classcode_id, classnumber)
      						VALUES ('"
      						. $mysqli->real_escape_string($_POST['book_title'])
      						. "', '"
      						. $target_file
                  . "', '"
                  . $_SESSION['id']
                  . "', '"
                  . date("Y-m-d H:i:s")
                  . "', '"
                  . (double)$_POST['price']
                  . "', '"
                  . (int)$_POST['subject']
                  . "', '"
                  . $mysqli->real_escape_string($_POST['class_code'])
      						. "');";
                  //echo $_POST['price'];
                  $results = $mysqli->query($sql);

              		if (!$results) :
              			echo $mysqli->error;
              		else :




     ?>
     <div class="text-success">
       User <?php echo $_POST['book_title']; ?> was successfully uploaded.
     </div>
     <?php
   endif;
   endif;
 endif;
      ?>
      <div class="container">
        <div class="row mt-4 mb-4">
        		<div class="col-12">
        			<a href="index.php" role="button" class="btn btn-primary">Home</a>
        			<a href="add.php" role="button" class="btn btn-light">Add Another</a>
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
