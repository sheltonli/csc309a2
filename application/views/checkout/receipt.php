<h2>Thank you for buying candy from us!</h2>
<p>Your receipt has been emailed to you <br> You may print a receipt for your records</p>
<?php
	$total = 0;
	echo "<p>" . anchor('client/index','Back') . "</p>";

echo "<table>";
                echo "<tr><th>Name</th><th>Description</th><th>Price</th></tr>";

                foreach ($products as $product) {
                        if ($this->session->userdata($product->id)) {
				echo "<tr>";
				echo "<td>" . $product->name . "</td>";
				echo "<td>" . $product->description . "</td>";
				echo "<td>" . $product->price . "</td>";
                        	echo "</tr>";
				$total += ($product->price * $this->session->userdata($product->id));
                        }

                }
                echo "<table>";
		echo "<p>". "Your total is: " . $total . "</p>"
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

 
 top.wRef.document.writeln(buf+'</table></center></body></html>')
 top.wRef.document.close()
}
//-->
writeMTable();
</script>
