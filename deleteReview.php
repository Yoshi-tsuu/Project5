<?php
$conn = new mysqli("localhost", "root", "", "MedicalAppointments");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reviewID = $_POST['reviewID'];

    $sql = "DELETE FROM Reviews WHERE ReviewID='$reviewID'";
    if ($conn->query($sql) === TRUE) {
        echo "Review deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>