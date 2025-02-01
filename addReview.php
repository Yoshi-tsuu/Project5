<?php
$conn = new mysqli("localhost", "root", "", "MedicalAppointments");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userID = $_POST['userID'];
    $doctorID = $_POST['doctorID'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    $sql = "INSERT INTO Reviews (UserID, DoctorID, Rating, Comment) VALUES ('$userID', '$doctorID', '$rating', '$comment')";
    if ($conn->query($sql) === TRUE) {
        echo "New review added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
header("Location: reviews.php");
?>