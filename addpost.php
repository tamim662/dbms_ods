<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Online Donation System</title>
  </head>
  <body>
    <header>
        <div class=<"main">
          <div class="logo">
            <img src="logo.png">

          </div>
          <ul>
            <li class="active"><a href="index.php">HOME</a></li>
            <li><a href="post.php">POST</a></li>
            <li><a href="#">EVENTS</a></li>
            <li><a href="login.php">LOGIN/SIGN UP</a></li>
            <li><a href="about.php">ABOUT</a></li>
            <li><a href="contact.php">CONTACT</a></li>
          </ul>
        </div>

  <h2>Write a post</h2>
<p>The textarea element defines a multi-line input field.</p>

<form  method="post" enctype="multipart/form-data">
  PostId:<br>
  <input class="text" type="text" name="postId" placeholder="Post Id">
  <br>
  <br>
  
  
  Title:<br>
  <input class="text" type="text" name="title" placeholder="Write a title" >
  <br>
  <br>
  Address:<br>
  <input class="text" type="text" name="address" placeholder="Address" >
  <br>
  <br>
  Details:<br>
  <textarea name="description" rows="10" cols="30"></textarea>
  <br><br>
  OrganizationId:<br>
  <input class="text" name="organizationId" placeholder="OrganizationId" >
  <br>
  <br> 
  Upload Images:<br>
  <input type="file" name="file">
  <br>
  <button type="submit" name="submit" value="Submit"> Submit</button>
</form>
</header>

<?php
			$servername = "localhost";
			$username = "root";
			$password = "";
			$dbname = "ods";

			$conn = mysqli_connect($servername, $username, $password, $dbname);

			// // Create database --------------------------------------------------------
			// $sql = "CREATE DATABASE IF NOT EXISTS ods";

			// if (mysqli_query($conn, $sql)) {
			//     echo "Database created successfully<br>";
			// } else {
			//     echo "Error creating database: " . mysqli_error($conn) . "<br>";
			// }

			// $dbname = 'ods';
			// mysqli_select_db ( $conn , $dbname);

			// if (!$conn) {
			//     die("select ods connection failed: " . mysqli_connect_error());
			// }

			//create accelaration table ----------------------------------------------
			$sql = "CREATE TABLE IF NOT EXISTS `post` (
				`postId` VARCHAR (10) NOT NULL,
				`title` VARCHAR(50) NOT NULL,
			  	`address` VARCHAR(100) NOT NULL,
			  	`description` VARCHAR(250) NOT NULL,
				`organizationId` VARCHAR(10) NOT NULL,
				`file_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
			  	PRIMARY KEY (`postId`))";

			if(mysqli_query($conn, $sql)){
			    echo "Table accelaration created successfully<br>";
			} else {
			    echo "Error creating accelaration table: " . mysqli_error($conn). "<br>";
			}


			$statusMsg = '';


		

			if (isset($_POST["submit"]) && !empty($_FILES["file"]["name"])) {
				$targetDir = "uploads/";
				$fileName = basename($_FILES["file"]["name"]);
				$targetFilePath = $targetDir . $fileName;
				$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
				
				
				$allowTypes = array('jpg','png','jpeg','gif','pdf');
				$postId =$_POST["postId"];
				$title = $_POST["title"];
				$organizationId = $_POST["organizationId"];
				$address = $_POST["address"];
				$description = $_POST["description"];




				if(in_array($fileType, $allowTypes)){
					// Upload file to server
					if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
						// Insert image file name into database
						$insert = $conn->query("INSERT into post (postId,title,address,description,organizationId,file_name) 
						VALUES ('$postId','$title','$address','$description','$organizationId','$fileName')");
						if($insert){
							echo "The file ".$fileName. " has been uploaded successfully.";
						}else{
							$statusMsg = "File upload failed, please try again.";
						} 
					}else{
						$statusMsg = "Sorry, there was an error uploading your file.";
					}
				}else{
					$statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
				}
			
				
				

				



				// $query = "INSERT INTO post (postId,title,address,description,organizationId,imaje)
				// 	VALUES
				// 		('$postId','$title','$address','$description','$organizationId','$imagetmp','$fileName')";
				// 			if(mysqli_query($conn, $query)){
		    	// 				echo "<script>
				// 			    alert('Your data d');
				// 				</script>";
				// 			} else{
			    // 				echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
				// 			}

				

			}















			// if(isset($_POST["submit"]) && !empty($_FILES["file"]["name"])){
			// 	// Allow certain file formats
			// 	$allowTypes = array('jpg','png','jpeg','gif','pdf');
			// 	if(in_array($fileType, $allowTypes)){
			// 		// Upload file to server
			// 		if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
			// 			// Insert image file name into database
			// 			$insert = $db->query("INSERT into images (file_name, uploaded_on) VALUES ('".$fileName."', NOW())");
			// 			if($insert){
			// 				$statusMsg = "The file ".$fileName. " has been uploaded successfully.";
			// 			}else{
			// 				$statusMsg = "File upload failed, please try again.";
			// 			} 
			// 		}else{
			// 			$statusMsg = "Sorry, there was an error uploading your file.";
			// 		}
			// 	}else{
			// 		$statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
			// 	}
			// }else{
			// 	$statusMsg = 'Please select a file to upload.';
			// }









		?>


  </body>
</html>








