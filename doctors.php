<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Doctors</title>
  <link rel="stylesheet" href="css/css.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="js/script.js"></script>
</head>
<body>
  <a href="Index.html">Powrót do strony głównej</a>
  <form method="POST" action='addDoctor.php' id='dane'>
    <input type='text' id='firstName' name='firstName' placeholder="First Name">
    <input type='text' id='lastName' name='lastName' placeholder="Last Name">
    <input type='text' id='email' name='email' placeholder="Email">
    <input type='text' id='phoneNumber' name='phoneNumber' placeholder="Phone Number">
    <select name='specializationID' id='specializationID'>
      <option value=""></option>
      <?php
      $conn = new mysqli("localhost","root","","MedicalAppointments");
      $sql = "SELECT SpecializationID, Name FROM Specializations";
      $result = $conn->query($sql);
      while($row = $result->fetch_row()){
        echo "<option value='$row[0]'>$row[1]</option>";
      }
      ?>
    </select>
    <input type='text' id='bio' name='bio' placeholder="Bio">
    <input type='submit' name='dodaj' value='Add Doctor'>
  </form>
  <?php
    $sql = "SELECT d.DoctorID, d.FirstName, d.LastName, d.Email, d.PhoneNumber, s.Name, d.Bio FROM Doctors d
          LEFT JOIN Specializations s ON s.SpecializationID = d.SpecializationID;
          ";
    echo "<table><tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Phone Number</th><th>Specialization</th><th>Bio</th><th>Controls</th></tr>";
    $result = $conn->query($sql);
    while($row = $result->fetch_row()){
      echo "<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td><td>$row[4]</td><td>$row[5]</td><td>$row[6]</td>
      <td>
        <input type='button' value='Delete' class='usun' data='$row[0]'>
        <input type='button' value='Update' class='update' data='$row[0]'>
        <a href='doctor_reviews.php?doctorID=$row[0]'><input type='button' value='See Reviews'></a>
      </td>";
    }
    echo "</table>";
  ?>
</body>
<script>
  $(".usun").on("click",function(){
    let id = $(this).attr("data");
    $.post("deleteDoctor.php",{doctorID:id},function(res){
    location.reload();
    })
  })
  $(".update").on("click",function(){
    let id = $(this).attr("data");
    let firstName = $("#firstName").val();
    let lastName = $("#lastName").val();
    let email = $("#email").val();
    let phoneNumber = $("#phoneNumber").val();
    let specializationID = $("#specializationID").val();
    let bio = $("#bio").val();
    $.post("updateDoctor.php",{doctorID:id,firstName:firstName,lastName:lastName,email:email,phoneNumber:phoneNumber,specializationID:specializationID,bio:bio},function(res){
    console.log(res);
    $("#dane >input[type!=submit]").val("");
    location.reload();
    })
  })
</script>
</html>