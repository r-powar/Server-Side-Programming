<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Form</title>

	<?php
		if($_POST){
			$product = $_POST['product']; 
			
		}
	?>
</head>

<body>
	<form action="p6-1.php" method="POST">
	
			<legend>Form</legend>
			<p><label for="product">product:</label> <input type="text" name="product" id="product"/></p>
			<input type = "submit" value="Submit"><br/>
	
	</form>

	
	<?php
	$mysqli = new mysqli("localhost", "cs174_68", "Qb8dsJmQ", "cs174_68");
	

	if ($mysqli->connect_errno) {
	    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	
	if (!$mysqli->query("DROP PROCEDURE IF EXISTS p") ||
	    !$mysqli->query("CREATE PROCEDURE p(IN string_value TEXT) BEGIN SELECT * FROM Product WHERE Name LIKE CONCAT('%',string_value,'%'); END;")) {
	    echo "Stored procedure creation failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
	
	if (!($res = $mysqli->query("CALL p('$product')"))) {
	    echo "CALL failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
	
	while($row = mysqli_fetch_array($res)){
		echo $row['Name'] . " " . $row['Description']. " " . $row['Price']. " " . $row['CountryofOrigin']. " " . $row['Description'];
		echo "<br>";
	}
	
	?>

		
	

</body>

</html>