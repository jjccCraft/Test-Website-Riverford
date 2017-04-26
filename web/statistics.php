
<!DOCTYPE html>
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
                <div class ="listFiles">
                    <?php

                    $dir = "uploads/";
                    $allFiles = array_diff(scandir($dir), array('.', '..')); //Array of all files excluding elements of '.' and '..'

                    foreach ($allFiles as $file) { //Loops through all files uploaded
                        $contents = file_get_contents("uploads/$file");
                        //Word and line counts
                        $wordCount = wordCount($contents);
                        $lineCount = lineCount($file);

                        //Processing arrays
                        $lengthArray = lengthArray($contents);
                        $processArray = processArray($lengthArray);
                        $letterArray = letterArray($contents);

                        //Averages
                        $mode = mode($lengthArray);
                        $median = median($lengthArray);
                        $mean = mean($lengthArray);

                        //Letter count
                        $letterCount = letterCount($letterArray);

                        //Putting all data into one array
                        $finalArray = array("Name: " => $file,
                                            "Word Count: " => $wordCount,
                                            "Line Count: " => $lineCount,
                                            "Mode Word Length: " => $mode,
                                            "Median Word Length: " => $median,
                                            "Mean Word Length: " => $mean,
                                            "Most Common Letter: " => $letterCount);


                        //Outputting the data from the array
                        foreach($finalArray as $key => $value) {
                            $a = "<p>$key $value</p>";
                            $b = "</br> </br>";
                            echo $a;
                        }
                        echo $b;
                    }
                    ?>

                </div>
                <div class= "back"> <!-- Must be clicked on the text of the button to work -->
                    <button type ="button" id= "back"> <a href = "main.php">Back</a></button>
                </div>
            </div>
        </div>
    </body>
  </html>


<?php
//Function creates and returns an associative array, where the keys indicate word length and the values indicate how many times a word of that length has been recorded.
function lengthArray($contents) {
    $wordArray = preg_split("/[\s,]+/", $contents);
    $keys = array_fill(0,25,0); //Initial blank array with a maximum potential word length of 24
    $i = 0;
    foreach($keys as $key) { //Loop formats the keys
        $keys[$i] = $i;
        $i++;
    }
    $lengthArray = array_fill_keys($keys, '0'); //Key is word length. Value is number of times a word has that length
    $k = array_keys($lengthArray);
    foreach ($wordArray as $word) {
        $lengthword = strlen($word);
        if ($lengthword <= 50) { //Word cannot be bigger than 50 letters
          $lengthArray[$k[$lengthword]] ++;
        }
    }
    return $lengthArray;
}


//Function creates a new array that can work with finding the median and mean. An example of elements in this array would be if a words of length 3 were used 6 times, there would be 6 elements with the value 3.
function processArray($lengthArray) {
    $processArray = array();
    $j = 0;
    foreach( $lengthArray as $key => $val ) {
        for($i = 0; $i < $val; $i++) {
            array_push($processArray, $key );
        }
        $j++;
    }
    return $processArray;
}


//Function creates and returns a new array where the keys are letters a-z and the values are how many times those letters are used in a string
function letterArray($contents) {
    $string = preg_replace('/\s+/', '', $contents); //Removes all spaces and turns entire file into one long unbroken string
    $string = strtolower($string);
    $array = str_split($string); //Creates an array where each character is an element
    $keys = range('a', 'z');
    $letterArray = array_fill_keys($keys, '0');
    foreach ($array as $letter) {
        if (array_key_exists($letter, $letterArray)) { //This also filters out characters that are not letters
            $letterArray[$letter] ++;
        }
    }
    return $letterArray;
}


//Function returns number of words without spaces in a file
function wordCount($contents) {
    $wordCount = str_word_count($contents, 0, "(),':;?!£$%@/0123456789");
    return $wordCount;
}


//Function returns number of lines in a file
function lineCount($file) {
    $lineCount = count(file("uploads/$file"));
    return $lineCount;

}

//Function returns number of times a letter is used in a text file
function letterCount($letterArray) {
    $highest = max($letterArray);
    $letterCount = array_search($highest, $letterArray, TRUE);
    return $letterCount;
}


//Function works out the mode of an array
function mode($lengthArray) {
    $highest = max($lengthArray);
    $mode = array_search($highest, $lengthArray, TRUE);
    return $mode;
}


//Function works out the median of an array through the use of processArray()
function median($lengthArray) {
    $processArray = processArray($lengthArray);
    $total = count($processArray);
    $middle = floor(($total-1)/2); // -1 required as indexing starts at zero
    if ($total % 2 == 1) { //If sum of elements in list is odd
        $median = $processArray[$middle];
        return $median;
    }
    else { // If sum of elements is even
        $low = $processArray[$middle];
        $high = $processArray[$middle+1];
        $median = (($low+$high)/2);
        return $median;
    }
}


//Function works out the mean of an array through the use of processArray()
function mean($lengthArray) {
    $processArray = processArray($lengthArray);
    $total = count($processArray);
    $sum = array_sum($processArray);
    $mean = round(($sum / $total), 1);
    return $mean;
}
?>
