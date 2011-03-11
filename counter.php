<?php
$fp1 = fopen ('count.txt', 'a+');
	$line = fgets($fp1);
	fclose($fp1);
$fp2 = fopen ('count.txt', 'w');
	$a = $line + 1;
	fputs($fp2,$a);
	fclose($fp2);
	$b = number_format($a);
	echo "<span style='font-size:10px;'>Hits: $b</font>";
?>