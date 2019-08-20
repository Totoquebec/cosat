<?
// Query for getting visitor countrycode
*****************************************************************************
  $country_query  = "SELECT country_code2,country_name FROM iptocountry ".
       "WHERE IP_FROM<=inet_aton('".$_ENV['REMOTE_ADDR']."') ".
        "AND IP_TO>=inet_aton('".$_ENV['REMOTE_ADDR']."') ";
*****************************************************************************
$ip=($_SERVER['HTTP_X_FORWARDED_FOR']=="")?$_SERVER['REMOTE_ADDR']:$_SERVER['HTTP_X_FORWARDED_FOR'];

If the user is behind a proxy,
 if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
  ...
}
 look in $_SERVER['HTTP_X_FORWARDED_FOR'] and rule out RFC 1918 IP's. That should leave you with the users real IP address.
 
If not, then $_SERVER['REMOTE_ADDR'] is what you need.
*****************************************************************************

    //---------------------------------------------------
    // Sample code to display Visitor Country information 
    // PHP 4 
    //---------------------------------------------------


    // Establishing a database connection
    $dbh=mysql_connect("localhost:3306","$MYSQL_USERNAME","$MYSQL_PASSWORD");
    mysql_select_db("$MYSQL_DBNAME");


    // Query for getting visitor countrycode
    $country_query  = "SELECT country_code2,country_name FROM iptoc ".
         "WHERE IP_FROM<=inet_aton('$REMOTE_ADDR') ".
          "AND IP_TO>=inet_aton('$REMOTE_ADDR') ";


    // Executing above query
    $country_exec = mysql_query($country_query);


    // Fetching the record set into an array
    $ccode_array=mysql_fetch_array($country_exec);


    // getting the country code from the array
    $country_code=$ccode_array['country_code2'];


    // getting the country name from the array
    $country_name=$ccode_array['country_name'];


   // Display the Visitor coountry information
   echo "$country_code - $country_name";


   // Closing the database connection
   mysql_close($dbh);


?>
