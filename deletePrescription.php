<?php
$conn = new mysqli("localhost", "root", "", "MedicalAppointments");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prescriptionID = $_POST['prescriptionID'];

    $sql = "DELETE FROM Prescriptions WHERE PrescriptionID='$prescriptionID'";
    if ($conn->query($sql) === TRUE) {
        echo "Prescription deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>