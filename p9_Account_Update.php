<?php
error_reporting(0);
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: deny');
session_start();

function removedata($input)
{
   $input = trim($input);
   $input = stripslashes($input);
   $input = htmlspecialchars($input);
   return $input;
}

?>
<html>
<head>
   <title>User Login</title>
</head>

<style>
   .error_display {
       display: none;
       color: red;
   }

   textarea#textbox {
       width: 500px;
       height: 100px;
       border: 3px solid black;
       padding: 5px;
       font-family: Arial, sans-serif;
       background-position: bottom right;
       background-repeat: no-repeat;
   }

   .popup {
       display: none;
   }

   .astrix {
       display: none;
       color: red;
       float: left;
   }
</style>
<body>
<table border="0" cellpadding="10" cellspacing="1" width="500" align="center">
   <tr>
       <td align="center">Account Update</td>
   </tr>
   <tr>
       <td>
           <?php

           if ($_SESSION["user_name"]) {
           ?>
           Welcome <?php echo $_SESSION["user_name"]; ?> 
               <?php

               $mysqli = new mysqli("localhost", "root", "root", "cs174_68");
               //$mysqli = new mysqli("localhost", "cs174_05", "aRvmaWP0", "cs174_05");

               // Check connection
               if ($mysqli->connect_errno) {
                   // terminate the current script with an error message
                   exit("Failed to connect to MySQL: " . mysqli_connect_error());
               }

               $uname = $_SESSION["user_name"];
               $upass = $_SESSION["password"];


               $stmt = $mysqli->stmt_init();
               $initial_search = $mysqli->prepare("SELECT firstname, lastname, username, password, email, phone, biography FROM sign_up WHERE username = ? and password = ? ");
               $initial_search->bind_param('ss', $uname, $upass);

               if ($initial_search->execute()) {
                   $initial_search->bind_result($col1, $col2, $col3, $col4, $col5, $col6, $col7);
                   $initial_search->fetch();

               }
               }
               ?>
       </td>
   </tr>
   <tr>
       <td>

           <form action="p9_Account_Update.php" method="POST" onSubmit="return ValidateForm();">
               <div class="error_display" id="ErrorMessage"></div>
               <p>

               <div class="astrix" id="first_n">*</div>
               <label for="first_name">First Name:</label>
               <input type="first_name" name="first_name" value="<?php echo $col1; ?>" id="first_name">
               </p>

               <p>

               <div class="astrix" id="last_n">*</div>
               <label for="last_name">Last Name:</label>
               <input type="last_name" name="last_name" value="<?php echo $col2; ?>" id="last_name">
               </p>


               <div class="astrix" id="pwd">*</div>
               <p>
                   <label for="password">Password:</label>
                   <input type="password" name="password" value="<?php echo $col4; ?>" id="password">
               </p>

               <div class="astrix" id="email">*</div>
               <label for="email">Email:</label>
               <input type="text" name="email" value="<?php echo $col5; ?>" id="email">
               </p>


               <p>

               <div class="astrix" id="phn">*</div>
               <label for="phone_number">Phone Number:</label>
               <input type="phone_number" name="phone_number" value="<?php echo $col6; ?>" id="phone_number">
               </p>


               <p>
                   <label for="biography">Biography:</label></p>
               <textarea placeholder="biography" name="biography" value="" id="textbox"><?php echo $col7; ?></textarea>


               <input type="submit" name="submit" value="Submit">

           </form>
   </tr>

   </td>

</table>


</body>


<script>
   function ValidateForm() {
       ErrorMessage = "";


       if (validate_first_name() == null) {

           ErrorMessage += "Please enter your first name.<br/>";
           document.getElementById("first_name").focus();
           document.getElementById("first_n").style.display = "block";
       }
       else {
           document.getElementById("first_n").style.display = "none";
       }

       if (validate_last_name() == null) {
           ErrorMessage += "Please enter your last name.<br/>";
           document.getElementById("last_name").focus();
           document.getElementById("last_n").style.display = "block";
       }
       else {
           document.getElementById("last_n").style.display = "none";
       }

       if (validate_password() == null) {
           ErrorMessage += "Invalid password.<br/>";
           document.getElementById("password").focus();
           document.getElementById("pwd").style.display = "block";

       }
       else {
           document.getElementById("pwd").style.display = "none";
       }

       if (validate_email() == null) {
           ErrorMessage += "Invalid email.<br/>";
           document.getElementById("email").focus();
           document.getElementById("email").style.display = "block";
       }
       else {
           document.getElementById("email").style.display = "none";
       }


       if (validate_phone_number() == null) {
           ErrorMessage += "Invalid phone number.<br/>";
           document.getElementById("phone_number").focus();
           document.getElementById("phn").style.display = "block";

       }
       else {
           document.getElementById("phn").style.display = "none";
       }


       if (ErrorMessage.length > 0) {
           document.getElementById("ErrorMessage").innerHTML = ErrorMessage;
           document.getElementById("ErrorMessage").style.display = "block";
           return false;
       }

       return true;
   }

   //validates first name by checking it's not empty
   function validate_first_name() {
       var new_first_name = document.getElementById("first_name").value;
       if (new_first_name.length == 0) {
           return null;
       }
       else {
           return true;
       }

   }

   //validates last name by checking it's not empty
   function validate_last_name() {
       var new_last_name = document.getElementById("last_name").value;
       if (new_last_name.length == 0) {
           return null;
       }
       else {
           return true;
       }

   }

   //validates password using regular expressions
   function validate_password() {
       var new_password = document.getElementById("password").value;
       var regular_expression = /^.*(?=.{8,})(?=.*[a-zA-Z])(?=.*\d).*$/;

       return regular_expression.exec(new_password);

   }

   //validates phone number using regular expressions
   function validate_phone_number() {
       var new_phone_number = document.getElementById("phone_number").value;
       if (new_phone_number.length == 0) {
           return true;
       }
       //var regular_expression = /^(\()?\d{3}(\))?(-|\s)?\d{3}(-|\s)\d{4}$/;
       var regular_expression = /\d\d\d\-\d\d\d\-\d\d\d\d$/;
       var x = regular_expression.exec(new_phone_number);
       return x;
   }


   function validate_email() {
       var new_email = document.getElementById("email").value;
       var regular_expression = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/;

       return regular_expression.exec(new_email);
   }


