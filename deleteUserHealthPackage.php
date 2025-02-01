<?php
$conn = new mysqli("localhost", "root", "", "MedicalAppointments");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subscriptionID = $_POST['subscriptionID'];

    $sql = "DELETE FROM UserHealthPackages WHERE SubscriptionID='$subscriptionID'";
    if ($conn->query($sql) === TRUE) {
        echo "User health package deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>