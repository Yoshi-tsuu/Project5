<?php
$conn = new mysqli("localhost", "root", "", "MedicalAppointments");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $doctorID = $_POST['doctorID'];
    $availableDate = $_POST['availableDate'];
    $startTime = $_POST['startTime'];
    $endTime = $_POST['endTime'];

    $sql = "INSERT INTO DoctorAvailability (DoctorID, AvailableDate, StartTime, EndTime) VALUES ('$doctorID', '$availableDate', '$startTime', '$endTime')";
    if ($conn->query($sql) === TRUE) {
        echo "New availability added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
header("Location: doctorAvailability.php");

?>