</script>

<?php

//$mysqli = new mysqli("localhost", "root", "root", "cs174_68");
$mysqli = new mysqli("localhost", "cs174_68", "Qb8dsJmQ", "cs174_68");

// Check connection
if ($mysqli->connect_errno) {
   // terminate the current script with an error message
   exit("Failed to connect to MySQL: " . mysqli_connect_error());
}

$fnameErr = $lnameErr = $unameErr = $phoneErr = $emailErr = $passwordErr = $availibilityErr = "";
$Errors = [];
$fname = $lname = $uname = $phone = $email = $password = $biography = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $isValid = false;


   //check to see if first name empty
   if (isset($_POST['first_name'])) {
       $fname = removedata(htmlentities($_POST['first_name']));
   } else {
       $fnameErr = "Please enter your first name.";
       array_push($Errors, $fnameErr);
   }

   //check to see if last name empty
   if (isset($_POST['last_name'])) {
       $lname = removedata(htmlentities($_POST['last_name']));
   } else {
       $lnameErr = "Please enter your last name.";
       array_push($Errors, $lnameErr);
   }

   $uname = $_SESSION["user_name"];

   if (isset($_POST['password'])) {
       if (!preg_match('/^.*(?=.{8,})(?=.*[a-zA-Z])(?=.*\d).*$/', removedata(htmlentities($_POST["password"])))) {
           $passwordErr = "*Invalid password. Must be 8 characters long and contain at least one digit. ";
           array_push($Errors, $passwordErr);
       }
       $password = md5(removedata(htmlentities($_POST['password'])));
   } else {
       $passwordErr = "Please enter a password.";
       array_push($Errors, $passwordErr);
   }


   if (isset($_POST['email'])) {
       if (!preg_match('/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/', removedata(htmlentities($_POST["email"])))) {
           $emailErr = "*Invalid email address";
           array_push($Errors, $emailErr);
       }
       $email = removedata(htmlentities($_POST['email']));
   } else {
       $emailErr = "Please enter an email address.";
       array_push($Errors, $emailErr);
   }


   if (!empty($_POST['phone_number'])) {
       if (!preg_match('/\d\d\d\-\d\d\d\-\d\d\d\d$/', removedata(htmlentities($_POST["phone_number"])))) {
           $phoneErr = "*Invalid phone number. ddd-ddd-dddd";
           array_push($Errors, $phoneErr);
       }
       $phone = removedata(htmlentities($_POST['phone_number']));

   } else {
       $phone = "";
   }

   //set biography to biography
   $biography = removedata(htmlentities($_POST['biography']));




   //if there are errors, print them out
   if (sizeof($Errors) > 0) {
//        print_r($Errors);
   }
   else if (sizeof($Errors) == 0) {

       /* Create a prepared statement */
       $sql = "UPDATE sign_up SET firstname=?, lastname=?, password=?, email=?, phone=?, biography=? WHERE username=?";
       $stmt = $mysqli->prepare($sql);
       $stmt->bind_param('sssssss', $fname, $lname, $password , $email, $phone, $biography, $uname);

       /* Execute it */
       if ($stmt->execute()) {
           ?>
               <script>location.reload();</script>
           <?php
           $_SESSION["user_name"] = $uname;
           $_SESSION["password"] = $password;
       } else {
          // printf("Error Message %s\n", $mysqli->error);
       }

       $stmt->fetch();

       /* Close statement */
       $stmt->close();
       /* Close connection */
       $mysqli->close();


   }


}

?>

</html>