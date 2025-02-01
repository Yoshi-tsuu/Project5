<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Health Packages</title>
  <link rel="stylesheet" href="css/css.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="js/script.js"></script>
</head>
<body>
  <a href="Index.html">Powrót do strony głównej</a>
  <form method="POST" action='addHealthPackage.php' id='dane'>
    <input type='text' id='name' name='name' placeholder="Name">
    <input type='text' id='description' name='description' placeholder="Description">
    <input type='text' id='price' name='price' placeholder="Price">
    <input type='text' id='durationMonths' name='durationMonths' placeholder="Duration (Months)">
    <input type='submit' name='dodaj' value='Add Health Package'>
  </form>
  <?php
    $conn = new mysqli("localhost", "root", "", "MedicalAppointments");
    $sql = "SELECT * FROM HealthPackages";
    echo "<table><tr><th>ID</th><th>Name</th><th>Description</th><th>Price</th><th>Duration (Months)</th><th>Created At</th><th>Controls</th></tr>";
    $result = $conn->query($sql);
    while($row = $result->fetch_row()){
      echo "<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td><td>$row[4]</td><td>$row[5]</td>
      <td>
        <input type='button' value='Delete' class='usun' data='$row[0]'>
        <input type='button' value='Update' class='update' data='$row[0]'>
      </td>";
    }
    echo "</table>";
  ?>
</body>
<script>
  $(".usun").on("click",function(){
    let id = $(this).attr("data");
    $.post("deleteHealthPackage.php",{packageID:id},function(res){
    location.reload();
    })
  })
  $(".update").on("click",function(){
    let id = $(this).attr("data");
    let name = $("#name").val();
    let description = $("#description").val();
    let price = $("#price").val();
    let durationMonths = $("#durationMonths").val();
    $.post("updateHealthPackage.php",{packageID:id,name:name,description:description,price:price,durationMonths:durationMonths},function(res){
    console.log(res);
    $("#dane >input[type!=submit]").val("");
    location.reload();
    })
  })
</script>
</html>