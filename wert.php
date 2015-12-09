<? /*
Wert ermittlung für den aktuellen Kurs einer Aktie aus dem höchsten wert
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