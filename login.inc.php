<?php
  if(isset($_POST['login-submit'])){
      
    require "db-connect.inc.php";
    require "dBFunctions.inc.php";

    $mailuid=  $_POST['mailuid'];
    $password= $_POST['pwd'];

    if(empty($mailuid) || empty($password)){
      header("Location: ../login.php?error=emptyfields");
      exit();
    }

    $result=5;
    // change all the function to fit the function uidExsitsforEnterance its easer 
    $uidExists = uidExistsClients($conn, $mailuid, $mailuid ,$result);

    if($uidExists  !== false ){

      $pwdHashed=$uidExists["password"];
      $checkPwd = Password_verify($password,$pwdHashed);

      if($checkPwd === false){
        header("Location: /login.php?error=wrongpwd");
        exit();
      }
      else if($checkPwd === true){
        session_start();
        $_SESSION["mailuid"] = $uidExists["username"];
        header("Location:../main.php?youdidit");
        exit();
      }
    }

    $uidExists = uidExistsWorkers($conn, $mailuid, $mailuid ,$result);

    if($uidExists  !== false ){

      $pwdHashed=$uidExists["password"];
      $checkPwd = Password_verify($password,$pwdHashed);

      if($checkPwd === false){
        header("Location: /login.php?error=wrongpwd");
        exit();
      }
      else if($checkPwd === true){
        session_start();
        $_SESSION["mailuid"] = $uidExists["ID"];
        header("Location:../main.php?youdidit");
        exit();
      }
    }


    $uidExists = uidExistsEmployee($conn, $mailuid, $mailuid ,$result);

    if($uidExists  !== false ){

      $pwdHashed=$uidExists["password"];
      $checkPwd = Password_verify($password,$pwdHashed);

      if($checkPwd === false){
        header("Location: /login.php?error=wrongpwd");
        exit();
      }
      else if($checkPwd === true){
          if($uidExists["department"] === 1){
          session_start();
          $_SESSION["mailuid"] = $uidExists["ID"];
          header("Location:../publisherTheMain.php?youdidit");
          exit();
          }else
            if($uidExists["department"] === 2){
          session_start();
          $_SESSION["mailuid"] = $uidExists["ID"];
          header("Location:../Editorial-Department.php?youdidit");
          exit();
          }
          else if($uidExists["department"] === 3){
            session_start();
            $_SESSION["mailuid"] = $uidExists["ID"];
            header("Location:../legalTeam.php?youdidit");
            exit();
            }
          else if($uidExists["department"] === 3){
              session_start();
              $_SESSION["mailuid"] = $uidExists["ID"];
              header("Location:../managingEditorial&Production.php?youdidit");
              exit();
              }
          else if($uidExists["department"] === 5){
                session_start();
                $_SESSION["mailuid"] = $uidExists["ID"];
                header("Location:../creativeDepartmnet,publicity,marketing,promation,advertising.php?youdidit");
                exit();
                }
          else if($uidExists["department"] === 6){
                  session_start();
                  $_SESSION["mailuid"] = $uidExists["ID"];
                  header("Location:../salles.php?youdidit");
                  exit();
          }
          else if($uidExists["department"] === 7){
            session_start();
            $_SESSION["mailuid"] = $uidExists["ID"];
            header("Location:../creativeDepartmnet,publicity,marketing,promation,advertising.php?youdidit");
            exit();
            }
            else if($uidExists["department"] === 8){
              session_start();
              $_SESSION["mailuid"] = $uidExists["ID"];
              header("Location:../creativeDepartmnet,publicity,marketing,promation,advertising.php?youdidit");
              exit();
            }
            else if($uidExists["department"] === 9){
              session_start();
              $_SESSION["mailuid"] = $uidExists["ID"];
              header("Location:../creativeDepartmnet,publicity,marketing,promation,advertising.php?youdidit");
              exit();
            }
            else if($uidExists["department"] === 10){
              session_start();
              $_SESSION["mailuid"] = $uidExists["ID"];
              header("Location:../creativeDepartmnet,publicity,marketing,promation,advertising.php?youdidit");
              exit();
            }
            else if($uidExists["department"] === 11){
              session_start();
              $_SESSION["mailuid"] = $uidExists["ID"];
              header("Location:../Finance-accounting.php?youdidit");
              exit();
              }
              else if($uidExists["department"] === 12){
                session_start();
                $_SESSION["mailuid"] = $uidExists["ID"];
                header("Location:../IT.php?youdidit");
                exit();
              }
              else if($uidExists["department"] === 13){
                session_start();
                $_SESSION["mailuid"] = $uidExists["ID"];
                header("Location:../humanResourse.php?youdidit");
                exit();
                }



      }
    }
 

  }
?>
    
  





