<?php
$conn = new mysqli("localhost", "root", "", "MedicalAppointments");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $availabilityID = $_POST['availabilityID'];
    $doctorID = $_POST['doctorID'];
    $availableDate = $_POST['availableDate'];
    $startTime = $_POST['startTime'];
    $endTime = $_POST['endTime'];

    $sql = "UPDATE DoctorAvailability SET DoctorID='$doctorID', AvailableDate='$availableDate', StartTime='$startTime', EndTime='$endTime' WHERE AvailabilityID='$availabilityID'";
    if ($conn->query($sql) === TRUE) {
        echo "Availability updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>