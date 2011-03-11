<!--#include file="stan.txt" -->
<div class="head">
  <table width="100%" border="0" cellspacing="0">
    <tr>
      <td width="40%" height="150" valign="top"><a href="index.php"><img src="img/dialdemand.jpg" width="327" height="142" border="0" /></a></td>
      <td width="60%" style="text-align: center;"><span class=balance><?php if($_SESSION['id_client']) echo "Balance: $currency".balance_nikal(); ?></span></td>
    </tr>
    <tr>
      <td height="50" colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="44%" height="33"><span class="login"><?php echo client_name(); ?></span> - A/C Status : <?php if(my_account_status()) $st="Active"; else $st = "InActive"; ?> <span class="<?php echo $st; ?>"><?php echo $st; ?> &#8226;</span></td>
          <td width="56%"><?php if(clients_reseller1_id()>0)
	resellers_balance_status();
	?></td>
        </tr>
      </table></td>
    </tr>
  </table>
</div>
<div class="menu"><br />
<?php
	if($_SESSION['id_client'])
		include "logged_menu.php";
		//echo "deepak";
?>
</div>