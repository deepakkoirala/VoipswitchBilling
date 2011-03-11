<?php

include "config.php";
connect_switch();

include "core.php";

function update_stats()
{
	if($_SESSION['id_client'])
	{
		global $sec_db;
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		if(!$ip)
			$ip = $_SERVER['REMOTE_ADDR'];
		$time= time();
		$a = mysql_fetch_row(mysql_query("select id_client from $sec_db.tbl_logs where id_client=$_SESSION[id_client]"));
		if($a[0])
			mysql_query("update $sec_db.tbl_logs set last_time='$time', last_ip='$ip' where id_client=$_SESSION[id_client]");
		else
			mysql_query("insert into $sec_db.tbl_logs set last_time='$time', last_ip='$ip', id_client=$_SESSION[id_client]");
	}
}

function change_date_stamp($d)
{
	$a = substr($d,0,2);
	if($a == 12)
	{
		$c = $d." PM";
		return $c;
	}
	if($a > 12)
	{
		$b = $a - 12;
		$c = str_replace($a,$b,$d)." PM";
		return $c;
	}
	else
	{
		$b = $a;
		return $d." AM";
	}

}


function total_money_invest()
{
	$tdate = date("Y-m-d",time());
	$a = mysql_fetch_row(mysql_query("select sum(cost) from calls where id_client=$_SESSION[id_client] AND call_start like '$tdate%'"));
	if($a[0]) return $a[0]; else return 0;
}


function total_calls_today()
{
	$tdate = date("Y-m-d",time());
	$a = mysql_fetch_row(mysql_query("select count(*) from calls where id_client=$_SESSION[id_client] AND call_start like '$tdate%'"));
	return $a[0];
}


function my_account_status()
{
	$r1 = clients_reseller1_id();
	//echo $r1;
	$b = mysql_fetch_row(mysql_query("select type from $_SESSION[client_table] where id_client=$_SESSION[id_client]"));
	$a = $b[0];
	if($r1 > 0)
	{
		if($a % 2 == 0)
			return 0;
		else
			$x = mysql_fetch_row(mysql_query("select type from resellers1 where id=$r1"));
			$a = $x[0];
	}
	$type = $a;
	if($type % 2 == 0)
		return 0;
	else
		return 1;

}


function resellers_balance_status()
{
	$r1b = get_resellers_balance("resellers1",clients_reseller1_id());
	$r2b = get_resellers_balance("resellers2",reseller2_id(clients_reseller1_id()));
	$r3b = get_resellers_balance("resellers3",reseller3_id(reseller2_id(clients_reseller1_id())));
	if($r1b < 1)
		echo "<p>Reseller Status: Your Reseller Balance is Finished. Please contact your reseller soon !!</p>";
	else if($r2b < 1)
		echo "<p>Resellers Status: Your Resellers Balance is Finished. Please contact your resellers soon !!</p>";
	else if($r3b < 1)
		echo "<p>Resellerss Status: Your Resellerss Balance is Finished. Please contact your resellerss soon !!</p>";
	else if( $r1b < 11)
		echo "<p>Reseller Status: Your Reseller Balance is Getting Low. Please contact your reseller soon !!</p>";
	else if($r2b < 11)
		echo "<p>Resellers Status: Your Resellers Balance is Getting Low. Please contact your resellers soon !!</p>";
	else if($r3b < 11)
		echo "<p>Resellerss Status: Your Resellerss Balance is Getting Low. Please contact your resellerss soon !!</p>";
	else
		echo "<p>Your Reseller Balance Status: Is Also Ok !</p>";
}

function login_user_check($login,$password,$id_client_type)
{
	$id_client_type_table = id_client_type_table($id_client_type);
	//echo $id_client_type_table;
	//$rep = array("=","'","\"");
	//$login = str_replace($rep,"",$login);
	//$password = str_replace($rep,"",$password);
	$login = mysql_real_escape_string($login);
	$password = mysql_real_escape_string($password);
	$a = mysql_fetch_row(mysql_query("select id_client from $id_client_type_table where login='$login' AND password='$password' "));
	if($a[0])
	{
		$_SESSION['id_client'] = $a[0];
		$_SESSION['client_table'] = $id_client_type_table;
		return 1;
	}
	return 0;
}

function login_form_nikal()
{
	global $sec_db;
	$a = mysql_query("select id_client_type from $sec_db.tbl_clienttypes");
	echo "<form action=login.php method=post><table style='border-right:1px solid #999; border-left:1px solid #999; border-top:1px solid #999; border-bottom:1px solid #999; padding:12px; '><tr><td>
	Username</td><td>:</td><td><input type=text name=login></td></tr>
	<tr><td>
	Password</td><td>:</td><td><input type=password name=password></td></tr>
	<tr><td colspan=3>
	<input type=hidden name=action value=login>";
	echo "Account Type : <select name=id_client_type>";
	while($b = mysql_fetch_row($a))
	{
		if($b[0] == 2)
			echo "<option value=$b[0] selected>".client_type_name_by_id($b[0])."</option>";
		else
			echo "<option value=$b[0]>".client_type_name_by_id($b[0])."</option>";
	}
	echo "</select></td></tr>";
	echo "<tr><td colspan=3><input type=submit value=Login><input type=reset></td></tr></table></form>";
}



function connect_switch()
{
	global $dbuser,$dbpw,$dbhost,$main_db;
	if(mysql_connect($dbhost,$dbuser,$dbpw))
	{
		if(mysql_select_db($main_db))
			return 1;
		else
			echo "<p>Error database doesnt exists or error fetching database</p>";
	}
	else
		echo "<p>Error, connecting database</p>";
}

	
	


?>