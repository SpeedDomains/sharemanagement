<? /*
Wert ermittlung f�r den aktuellen Kurs einer Aktie aus dem h�chsten wert
*/

include ("connect.php");
$sql="select * from  balance order by id desc";


$result = mysql_query ($query) or die (mysql_error());
while ($row = mysql_fetch_assoc($result))
{
  echo '<tr>
          <td>'.$row['id'].'</td>
          <td>'.$row['balance'].'</td>
          <td>'.$row['shares'].'</td>
        </tr>';
}




?>