<?php
$conn = new mysqli("localhost", "root", "", "MedicalAppointments");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $appointmentID = $_POST['appointmentID'];

    $sql = "DELETE FROM Appointments WHERE AppointmentID='$appointmentID'";
    if ($conn->query($sql) === TRUE) {
        echo "Appointment deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>