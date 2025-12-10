<?php

$dogs = array(
    array("Husky", "Mexico", 20),
    array("Bulldog", "England", 15),
    array("Husky", "Mexico", 23),
);

echo $dogs[0][0]. ": Origin ". $dogs[0][1]. " , Life span " . $dogs[0][2]. "<br>";
echo $dogs[1][0]. ": Origin ". $dogs[1][1]. " , Life span " . $dogs[1][2]. "<br>";
echo $dogs[2][0]. ": Origin ". $dogs[2][1]. " , Life span " . $dogs[2][2]. "<br>";
?>