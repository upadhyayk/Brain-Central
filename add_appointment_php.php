<?php include "db_connection.php"; ?>

<?php
echo "<script>console.log('Starting add_appointment_php.php');</script>";
session_start();

$doctor = htmlentities($_POST["appointment_doctor"]);
$appointment_time = htmlentities($_POST["appointmenttime"]);
$reminder_time = htmlentities($_POST["remindertime"]);
$appointment_type = htmlentities($_POST["appointment_type"]);

if(empty($doctor)) {
  header("Refresh: 2; url=add_appointment.php?error=Doctor is required");
  exit();
} else if (empty($appointment_time)) {
  header("Refresh: 2; url=add_appointment.php?error=Appointment Time is required");
  exit();
}

$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

if (mysqli_connect_errno()) {
  $error =  mysqli_connect_error();
  echo "<script>console.log('Could not connect to the database...');</script>";
  echo "<script>";
  echo "console.log('sql: " . json_encode($error) . "');";
  echo "</script>";

  header("Refresh: 4; url=index.php?error=Failed to connect to mysql");
}

echo "<script>console.log('Selecting db now...');</script>";

$database = mysqli_select_db($conn, DB_DATABASE);

$d = mysqli_real_escape_string($conn, $doctor);
$i = $_SESSION["id"];

$sql = "SELECT * FROM brain_central.Doctor WHERE name= '$d'";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$doctor_id = $row["id"];

echo "console.log('sql: " . json_encode($doctor_id) . "');";

$sql = "Insert into brain_central.appointment(doctor_id, patient_id, time, type, reminder) Values ('$doctor_id', '$i' ,'$appointment_time', '$appointment_type'  ,'$reminder_time')";

echo "console.log('sql: " . json_encode($sql) . "');";

if(!mysqli_query($conn, $sql)){
  echo("<p> Error inserting appointment <p>");
} else {
  echo "<script>console.log('changing screen...');</script>";
  header("Location: patient_view.php");
}