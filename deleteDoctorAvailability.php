<?php
$conn = new mysqli("localhost", "root", "", "MedicalAppointments");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $availabilityID = $_POST['availabilityID'];

    $sql = "DELETE FROM DoctorAvailability WHERE AvailabilityID='$availabilityID'";
    if ($conn->query($sql) === TRUE) {
        echo "Availability deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>