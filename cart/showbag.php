<?php  include (__DIR__ . "/../top.php"); ?>
  <body style="background-color:#EFEFEF">
  </body>
  
<table border=1 width=900>
<tr height=600>
<td width=180 valign=top><?php  include (__DIR__ . "/../left.php"); ?></td>
<td width=720 align=center valign=top>

<?php 
if (!isset($UserID)) {
	echo ("<script>
		window.alert('로그인 사용자만 이용하실 수 있어요')
		history.go(-1)
		</script>");
	exit;
}
?>
<br>
<table  width=100% cellspacing=0 >
<tr><td width=18% height=20 align=center bgcolor=black style="border: thin solid; border-radius:10px;"><font color=white size=5><b>쇼핑카트<b></font></td>
	<td align=right><font size=4>[<a href=../index.html style="color:black;" onMouseover="this.style.color='red'"onMouseout="this.style.color='black'"><b>Back</b></a>]</td></tr>
<tr border=1><td bgcolor=black width=100% height=5 colspan=2></td></tr>
<tr><td align=right colspan=2><font size=2><b><?php  echo $UserName; ?></b>님의 현재 쇼핑 카트 내용</td></tr>
</table>


<?php 
$con =   mysql_connect(getenv('DB_HOST') ? getenv('DB_HOST') : 'db',"root","apmsetup");
mysql_select_db("shopmall",$con);

// 전체 쇼핑백 테이블에서 특정 사용자의 구매 정보만을 읽어낸다
$result = mysql_query("select * from shoppingbag where session='$Session'", $con);
$total = mysql_num_rows($result);

echo ("
	<table border=0 cellspacing=0 width=690 style='border: 1px solid black; '>
	<tr><td><br></td></tr>
    <tr><td width=100 align=center style='border: 1px solid #444444; border-radius:10px;'><font size=2>상품사진</td>
	<td width=300 align=center style='border: 1px solid #444444; border-radius:10px;'><font size=2>상품이름</td>
	<td width=90 align=center style='border: 1px solid #444444; border-radius:10px;'><font size=2>가격(단가)</td>
	<td width=120 align=center style='border: 1px solid #444444; border-radius:10px;'><font size=2>수량</td>
	<td width=100 align=center style='border: 1px solid #444444; border-radius:10px;'><font size=2>품목별합계</td>
	<td width=50 align=center style='border: 1px solid #444444; border-radius:10px;'><font size=2>삭제</td></tr>
	<tr><td><br></td></tr>
");

if (!$total) {
     echo("<tr><td colspan=6 align=center><font size=2>쇼핑백에 담긴 상품이 없습니다.</td></tr></table>");
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

		echo ("<tr><td align=center>
			<a href=# onclick=\"window.open('../photo/$userfile', '_new', 'width=450,   height=450')\"><img src='../photo/$userfile' width=50   border=0></a></td>
			<td align=left><font size=2><a   href=../product/p-show.php?code=$pcode>$pname </a></td>
			<td align=right><font size=2>$price&nbsp;원</td>
			<td align=center>
			<form method=post action=q-modift.php?pcode=$pcode><input type=text name=newnum size=3 value=$quantity>&nbsp;<input type=submit value=변경>
			</td></form>
			<td align=right><font size=2>$subtotalprice&nbsp;원</td>
			<td align=center>
			<form method=post action=itemdelete.php?pcode=$pcode><input type=submit value=삭제></td></form>
			</tr>
			<tr><td colspan=6><font size=5> - - - - - - - - - - - - - - - -  - - - - - - - - - - - - - - - - - - - - -</font></td></tr>");

		$counter++;
    endwhile;
 	
     echo("<tr><td colspan=6 align=right><font size=2>총 구매 금액: $totalprice 원</td></tr></table>");

}

mysql_close($con);	//데이터베이스 연결해제

echo ("<table width=690 border=0>
		<tr><td align=right>
		<button style='background-color:orange; border-radius:10px; height:40;'><font size=4px ><a href=buy.php style='color:black;'><b>구매결정</b></a></font></button>
		<button style='background-color:orange; border-radius:10px; height:40;'><font size=4px><a href=../product/p-list.php style='color:black;'><b>쇼핑계속</b></a></font></button>
		</tr></td>
	</table>");

?>

</td></tr>
</table>
<?php  include (__DIR__ . "/../bottom.php");   ?>
