A php script to convert csv to sql

Posted by npelov on Tue, 08/29/2006 - 02:38.

I wrote a little script to convert the csv file to sql import script: #!/bin/php
 $lines=file('ip-to-country.csv');
 foreach($lines as $line){
 $line=trim($line);
 if(!preg_match('/^"([0-9]+)","([0-9]+)","(.{2})","(.{3})","(.*)"$/',$line,$matches)){
 echo "error";
 }else{
 echo 'insert into ip2c values("'.($matches[1]).'","'.($matches[2]).'","'.($matches[3]).'","'.($matches[4]).'","'.($matches[5]).'");'."\n";
 }
 }
 ?>
 

Usage:
 copy this script and .csv file in the same dir then run:
 convert.php >ip2c.sql
 

Here is create table syntax:
 
CREATE TABLE `ip2c` (
 `start` int(10) unsigned NOT NULL default '0',
 `end` int(10) unsigned NOT NULL default '0',
 `a2` char(2) NOT NULL default '',
 `a3` char(3) NOT NULL default '',
 `country` varchar(100) NOT NULL default '',
 PRIMARY KEY (`start`,`end`)
 );


» 