<!--This code to write the worker  page so the worker can do all his activities -->
<?php
session_start();
/*if((!isset($_SESSION['employees']))){
  header("Location:main.php");
}*/
$title = "main page";
require "./template/header.php";
require_once "./include/dBFunctions.inc.php";
?>
 <head>
  <link href="bootstrap/css/main.css" type="text/css" rel="stylesheet"/>
  </head> 
<body>
    <br>
    <br>
      <div class="row">
       <a type="submit" class="btn  btn-block"  style="Width:1100px; height:50px; background-color:Lavender; color:SteelBlue; font-family:Cursive;" href="add_book.php">add a book</a>
     </div><br>
    <div class="row">
       <a type="submit" class="btn  btn-block"  style="Width:1100px; height:50px; background-color:Lavender; color:SteelBlue; font-family:Cursive;"  href="admin_categories.php">list of categories</a>
     </div><br>
     <div class="row">
      <a type="submit" class="btn  btn-block"  style="Width:1100px; height:50px; background-color:Lavender; color:SteelBlue; font-family:Cursive;"  href="add-category.php">add a category </a><br><br>
    </div>
    <div class="row">
       <a type="submit" class="btn  btn-block"  style="Width:1100px; height:50px; background-color:Lavender; color:SteelBlue; font-family:Cursive;"  href="admin_book.php">list of books</a>
     </div><br><br>
     <div class="row">
       <a type="submit" class="btn  btn-block"  style="Width:1100px; height:50px; background-color:Lavender; color:SteelBlue; font-family:Cursive;"  href="add-publisher.php">add publisher</a>
      </div><br><br> 
      <div class="row">
       <a type="submit" class="btn  btn-block"  style="Width:1100px; height:50px; background-color:Lavender; color:SteelBlue; font-family:Cursive;"  href="best_authors.php">list a authors</a>
      </div><br><br> 
      <div class="row">
       <a type="submit" class="btn  btn-block"  style="Width:1100px; height:50px; background-color:Lavender; color:SteelBlue; font-family:Cursive;"  href="publisher_list.php">list a publishers</a>
      </div><br><br>  
      <div class="row">
       <a type="submit" class="btn  btn-block"  style="Width:1100px; height:50px; background-color:Lavender; color:SteelBlue; font-family:Cursive;"  href="add-language.php">add a language</a>
      </div><br><br> 
      <div class="row">
       <a type="submit" class="btn  btn-block"  style="Width:1100px; height:50px; background-color:Lavender; color:SteelBlue; font-family:Cursive;"  href="language_list.php">list a language</a>
      </div><br><br> 
</body>   
