<?php
$conn = new mysqli("localhost", "root", "", "MedicalAppointments");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $durationMonths = $_POST['durationMonths'];

    $sql = "INSERT INTO HealthPackages (Name, Description, Price, DurationMonths) VALUES ('$name', '$description', '$price', '$durationMonths')";
    if ($conn->query($sql) === TRUE) {
        echo "New health package added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
header("Location: healthPackages.php");
?>