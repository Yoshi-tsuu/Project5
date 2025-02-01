<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Specializations</title>
  <link rel="stylesheet" href="css/css.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="js/script.js"></script>
</head>
<body>
  <a href="Index.html">Powrót do strony głównej</a>
  <form method="POST" action='addSpecialization.php' id='dane'>
    <input type='text' id='name' name='name' placeholder="Name">
    <input type='text' id='description' name='description' placeholder="Description">
    <input type='submit' name='dodaj' value='Add Specialization'>
  </form>
  <?php
    $conn = new mysqli("localhost", "root", "", "MedicalAppointments");
    $sql = "SELECT * FROM Specializations";
    echo "<table><tr><th>ID</th><th>Name</th><th>Description</th><th>Controls</th></tr>";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()){
      echo "<tr><td>{$row['SpecializationID']}</td><td>{$row['Name']}</td><td>{$row['Description']}</td>
      <td>
        <input type='button' value='Delete' class='usun' data='{$row['SpecializationID']}'>
        <input type='button' value='Update' class='update' data='{$row['SpecializationID']}'>
      </td>";
    }
    echo "</table>";
  ?>
</body>
<script>
  $(".usun").on("click",function(){
    let id = $(this).attr("data");
    $.post("deleteSpecialization.php",{specializationID:id},function(res){
    location.reload();
    })
  })
  $(".update").on("click",function(){
    let id = $(this).attr("data");
    let name = $("#name").val();
    let description = $("#description").val();
    $.post("updateSpecialization.php",{specializationID:id,name:name,description:description},function(res){
    console.log(res);
    $("#dane >input[type!=submit]").val("");
    location.reload();
    })
  })
</script>
</html>