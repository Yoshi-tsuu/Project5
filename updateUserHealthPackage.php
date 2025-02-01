<?php
$conn = new mysqli("localhost", "root", "", "MedicalAppointments");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $subscriptionID = $_POST['subscriptionID'];
    $userID = $_POST['userID'];
    $packageID = $_POST['packageID'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];

    $sql = "UPDATE UserHealthPackages SET UserID='$userID', PackageID='$packageID', StartDate='$startDate', EndDate='$endDate' WHERE SubscriptionID='$subscriptionID'";
    if ($conn->query($sql) === TRUE) {
        echo "User health package updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>