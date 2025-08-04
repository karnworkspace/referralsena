<?php
$conn=mysqli_connect("203.146.107.98:3306","sena_agent","Sena_1775","sena_agent");
if(!$conn)
{
die("Connection failed: " . mysqli_connect_error());
echo "False";
}else{
// echo $conn;
if($_POST["body"]){
$DataArr = array();
foreach($_POST["body"] as $row){
    // foreach($records as $row){
        $Val1 = mysql_real_escape_string($_POST["body"][$row][0]);
        $Val2 = mysql_real_escape_string($_POST["body"][$row][1]);
        $Val3 = mysql_real_escape_string($_POST["body"][$row][2]);
        $Val4 = mysql_real_escape_string($_POST["body"][$row][3]);
        $Val5 = mysql_real_escape_string($_POST["body"][$row][4]);
        $Val6 = mysql_real_escape_string($_POST["body"][$row][5]);
        $Val7 = mysql_real_escape_string($_POST["body"][$row][6]);

        $DataArr[] = "('$Val1', '$Val2', '$Val3','$Val4','$Val5','$Val6',,'$Val7')";
    }
    $sql = "INSERT INTO ag_agent (id,idcard,fname,lname,email,phone,regis_date) values ".implode(',', $DataArr).";";
    // $sql = "INSERT INTO ag_agent (id,idcard,fname,lname,email,phone,regis_date) values ('999','xx','xx','xx','xx','xx','2020-05-08')";
    // mysqli_query($conn, $sql);
if(mysqli_query($conn, $sql)){
    echo "Records added successfully.";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
}
    // $sql = "INSERT INTO ag_agent (id,idcard,firstname,lastname,email,phone,regis_date) values ".implode(',', $DataArr).";";
    // mysqli_query($conn, $sql);
// echo $sql;
}else{
  echo "Jaaaaaaaaaaaaaaaaa";
}
}


?>
