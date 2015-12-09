<html>
  <head>
    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script type="text/javascript">
    
    // Load the Visualization API and the piechart package.
    google.load('visualization', '1', {'packages':['corechart']});
      
    // Set a callback to run when the Google Visualization API is loaded.
    google.setOnLoadCallback(drawChart);
      
    function drawChart() {
      var jsonData = $.ajax({
          url: "getData.php",
          dataType:"json",
          async: false
          }).responseText;
          
      // Create our data table out of JSON data loaded from server.
      var data = new google.visualization.DataTable(jsonData);

      // Instantiate and draw our chart, passing in some options.
      var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
      chart.draw(data, {width: 600, height: 400});
    }
	

    </script>
  </head>

  <body>
    <!--Div that will hold the pie chart-->
    <div align ="center" id="chart_div"></div>

<div id="shareholders">
<table align="center">
<div align="center">
<thead>
<tr><th>Name</th><th>Aktien</th></tr>
</thead><tbody>
<?
error_reporting( E_ALL | E_STRICT );
ini_set('display_errors', TRUE);


$dbh = new PDO('mysql:host=localhost;dbname=eve-tv_shares', 'shares', 'iboY05?7');
# current shareholders only
$sql="select name,eveid,shares,lastupdate,type from shareholders where lastupdate=(select max(lastupdate) from shareholders) order by shares DESC";
#all shareholders in the last 5 months, along with the time they were last a shareholder, with the shares they held at that time.
//$sql="select name,eveid,shares,max(lastupdate) from shareholders where lastupdate>date_sub(now(),INTERVAL 5 MONTH) group by name,eveid,shares";


$stmt = $dbh->prepare($sql);

$stmt->execute();
while ($row = $stmt->fetchObject()){
$shareholdertype=1377;
if ($row->type)
{
$shareholdertype=2;

}
echo "<tr><td onclick='CCPEVE.showInfo(".$shareholdertype.",".$row->eveid.")'>".$row->name."</td><td>".$row->shares."</td></tr>";
}


?>

</tbody>
</table>
</div>
<div align="center" class="CurrentStockValue">
<br />
Aktueller Kurs zurzeit:
<br />
<?

$sql="select balance, shares from balance order by id desc limit 1";
$stmt = $dbh->prepare($sql);
$s =	'ISK';
$stmt->execute();
$row = $stmt->fetchObject();
//echo sprintf("%.2f",$row->balance/$row->shares); //$row->balance/$row->shares;
$ausgabe = $row->balance / $row->shares;
echo "<br />";
echo number_format($ausgabe, 2,',', '.')." ISK";
/*
echo "<br />";

echo ($ausgabe);
echo "<br />";
echo ($row->balance);
echo "<br />";
*/
/*
echo "Aktien im Umlauf";
echo "<br />";
echo number_format($row->shares, 0,',', '.');


/*
echo "<br />";
echo "<b> Testausgabe fuer Format</b><br />";

$sql="select * from balance order by id desc limit 1";
$stmt = $dbh->prepare($sql);

$stmt->execute();
$row = $stmt->fetchObject();
echo sprintf("%.2f",$row->balance/$row->shares); //$row->balance/$row->shares;
echo number_format($zahl)."<br>";
echo number_format($zahl,1)."<br>";
echo number_format($zahl,2, ",", ".");
echo sprintf("%.2f",$row->balance/$row->shares); //$row->balance/$row->shares;
*/


?>
<div align="center"><b> Der Kauf einer Aktie enth&auml;lt je eine Stimme</b>
</div>
</body>
</html>