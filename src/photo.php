<?php
	include("include/configure.php");
	include ("include/photo.class.php");

if ($id) {

   $sql = "SELECT photo FROM $base_from_where AND $table.id='$id'";
   $result = mysql_query($sql, $db);
   $r = mysqli_fetch_array($result);

   $resultsnumber = mysqli_num_rows($result);
}

$encoded = $r['photo'];

header('Content-Type: image/jpeg');
echo binaryImg($encoded);

?>
