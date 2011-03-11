<?php
include "func.php";

session_start();

$login = $_REQUEST['login'];
$password = $_REQUEST['password'];
$id_client_type = $_REQUEST['id_client_type'];
$action = $_REQUEST['action'];

if($action == "login")
{
	if(login_user_check($login,$password,$id_client_type))
	{
		if(check_user_profile())
		{
		//echo "<p>Successfully logged In</p>";
		//header("location: index.php");
			header("location: index.php");
			exit;
		}
		else
		{
			header("location: profile.php");
			exit;
		}
	}
	else
	{
		$msg = "Login unsuccessful, plz try again !!!!";
		//login_form_nikal();

	}
}
else if($action == "logout")
{
	$msg =  "Successfully logged out!! Thank you for using our system.";
	update_stats();
	session_destroy();
	//login_form_nikal();
}
else
{
	if($_SESSION['id_client'])
		$msg = client_name()." is logged in <a href=login.php?action=logout>Logout Now</a>";
	else
	{
		$msg = "<p>Not logged in. Please login now.<p>";
		//login_form_nikal();
	}
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DialDemand.com - Login - Please Login</title>
<link href="styles.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="head">
  <table width="100%" border="0" cellspacing="0">
    <tr>
      <td width="40%" height="150" valign="top"><a href="index.php"><img src="img/dialdemand.jpg" width="327" height="142" border="0" /></a></td>
      <td width="60%" style="text-align: center;"></td>
    </tr>
    <tr>
      <td height="50" colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="35%" height="33"></td>
          <td width="65%"></td>
        </tr>
      </table></td>
    </tr>
  </table>
</div>
<div class="bichko">
  <div class="cell"><style>
.t1 td { padding:15px; font-family:tahoma; font-size:12px;}
.t1 { border: 1px solid #999; border-collapse: collapse; }
</style>
<?php

echo "<p><font color=blue>$msg</font></p>";
login_form_nikal();



?>
<p><h2><a href=http://cdr.dialdemand.com/vsr target=_blank>Reseller Login</a></h2></p>
</div>
</div>
<?php include "footer.php"; ?>
</body>
</html>
<?php

function check_user_profile()
{
	$data = mysql_fetch_row(mysql_query("select IDClient from invoiceclients where IDClient= $_SESSION[id_client]"));
	if($data[0] != "")
		return 1;
	else
		return 0;
}

?>