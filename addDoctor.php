<?php
$conn = new mysqli("localhost", "root", "", "MedicalAppointments");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phoneNumber'];
    $specializationID = $_POST['specializationID'];
    $bio = $_POST['bio'];

    $sql = "INSERT INTO Doctors (FirstName, LastName, Email, PhoneNumber, SpecializationID, Bio) VALUES ('$firstName', '$lastName', '$email', '$phoneNumber', '$specializationID', '$bio')";
    if ($conn->query($sql) === TRUE) {
        echo "New doctor added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
header("Location: doctors.php");
?>
