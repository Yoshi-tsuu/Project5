<?php
$conn = new mysqli("localhost", "root", "", "MedicalAppointments");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reviewID = $_POST['reviewID'];
    $userID = $_POST['userID'];
    $doctorID = $_POST['doctorID'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    $sql = "UPDATE Reviews SET UserID='$userID', DoctorID='$doctorID', Rating='$rating', Comment='$comment' WHERE ReviewID='$reviewID'";
    if ($conn->query($sql) === TRUE) {
        echo "Review updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>