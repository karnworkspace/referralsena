<?php
//$conn=mysqli_connect("localhost","root","","sena_agent");
$conn=mysqli_connect("10.253.199.8:3306","sena_agent","Sena_1775","sena_agent");
mysqli_set_charset($conn,"utf8");
if(!$conn)
{
die("Connection failed: " . mysqli_connect_error());
echo "False";
}else{
	
	$icard = $_REQUEST['idcard'];
	$fname = $_REQUEST['fname'];
	$lname = $_REQUEST['lname'];
	$email = $_REQUEST['email'];
	$phone = $_REQUEST['phone'];
			
}
if($icard !=''){
//insert 
	
$sql = "select max(id) as last_id from ag_agent";
//echo "result get Max(id)--".$sql."<br>";
$qry = mysqli_query($conn,$sql);


$rs = mysqli_fetch_assoc($qry);
//$maxId = substr($rs['last_id'], -5);  
	$maxId = $rs['last_id'];
//echo "max-i = ".$maxId;
//ข้อมูลนี้จะติดรหัสตัวอักษรด้วย ตัดเอาเฉพาะตัวเลขท้ายนะครับ
//$maxId = 237;   //<--- บรรทัดนี้เป็นเลขทดสอบ ตอนใช้จริงให้ ลบ! ออกด้วยนะครับ
$maxId = ($maxId + 1);
$regisdate=date('Y-m-d');
	
$icode ="insert into ag_agent values ('$maxId','$icard','$fname','$lname','$email','$phone','$regisdate')";
//echo "insert ==".$icode."<br />";
	//exit();
$qicode = mysqli_query($conn,$icode);
header( 'refresh: 0; url=/agentsena/index.php/site/login' );
	//header('refresh:0;url=/agentsena/xxxlistagent.php');
	//exit(0);
} else {
  echo  $conn->error;
}
// Close connection

mysqli_close($conn);
?>
