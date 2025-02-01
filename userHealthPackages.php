<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Health Packages</title>
  <link rel="stylesheet" href="css/css.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="js/script.js"></script>
</head>
<body>
  <a href="Index.html">Powrót do strony głównej</a>
  <form method="POST" action='addUserHealthPackage.php' id='dane'>
    <input type='text' id='userID' name='userID' placeholder="User ID">
    <input type='text' id='packageID' name='packageID' placeholder="Package ID">
    <input type='date' id='startDate' name='startDate' placeholder="Start Date">
    <input type='date' id='endDate' name='endDate' placeholder="End Date">
    <input type='submit' name='dodaj' value='Add User Health Package'>
  </form>
  <?php
    $conn = new mysqli("localhost", "root", "", "MedicalAppointments");
    $sql = "SELECT * FROM UserHealthPackages";
    echo "<table><tr><th>ID</th><th>User ID</th><th>Package ID</th><th>Start Date</th><th>End Date</th><th>Controls</th></tr>";
    $result = $conn->query($sql);
    while($row = $result->fetch_row()){
      echo "<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td><td>$row[4]</td>
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
    $.post("deleteUserHealthPackage.php",{subscriptionID:id},function(res){
    location.reload();
    })
  })
  $(".update").on("click",function(){
    let id = $(this).attr("data");
    let userID = $("#userID").val();
    let packageID = $("#packageID").val();
    let startDate = $("#startDate").val();
    let endDate = $("#endDate").val();
    $.post("updateUserHealthPackage.php",{subscriptionID:id,userID:userID,packageID:packageID,startDate:startDate,endDate:endDate},function(res){
    console.log(res);
    $("#dane >input[type!=submit]").val("");
    location.reload();
    })
  })
</script>
</html>