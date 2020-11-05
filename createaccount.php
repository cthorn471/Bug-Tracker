<?php
//declare the fields that will be used in the database login
$Email=$_POST['Email'];
$Pass=$_POST['Pass'];
$Fname=$_POST['Fname'];
$Lname=$_POST['Lname'];

if (!empty($Email) || !empty($Pass) || !empty($Fname) || !empty($Lname)){
    $host="localhost";
    $dbUsername="root";
    $dbPassword="";
    $dbname="loginform";

        //create database connection
        $conn = new mysqli($host,$dbUsername,$dbPassword,$dbname);

        if (mysqli_connect_error()){
            die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
        }else{
            $SELECT = "SELECT Email From loginpage Where Email = ? Limit 1";
            $INSERT = "INSERT Into loginpage (Email, Pass, Fname, Lname) values (?,?,?,?)";

            //prepare statement
            $stmt = $conn->prepare($SELECT);
            $stmt->bind_param("s",$Email);
            $stmt->execute();
            $stmt->bind_result($Email);
            $stmt->store_result();
            $rnum=$stmt->num_rows;

            if ($rnum ==0){
                $stmt->close();

                $stmt = $conn->prepare($INSERT);
                $stmt->bind_param("ssss",$Email,$Pass,$Fname,$Lname);
                $stmt->execute();
                echo "New record inserted successfully <br>";
                echo $Fname, "<br>";
                echo $Lname, "<br>";
                echo $Email, "<br>";
                echo $Pass, "<br>";

            }else{
                echo " Someone already registered with that email";
            }
            $stmt->close();
            $conn->close();
    }
}else{
    echo "All fields are required";
    die();
}
?>