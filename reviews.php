<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reviews</title>
  <link rel="stylesheet" href="css/css.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="js/script.js"></script>
</head>
<body>
  <a href="Index.html">Powrót do strony głównej</a>
  <form method="POST" action='addReview.php' id='dane'>
    <input type='text' id='userID' name='userID' placeholder="User ID">
    <input type='text' id='doctorID' name='doctorID' placeholder="Doctor ID">
    <input type='text' id='rating' name='rating' placeholder="Rating">
    <input type='text' id='comment' name='comment' placeholder="Comment">
    <input type='submit' name='dodaj' value='Add Review'>
  </form>
  <?php
    $conn = new mysqli("localhost", "root", "", "MedicalAppointments");
    $sql = "SELECT * FROM Reviews";
    echo "<table><tr><th>ID</th><th>User ID</th><th>Doctor ID</th><th>Rating</th><th>Comment</th><th>Created At</th><th>Controls</th></tr>";
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
    $.post("deleteReview.php",{reviewID:id},function(res){
    location.reload();
    })
  })
  $(".update").on("click",function(){
    let id = $(this).attr("data");
    let userID = $("#userID").val();
    let doctorID = $("#doctorID").val();
    let rating = $("#rating").val();
    let comment = $("#comment").val();
    $.post("updateReview.php",{reviewID:id,userID:userID,doctorID:doctorID,rating:rating,comment:comment},function(res){
    console.log(res);
    $("#dane >input[type!=submit]").val("");
    location.reload();
    })
  })
</script>
</html>