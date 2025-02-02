<?php
$conn = new mysqli("localhost", "root", "", "MedicalAppointments");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phoneNumber'];
    $dateOfBirth = $_POST['dateOfBirth'];
    $address = $_POST['address'];

    $sql = "INSERT INTO Users (FirstName, LastName, Email, PhoneNumber, DateOfBirth, Address) VALUES ('$firstName', '$lastName', '$email', '$phoneNumber', '$dateOfBirth', '$address')";
    if ($conn->query($sql) === TRUE) {
        echo "New user added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
header("Location: users.php");

?>