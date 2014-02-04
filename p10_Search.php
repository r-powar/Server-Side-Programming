<?php
$connect = new mysqli("localhost", "cs174_68", "Qb8dsJmQ", "cs174_68");

if ($connect->connect_errno) 
{
   die("Unsuccesful Connection");
}

$val = "";

if (isset($_GET['s'])) 
{
   $val = $connect->real_escape_string($_GET['s']);
}

$query = "SELECT id, Name, Price, Summary FROM `paypal` WHERE id = ? or Name LIKE CONCAT('%',?,'%') or Summary LIKE CONCAT('%',?,'%')";

if ($result = $connect->prepare($query)) {
   $result->bind_param("sss", $val, $val, $val);
   $result->execute();

   $result->bind_result($col1, $col2, $col3, $col4);

   $jsn_arry = "[";
   while ($result->fetch())
   {
       $jsn_arry .= '{"id":' . $col1 . ", " . '"Name":' . $col2 . ", " . '"Price":' . $col3 . '},';
   }
   $jsn_arry = rtrim($jsn_arry, ",");
   echo $jsn_arry . "]";

   $result->close();

} 
else 
{
   echo "Unable to connect";
}
$connect->close();
?>

