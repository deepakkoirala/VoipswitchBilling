<?php
include "func.php";
include "session.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DialDemand.com - Profile - Edit Your Profile</title>
<link href="styles.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php include "header.php"; ?>
<div class="bichko">
  <div class="cell"><style>
.t1 td , th { padding-left:15px; padding-right:15px;padding-top:1px;padding-bottom:1px; font-family:tahoma; font-size:12px;}
.t1 {border-left: 1px solid #999; border-right: 1px solid #999;border-top: 1px solid #999;border-bottom: 1px solid #999;  }
</style>
<?php

$action = $_REQUEST['action'];

$name = $_REQUEST['name'];
$address = $_REQUEST['address'];
$city = $_REQUEST['city'];
$country = $_REQUEST['country'];
$email = $_REQUEST['email'];
$phone = $_REQUEST['phone'];

$cp= $_REQUEST['cp'];
$np = $_REQUEST['np'];
$rnp = $_REQUEST['rnp'];

if($action == "editprofile")
{
	$clientType = get_client_type_by_table();
	if($name != "" && $address != "" && $city != "" && $country != "" && $email != "" && $phone != "")
	{
		if(!check_user_profile())
		{
			if(mysql_query("insert into invoiceclients set IDClient=$id_client, type=$clientType, Name='$name', Address='$address', EMail='$email', City='$city', Country='$country', Phone='$phone'"))
				echo "<p><b><font color=red>Your profile information has been updated successfully..</font></b></p>";
			else
				echo "<p><b><font color=red>Error.. updating profile information...</font></b></p>";
		}
		else
		{
			//for update
			//echo "exists row";
			if(mysql_query("update invoiceclients set Name='$name', type=$clientType, Address='$address', EMail='$email', City='$city', Country='$country', Phone='$phone' where IDClient=$id_client"))
				echo "<p><b><font color=red>Your profile information has been updated successfully..</font></b></p>";
			else
				echo "<p><b><font color=red>Error.. updating profile information...</font></b></p>";
		
		}
	}
	else
			echo "<p><b><font color=red>Error, please fill up all the forms correctly..</font></b></p>";
	
}

$nikal = mysql_fetch_row(mysql_query("select Name, Address, City, Country, EMail, Phone from invoiceclients where IDClient=$id_client"));

echo "<br><form action=profile.php method=post> <table class=t1>
<tr>
<th colspan=3><font color=red>Warning: Please Update Your Profile. So that it wont ask you again.</font><br><br></th>
</tr>
<tr>
<td>Full Name</td><td>:</td><td><input type=text name=name value='$nikal[0]'> *</td>
</tr>
<tr>
<td>Address</td><td>:</td><td><input type=text name=address value='$nikal[1]'> *</td>
</tr>
<tr>
<td>City</td><td>:</td><td><input type=text name=city value='$nikal[2]'> *</td>
</tr>
<tr>
<td>Country</td><td>:</td><td>"; include "countries2.txt"; echo " *</td>
</tr>
<tr>
<td>Email</td><td>:</td><td><input type=text name=email value='$nikal[4]'> *</td>
</tr>
<tr>
<td>Phone/Cell</td><td>:</td><td><input type=text name=phone value='$nikal[5]'> *</td>
</tr>
<tr>
<th colspan=3><input type=hidden name=action value=editprofile><input type=submit value='Update Profile'> <input type=reset></th>
</tr>
<tr>
</table></form><br><br>
";

if($_SESSION['id_client'] == $demoid1 || $_SESSION['id_client'] == $demoid2 || $_SESSION['id_client'] == $demoid3 || $_SESSION['id_client'] == $demoid4 )
{
	echo "<p><b><font color=red><p><p>Demo Users Cannot change Password...</font></b></p>";
}
else
{
	if($action == "changepw")
	{
		
		if(($np == $rnp) && strlen($np) > 0)
		{
			if(check_user_password($cp))
			{
				if(mysql_query("update $_SESSION[client_table] set password='$np' where id_client= $_SESSION[id_client]"))
					echo "<p><b><font color=red>Your Password has been changed Successfully..</font></b></p>";
				else
					echo "<p><b><font color=red>Error, changing password...</font></b></p>";
				
			}
			else
				echo "<p><b><p><font color=red>Error.. your current password doesnt match</font></b></p>";
		}
		else if($np != $rnp)
		{
			echo "<p><b><font color=red>Error.. both password fields doesnt match</font></b></p>";
		}
		else
		{
			echo "<p><b><font color=red>Error.. Please fill the forms correctly..</font></b></p>";
		}

	}
	echo "<p><form action=profile.php method=post> <table class=t1>
	<tr>
	<th colspan=3>Change Your Current Password</th>
	</tr>
	<tr>
	<td>Current Password</td><td>:</td><td><input type=password name=cp> *</td>
	</tr>
	<tr>
	<td>New Password</td><td>:</td><td><input type=password name=np> * Min: 1 Char</td>
	</tr>
	<tr>
	<td>Retype New Password</td><td>:</td><td><input type=password name=rnp> *</td>
	</tr>
	<tr>
	<th colspan=3><input type=hidden name=action value=changepw><input type=submit value='Change Password'> <input type=reset><br>
	Note: If you Change your password, you need to change on your voIP device also.
	</th>
	</tr>
	<tr>
	</table></form>
	";
}

function check_user_profile()
{
	$data = mysql_fetch_row(mysql_query("select IDClient from invoiceclients where IDClient= $_SESSION[id_client]"));
	if($data[0] != "")
		return 1;
	else
		return 0;
}

function check_user_password($pw)
{
	$data = mysql_fetch_row(mysql_query("select password from $_SESSION[client_table] where id_client= $_SESSION[id_client] AND password='$pw'"));
	if($data[0] != "")
		return 1;
	else
		return 0;
}

?>
</div>
</div>
<?php include "footer.php"; ?>
</body>
</html>