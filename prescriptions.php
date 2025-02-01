<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Prescriptions</title>
  <link rel="stylesheet" href="css/css.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="js/script.js"></script>
</head>
<body>
  <a href="Index.html">Powrót do strony głównej</a>
  <form method="POST" action='addPrescription.php' id='dane'>
    <input type='text' id='appointmentID' name='appointmentID' placeholder="Appointment ID">
    <input type='text' id='doctorID' name='doctorID' placeholder="Doctor ID">
    <input type='text' id='userID' name='userID' placeholder="User ID">
    <input type='text' id='details' name='details' placeholder="Details">
    <input type='submit' name='dodaj' value='Add Prescription'>
  </form>
  <?php
    $conn = new mysqli("localhost", "root", "", "MedicalAppointments");
    $sql = "SELECT * FROM Prescriptions";
    echo "<table><tr><th>ID</th><th>Appointment ID</th><th>Doctor ID</th><th>User ID</th><th>Details</th><th>Created At</th><th>Controls</th></tr>";
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
    $.post("deletePrescription.php",{prescriptionID:id},function(res){
    location.reload();
    })
  })
  $(".update").on("click",function(){
    let id = $(this).attr("data");
    let appointmentID = $("#appointmentID").val();
    let doctorID = $("#doctorID").val();
    let userID = $("#userID").val();
    let details = $("#details").val();
    $.post("updatePrescription.php",{prescriptionID:id,appointmentID:appointmentID,doctorID:doctorID,userID:userID,details:details},function(res){
    console.log(res);
    $("#dane >input[type!=submit]").val("");
    location.reload();
    })
  })
</script>
</html>