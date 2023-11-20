<?php
// session started
   session_start();
   // if the entering is employee or mangers 
   if((!isset($_SESSION['employees'])  && !isset($_SESSION['managers']))){
    header("Location:main.php");
}
// the title for the page 
  $title="Entreing Employee";
  //pages to bring from it functions 
  require "./template/header.php";
  require "./include/dBFunctions.inc.php";
    require 'include/db-connect.inc.php';


//if the oreder we get submit after entering all the information 
 if(isset($_POST['entery-submit'])){
    

    // change all the under to fit the accptence form 
    $id = $_POST['idWorkerEmplo'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['passwd'];
    $passwordRepeat = $_POST['repasswd'];
    $birthdate = $_POST['bidate'];
    $cityName = $_POST['ciname'];
    $department = $_POST['com'];
    $phone = $_POST['telph'];
    $info = $_POST['info'];
    
    //if the email is validate and checking if the id was written with only numbers and to check if the name was written in only letters
    else if(!filter_var($email,FILTER_VALIDATE_EMAIL) && !preg_match("/^[0-9]*$/",$id) && !preg_match("/^[a-zA-Z ]*$/",$name)){
        header("Location:../accptence-newComer.php?error=invalidemainfirstlastname");
        exit();
    }
    //if the id was written with only numbers
    elseif (!preg_match("/^[0-9]*$/",$id)) {
        header("Location:../accptence-newComer.php?error=invalidid");
        exit();
    }
    //if the email is validate 
    else if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        header("Location:../accptence-newComer.php?error=invalidemail");
        exit();
    }
    //to check if the name was written in only letters
    else if(!preg_match("/^[a-zA-Z ]*$/",$name)){
        header("Location:../accptence-newComer.php?error=invalidfirstname");
        exit();
    }
    //checking if the password the the repeat paasword the same 
    else if($password !== $passwordRepeat) {
        header("Location:../accptence-newComer.php?error= passwordCheck");
        exit();
    }
    else{// you can enter the employee name 
        // checking if the ID already exists in the database
        $sql = "SELECT ID FROM employees WHERE ID=?;";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location:../accptence-newComer.php?error=sqlerror");
            exit();
        }
        else {
            mysqli_stmt_bind_param($stmt,"s",$id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);


            $resultCheck = mysqli_stmt_num_rows($stmt);

            // if there are ID the same we are trying to enter we will get this message
            if($resultCheck > 0){
                header("Location:../accptence-newComer.php?error=idTaken");
                exit();
            }
            // else entering the info of the employee to the database
            else {
                $clientSum = 0;
                $hashedpwd = password_hash($password,PASSWORD_DEFAULT);

                $idint= (int)$id;
                $sql = "INSERT INTO employees VALUES ('" .  $idint. "', '" . $name. "', '" . $phone. "','" .  $email. "', '" . $password. "', '" . $birthdate. "','" . $cityName. "', '" . $idBranchInt. "','". $clientSum . "')";
                $result = mysqli_query($conn,$sql);
     
                if(!$result){
                 echo "Can't add new data " . mysqli_error($conn);
                 exit();
                }
                else {
                 header("Location: add-department.php");
               }
            }


        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
    header("Location:../accptence-newComer.php");
    exit();

}
 
?>

<!--  if we get errors -->

<?php
    if(isset($_GET["error"])){
        if($_GET["error"] == "invalidemainfirstlastname"){
            echo "<p> invalid id, email, first and last name </p>";
        }
        else if($_GET["error"] == "emptyfields"){
            echo "<p> You have to enter if the person entering branch or company!!</p>";
        }
        else if($_GET["error"] == "invalidid"){
            echo "<p> invalid id you have to change the id</p>";
        }
        else if($_GET["error"] == "invalidemail"){
            echo "<p> invalid email!! you have to change the email</p>";
        }
        else if($_GET["error"] == "invalidfirstname"){
            echo "<p> invalid first name!! you have to change the first name</p>";
        }
        else if($_GET["error"] == "invalidlastname"){
            echo "<p> invalid last name!! you have to change the last name</p>";
        }
        else if($_GET["error"] == "passwordCheck"){
            echo "<p> repeat the password! you repeated it wrong</p>";
        }
    }
?>



<main>
   <div class="bg-image">
    <div class="container">
      <h2 class="text-info">Entring new Employee inforamtion</h2>
      <form action="accptence-newComer.php" method ="post" >
      <br>
        <label for="idWorkerEmplo" class="text-white">ID:</label>
        <input type="text" id="idWorkerEmplo" name="idWorkerEmplo" placeholder="ID" required class="form-control"><br><br>
        <label for="name" class="text-white">First Name:</label>
        <input type="text" id="name" name="name" placeholder=" Name" required class="form-control"><br><br>
        <labe for="email" class="text-white">Email:</labe>
        <input type="email" id="email" name="email" placeholder="Email" required class="form-control"><br><br>
        <label for="passwd" class="text-white">password:</label>
        <input type="password" id="passwd" name="passwd" placeholder="Password" required class="form-control"><br><br>
        <label for="repasswd" class="text-white">Repeat Password:</label>
        <input type="password" id="repasswd" name="repasswd" placeholder="Repeat Password" required class="form-control"><br><br>
        <label for="bidate" class="text-white">Birth Date:</label>
        <input type="date" id="bidate" name="bidate" placeholder="Birth Date" class="form-control"><br><br>
        <label for="ciname" class="text-white">City Name:</label>
        <input type="text" id="ciname" name="ciname" placeholder="City Name" class="form-control"><br><br>
        <label for="telph" class="text-white">Phone:</label>
        <input type="tel" id="telph" name="telph" placeholder="Phone" class="form-control"><br><br>
        <div class="form-group" >
            <label for="info" class="text-white">Important Information:</label>
            <textarea name="info" rows="8" class="form-control"></textarea><br><br>
        </div>    
        <button type="submit" name="entery-submit" class="btn btn-danger btn-sm" >Finish</button>
      </form> 
    </div> 
   </div>   
</main>  




  