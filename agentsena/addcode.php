<?php
//$conn=mysqli_connect("localhost","root","","sena_agent");
$conn=mysqli_connect("203.146.107.98:3306","sena_agent","Sena_1775","sena_agent");
if(!$conn)
{
die("Connection failed: " . mysqli_connect_error());
echo "False";
}else{
	
	$icard = $_REQUEST['idcard'];
	echo "id=".$icard;
	
$code = "SNA";
//$yearMonth = substr(date("Y")+543, -2).date("m"); เปลี่ยน ค.ศ. เป็น พ.ศ. +543
//$yearMonth = substr(date("Y"), -2).date("m");
$year = substr(date("Y"), -2);

//query MAX ID 
//$sql = "SELECT MAX(id) AS last_id FROM ag_code";
$sql = "select max(acode) as last_id from ag_code";
//echo "result".$sql;
$qry = mysqli_query($conn,$sql);


$rs = mysqli_fetch_assoc($qry);
$maxId = substr($rs['last_id'], -5);  
echo "max-i = ".$maxId;
//ข้อมูลนี้จะติดรหัสตัวอักษรด้วย ตัดเอาเฉพาะตัวเลขท้ายนะครับ
//$maxId = 237;   //<--- บรรทัดนี้เป็นเลขทดสอบ ตอนใช้จริงให้ ลบ! ออกด้วยนะครับ
$maxId = ($maxId + 1);
$maxNo = substr("00".$maxId, -5);
$nextId = $code."-".$year."-".$maxNo;

}
if($icard !=''){
//insert 

$icode ="insert into ag_code values ('','$icard','$maxId','$nextId')";
//echo "insert ==".$icode."<br />";
$qicode = mysqli_query($conn,$icode);
 header( 'refresh: 0; url=/agentsena/numcode.php' );
	exit(0);
} else {
  echo  $conn->error;
}
// Close connection
mysqli_close($conn);
?>
