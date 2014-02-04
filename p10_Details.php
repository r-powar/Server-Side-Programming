<?php
$connect = new mysqli("localhost", "cs174_68", "Qb8dsJmQ", "cs174_68");

if ($connect->connect_errno) {
   die("Unsuccesful Connection");
}

$find = "";

if (isset($_GET['id'])) {
   $find = $connect->real_escape_string($_GET['id']);
}

$query = "SELECT id, Name, Price, Summary, Paypal FROM `paypal` WHERE id = ?";

if ($result = $connect->prepare($query)) {
   $result->bind_param("s", $find);
   $result->execute();

 
   $result->bind_result($col1, $col2, $col3, $col4, $col5);

 

   $jsn_arry = "[";
   while ($result->fetch()) {
       $jsn_arry .= '{"id":' . $col1 . ", " . '"Name":' . $col2 . ", " . 
       '"Price":' . $col3 . ", " . '"Summary":' . $col4 . ", " . '"Paypal":' . $col5 . '},';
       

   }
   $jsn_arry = rtrim($jsn_arry, ",");
   echo $jsn_arry . "]";

   $result->close();

} else {
  echo "Unable to execute";
}

$connect->close();
?>