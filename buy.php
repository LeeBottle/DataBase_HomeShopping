<? include ("top.html"); ?>
  <body style="background-color:#EFEFEF">
  </body>
  
<table border=1 width=900>
<tr height=600>
<td width=180 valign=top><? include ("left.html"); ?></td>
<td width=720 align=center valign=top>

<script language='Javascript'>
	function go_zip(){
		window.open('zipcode2.php', 'zipcode',   'width=470, height=180, scrollbars=yes');
	}
</script>
<br>
	<table  width=100% cellspacing=0 >
	<tr><td width=23% height=20 align=center bgcolor=black style='border: thin solid; border-radius:10px;'><font color=white size=5><b>상품구매 목록<b></font></td>
	<td align=right><font size=4>[<a href=index.html style='color:black;' onMouseover='this.style.color='red''onMouseout='this.style.color='black'><b>Back</b></a>]</td></tr>
	<tr border=1><td bgcolor=black width=100% height=5 colspan=2></td></tr>
	</table>
<table width=690 border=0>
<tr><td align=right><font size=2><b><? echo $UserName; ?></b>님의 구입 예정   품목</td>
</table>
<br>

<?

$con = mysql_connect("localhost","root","apmsetup");
mysql_select_db("shopmall",$con);

// 전체 쇼핑백 테이블에서 특정 사용자의 구매 정보만을 읽어낸다
$result = mysql_query("select * from shoppingbag where session='$Session'", $con);
$total = mysql_num_rows($result);

echo ("
	<table border=1 cellspacing=0 width=690>
    <tr><td width=100 align=center><font size=2>상품사진</td>
	<td width=300 align=center><font size=2>상품이름</td>
	<td width=90 align=center><font size=2>가격(단가)</td>
	<td width=50 align=center><font ssize=2>수량</td>
	<td width=100 align=center><font size=2>품목별합계</td></tr>
	");

if (!$total) {
     echo("<tr><td colspan=5 align=center><font   size=2><b>쇼핑백에 담긴 상품이   없습니다.</b>
        </font></td></tr></table>");
} else {

    $counter=0;
    $totalprice=0;    // 총 구매 금액  

    while ($counter < $total) :
		$pcode = mysql_result($result, $counter, "pcode");
		$quantity = mysql_result($result, $counter, "quantity");
      
		$subresult = mysql_query("select * from product where code='$pcode'", $con);
		$userfile = mysql_result($subresult, 0, "userfile");
		$pname = mysql_result($subresult, 0, "name");
		$price = mysql_result($subresult, 0, "price2");
       
		$subtotalprice = $quantity * $price;
		$totalprice = $totalprice + $subtotalprice; 
		$point = ( $subtotalprice / 100 ) ;
		
		echo("<tr><td align=center><a href=#   onclick=\"window.open('./photo/$userfile', '_new', 'width=450, height=450')\"><img src='./photo/$userfile' width=50 border=0></a></td>
			<td align=left><font size=2><a href=p-show.php?code=$pcode>$pname</a></td>
			<td align=right><font size=2>$price&nbsp;원</td>
			<td align=center><font size=2>$quantity&nbsp;개</td>
			<td align=right><font size=2>$subtotalprice&nbsp;원</td></tr>
			");

		$counter++;

    endwhile;
 
     echo("<tr><td colspan=5 align=right><font size=2>총 구매 금액: $totalprice 원</td></tr></table>");
}

mysql_close($con);	//데이터베이스 연결해제

echo ("<br>
		<table border=0 width=690>
        <tr><td align=center><font size=2>입금 계좌: <b>하나은행 595-910154-33707 (예금주: 홍길동)</b><br><br>
		* 구입하신 물품은 입금 확인후 배송되며, 주문 진행 상황은 My Page에서 확인하실 수 있습니다.<br>
		* 물품 배송 이전에 주문 취소를 원하시면 My Page에서 직접 주문 취소 요청을 하시면 됩니다.<br>
		* 물품을 배송 받으신 후에 구매 취소를 원하시면 고객센터(전화:070-8236-4423)로 연락주세요.
       </td></tr>
       </table>");

echo("
    <br><br>
	<br>
	<table  width=100% cellspacing=0 >
	<tr><td width=23% height=20 align=center bgcolor=black style='border: thin solid; border-radius:10px;'><font color=white size=5><b>배송정보 목록<b></font></td><td></td></tr>
	<tr border=1><td bgcolor=black width=100% height=5 colspan=2></td></tr>
	</table>
	<br>
	<table width=690 border=0>
	<form method=post action=endshopping.php name=buy>
	<tr><td align=right><font size=2>받는이</td>
	<td><input type=text name=receiver size=10></td>
	</tr>
	<tr>
	<td align=right><font size=2>전화번호</td>
	<td><input type=text name=phone   size=20></td>
	</tr>
	<tr><td height=30 align=right><font size=2>배송주소</td>
	<td align=left><input type=text size=6 name=zip readonly=readonly>
	<font size=2>[<a href='javascript:go_zip()'>우편번호검색</a>]<br>
	<input type=text size=55 name=addr1 readonly=readonly style='font-size:10pt; font-family:Tahoma;'>
	<input type=text size=30 name=addr2 style='font-size:10pt; font-family:Tahoma;'></td>
	<tr><td align=right><font size=2>주문요구사항</td>
	<td><textarea name=message rows=3 cols=65></textarea></td></tr>
	<tr><td align=center colspan=2>
	<input type=submit value=구매완료></td></tr>
	</table>
	<input type='hidden' name=point value=$point>
	</form>
	</center>
");

?>

</td></tr>
</table>
<? include ("bottom.html");   ?>
