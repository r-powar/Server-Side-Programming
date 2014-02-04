<html>
<head>
	<title></title>
</head>

<body>
	<?php
	error_reporting(E_ALL ^ E_NOTICE);
	$password = $_GET['pw'];
	//echo $password . "<br/>";

	$file = fopen("psswrds.txt", "r") or exit("Unable to open file!");
	$pss_in_list = "false";
	$number = "-1";
	$count = 0; 
	$strength = 0;
	if(strlen($password) >= 8)
		$strength++;
	if(preg_match("/[A-Z]/", $password))
		 $strength++;
	if(preg_match("/[a-z]/", $password))
		 $strength++;
	if(preg_match("/[0-9]/", $password))
		 $strength++;
	if(preg_match("/.[!,@,#,$,%,^,&,*,?,_,~,-,£,(,)]/", $password))
		 $strength++;

	//Output a line of the file until the end is reached
	if($file){
	while($read = fgets($file))
	{
		$count++;
		if($password == trim($read))
		{
			$pss_in_list = "true";
			//echo $pss_in_list." "; 
			//echo $count." ";	
			$jsonArray = array($pss_in_list , $count, $strength);
				echo json_encode($jsonArray);

			return;

		}
		
	}
	}	

		$jsonArray = array($pss_in_list , $number, $strength);
		echo json_encode($jsonArray);
	

	

	



	//echo $pss_in_list; 
	//echo $count;

	// if($pss_in_list=="true")
		
	// else
	// 	echo $number;
	//fclose($file);

	
	?>

</body>
</html>