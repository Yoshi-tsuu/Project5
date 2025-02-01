<?php
$conn = new mysqli("localhost", "root", "", "MedicalAppointments");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userID = $_POST['userID'];
    $doctorID = $_POST['doctorID'];
    $appointmentDate = $_POST['appointmentDate'];
    $mode = $_POST['mode'];

    $sql = "INSERT INTO Appointments (UserID, DoctorID, AppointmentDate, Mode) VALUES ('$userID', '$doctorID', '$appointmentDate', '$mode')";
    if ($conn->query($sql) === TRUE) {
        echo "New appointment added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
header("Location: appointments.php");
?>