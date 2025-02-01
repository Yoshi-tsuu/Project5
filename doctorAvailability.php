<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Doctor Availability</title>
  <link rel="stylesheet" href="css/css.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="js/script.js"></script>
</head>
<body>
  <a href="Index.html">Powrót do strony głównej</a>
  <form method="POST" action='addDoctorAvailability.php' id='dane'>
    <select name='doctorID' id='doctorID'>
      <option value=""></option>
      <?php
      $conn = new mysqli("localhost","root","","MedicalAppointments");
      $sql = "SELECT DoctorID, CONCAT(FirstName, ' ', LastName) FROM Doctors";
      $result = $conn->query($sql);
      while($row = $result->fetch_row()){
        echo "<option value='$row[0]'>$row[1]</option>";
      }
      ?>
    </select>
    <input type='date' id='availableDate' name='availableDate' placeholder="Available Date">
    <input type='time' id='startTime' name='startTime' placeholder="Start Time">
    <input type='time' id='endTime' name='endTime' placeholder="End Time">
    <input type='submit' name='dodaj' value='Add Availability'>
  </form>
  <?php
    $sql = "SELECT da.AvailabilityID, d.FirstName, d.LastName, da.AvailableDate, da.StartTime, da.EndTime FROM DoctorAvailability da
          LEFT JOIN Doctors d ON d.DoctorID = da.DoctorID;
          ";
    echo "<table><tr><th>ID</th><th>Doctor</th><th>Available Date</th><th>Start Time</th><th>End Time</th><th>Controls</th></tr>";
    $result = $conn->query($sql);
    while($row = $result->fetch_row()){
      echo "<tr><td>$row[0]</td><td>$row[1] $row[2]</td><td>$row[3]</td><td>$row[4]</td><td>$row[5]</td>
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
    $.post("deleteDoctorAvailability.php",{availabilityID:id},function(res){
    location.reload();
    })
  })
  $(".update").on("click",function(){
    let id = $(this).attr("data");
    let doctorID = $("#doctorID").val();
    let availableDate = $("#availableDate").val();
    let startTime = $("#startTime").val();
    let endTime = $("#endTime").val();
    $.post("updateDoctorAvailability.php",{availabilityID:id,doctorID:doctorID,availableDate:availableDate,startTime:startTime,endTime:endTime},function(res){
    console.log(res);
    $("#dane >input[type!=submit]").val("");
    location.reload();
    })
  })
</script>
</html>