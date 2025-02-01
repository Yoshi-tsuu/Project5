<?php
$conn = new mysqli("localhost", "root", "", "MedicalAppointments");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userID = $_POST['userID'];
    $packageID = $_POST['packageID'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];

    $sql = "INSERT INTO UserHealthPackages (UserID, PackageID, StartDate, EndDate) VALUES ('$userID', '$packageID', '$startDate', '$endDate')";
    if ($conn->query($sql) === TRUE) {
        echo "New user health package added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
header("Location: userHealthPackages.php");
?>