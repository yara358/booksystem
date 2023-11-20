<?php
  if(isset($_POST["signup-submit"])){
      
    require 'db-connect.inc.php';
    //require 'functions.inc.php';

    $username = $_POST['username'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['mail'];
    $password = $_POST['pwd'];
    $passwordRepeat = $_POST['repwd'];


    if(empty($username) || empty($fname) || empty($lname) || empty($email) || empty($password) || empty($passwordRepeat)){

    header("Location:../signup.php?error=emptyfields& uid=".$username."&email = ".$email);
    exit();
   }

   else if(!filter_var($email,FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/",$username)) {
    header("Location:../signup.php?error=invalidmailuid");
    exit();
    }

  else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
         header("Location:../signup.php?error= inavalid mail &uid = ".$username);
        exit();
  }

  else if(!preg_match("/^[a-zA-Z0-9]*$/",$username)) {
    header("Location:../signup.php?error=invaliduid& email = &email".$email);
    exit();
  }

  else if($password !== $passwordRepeat) {
    header("Location:../signup.php?error= passwordCheck &uid =".$username . "&email = ".$email);
    exit();
  }

  else {
       $sql = " SELECT username FROM clients WHERE username = ?;";
      $stmt = mysqli_stmt_init($conn);

      if(!mysqli_stmt_prepare($stmt,$sql)) {
        header("Location:../signup.php?error= sqlerror1");
        exit();
      }
      else {
          mysqli_stmt_bind_param($stmt,"s",$username);
          mysqli_stmt_execute($stmt);
          mysqli_stmt_store_result($stmt);
          
          //$resultData = mysqli_stmt_get_result($stmt);
          $resultCheck = mysqli_stmt_num_rows($stmt);

        
          
          if($resultCheck > 0) {
            header("Location:../signup.php?error= usertaken &email = ".$email);
            exit();
          }
          
          else {
              
              
              $sql = "INSERT INTO clients(username,first_name,last_name,password,email) VALUES (?,?,?,?,?)";
              $stmt = mysqli_stmt_init($conn);
              
              if(!mysqli_stmt_prepare($stmt,$sql)) {
                header("Location:../signup.php?error= sqlerror2");
                exit();
               }
              else {
                  $hashedPwd = password_hash($password,PASSWORD_DEFAULT);

                   mysqli_stmt_bind_param($stmt,"sssss",$username,$fname,$lname,$hashedPwd,$email);
                  mysqli_stmt_execute($stmt);
                  

                  if (mysqli_query($conn, $stmt)) {
                    echo "New record created successfully";
                  } 



                  header("Location:../profile.php");
                  exit();
              }
          }
      }

      mysqli_stmt_close($stmt);
      mysqli_close($conn);
  }
  
    header("Location:../signup.php");
          exit();
  }

