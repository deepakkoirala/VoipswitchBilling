<?php

function last_login_ip()
{
	global $sec_db;
	$a = mysql_fetch_row(mysql_query("select last_ip from $sec_db.tbl_logs where id_client=$_SESSION[id_client]"));
	return $a[0];
}

function last_login_time()
{
	global $sec_db;
	$a = mysql_fetch_row(mysql_query("select last_time from $sec_db.tbl_logs where id_client=$_SESSION[id_client]"));
	return date("d M Y, h:i:s A",$a[0]);
}

function get_client_type_by_table()
{
	global $sec_db;
	$a = mysql_fetch_row(mysql_query("select id_client_type from $sec_db.tbl_clienttypes where table_name='$_SESSION[client_table]'"));
	return $a[0];
}
function get_resellers_balance($kasko,$id)
{
	$a = mysql_fetch_row(mysql_query("select callsLimit from $kasko where id=$id"));
	return $a[0];
}

function reseller3_id($r2)
{
	$a = mysql_fetch_row(mysql_query("select idReseller from resellers2 where id=$r2"));
	return $a[0];
}

function reseller2_id($r1)
{
	$a = mysql_fetch_row(mysql_query("select idReseller from resellers1 where id=$r1"));
	return $a[0];
}

function clients_reseller1_id()
{
	$a=mysql_fetch_row(mysql_query("select id_reseller from $_SESSION[client_table] where id_client=$_SESSION[id_client]"));
	return $a[0];
}


function client_type()
{
	global $sec_db;
	$a = mysql_fetch_row(mysql_query("select id_client_type from $sec_db.tbl_clienttypes where table_name='$_SESSION[client_table]'"));
	$b = mysql_fetch_row(mysql_query("select client_type_name from clienttypes where id_client_type=$a[0]"));
	return $b[0];
}

function client_tariff_name()
{
	$a=mysql_fetch_row(mysql_query("select id_tariff from $_SESSION[client_table] where id_client=$_SESSION[id_client]"));
	return tariff_name_by_id($a[0]);
}

function balance_nikal()
{
	$a=mysql_fetch_row(mysql_query("select account_state from $_SESSION[client_table] where id_client=$_SESSION[id_client]"));
	return $a[0];
}

function client_name()
{
	$a=mysql_fetch_row(mysql_query("select login from $_SESSION[client_table] where id_client=$_SESSION[id_client]"));
	return $a[0];
}

function tariff_name_by_id($id)
{
	$x = mysql_fetch_row(mysql_query("select description from tariffsnames where id_tariff=$id"));
	return $x[0];
}


function client_id_tariff($uid)
{
	global $client_table;
	$a=mysql_fetch_row(mysql_query("select id_tariff from $client_table where id_client=$uid"));
	return $a[0];
}

function id_client_type_table($id_client_type)
{
	global $sec_db;
	$a = mysql_fetch_row(mysql_query("select table_name from $sec_db.tbl_clienttypes where id_client_type=$id_client_type"));
	return $a[0];
}

function client_type_name_by_id($id)
{
	$b = mysql_fetch_row(mysql_query("select client_type_name from clienttypes where id_client_type = $id"));
	return $b[0];
}

?>