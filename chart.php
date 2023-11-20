<!--This code will shoe the chart to all books that are been sold  -->
<?php 
//getting the function og the function to connect the sql data
require "./include/dBFunctions.inc.php";
	$conn = db_connect();// connecting the data base 
$query = "SELECT * FROM books";// selection alll the books 
$result = mysqli_query($conn, $query);
$chart_data = '';
while($row = mysqli_fetch_array($result))// the chart to the result 
{
 $chart_data .= "{ Title:'".$row["Title"]."', sales:".$row["sales"]."}, ";
}
$chart_data = substr($chart_data, 0, -2);
?>


<!DOCTYPE html>
<html>
 <head>
  <title>Graphs</title>
  
  <!-- Bootstrap CDN 
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
-->
  <script src="https://code.jquery.com/jquery-3.4.0.js"></script>
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
  <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

  
 </head>
 <body>
  <br /><br />
  <div class="container" style="width:900px;">
   <br /><br />
   <div id="chart"></div>
  </div>


 </body>
</html>
<!-- The script to enter the dat-->
<script>
Morris.Bar({
 element : 'chart',
 data:[<?php echo $chart_data; ?>],
 xkey:'Title',
 ykeys:['sales'],
 hideHover:'auto',
 stacked:true
});
</script>