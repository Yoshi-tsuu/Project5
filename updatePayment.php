<?php
$conn = new mysqli("localhost", "root", "", "MedicalAppointments");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $paymentID = $_POST['paymentID'];
    $userID = $_POST['userID'];
    $appointmentID = $_POST['appointmentID'];
    $amount = $_POST['amount'];
    $paymentMethod = $_POST['paymentMethod'];
    $status = $_POST['status'];

    $sql = "UPDATE Payments SET UserID='$userID', AppointmentID='$appointmentID', Amount='$amount', PaymentMethod='$paymentMethod', Status='$status' WHERE PaymentID='$paymentID'";
    if ($conn->query($sql) === TRUE) {
        echo "Payment updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>