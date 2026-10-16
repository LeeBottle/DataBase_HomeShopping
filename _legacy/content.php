<? include ("top.html"); ?>
  <body style="background-color:#EFEFEF">
  </body>
  
<table border=1 width=900>
<tr height=600>
<td width=180 valign=top><? include ("left.html"); ?></td>
<td width=720 align=center valign=top>
<br>
	<table  width=100% cellspacing=0 >
	<tr><td width=18% height=20 align=center bgcolor=black style='border: thin solid; border-radius:10px;'><font color=white size=5><b>게시판</b></font></td>
	<td align=right><font size=4>[<a href=show.php style='color:black;' onMouseover='this.style.color='red''onMouseout='this.style.color='black'><b>Back</b></a>]</td></tr>
	<tr border=1><td bgcolor=black width=100% height=5 colspan=2></td></tr>
	</table>
<br>

<BODY BGCOLOR="#424242">

<?
 echo ("<style type='text/css'>
	#t1 {border-bottom:2px dotted red; background-color:#27272B; padding:5px; color:white; }
	#t2 {border-bottom:2px dotted red; background-color:#BABABC; padding:5px;}
	#t3 {border-bottom:2px dotted red; background-color:gray; padding-top:5px; padding-bottom:5px;}
	#t4 {color:#F2F2F2; font-size:40px; font-weight:bold; padding:15px;}
	a {text-decoration:none; color:black;}
	a:hover { text-decoration:underline; color:red;}
	.pg {color: white;}
			</style>");
			
$con=mysql_connect("localhost","root","apmsetup");
mysql_select_db("shopmall",$con);
$result=mysql_query("select * from board where id=$id",$con);

// 각 필드에 해당하는 데이터를 뽑아 내는 과정
$id=mysql_result($result,0,"id");
$writer=mysql_result($result,0,"writer");
$topic=mysql_result($result,0,"topic");
$hit=mysql_result($result,0,"hit");
$filename=mysql_result($result,0,"filename");
$filesize=mysql_result($result,0,"filesize");

$hit = $hit +1;   //조회수를 하나 증가
mysql_query("update board set hit=$hit where id=$id",$con);

$wdate=mysql_result($result,0,"wdate");
$email=mysql_result($result,0,"email");
$content=mysql_result($result,0,"content");

if ($filesize > 1000) {
	$kb_filesize =   (int)($filesize / 1000);
	$disp_size = $kb_filesize . ' KBytes';
} else {
	$disp_size = $filesize . ' Bytes';
}

// 테이블로부터 읽은 내용을 화면에 디스플레이
echo("
	<table border=0 width=690 align=center>
		<tr>
			<td align=right><a href=show.php?board=$board><img src=home.png width=25 height=25></a></td>
		</tr>
	</table>
	<table border=0 align=center width=85%><tr id=t1><td>
		<table border=0 width=690 align=center>
		<tr id=t1>
		<td width=100>번호: $id</td>
		<td width=200>글쓴이: <a href=mailto:$email>$writer</a></td>
		<td width=300>작성일자: $wdate</td>
		<td width=100>조회: $hit</td>
		</tr></table>
	</table>
	<table border=0 align=center width=85%><tr><td>
		<table border=0 width=690 align=center>
		<tr>");
if(!$filesize){
	echo("<td colspan=4 bgcolor=#f5f5f5>파일:</td>");
}else{
	echo("
	<td colspan=4 bgcolor=#e8e8e8>파일: <a href=./pds/$filename>$filename</a> [ $disp_size ]</td>
	</tr>
	");
}

echo("
	<tr>
	<td colspan=4 bgcolor=#f5f5f5>제목: $topic</td>
	</tr>
	<tr>
	<td colspan=4 bgcolor=#fcfcfc><pre>$content</pre></td>
	</tr>
	</table>

	<table   border=0 width=690 align=center>
	<tr ><td align=right>
	<a href=pass.php?board=$board&id=$id&mode=0 title=\"수정\"><img src=edit.png width=30 height=30></a>
	<a href=pass.php?board=$board&id=$id&mode=1 title=\"삭제\"><img src=eraser.png width=30 height=30></a>
	<a href=reply.php?board=$board&id=$id title=\"답변\"><img src=replyl.png width=30 height=30></a>
	</td></tr>
	</table><br>
");

			
$con =   mysql_connect("localhost", "root", "apmsetup");
mysql_select_db("shopmall",   $con);
$result =   mysql_query("select * from boardmemo where id=$id order by wdate desc", $con);
$total =   mysql_num_rows($result);

echo("<table align=center>");
if (!$total)   {
	echo ("<table border=0 align=center width=80%><tr id=t1><td>
				<table align=center border=0 width=690>
				<tr id=t1 align=center><td width=50>번호</td><td width=100>이름</td>
				<td width=150>작성일자</td><td width=400>댓글내용</td></tr></td>
				</table>
			</table>
			<table align=center><tr><td><font color=white>등록된 댓글이 없습니다</font></td></tr></table>");
		
} 
else{
	echo ("
			<table align=center border=0 width=690 align=center>
				<tr id=t1 align=center>
				<td width=50>번호</td>
				<td width=80>이름</td>
				<td width=150>작성일자</td>
				<td width=300>댓글내용</td>
				<td width=80></td></tr>
	");

	$pagesize =   5;	// 한 페이지에 보여 줄 메모 글의 개수
	if ($mcpage ==  '') $mcpage = 1; 
	$endpage = (int)($total / $pagesize);
	if ( ($total % $pagesize) != 0 ) $endpage = $endpage + 1;
	$i = 0;	
	while ( $i   < $pagesize ) :
		$counter = $pagesize * ($mcpage - 1) + $i;
		if ($counter == $total) break;
		$num=$i+1;
		$name = mysql_result($result, $counter, "name");
		$wdate = mysql_result($result, $counter, "wdate");
		$date=substr($wdate,0,16);
		$message = mysql_result($result,   $counter, "message");
		
		echo ("
			<tr bgcolor=white><td align=center>$num</td><td align=center>$name</td>
			<td align=center>$date</td><td>$message</td>
			<td align=center><a href=cpass.php?board=$board&id=$id&mode=0&wdate=$wdate&wname=$name&wmemo=$message>수정</a>|<a href=cpass.php?board=$board&id=$id&mode=1&wdate=$wdate>삭제</a></td></tr>
		");
		$i++;
	endwhile;
	echo ("</table>");
	}
echo ("<table border=0 width=690 align=center><tr><td align=center>");	
$ppage =   $mcpage - 1;
$npage =   $mcpage + 1;
if ($mcpage > 1) echo ("[<a href=content.php?mcpage=$ppage&board=$board&id=$id>이전페이지</a>]");
if ($mcpage < $endpage) echo ("[<a href=content.php?mcpage=$npage&board=$board&id=$id>다음페이지</a>]");
echo("<br><br>");
mysql_close($con);

$con = mysql_connect("localhost","root","apmsetup");
mysql_select_db("shopmall",$con);
$result = mysql_query("select * from board order by id desc", $con);
$total = mysql_num_rows($result);

echo("<form method=post align=center action=memo.php?board=$board&id=$id>
			<table border=0><font color=white>이름
			<input type=text size=10 name=wname align=center>
			댓글
			<input type=text size=30 name=wmemo>
			암호
			<input type=password name=wpasswd size=15>&nbsp;&nbsp;
			<input type=submit value=등록>
			</font></table></form>");
echo("
	<table border=0 width=690 align=center>
	<tr id=t1 align=center ><td align=center width=50><b>번호</b></td>
	<td align=center width=100><b>글쓴이</b></td>
	<td align=center width=400><b>제목</b></td>
	<td align=center width=150><b>날짜</b></td>
	<td align=center width=50><b>조회</b></td>
	</tr>
");

if (!$total){
	echo("
		<tr><td colspan=5 align=center>아직 등록된 글이 없습니다.</td></tr>
	");
} else {

	if   ($cpage=='') $cpage=1;    // $cpage -  현재 페이지 번호
	$pagesize = 5;                // $pagesize - 한 페이지에 출력할 목록 개수

	$totalpage = (int)($total/$pagesize);
	if (($total%$pagesize)!=0) $totalpage = $totalpage + 1;

	$counter=0;

	while($counter<$pagesize):
		$newcounter=($cpage-1)*$pagesize+$counter;
		if ($newcounter == $total) break;

		$idd=mysql_result($result,$newcounter,"id");
		$writer=mysql_result($result,$newcounter,"writer");
		$topic=mysql_result($result,$newcounter,"topic");
		$hit=mysql_result($result,$newcounter,"hit");
		$wdate=mysql_result($result,$newcounter,"wdate");
		$date=substr($wdate,0,10);
		$space=mysql_result($result,$newcounter,"space");
		$file=mysql_result($result,$newcounter,"filename");
		$result1 = mysql_query("select * from boardmemo where id=$idd", $con);
		$total1 = mysql_num_rows($result1);

		$t="";

		if   ($space>0) {
			for ($i=0 ; $i<=$space ; $i++)
				$t = $t . "&nbsp;";     // 답변 글의 경우 제목 앞 부분에 공백을 채움
		}
		
		echo("
			<tr bgcolor='#BABABC'>");
		if($id==$idd){ //현재 보고있는 글 표시
			echo("<td align=center>➡</td>");
		}else{
			echo("
				<td align=center>$idd</td>");
		}
		echo("
			<td align=center>$writer</td>");
		if(!$file){
			if($total1!=0){
				echo("
					<td align=left>$t<a href=content.php?board=$board&id=$idd>$topic [$total1]</a></td>
				");
			}
			else {
				echo("
					<td align=left>$t<a href=content.php?board=$board&id=$idd>$topic</a></td>
				");
			}
		}else{
			if($total1!=0){
				echo("
					<td align=left>$t<a href=content.php?board=$board&id=$idd>$topic [$total1]     </a><img src=filel.png width=20 height=16></td>
				");
			}
			else {
				echo("
					<td align=left>$t<a href=content.php?board=$board&id=$idd>$topic     </a><img src=filel.png width=20 height=16></td>
				");
			}
		}
		echo("
			<td align=center>$date</td><td align=center>$hit</td>
			</tr>
		");
		$counter = $counter + 1;
	endwhile;
	echo("</table>");
	echo ("<table border=0 width=690 align=center>
		  <tr><td align=center>");		   
	// 화면 하단에 페이지 번호 출력
	if ($cblock=='') $cblock=1;   // $cblock - 현재 페이지 블록값
	$blocksize = 5;             // $blocksize - 화면상에 출력할 페이지 번호 개수
	$pblock = $cblock - 1;      // 이전 블록은 현재 블록 - 1
	$nblock = $cblock + 1;     // 다음 블록은 현재 블록 + 1		
	// 현재 블록의 첫 페이지 번호
	$startpage = ($cblock - 1) * $blocksize + 1;	
	$pstartpage = $startpage - 1;  // 이전 블록의 마지막 페이지 번호
	$nstartpage = $startpage + $blocksize;  // 다음 블록의 첫 페이지 번호
	if ($pblock > 0)        // 이전 블록이 존재하면 [이전블록] 버튼을 활성화
		echo ("[<a  class=pg href=content.php?board=$board&id=$id&cblock=$pblock&cpage=$pstartpage><STRONG>＜</STRONG></a>] ");
	// 현재 블록에 속한 페이지 번호를 출력	
	$i =   $startpage;
	while($i < $nstartpage):
	   if ($i > $totalpage) break;  // 마지막 페이지를 출력했으면 종료함
	   echo ("[<a  class=pg href=content.php?board=$board&id=$id&cblock=$cblock&cpage=$i>$i</a>]");
	   $i = $i + 1;
	endwhile;	 
	// 다음 블록의 시작 페이지가 전체 페이지 수보다 작으면 [다음블록] 버튼 활성화  
	if ($nstartpage <= $totalpage)   
		echo ("[<a  class=pg href=content.php?board=$board&id=$id&cblock=$nblock&cpage=$nstartpage><STRONG>＞</STRONG></a>] ");
	echo ("</td></tr></table>");
}
	
mysql_close($con);


?>
</table>
</table>
</td></tr>
</table>
<? include ("bottom.html");   ?>
