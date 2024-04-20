<?php include "db_connection.php"; ?>

<?php
echo "<script>console.log('Starting doctor.php');</script>";
session_start();

$id = htmlentities($_POST["id"]);

if(empty($id)) {
  header("Location: index.php?error=Id is required");
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

$i = mysqli_real_escape_string($conn, $id);

$sql = "SELECT * FROM brain_central.Doctor WHERE id = '$i'";

$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) === 1){
  $row = mysqli_fetch_assoc($result);
  if($row["id"] === $id) {
    echo "Logged In!";
    $_SESSION["id"] = $row["id"];
    $_SESSION["name"] = $row["name"];
    mysqli_close($conn);
    header("Location: doctor_view.php");
  } else{
    header("Location: index.php?error=Incorrect Id");
  }
} else{
  header("Location: index.php");
}
