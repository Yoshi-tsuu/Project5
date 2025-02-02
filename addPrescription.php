<?php
$conn = new mysqli("localhost", "root", "", "MedicalAppointments");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $appointmentID = $_POST['appointmentID'];
    $doctorID = $_POST['doctorID'];
    $userID = $_POST['userID'];
    $details = $_POST['details'];

    $sql = "INSERT INTO Prescriptions (AppointmentID, DoctorID, UserID, Details) VALUES ('$appointmentID', '$doctorID', '$userID', '$details')";
    if ($conn->query($sql) === TRUE) {
        echo "New prescription added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
header("Location: prescriptions.php");
?>
