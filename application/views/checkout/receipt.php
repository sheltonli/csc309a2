<h2>Thank you for buying candy from us!</h2>
<p>Your receipt has been emailed to you <br> You may print a receipt for your records</p>
<?php
$total = 0;
$s = "<table>";
$s = $s . "<tr><th>Name</th><th>Description</th><th>Price</th></tr>";

foreach ($products as $product) {
	if ($this->session->userdata($product->id)) {
		$s = $s . "<tr>";
		$s = $s . "<td>" . $product->name . "</td>";
		$s = $s . "<td>" . $product->description . "</td>";
		$s = $s . "<td>" . $product->price . "</td>";
		$s = $s . "</tr>";
		$total += ($product->price * $this->session->userdata($product->id));
	}

}
$s = $s . "<table>";
$s = $s . "<p>". "Your total is: " . $total . "</p>";
$date = getDate();
$day = $date['mday'];
$month = $date['mon'];
$year = $date['year'];

echo "<p>" . anchor('client/index','Return To Store') . "</p>";
?>	

<script language="JavaScript">
<!--
	function writeMTable() {
		top.wRef=window.open('','myconsole',
			'width=500,height=450,left=10,top=10'
			+',menubar=1'
			+',toolbar=0'
			+',status=1'
			+',scrollbars=1'
			+',resizable=1')
			top.wRef.document.writeln(
				'<html><head><title>Candy Store Receipt</title></head>'
				+'<body bgcolor=white onLoad="self.focus()">'
				+'<center><font color=red><b><i>For printing, <a href=# onclick="window.print();return false;">click here</a> or press Ctrl+P</i></b></font>'
				+'<H3>Candy Store Receipt</H3>'
				+'<table border=0 cellspacing=3 cellpadding=3>'
			)

			var text = "<?php echo $s; ?>";
			var d = "<?php echo $day; ?>";
			var m = "<?php echo $month; ?>";
			var y = "<?php echo $year; ?>";
		top.wRef.document.writeln(text);
		top.wRef.document.writeln(d + "/");
		top.wRef.document.writeln(m + "/");
		top.wRef.document.writeln(y);

		top.wRef.document.writeln(buf+'</table></center></body></html>')
			top.wRef.document.close()
	}
//-->
writeMTable();
</script>
