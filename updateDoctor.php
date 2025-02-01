<?php
$conn = new mysqli("localhost", "root", "", "MedicalAppointments");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $doctorID = $_POST['doctorID'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phoneNumber'];
    $specializationID = $_POST['specializationID'];
    $bio = $_POST['bio'];

    $sql = "UPDATE Doctors SET FirstName='$firstName', LastName='$lastName', Email='$email', PhoneNumber='$phoneNumber', SpecializationID='$specializationID', Bio='$bio' WHERE DoctorID='$doctorID'";
    if ($conn->query($sql) === TRUE) {
        echo "Doctor updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>