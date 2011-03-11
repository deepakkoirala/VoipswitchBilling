<?php
include "func.php";
include "session.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DialDemand.com - Home - Billing</title>
<link href="styles.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php include "header.php"; ?>
<div class="bichko">
  <div class="cell"><style>
.t1 td { padding:15px; font-family:tahoma; font-size:12px;}
.t1 { border: 1px solid #999; border-collapse: collapse; }
</style>
<?php
		
if($_SESSION['id_client'])
{
$tid = client_id_tariff($id_client);
$tname =  tariff_name_by_id($tid);
$balance = balance_nikal();
$at = client_type();
$cn = client_name();

echo "<br>
<table border=1 class=t1>
<tr>
<th colspan=3</th>Account Information</th>
</tr>
<tr>
<td>Account Client Name</td><td>:</td><td>$cn</td>
</tr>
<tr>
<td>Account Tariff</td><td>:</td><td>$tname</td>
</tr>
<tr>
<td>Account Type</td><td>:</td><td>$at</td>
</tr>
<td>Your Current IP</td><td>:</td><td>$_SERVER[REMOTE_ADDR]</td>
</tr>
</tr>
<td>Last Login IP</td><td>:</td><td>".last_login_ip()."</td>
</tr>
</tr>
<td>Last Login Time</td><td>:</td><td>".last_login_time()."</td>
</tr>
<tr>
<td>Balance</td><td>:</td><td>$currency$balance</td>
</tr>
</table>
";

if(my_account_status())
	echo "<p>Your Account is Active</p>";
else
	echo "<p>Your Account is not Active</p>";

if(clients_reseller1_id()>0)
	resellers_balance_status();

$tdate = date("Y-m-d",time());
echo "<p><b>Today Date: $tdate</b><br>
Calls Made: ".total_calls_today()."<br>
Money Invested : $currency".total_money_invest()."<br>



</p>";

}




?>
</div>
</div>
<?php include "footer.php"; ?>
</body>
</html>