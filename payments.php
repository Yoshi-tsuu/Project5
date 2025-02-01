<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payments</title>
  <link rel="stylesheet" href="css/css.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="js/script.js"></script>
</head>
<body>
  <a href="Index.html">Powrót do strony głównej</a>
  <form method="POST" action='addPayment.php' id='dane'>
    <input type='text' id='userID' name='userID' placeholder="User ID">
    <input type='text' id='appointmentID' name='appointmentID' placeholder="Appointment ID">
    <input type='text' id='amount' name='amount' placeholder="Amount">
    <select name='paymentMethod' id='paymentMethod'>
      <option value="CreditCard">Credit Card</option>
      <option value="DebitCard">Debit Card</option>
      <option value="PayPal">PayPal</option>
      <option value="Cash">Cash</option>
    </select>
    <select name='status' id='status'>
      <option value="Pending">Pending</option>
      <option value="Completed">Completed</option>
      <option value="Failed">Failed</option>
    </select>
    <input type='submit' name='dodaj' value='Add Payment'>
  </form>
  <?php
    $conn = new mysqli("localhost", "root", "", "MedicalAppointments");
    $sql = "SELECT * FROM Payments";
    echo "<table><tr><th>ID</th><th>User ID</th><th>Appointment ID</th><th>Amount</th><th>Payment Method</th><th>Status</th><th>Payment Date</th><th>Controls</th></tr>";
    $result = $conn->query($sql);
    while($row = $result->fetch_row()){
      echo "<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td><td>$row[3]</td><td>$row[4]</td><td>$row[5]</td><td>$row[6]</td>
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
    $.post("deletePayment.php",{paymentID:id},function(res){
    location.reload();
    })
  })
  $(".update").on("click",function(){
    let id = $(this).attr("data");
    let userID = $("#userID").val();
    let appointmentID = $("#appointmentID").val();
    let amount = $("#amount").val();
    let paymentMethod = $("#paymentMethod").val();
    let status = $("#status").val();
    $.post("updatePayment.php",{paymentID:id,userID:userID,appointmentID:appointmentID,amount:amount,paymentMethod:paymentMethod,status:status},function(res){
    console.log(res);
    $("#dane >input[type!=submit]").val("");
    location.reload();
    })
  })
</script>
</html>