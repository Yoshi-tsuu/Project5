<?php
$conn = new mysqli("localhost", "root", "", "MedicalAppointments");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userID = $_POST['userID'];
    $appointmentID = $_POST['appointmentID'];
    $amount = $_POST['amount'];
    $paymentMethod = $_POST['paymentMethod'];
    $status = $_POST['status'];

    $sql = "INSERT INTO Payments (UserID, AppointmentID, Amount, PaymentMethod, Status) VALUES ('$userID', '$appointmentID', '$amount', '$paymentMethod', '$status')";
    if ($conn->query($sql) === TRUE) {
        echo "New payment added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
header("Location: payments.php");
?>