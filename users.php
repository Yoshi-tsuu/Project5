<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Users</title>
  <link rel="stylesheet" href="css/css.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="js/script.js"></script>
</head>
<body>
  <a href="Index.html">Powrót do strony głównej</a>
  <form method="POST" action='addUser.php' id='dane'>
    <input type='text' id='firstName' name='firstName' placeholder="First Name">
    <input type='text' id='lastName' name='lastName' placeholder="Last Name">
    <input type='text' id='email' name='email' placeholder="Email">
    <input type='text' id='phoneNumber' name='phoneNumber' placeholder="Phone Number">
    <input type='date' id='dateOfBirth' name='dateOfBirth' placeholder="Date of Birth">
    <input type='text' id='address' name='address' placeholder="Address">
    <input type='submit' name='dodaj' value='Add User'>
  </form>
  <?php
    $conn = new mysqli("localhost", "root", "", "MedicalAppointments");
    
    $sql = "SELECT u.UserID, u.FirstName, u.LastName, u.Email, u.PhoneNumber, u.DateOfBirth, u.Address, 
                   COALESCE(SUM(p.Amount), 0) AS TotalAmountPaid
            FROM Users u
            LEFT JOIN Payments p ON u.UserID = p.UserID
            GROUP BY u.UserID";
    
    echo "<table><tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Phone Number</th><th>Date of Birth</th><th>Address</th><th>Total Amount Paid</th><th>Controls</th></tr>";
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()){
      echo "<tr>
              <td>{$row['UserID']}</td>
              <td>{$row['FirstName']}</td>
              <td>{$row['LastName']}</td>
              <td>{$row['Email']}</td>
              <td>{$row['PhoneNumber']}</td>
              <td>{$row['DateOfBirth']}</td>
              <td>{$row['Address']}</td>
              <td>{$row['TotalAmountPaid']}</td>
              <td>
                <input type='button' value='Delete' class='usun' data='{$row['UserID']}'>
                <input type='button' value='Update' class='update' data='{$row['UserID']}'>
              </td>
            </tr>";
    }
    echo "</table>";
  ?>
</body>
<script>
  $(".usun").on("click",function(){
    let id = $(this).attr("data");
    $.post("deleteUser.php",{userID:id},function(res){
    location.reload();
    })
  })
  $(".update").on("click",function(){
    let id = $(this).attr("data");
    let firstName = $("#firstName").val();
    let lastName = $("#lastName").val();
    let email = $("#email").val();
    let phoneNumber = $("#phoneNumber").val();
    let dateOfBirth = $("#dateOfBirth").val();
    let address = $("#address").val();
    $.post("updateUser.php",{userID:id,firstName:firstName,lastName:lastName,email:email,phoneNumber:phoneNumber,dateOfBirth:dateOfBirth,address:address},function(res){
    console.log(res);
    $("#dane >input[type!=submit]").val("");
    location.reload();
    })
  })
</script>
</html>