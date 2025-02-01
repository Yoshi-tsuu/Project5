<?php
$conn = new mysqli("localhost", "root", "", "MedicalAppointments");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $paymentID = $_POST['paymentID'];

    $sql = "DELETE FROM Payments WHERE PaymentID='$paymentID'";
    if ($conn->query($sql) === TRUE) {
        echo "Payment deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>