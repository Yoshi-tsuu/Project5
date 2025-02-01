<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Appointments</title>
  <link rel="stylesheet" href="css/css.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="js/script.js"></script>
</head>
<body>
  <a href="Index.html">Powrót do strony głównej</a>
  <form method="POST" action='addAppointment.php' id='dane'>
    <select name='userID' id='userID'>
      <option value=""></option>
      <?php
      $conn = new mysqli("localhost","root","","MedicalAppointments");
      $sql = "SELECT UserID, CONCAT(FirstName, ' ', LastName) FROM Users";
      $result = $conn->query($sql);
      while($row = $result->fetch_row()){
        echo "<option value='$row[0]'>$row[1]</option>";
      }
      ?>
    </select>
    <select name='doctorID' id='doctorID'>
      <option value=""></option>
      <?php
      $sql = "SELECT DoctorID, CONCAT(FirstName, ' ', LastName) FROM Doctors";
      $result = $conn->query($sql);
      while($row = $result->fetch_row()){
        echo "<option value='$row[0]'>$row[1]</option>";
      }
      ?>
    </select>
    <input type='datetime-local' id='appointmentDate' name='appointmentDate' placeholder="Appointment Date">
    <select name='mode' id='mode'>
      <option value="InPerson">In Person</option>
      <option value="Online">Online</option>
    </select>
    <input type='submit' name='dodaj' value='Add Appointment'>
  </form>
  <?php
    $sql = "SELECT a.AppointmentID, u.FirstName, u.LastName, d.FirstName, d.LastName, a.AppointmentDate, a.Mode FROM Appointments a
          LEFT JOIN Users u ON u.UserID = a.UserID
          LEFT JOIN Doctors d ON d.DoctorID = a.DoctorID;
          ";
    echo "<table><tr><th>ID</th><th>User</th><th>Doctor</th><th>Appointment Date</th><th>Mode</th><th>Controls</th></tr>";
    $result = $conn->query($sql);
    while($row = $result->fetch_row()){
      echo "<tr><td>$row[0]</td><td>$row[1] $row[2]</td><td>$row[3] $row[4]</td><td>$row[5]</td><td>$row[6]</td>
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
    $.post("deleteAppointment.php",{appointmentID:id},function(res){
    location.reload();
    })
  })
  $(".update").on("click",function(){
    let id = $(this).attr("data");
    let userID = $("#userID").val();
    let doctorID = $("#doctorID").val();
    let appointmentDate = $("#appointmentDate").val();
    let mode = $("#mode").val();
    $.post("updateAppointment.php",{appointmentID:id,userID:userID,doctorID:doctorID,appointmentDate:appointmentDate,mode:mode},function(res){
    console.log(res);
    $("#dane >input[type!=submit]").val("");
    location.reload();
    })
  })
</script>
</html>