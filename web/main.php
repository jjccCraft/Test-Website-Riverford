<!DOCTYPE html>
<?php
session_start();
?>
<html>
    <head>
        <title>Riverford Test Page</title>
        <link href="stylesheet.css" rel='stylesheet' type='text/css'/>
    </head>

    <body>
        <div class = "header">
            <div class = "container">
                <div class = "logo">
                    <img src = "riverford.webp" alt = "Company Logo">
                </div>
                <div class = "title">
                    <h2>Riverford Test Website</h2>
                </div>
            </div>
        </div>


        <div class = "contents">
            <div class = "container">
                <div class = "response">
                <?php
                if (isset($_SESSION["totalResponses"])) {
                    $totalResponses = $_SESSION["totalResponses"];
                    foreach ($totalResponses as $response) {
                        $a = "<p>$response</p>";
                        echo $a;
                    }
                }
                ?>
               </div>
                <div class= "options">
                    <ul>
                        <li>
                            <div class="uploadForm">
                                <form action="upload.php" method="post" enctype="multipart/form-data">
                                    <input type="file" name="files[]" id="fileUpload" multiple>
                                    <label for="fileUpload">choose files</label>
                                    <input type="submit" value="upload" name="submit">
                                </form>
                           </div>
                        </li>
                        <li>
                            <div class= "statistics">
                                <button type ="button" id= "statistics"> <a href = "statistics.php">Show Statistics</a></button>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </body>
</html>

<?php
session_unset();
session_destroy();
 ?>
