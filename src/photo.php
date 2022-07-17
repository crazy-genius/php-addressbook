<?php
	include("include/configure.php");
	include ("include/photo.class.php");

if ($id) {

   $sql = "SELECT photo FROM $base_from_where AND $table.id='$id'";
   $result = mysql_query($sql, $db);
   $r = $result[0]??[];;

   $resultsnumber = count($result);
}

$encoded = $r['photo'];

header('Content-Type: image/jpeg');
echo binaryImg($encoded);

?>
