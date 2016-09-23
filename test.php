<?php

require './overtrue/pinyin/src/Pinyin.php';
require './overtrue/pinyin/src/DictLoaderInterface.php';
require './overtrue/pinyin/src/FileDictLoader.php';
use Overtrue\Pinyin\Pinyin;
$pinyin = new Pinyin();

$con = mysql_connect("sql_ip","user_name","user_password"); // modify sql_ip,user_name,user_password
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
  
  mysql_select_db("db_name", $con); // modify sql_ip,user_name,user_password
  $result = mysql_query("SELECT * from base_zone where level_num = 2 || level_num =1 ORDER BY id");
  while($row = mysql_fetch_array($result))
  {
	  $name = $pinyin->convert($row['name']);
	  $name_str = "";
	  for($i=0;$i<count($name)-1;$i++) {
		  if($i == 0) {
			  $name_str = ucfirst($name[$i]);
		  } else {
			  $name_str = $name_str . $name[$i];
		  }
	  }
	  $result_update = mysql_query("UPDATE base_zone SET pinyin_name = '".$name_str."' WHERE id = ".$row['id']);
	  echo $row['name'] . "  - " . $name_str ; 
	  echo "<br />";
  }

mysql_close($con);
  
?>