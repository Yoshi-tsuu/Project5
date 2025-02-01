<?php
$conn = new mysqli("localhost", "root", "", "MedicalAppointments");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $packageID = $_POST['packageID'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $durationMonths = $_POST['durationMonths'];

    $sql = "UPDATE HealthPackages SET Name='$name', Description='$description', Price='$price', DurationMonths='$durationMonths' WHERE PackageID='$packageID'";
    if ($conn->query($sql) === TRUE) {
        echo "Health package updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>