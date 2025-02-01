<?php
$conn = new mysqli("localhost", "root", "", "MedicalAppointments");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $specializationID = $_POST['specializationID'];

    $sql = "DELETE FROM Specializations WHERE SpecializationID='$specializationID'";
    if ($conn->query($sql) === TRUE) {
        echo "Specialization deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>