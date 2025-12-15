<?php

$grade = array(
    "Math" => "3",
    "Art" => "5",
    "History" => "3",
    "Music" => "5"

);

foreach($grade as $subject=> $grade){
    echo "Subject:" . $subject . " , Grade:" . $grade;
    echo "<br>";
}

?>