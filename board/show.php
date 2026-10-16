<?php  include (__DIR__ . "/../top.php"); ?>
  <body style="background-color:#EFEFEF">
  </body>
  
<table border=1 width=900>
<tr height=600>
<td width=180 valign=top><?php  include (__DIR__ . "/../left.php"); ?></td>
<td width=720 align=center valign=top>
<br>
	<table cellspacing=0 >
	<tr><td width=19% height=20 align=center bgcolor=black style='border: thin solid; border-radius:10px;'><font color=white size=5><b>고객 게시판<b></font></td>
	<td align=right><font size=4>[<a href=../index.html style='color:black;' onMouseover='this.style.color='red''onMouseout='this.style.color='black'><b>Back</b></a>]</td></tr>
	<tr border=1><td bgcolor=black width=100% height=5 colspan=2></td></tr>
	</table>
<br>

<?php 
 echo ("<style type='text/css'>
	#t1 {border-bottom:2px dotted red; background-color:#27272B; padding:5px; color:white; }
	#t2 {border-bottom:2px dotted red; background-color:#BABABC; padding:5px;}
	#t3 {color:#F2F2F2; font-size:40px; font-weight:bold; padding:15px;}
	a {text-decoration:none; color:black;}
	a:hover { text-decoration:underline; color:red;}
	.pg {color: white;}
			</style>");
			
$con = mysql_connect(getenv('DB_HOST') ? getenv('DB_HOST') : 'db',"root","apmsetup");
mysql_select_db("shopmall",$con);
$result = mysql_query("select * from board order by id desc", $con);
$total = mysql_num_rows($result);

echo("
	<table border=0 align=center width=690><tr id=t1><td>
		<table border=0 wwidth=690 align=center>
		<tr id=t1>
		<td align=right width=50><b>번호</b></td>
		<td align=center width=100><b>글쓴이</b></td>
		<td align=center width=400><b>제목</b></td>
		<td align=center width=150><b>날짜</b></td>
		<td align=left width=50><b>조회</b></td>
		</tr></table>
	</table>
	<table border=0 width=690 align=center>
");

if (!$total){
	echo("<tr id=t2><td colspan=6 align=center>아직 등록된 글이 없습니다.</td></tr>
	");
}
else {
	if   ($cpage=='') $cpage=1;    // $cpage -  현재 페이지 번호
	$pagesize = 10;                // $pagesize - 한 페이지에 출력할 목록 개수

	$totalpage = (int)($total/$pagesize);
	if (($total%$pagesize)!=0) $totalpage = $totalpage + 1;

	$counter=0;

	while($counter<$pagesize):
		
		$newcounter=($cpage-1)*$pagesize+$counter;
		if ($newcounter == $total) break;

		$id=mysql_result($result,$newcounter,"id");
		$writer=mysql_result($result,$newcounter,"writer");
		$topic=mysql_result($result,$newcounter,"topic");
		$hit=mysql_result($result,$newcounter,"hit");
		$wdate=mysql_result($result,$newcounter,"wdate");
		$date=substr($wdate,0,10);
		$space=mysql_result($result,$newcounter,"space");
		$file=mysql_result($result,$newcounter,"filename");

		// XSS 방어 처리
		$writer = h($writer);
		$topic = h($topic);

		$result1 = mysql_query("select * from boardmemo where id=$id", $con);
		$total1=mysql_num_rows($result1);
		$new=$total-5; //새로 적은 글 표시 하기 위함.
		$t="";

		if   ($space>0) {
			for ($i=0 ; $i<=$space ; $i++)
				$t = $t . "&nbsp;";     // 답변 글의 경우 제목 앞 부분에 공백을 채움
		}
		
		echo("
			<tr bgcolor='#BABABC'>
			<td align=center width=50>$id</td>
			<td align=center width=100>$writer</td>");
		if($hit==0){
			if(!$file){ //첨부파일이 없을 경우 
				if($total1!=0){
					echo("
						<td align=left width=400>$t<a href=content.php?board=$board&id=$id>$topic [$total1]</a><img src=newmark.png width=20 height=20></td>
					");
				}
				else {
					echo("
						<td align=left width=400>$t<a href=content.php?board=$board&id=$id>$topic</a><img src=newmark.png width=20 height=20></td>
					");
				}
			}
			else{ //첨부파일이 있을경우 표시 남김.
				if($total1!=0){
					echo("
						<td align=left width=400>$t<a href=content.php?board=$board&id=$id>$topic [$total1] </a><img src=filel.png width=15 height=15><img src=newmark.png width=20 height=20></td>
					");
				}
				else {
					echo("
						<td align=left width=400>$t<a href=content.php?board=$board&id=$id>$topic </a><img src=filel.png width=15 height=15><img src=newmark.png width=20 height=20></td>
					");
				}			
			}
		}
		else{
			if(!$file){ //첨부파일이 없을 경우 
				if($total1!=0){
					echo("
						<td align=left width=400>$t<a href=content.php?board=$board&id=$id>$topic [$total1]</a></td>
					");
				}
				else {
					echo("
						<td align=left width=400>$t<a href=content.php?board=$board&id=$id>$topic</a></td>
					");
				}
			}
			else{ //첨부파일이 있을경우 표시 남김.
				if($total1!=0){
					echo("
						<td align=left width=400>$t<a href=content.php?board=$board&id=$id>$topic [$total1]   </a><img src=filel.png width=15 height=15></td>
					");
				}
				else {
					echo("
						<td align=left width=400>$t<a href=content.php?board=$board&id=$id>$topic    </a><img src=filel.png width=15 height=15></td>
				");
				}			
			}
		}
		echo("
			<td align=center width=150>$date</td>
			<td align=center width=50>$hit</td>
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
		echo ("[<a class=pg href=show.php?board=$board&cblock=$pblock&cpage=$pstartpage color=white><STRONG>＜</STRONG></a>] ");

	// 현재 블록에 속한 페이지 번호를 출력	
	$i =   $startpage;
	while($i < $nstartpage):
	   if ($i > $totalpage) break;  // 마지막 페이지를 출력했으면 종료함
	   echo ("[<a class=pg href=show.php?board=$board&cblock=$cblock&cpage=$i>$i</a>]");
	   $i = $i + 1;
	endwhile;
	 
	// 다음 블록의 시작 페이지가 전체 페이지 수보다 작으면 [다음블록] 버튼 활성화  
	if ($nstartpage <= $totalpage)   
		echo ("[<a class=pg href=show.php?board=$board&cblock=$nblock&cpage=$nstartpage><STRONG>＞</STRONG></a>] ");

	echo ("</td></tr></table>");

}

echo ("<table width=690 align=center>
<tr><td width=500 align=right>
<form method=post action=search.php?board=$board >
<select name=field>
		<option value=writer>글쓴이</option>
	<option value=topic>제목</option>
	<option value=content>내용</option>
</select>
<input type=text name=key size=20 height=70></td>
<td>
<input style='background-color:orange; border-radius:10px; font-weight:bold; cursor:pointer;' type=submit value='▶'>
</td>
</form>
<td align=right><a href=input.php?board=$board><input style='background-color:orange; border-radius:10px; font-weight:bold; cursor:pointer;' type=button value='글쓰기'></a>
</td></tr></table>");
		
mysql_close($con);

?>
</td></tr>
</table>
<?php  include (__DIR__ . "/../bottom.php");   ?>
