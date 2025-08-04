<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>เพิ่มข้อมูลเลขบัตรประชาชน</title>
</head>

<body>
<div style="padding:30px;"><center><form action="addcode.php" method="get" name="insert">
กรอกเลขบัตรประชาชน <input name="idcard" type="text" size="13" maxlength="13" />
<input name="submit" type="submit" value="submit" />
</form>
<br /><br /><br />

<?php
//$conn=mysqli_connect("localhost","root","","sena_agent");
//$conn=mysqli_connect("203.146.107.98:3306","sena_agent","Sena_1775","sena_agent");
$conn=mysqli_connect("10.253.199.8:3306","sena_agent","Sena_1775","sena_agent");
if(!$conn)
{
die("Connection failed: " . mysqli_connect_error());
echo "False";
}else{
	
	$qv = "select * from ag_code order by id desc";
	$query = mysqli_query($conn,$qv);
	
	$rows = array();
while($row = mysqli_fetch_array($query))
    $rows[] = $row;
foreach($rows as $row){ 
    $idcard = stripslashes($row['idcard']);
    $code = stripcslashes($row['agentcode']);
    echo "idcard = [".$idcard."]"."  code = [".$code."] <br />";     
} //end loop foreach
	
	
}// end if
?>
</center>
</div>

</body>
</html>