<?php
include "func.php";
include "session.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DialDemand.com - Logs - See All Your Call Logs</title>
<link href="styles.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="calendarDateInput.js"></script>
</head>
<body>
<?php include "header.php"; ?>
<div style="margin-left:auto; margin-right:auto; width:1001px;">
<div class="cell"><br />
<form method=get action=logs.php> 
<script>DateInput('date', true, 'YYYY-MM-DD')</script><input type=submit value='Show Logs For This Date'>
</form>
<style>
.t1 td { padding-left:10px; padding-right:10px; padding-top:5px; padding-bottom:5px; font-family:tahoma; font-size:12px;}
.t1 { border: 1px solid #999; border-collapse: collapse; }
</style>
<?php

update_stats();

$ct = get_client_type_by_table();
$date = $_REQUEST['date'];
if($date != "")
	$thap = "AND call_start like '$date%'";
$total = total_logs();
	//echo $thap;
$kati = 40;
$p = $_REQUEST['p']==0?1:$_REQUEST['p'];
$start = ($p * $kati)-$kati;

$i = $start + 1;

if($total > 0)
{
	if($date)	echo "<p>Log Results - $total Logs Found for $date.!!</p>"; else echo "<p>Log Results - Displaying All Logs</p>";
	echo "<table class=t1 border=1 cellpadding=0 border=0 cellspacing=0>
	<tr>
		<td>Sn.</td>
		<td>Date</td>
		<td>Time</td>
		<td>Location</td>
		<td>Dialed Number</td>
		<td>IP Used</th>
		<td>(MIN)</td>
		<td>Charge</td>
	</tr>";
	$a = mysql_query("select call_start, called_number, tariffdesc, ip_number, cost,call_end,duration from calls where id_client = $_SESSION[id_client] AND client_type=$ct $thap order by id_call desc limit $start, $kati");
	while($b = mysql_fetch_row($a))
	{
		$dura = ceil($b[6]/60);
		echo "<tr><td>$i</td><td>".substr($b[0],0,10)."</td><td>".change_date_stamp(substr($b[0],11,9))." - ".change_date_stamp(substr($b[5],11,9))."</td><td>$b[2]</td><td>+$b[1]</td><td>$b[3]</td><td>$dura</td><td>$currency$b[4]</td></tr>";
		$totaldura = $totaldura + $dura;
		$i++;
	}
	echo "</table>";

	$tk = $total / $kati;
	$tk = (int)$tk;
	if($total % $kati != 0)
		++$tk;
	$possible = $tk;

	$prev = $p-1;
	$next = $p+1;

	echo "<p>";
	if($p != 1)
		echo "<a title='Previous Page' href=$_SERVER[PHP_SELF]?p=$prev&date=$date><< Prev</a> ";

	for($i=1;$i<=$possible;$i++)
	{
		if($p==$i)
		{ if($possible != 1) echo "$i "; }
		else
			echo "<a title='Page $i' href=$_SERVER[PHP_SELF]?p=$i&date=$date>$i</a> ";

	}
	if($p != $possible)
		echo "<a title='Next Page' href=$_SERVER[PHP_SELF]?p=$next&date=$date> Next >></a>";

	echo "</p>";
	if($date)
		echo "<p>Total Money In $date is $currency".total_money()." for $totaldura Mins</p>";
	else
		echo "<p>Total Money In All Months is $currency".total_money()." for $totaldura Mins</p>";
}
else
	echo "<p>No any logs found for $date. !!! <a href=logs.php>See All Logs</a></p>";

function total_logs()
{
	global $thap,$ct;
	$a = mysql_query("select count(*) from calls where id_client = $_SESSION[id_client] AND client_type=$ct $thap");
	$b = mysql_fetch_row($a);
	return $b[0];
}

function total_money()
{
	global $thap,$ct;
	$a = mysql_query("select sum(cost) from calls where id_client = $_SESSION[id_client] AND client_type=$ct $thap ");
	$b = mysql_fetch_row($a);
	return $b[0];
}


?>
</div>
</div>
<?php include "footer.php"; ?>
</body>
</html>