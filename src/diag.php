<?php
	include("include/configure.php");
	include ("include/format.inc.php");

	if(! $user->hasRole("root")) {
		echo "Login in with root permissions";
		print_r($user);
		exit;
	}
?>
<title><?php echo ucfmsg("ADDRESS_BOOK").($group_name != "" ? " ($group_name)":""); ?></title>
<?php include ("include/header.inc.php"); ?>

<br>
<br>
<hr>
<h1>Self-Checks</h1>
<table>
	<tr><th>Test</th><th>Expected</th><th>Result</th></tr>
	<tr>
		<td><b>DB-Connection</b></td>
		<td><?php echo ($db ? "ok" : "nok"); ?></td>
	</tr>
	<tr>
<?php
 $tbls = array($table, $month_lookup, $table_groups, $table_grp_adr);
 $sql = "select * from information_schema.tables where table_name in ('".implode("', '", $tbls)."');";
 $result = $dbal->query($sql);
 $resultsnumber = count($result);
 ?>
		<td><b>Tables</b><br><?php echo $sql;?></td>
		<td><?php echo count($tbls); ?></td>
		<td><?php echo $resultsnumber; ?></td>
	</tr>
</table>

<?php
 $tbls = array($table, $month_lookup, $table_groups, $table_grp_adr);
 $sql = "select * from information_schema.tables where table_name in ('".implode("', '", $tbls)."');";
 $result = $dbal->query($sql);
 $resultsnumber = count($result);
 ?>

<hr>
<h1>Statistics</h1>
<table>
	<tr><th>ID</th><th>Name</th><th>Count</th></tr>
<?php
 $sql = "select count(*) cnt, domain_id from $table where deprecated is null group by domain_id order by cnt desc";
 $result = $dbal->query($sql);
 foreach ($result as $myrow)
 {
   echo "<tr><td>".$myrow['domain_id']."</td>"
           ."<td>".$domain[$myrow['domain_id']]['name']."</td>"
           ."<td>".$myrow['cnt']."</td></tr>";
 }
?>
</table>
<?php include("include/footer.inc.php"); ?>
