<?php
$conn = new mysqli("localhost", "root", "", "MedicalAppointments");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $doctorID = $_POST['doctorID'];

    $sql = "DELETE FROM Doctors WHERE DoctorID='$doctorID'";
    if ($conn->query($sql) === TRUE) {
        echo "Doctor deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>