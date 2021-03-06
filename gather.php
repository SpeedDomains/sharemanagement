<?

# create table shareholders (id int primary key auto_increment,type int,name varchar(255),eveid bigint,shares int,lastupdate datetime);
# create table shareholderchecksum (id int primary key auto_increment,checksum varchar(64));
# create table balance (id int primary key auto_increment,balance decimal(20,2),shares int,pointtime datetime);

$dbh = new PDO('mysql:host=localhost;dbname=dbname', 'shares', 'password');
$corpid=98427983;

$key=keyID;
$vcode="You´re Vcode here";
$character="Character ID";
$walletidgs=1000;
$walletid1=1000;
$walletid2=1001;
$walletid3=1002;
$walletid4=1003;
$walletid5=1004;
$walletid6=1005;
$walletid7=1006;

$corporationurl="https://api.eveonline.com/corp/CorporationSheet.xml.aspx?corporationID=".$corpid;
$walleturl="https://api.eveonline.com/corp/AccountBalance.xml.aspx?keyID=".$key."&vcode=".$vcode."&characterID=".$character;
$shareholdersurl="https://api.eveonline.com/corp/Shareholders.xml.aspx?keyID=".$key."&vcode=".$vcode."&characterID=".$character;



function get($url) {
    global $ch;
    curl_setopt($ch, CURLOPT_URL, $url);
    $response=curl_exec($ch);
    if($response === false)
    {
        echo 'Curl error: ' . curl_error($ch);
        exit;
    }
    return $response;
}


$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_USERAGENT, 'ShareFinder General');
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
$corpres = get($corporationurl);
$corpxml=new SimpleXMLElement($corpres);
$shares= (int) $corpxml->result->shares;
echo $shares;
$walletres=get($walleturl);
$walletxml=new SimpleXMLElement($walletres);
$balancexml= $walletxml->xpath('//row[@accountKey='.$walletidgs.']');
$balance= (float) $balancexml[0]->attributes()->balance;
echo "\n".$balance;


$walletsql="insert into balance (balance,shares,pointtime) values (?,?,DATE_SUB(DATE_SUB(now(), INTERVAL MINUTE(now()) MINUTE ),INTERVAL SECOND(now()) SECOND))";
$stmt = $dbh->prepare($walletsql);
$stmt->execute(array($balance,$shares));





$shareholderres=get($shareholdersurl);
$shareholderxml=new SimpleXMLElement($shareholderres);
$charactershareholders=$shareholderxml->xpath('//rowset[@name="characters"]');
$corpshareholders=$shareholderxml->xpath('//rowset[@name="corporations"]');

$checksum=md5(json_encode($charactershareholders)).md5(json_encode($corpshareholders));

$checksumsql="select checksum from shareholderchecksum order by id desc limit 1";
$stmt = $dbh->prepare($checksumsql);
$stmt->execute();
if ($row=$stmt->fetchObject())
{
    if ( $row->checksum==$checksum)
    {
        # Shareholders haven't changed since last time.
        exit;
    }
}

$checksumsql="insert into shareholderchecksum (checksum) values (?)";
$stmt = $dbh->prepare($checksumsql);
$stmt->execute(array($checksum));


$addshareholder="insert into shareholders (type,name,eveid,shares,lastupdate) values (?,?,?,?,now())";
$stmt = $dbh->prepare($addshareholder);
foreach ($charactershareholders[0]->row as $character)
{
    $stmt->execute(array(0,$character->attributes()->shareholderName,$character->attributes()->shareholderID,$character->attributes()->shares));
}
foreach ($corpshareholders[0]->row as $corp)
{
    $stmt->execute(array(1,$corp->attributes()->shareholderName,$corp->attributes()->shareholderID,$corp->attributes()->shares));
}




?>
