<?php
include "func.php";
include "session.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DialDemand.com - Payment - See Your Payments</title>
<link href="styles.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php include "header.php"; ?>
<div class="bichko">
  <div class="cell"><style>
.t1 td, th { padding:15px; font-family:tahoma; font-size:12px;}
.t1 { border: 1px solid #999; border-collapse: collapse; }
</style>
<?php

$ct = get_client_type_by_table();
echo "<p>Here comes the Payments History</p>";
$i = 1;
echo "<table class=t1 border=1 cellpadding=0 border=0 cellspacing=0>
<tr>
	<td>Sn.</td>
	<td>Balance</td>
	<td>Date Of Payment</td>
	<td>Type</th>
	<td>Description</th>
</tr>";
$trt = sprintf("%.4f",0);
$a = mysql_query("select money, data, type, description from payments where id_client=$id_client AND client_type=$ct order by data desc");
while($b = mysql_fetch_row($a))
{
	echo "<tr><td>$i</td><td>$b[0] $currency</td><td>".substr($b[1],0,10).". ".change_date_stamp(substr($b[1],11,9))."</td><td>".paymenttypes_($b[2])."</td><td>$b[3]</tr>";
	if($b[2] == 1)
		$tpr = sprintf("%.4f",$tpr + $b[0]);
	else if($b[2] == 3)
		$trt = sprintf("%.4f",$trt + $b[0]);
	$i++;
}
$gt = sprintf("%.4f",$tpr-$trt);
echo "<tr><th colspan=5>- Total PrePaid Type : $tpr $currency
<br><br>- Total Return Type : $trt $currency
<br><br>- Grand Total : $gt $currency
</th></tr>
</table>";

function paymenttypes_($x)
{
	$a = mysql_fetch_row(mysql_query("select name from paymenttypes where id=$x"));
	return $a[0];
}
?>
</div>
</div>
<?php include "footer.php"; ?>
</body>
</html>