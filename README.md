# sharemanagement
Aktien-Managment

Aktien-Managment mit Webseite ( Grundlage )

Installation

1 Datenbank anlegen - in der Datenbank einfügen:

# create table shareholders (id int primary key auto_increment,type int,name varchar(255),eveid bigint,shares int,lastupdate datetime);
# create table shareholderchecksum (id int primary key auto_increment,checksum varchar(64));
# create table balance (id int primary key auto_increment,balance decimal(20,2),shares int,pointtime datetime);

Anschließend die gather.php und die getData.php per Cronjob aufrufen. In der Regel sollten alle 30 Minuten oder 60 Minuten Daten abgerufen werden.
Wichtig! -> Tragt eure API und CharID ein, da sonst keine Daten abgerufen werden können.

API? http://www.api.eve-online.com

Muster Einsatz? http://www.eve-tv.de
