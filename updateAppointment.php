<?php
$conn = new mysqli("localhost", "root", "", "MedicalAppointments");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $appointmentID = $_POST['appointmentID'];
    $userID = $_POST['userID'];
    $doctorID = $_POST['doctorID'];
    $appointmentDate = $_POST['appointmentDate'];
    $mode = $_POST['mode'];

    $sql = "UPDATE Appointments SET UserID='$userID', DoctorID='$doctorID', AppointmentDate='$appointmentDate', Mode='$mode' WHERE AppointmentID='$appointmentID'";
    if ($conn->query($sql) === TRUE) {
        echo "Appointment updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>