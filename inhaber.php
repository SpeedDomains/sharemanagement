<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
<?php


require "connect.php";

$abfrage = "SELECT DISTINCT name,shares,type FROM shareholders WHERE type=0";
$ergebnis = mysql_query($abfrage);
while($row = mysql_fetch_object($ergebnis))
   { 
   

 ?>
 <body>

			<table width="90%">
			<tr>
			<th align="center" class="first">Name:</th>
            <th align="center">Share</th>
			<th>Picture</th>
			</tr>
<?php
$i=0;
while ($i < $num) {
$f1=mysql_result($result,$i,"name");
$f2=mysql_result($result,$i,"shares");
$f3=mysql_result($result,$i,"eveid");
?>
			<tr>
			<td><?php echo $f1; ?></td>
			<td><img src="https://image.eveonline.com/Character/<?php echo $f3; ?>_50.jpg"/></td>
			<td><?php echo $f2; ?></a></td>
			</tr>
<?php
$i++;
}
?>
			</table>
<?

// echo "<td>$row->name</td> <td>$row->shares</td> <td>$row->lastupdate</td> <td>$row->eveid</td> <br />";
   }
?>
</body>
</html>