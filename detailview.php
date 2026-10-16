<?
$con = mysql_connect("localhost","root","apmsetup");
mysql_select_db("shopmall",$con);

$result = mysql_query("select * from receivers where ordernum='$ordernum'", $con);
$total = mysql_num_rows($result);

$session = mysql_result($result, 0, "session");
$sender = mysql_result($result, 0, "sender");
$receiver = mysql_result($result, 0, "receiver");
$phone = mysql_result($result, 0, "phone");
$address = mysql_result($result, 0, "address");
$message = mysql_result($result, 0, "message");
$buydate = mysql_result($result, 0,  "buydate");
$status = mysql_result($result, 0, "status");
	 
switch ($status) {
	case 1:
		$status   = "주문신청";
		break;
	case 2:
		$status   = "주문접수";
		break;
	case 3: 
		$status   = "배송준비중";
		break;
	case 4:
		$status   = "배송중";
		break;
	case 5:
		$status   = "배송완료";
		break;
	case 6:
		$status   = "구매완료";
		break;
}
	 
echo ("
    <center><font size=2>주문번호:<b>$ordernum</b> [<font color=red size=2>   <b>$status</b></font>]</center>
	<table border=1 width=900>
");

echo ("
	<tr><td align=center width=100><font size=2>주문번호</td>
	<td align=center width=150><font size=2>주문일자</td>
	<td align=center width=550>
		<table border=0>
			<tr><td width=390 align=center><font size=2>상품명</td>
			<td align=center width=40><font size=2>수량</td>
			<td align=center width=50><font size=2>단가</td>
			<td align=center width=70><font size=2>금액</td>
			</tr>
		</table></td>
	<td align=center width=100><font size=2>총액</td></tr>
");	

echo("
	<tr><td align=center><font size=2>$ordernum</td>
	<td align=center><font size=2>$buydate</td>
	<td>
");
	
$subresult = mysql_query("select * from orderlist where session='$session'", $con);
$subtotal = mysql_num_rows($subresult);

$subcounter=0;
$totalprice=0;
          
while ($subcounter < $subtotal) :
	$pcode = mysql_result($subresult, $subcounter, "pcode");
	$quantity = mysql_result($subresult, $subcounter, "quantity");
	   
	$tmpresult = mysql_query("select * from product where code='$pcode'", $con);

	$pname = mysql_result($tmpresult, 0,   "name");
	$price = mysql_result($tmpresult, 0,   "price2");
		   
	$subtotalprice = $quantity * $price;
	$totalprice = $totalprice + $subtotalprice;
	
	echo("
		<table border=0>
		<tr><td width=390><font size=2>$pname</td>
		<td align=right width=40><font size=2>$quantity</td>
		<td align=right width=50><font size=2>$price</td>
		<td align=right width=70><font size=2>$subtotalprice</td>
		</tr>
		</table>
	");
	
     $subcounter++;
endwhile;
	
echo ("
	</td>
	<td align=right><font color=red size=2><b>$totalprice</b></td>
	</tr>
	</table>
");

echo ("
	<table border=1 width=900>
	<tr><td   align=center><font size=2>주문자명</td>
	<td align=center><font size=2>수신자명</td>
	<td align=center><font size=2>수신주소</td>
	<td align=center><font size=2>수신자연락처</td>
	</tr>
");

echo ("
	<tr><td align=center><font size=2>$sender</td>
	<td align=center><font size=2>$receiver</td>
	<td><font size=2>$address</td>
	<td align=center><font size=2>$phone</td></tr>
	<tr><td colspan=4><font size=2>주문 메시지: $message</td></tr>
	</table>
");

mysql_close($con);

?>
