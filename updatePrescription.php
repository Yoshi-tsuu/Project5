<?php
$conn = new mysqli("localhost", "root", "", "MedicalAppointments");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prescriptionID = $_POST['prescriptionID'];
    $appointmentID = $_POST['appointmentID'];
    $doctorID = $_POST['doctorID'];
    $userID = $_POST['userID'];
    $details = $_POST['details'];

    $sql = "UPDATE Prescriptions SET AppointmentID='$appointmentID', DoctorID='$doctorID', UserID='$userID', Details='$details' WHERE PrescriptionID='$prescriptionID'";
    if ($conn->query($sql) === TRUE) {
        echo "Prescription updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>