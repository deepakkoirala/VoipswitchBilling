<?php
include "func.php";
include "session.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DialDemand.com - Rates - See All Call Rates</title>
<link href="styles.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php include "header.php"; ?>
<div class="bichko">
  <div class="cell"><style>
.t1 td { padding-left:10px; padding-right:10px; padding-top:5px; padding-bottom:5px; font-family:tahoma; font-size:12px;}
.t1 { border: 1px solid #999; border-collapse: collapse; }
</style>
<?php

$s = $_REQUEST['s'];
$tid = client_id_tariff($id_client);
$tname =  tariff_name_by_id($tid);

$kati = 20;
$p = $_REQUEST['p']==0?1:$_REQUEST['p'];
$start = ($p * $kati)-$kati;

$i = $start + 1;
echo "<p>Your Tarriff : $tname</p>";
include "countries.txt";

echo "<p>Alphabetical Order</p>";

for($al=65;$al<=90;$al++)
{
	echo "<a href=$_SERVER[PHP_SELF]?s=".chr($al).">".chr($al)."</a> ";

}

$total = total_tariffs();
if($s)
{
	if($total > 0)
	{
		echo "<br><br>Listed according to: $s<br><br><table class=t1 border=1 cellpadding=0 border=0 cellspacing=0>
		<tr>
		<td>Sn.</td>
		<td>Network</td>
		<td>Code</td>
		<td>Rate $currency</td>
		</tr>";

		$x = mysql_query("select prefix, description, voice_rate from tariffs where id_tariff=$tid AND (description like '$s%' OR prefix like '$s%') order by description,prefix limit $start, $kati");
		while($y = mysql_fetch_row($x))
		{
			echo "<tr><td>$i</td><td>$y[1]</td><td>$y[0]</td><td>$y[2]</td></tr>";
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
			echo "<a title='Previous Page' href='$_SERVER[PHP_SELF]?p=$prev&s=$s'><< Prev</a> ";

		for($i=1;$i<=$possible;$i++)
		{
			if($p==$i)
			{ if($possible != 1) echo "$i "; }
			else
				echo "<a title='Page $i' href='$_SERVER[PHP_SELF]?p=$i&s=$s'>$i</a> ";

		}
		if($p != $possible)
			echo "<a title='Next Page' href='$_SERVER[PHP_SELF]?p=$next&s=$s'> Next >></a>";

		echo "</p>";
	}
	else
		echo "<p>$total rates found for $s !!</p>";
}


function total_tariffs()
{
	global $tid,$s;
	$x = mysql_fetch_row(mysql_query("select count(*) from tariffs where id_tariff=$tid AND (description  like '$s%' OR prefix like '$s%')"));
	return $x[0];
}

?>
</div>
</div>
<?php include "footer.php"; ?>
</body>
</html>