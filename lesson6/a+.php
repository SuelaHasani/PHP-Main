<?php

$handle = fopen('data.txt','a+');

fwrite($handle, "\n Add more lines");

fclose($handle);

?>