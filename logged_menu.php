<?php
if($_SESSION['id_client'])
{
echo "<a class=hm href=index.php>Home</a>  <a class=hm href=profile.php>My Profile</a>  <a class=hm href=logs.php>Call Logs</a>  <a class=hm href=rates.php>Call Rates</a>  <a class=hm href=payments.php>Payments</a>  <a class=hm href=login.php?action=logout>Logout</a>&nbsp;";

//echo "<p><b><font size=5>".client_name()."</font></b> - Status: <b>";
//if(my_account_status()) echo "Active"; else echo "InActive";
//echo "</b> &nbsp;<b><font size=5>Balance: $currency".balance_nikal()."</font></b></p>";
}
?>