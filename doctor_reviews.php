<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Doctor Reviews</title>
  <link rel="stylesheet" href="css/css.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="js/script.js"></script>
</head>
<body>
  <a href="doctors.php">Powrót do listy lekarzy</a>
  <?php
    $doctorID = $_GET['doctorID'];
    $conn = new mysqli("localhost", "root", "", "MedicalAppointments");
    $sql = "SELECT * FROM Reviews WHERE DoctorID = $doctorID";
    echo "<h2>Reviews for Doctor ID: $doctorID</h2>";
    echo "<table><tr><th>ID</th><th>User ID</th><th>Rating</th><th>Comment</th><th>Created At</th></tr>";
    $result = $conn->query($sql);
    while($row = $result->fetch_row()){
      echo "<tr><td>$row[0]</td><td>$row[1]</td><td>$row[3]</td><td>$row[4]</td><td>$row[5]</td></tr>";
    }
    echo "</table>";
  ?>
</body>
</html>