<?php
session_start(); //Used to tell the user the status of the file(s) being uploaded

$totalResponses = array(); //All responses will be reported back to the user on the main page.

//Goes through each file and checks for errors before uploading
foreach ($_FILES["files"]["error"] as $key => $error) {
    //Initial checks
    if ($error == UPLOAD_ERR_OK) {
        $uploadOk = 1;
        $target_dir = "uploads/";
        $name = $_FILES["files"]["name"][$key];
        $tmp_name = $_FILES["files"]["tmp_name"][$key];
        $target_file = $target_dir . basename($name);
        $fileType = pathinfo($target_file,PATHINFO_EXTENSION);
    } else {
        $response = "Either there is an error uploading the file or nothing has been chosen to be uploaded.";
        array_push($totalResponses, $response);
        continue; //variables are is created only if value of UPLOAD_ERR_OK is 0. Therefore, continue is used here as variables are referenced later (avoiding errors).
    }


    //Check to see if file already exists
    if (file_exists($target_file)) {
          $response = "File ". $name . " already exists.";
          array_push($totalResponses, $response);
          $uploadOk = 0;
    }

    //Check to see if file is a text file
    if($fileType != "txt") {
        $response = "File ". $name . " is not a text file. Only text files are allowed.";
        array_push($totalResponses, $response);
        $uploadOk = 0;
    }


    //If checks are fine, move the file to desired directory. Else, error
    if ($uploadOk == 1) {
        if (move_uploaded_file($tmp_name, "uploads/$name")) {
            $response = "File " . $name . " has been uploaded.";
            array_push($totalResponses, $response);
        }
        else {
            $response = "File " . $name . " had an unexpected error. Please Try again.";
        }
    }
}
$_SESSION["totalResponses"] = $totalResponses;
header("Location: main.php");


 ?>
