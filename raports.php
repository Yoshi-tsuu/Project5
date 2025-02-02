<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reports</title>
  <link rel="stylesheet" href="css/css.css">
  <style>
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }
    th, td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: left;
    }
    th {
      background-color: #f2f2f2;
    }
  </style>
</head>
<body>
  <a href="Index.html">Powrót do strony głównej</a>
  <h1>Reports</h1>

  <?php
  $conn = new mysqli("localhost", "root", "", "MedicalAppointments");

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Query 1: Doctors with above-average reviews
  echo "<h2>1. Lekarze z powyżej średniej liczby opinii</h2>";
  $query1 = "
    WITH AvgReviews AS (
        SELECT AVG(TotalReviews) AS AvgReviewCount
        FROM (
            SELECT DoctorID, COUNT(*) AS TotalReviews
            FROM reviews
            GROUP BY DoctorID
        ) AS ReviewCounts
    )
    SELECT d.DoctorID, 
           d.FirstName, 
           d.LastName, 
           COUNT(r.ReviewID) AS TotalReviews
    FROM doctors d
    JOIN reviews r ON d.DoctorID = r.DoctorID
    GROUP BY d.DoctorID
    HAVING TotalReviews > (SELECT AvgReviewCount FROM AvgReviews)
    ORDER BY TotalReviews DESC;
  ";
  $result1 = $conn->query($query1);
  if ($result1->num_rows > 0) {
    echo "<table><tr><th>Doctor ID</th><th>First Name</th><th>Last Name</th><th>Total Reviews</th></tr>";
    while($row = $result1->fetch_assoc()) {
      echo "<tr><td>{$row['DoctorID']}</td><td>{$row['FirstName']}</td><td>{$row['LastName']}</td><td>{$row['TotalReviews']}</td></tr>";
    }
    echo "</table>";
  } else {
    echo "<p>No results found.</p>";
  }

  // Query 2: List of users and active health subscriptions (or lack thereof)
  echo "<h2>2. Lista użytkowników i aktywne subskrypcje zdrowotne (lub jej brak)</h2>";
  $query2 = "
    SELECT u.UserID, u.FirstName, u.LastName, h.Name AS PackageName, uh.StartDate, uh.EndDate
    FROM users u
    JOIN userhealthpackages uh ON u.UserID = uh.UserID
    JOIN healthpackages h ON uh.PackageID = h.PackageID
    WHERE uh.EndDate >= CURDATE()
    UNION
    SELECT u.UserID, u.FirstName, u.LastName, 'Brak aktywnej subskrypcji' AS PackageName, NULL AS StartDate, NULL AS EndDate
    FROM users u
    WHERE u.UserID NOT IN (SELECT UserID FROM userhealthpackages WHERE EndDate >= CURDATE())
    ORDER BY UserID;
  ";
  $result2 = $conn->query($query2);
  if ($result2->num_rows > 0) {
    echo "<table><tr><th>User ID</th><th>First Name</th><th>Last Name</th><th>Package Name</th><th>Start Date</th><th>End Date</th></tr>";
    while($row = $result2->fetch_assoc()) {
      echo "<tr><td>{$row['UserID']}</td><td>{$row['FirstName']}</td><td>{$row['LastName']}</td><td>{$row['PackageName']}</td><td>{$row['StartDate']}</td><td>{$row['EndDate']}</td></tr>";
    }
    echo "</table>";
  } else {
    echo "<p>No results found.</p>";
  }

  // Query 3: List of doctors available on a specific day with their specializations
  echo "<h2>3. Lista lekarzy dostępnych danego dnia z ich specjalizacjami</h2>";
  $query3 = "
    SELECT d.DoctorID, 
           d.FirstName, 
           d.LastName, 
           s.Name AS Specialization, 
           da.AvailableDate, 
           da.StartTime, 
           da.EndTime
    FROM doctors d
    JOIN specializations s ON d.SpecializationID = s.SpecializationID
    JOIN doctoravailability da ON d.DoctorID = da.DoctorID
    WHERE da.AvailableDate = (SELECT CURDATE())
    ORDER BY da.StartTime;
  ";
  $result3 = $conn->query($query3);
  if ($result3->num_rows > 0) {
    echo "<table><tr><th>Doctor ID</th><th>First Name</th><th>Last Name</th><th>Specialization</th><th>Available Date</th><th>Start Time</th><th>End Time</th></tr>";
    while($row = $result3->fetch_assoc()) {
      echo "<tr><td>{$row['DoctorID']}</td><td>{$row['FirstName']}</td><td>{$row['LastName']}</td><td>{$row['Specialization']}</td><td>{$row['AvailableDate']}</td><td>{$row['StartTime']}</td><td>{$row['EndTime']}</td></tr>";
    }
    echo "</table>";
  } else {
    echo "<p>No results found.</p>";
  }

  // Query 4: Average rating of doctors with the number of reviews
  echo "<h2>4. Średnia ocena lekarzy z liczbą opinii</h2>";
  $query4 = "
    SELECT d.DoctorID, 
           d.FirstName, 
           d.LastName, 
           IFNULL(AVG(r.Rating), 0) AS AverageRating, 
           COUNT(r.ReviewID) AS TotalReviews
    FROM doctors d
    LEFT JOIN reviews r ON d.DoctorID = r.DoctorID
    GROUP BY d.DoctorID
    ORDER BY AverageRating DESC, TotalReviews DESC;
  ";
  $result4 = $conn->query($query4);
  if ($result4->num_rows > 0) {
    echo "<table><tr><th>Doctor ID</th><th>First Name</th><th>Last Name</th><th>Average Rating</th><th>Total Reviews</th></tr>";
    while($row = $result4->fetch_assoc()) {
      echo "<tr><td>{$row['DoctorID']}</td><td>{$row['FirstName']}</td><td>{$row['LastName']}</td><td>{$row['AverageRating']}</td><td>{$row['TotalReviews']}</td></tr>";
    }
    echo "</table>";
  } else {
    echo "<p>No results found.</p>";
  }

  // Query 5: List of scheduled appointments with doctor and patient information
  echo "<h2>5. Lista zaplanowanych wizyt z informacjami o lekarzach i pacjentach</h2>";
  $query5 = "
    WITH ScheduledAppointments AS (
        SELECT * FROM appointments WHERE Status = 'Scheduled'
    )
    SELECT sa.AppointmentID, 
           u.FirstName AS PatientFirstName, 
           u.LastName AS PatientLastName,
           d.FirstName AS DoctorFirstName, 
           d.LastName AS DoctorLastName,
           sa.AppointmentDate, 
           sa.Mode
    FROM ScheduledAppointments sa
    JOIN users u ON sa.UserID = u.UserID
    JOIN doctors d ON sa.DoctorID = d.DoctorID
    ORDER BY sa.AppointmentDate ASC;
  ";
  $result5 = $conn->query($query5);
  if ($result5->num_rows > 0) {
    echo "<table><tr><th>Appointment ID</th><th>Patient First Name</th><th>Patient Last Name</th><th>Doctor First Name</th><th>Doctor Last Name</th><th>Appointment Date</th><th>Mode</th></tr>";
    while($row = $result5->fetch_assoc()) {
      echo "<tr><td>{$row['AppointmentID']}</td><td>{$row['PatientFirstName']}</td><td>{$row['PatientLastName']}</td><td>{$row['DoctorFirstName']}</td><td>{$row['DoctorLastName']}</td><td>{$row['AppointmentDate']}</td><td>{$row['Mode']}</td></tr>";
    }
    echo "</table>";
  } else {
    echo "<p>No results found.</p>";
  }

  $conn->close();
  ?>
</body>
</html>