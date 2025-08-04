<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	
<meta name=“viewport” content=“width=device-width, initial-scale=1.0” />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
 
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>แสดงข้อมูล Agent</title>
	
	
</head>

<body>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<!--
<div style="padding:30px;"><center><form action="addagent.php" method="get" name="insert">
กรอกเลขบัตรประชาชน <input name="idcard" type="text" size="13" maxlength="13" />
	ชื่อ<input name="fname" type="text" size="13"  />
	นามสกุล<input name="lname" type="text" size="13"  />
	โทร <input name="phone" type="text" size="13"  />
	อีเมล <input name="email" type="text" size="13"  />

<input name="submit" type="submit" value="submit" />
</form>
<br /><br /><br />
 -->

	<div class="container">
		<div class="row">
			<div class="col-md-2">
			</div>
			<div class="col-md-8">
		<b>List Agent<br><br> </b>
<?php
//$conn=mysqli_connect("localhost","root","","sena_agent");
//$conn=mysqli_connect("203.146.107.98:3306","sena_agent","Sena_1775","sena_agent");
$conn=mysqli_connect("10.253.199.8:3306","sena_agent","Sena_1775","sena_agent");
mysqli_set_charset($conn,"utf8");

if(!$conn)
{
die("Connection failed: " . mysqli_connect_error());
echo "False";
}else{
	
	$qv = "select * from ag_project order by id desc";
	$query = mysqli_query($conn,$qv);
	
	$rows = array();
while($row = mysqli_fetch_array($query))
    $rows[] = $row;
foreach($rows as $row){ 
    	$project_name = $row['project_name'];
        $project_type = $row['project_type'];
        $project_sale = $row['project_sale'];
        $project_bud = $row['project_bud'];


	
    //$code = stripcslashes($row['agentcode']);
    echo "proj_namme = [".$project_name."]"."----".$project_type."--".$project_sale."-----".$project_bud."</span>]<br />";     

} //end loop foreach
	
	
}// end if

mysqli_close($conn);
?>

</div>

			<div class="col-md-2">
			</div>
		</div>

</body>
</html>