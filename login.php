<?php include "db_connection.php"; ?>

<?php
echo "<script>console.log('Starting login.php');</script>";
session_start();

$uname = htmlentities($_POST["uname"]);
$password = htmlentities($_POST["password"]);

if(empty($uname)) {
  header("Refresh: 2; url=index.php?error=Username is required");
  exit();
} else if (empty($password)) {
  header("Refresh: 2; url=index.php?error=Password is required");
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

$n = mysqli_real_escape_string($conn, $uname);
$p = mysqli_real_escape_string($conn, $password);

$sql = "SELECT * FROM brain_central.patient WHERE username= '$n' AND password = '$p'";

echo "<script>";
echo "console.log('sql: " . json_encode($n) . "');"; // Encoding in JSON to handle special characters
echo "</script>";

echo "<script>console.log('Running sql query...');</script>";

$result = mysqli_query($conn, $sql);

$row_num = mysqli_num_rows($result);

echo "<script>";
echo "console.log('sql: " . json_encode($row_num) . "');"; // Encoding in JSON to handle special characters
echo "</script>";

if(mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    echo "<script>";
    echo "console.log('sql: " . json_encode($row[username]) . "');"; // Encoding in JSON to handle special characters
    echo "</script>";
    if($row["username"] === $uname && $row["password"] === $password){
      $_SESSION["name"] = $row["name"];
      $_SESSION["id"] = $row["doctor_id"];
      $_SESSION["username"] = $row["username"];
      mysqli_close($conn);
      header("Refresh:4; url=patient_view.php");
    }else {
      header("Refresh:4; url=index.php?error=Incorrect username or password");
    }
  } else {
    header("Refresh: 4; url=index.php?error=num rows != 1");
  }
  