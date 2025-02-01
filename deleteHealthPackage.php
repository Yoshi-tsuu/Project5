<?php
$conn = new mysqli("localhost", "root", "", "MedicalAppointments");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $packageID = $_POST['packageID'];

    $sql = "DELETE FROM HealthPackages WHERE PackageID='$packageID'";
    if ($conn->query($sql) === TRUE) {
        echo "Health package deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>