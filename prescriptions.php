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
    <select name='appointmentID' id='appointmentID'>
      <option value=""></option>
      <?php
      $conn = new mysqli("localhost", "root", "", "MedicalAppointments");
      $sql = "SELECT AppointmentID, AppointmentDate FROM Appointments";
      $result = $conn->query($sql);
      while($row = $result->fetch_row()){
        echo "<option value='$row[0]'>$row[1]</option>";
      }
      ?>
    </select>
    <select name='doctorID' id='doctorID'>
      <option value=""></option>
      <?php
      $sql = "SELECT DoctorID, FirstName, LastName FROM Doctors";
      $result = $conn->query($sql);
      while($row = $result->fetch_row()){
        echo "<option value='$row[0]'>$row[1] $row[2]</option>";
      }
      ?>
    </select>
    <select name='userID' id='userID'>
      <option value=""></option>
      <?php
      $sql = "SELECT UserID, FirstName, LastName FROM Users";
      $result = $conn->query($sql);
      while($row = $result->fetch_row()){
        echo "<option value='$row[0]'>$row[1] $row[2]</option>";
      }
      ?>
    </select>
    <input type='text' id='details' name='details' placeholder="Details">
    <input type='submit' name='dodaj' value='Add Prescription'>
  </form>
  <?php
    $sql = "SELECT 
    pr.PrescriptionID,
    CONCAT(u.FirstName, ' ', u.LastName) AS UserName,  
    CONCAT(d.FirstName, ' ', d.LastName) AS DoctorName,  
    a.AppointmentDate,  
    pr.Details,
    pr.CreatedAt  
FROM 
    Prescriptions pr
JOIN 
    Users u ON pr.UserID = u.UserID  
JOIN 
    Doctors d ON pr.DoctorID = d.DoctorID
JOIN 
    Appointments a ON pr.AppointmentID = a.AppointmentID; ";
    echo "<table><tr><th>ID</th><th>User ID</th><th>Doctor ID</th><th>Appointment ID</th><th>Details</th><th>Created At</th><th>Controls</th></tr>";
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