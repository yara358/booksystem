<?php
 class calendar{
     protected $db_query;
     protected $db_result;
     protected $db_row;

     public function listToDo($connection){
         $this -> connection = $connection;
         $this -> db_query = "SELECT * FROM events";

         try {
                $db_result = $connection -> prepare($this -> db_query);
                $db_result -> execute();

                $db_array = array();
                $i = 0;

                while($db_row = $db_result -> fetch(PDO::FETCH_BOTH)){
                    $db_array[$i] = $db_row;
                    $i++;
                 } 

                echo json_decode(array("success" => 1,"result" => $db_array));

                $db_result -> CloseCursor();
         }
         catch(Exception $e){
             die('Error' . $e -> GetMessage());
             echo "<div class'alert alert-danger' role='alert'>". $e -> getLine() . "</div>";
         }
     }

     public function new($connection){
         $this -> connection = $connection;

         $this -> db_query = "INSERT INTO events (title, body, url, class, start, end, start_normal, end_normal) VALUES (:title, :body, :url, :class, :start, :end, :start_normal, :end_normal)";

         $start = strtotime(substr($_POST["start"], 6, 4) . "-" . substr($_POST["start"], 3, 2) . "-" . substr($_POST["start"], 0, 2) . " "  . substr($_POST["start"], 10, 6)) * 1000;

         $end = strtotime(substr($_POST["end"], 6, 4)."-" . substr($_POST["end"], 3, 2) . "-" . substr($_POST["end"], 0, 2) . " " . substr($_POST["end"], 10, 6)) * 1000;

         $link = __LOCALHOST__ . "/calendarDetails.php";

         try {
             $db_result = $connection -> prepare($this -> db_query);

             $db_result -> bindValue(":title", $_POST['title']);
             $db_result -> bindValue(":body", $_POST["body"]);
             $db_result -> bindValue(":url", $link);
             $db_result -> bindValue(":class", $_POST["class"]);
             $db_result -> bindValue(":start", $inicio);
             $db_result -> bindValue(":end", $final);
             $db_result -> bindValue(":start_normal", $_POST["start"]);
             $db_result -> bindValue(":end_normal", $_POST["end"]);

             $db_result -> execute();

             $this -> db_query = "SELECT MAX(id) AS id FROM events";
             $db_result = $connection -> prepare($this -> db_query);
             $db_result -> execute();

             $db_file = $db_result -> fetch(PDO::FETCH_ASSOC);
             $id_event = $_file['id'];
             
             $link = __LOCALHOST__ . "/calendarDetails.php?id=$id_event";

             $this -> db_query = "UPDATE events SET url= '$link' WHERE id = '$id_event'";
             $db_result = $connection ->prepare($this -> db_query);
             $db_result -> execute();

             $db_result -> CloseCursor();

             header("location:indexForTheCalendar.php?new=done");
         }
         catch(Exception $e){
             die('Error' . $e -> GetMessage());
             echo "<div class='alert alert-danger' role='alert'>" . $e -> getLine() . "</div>";
         }
     }
     
     public function remove($connection){
         $this -> connection = $connection;
         $this -> db_query = "DELETE FROM events WHERE id = :id";

         try{
             $db_result = $connection -> prepare($this -> db_query);
             $db_result -> bindValue(":id", $_Get["id"]);
             $db_result -> execute();

             $db_result -> CloseCursor();

             header("location:indexForTheCalendar.php?remove=done");
         }
         catch(Exception $e){
             die('Error' . $e -> GetMessage());
             echo "<div class='alert alert-danger' role='alert'>" . $e -> getLine() . "</div>";
         }
     }
 }