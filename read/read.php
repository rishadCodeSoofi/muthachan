<?php
$fh = fopen('MPSTAT.2017.02.07-06.21.51.dsrstat','r');
while ($line = fgets($fh)) {
  // <... Do your work with the line ...>
  //echo($line);
  //$exploded_data = explode(" ",$line);
  $comp = preg_split('/\s+/', $line);
  
  echo '<pre>';
  print_r($comp);
  
  echo "<br />";
}
fclose($fh);
?>