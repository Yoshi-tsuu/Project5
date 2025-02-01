<?php
$conn = new mysqli("localhost", "root", "", "MedicalAppointments");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $specializationID = $_POST['specializationID'];
    $name = $_POST['name'];
    $description = $_POST['description'];

    $sql = "UPDATE Specializations SET Name='$name', Description='$description' WHERE SpecializationID='$specializationID'";
    if ($conn->query($sql) === TRUE) {
        echo "Specialization updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>