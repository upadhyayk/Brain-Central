<?php include "db_connection.php"; ?>

<?php
session_start();

if(isset($_SESSION["id"])) {
    ?>

    <!DOCTYPE html>
    <html>
	<head>
            <title>Welcome <?php echo $_SESSION["name"]; ?></title>
            <link rel="stylesheet" type="text/css" href="style.css">
        </head>
        <body>
            <h1>Welcome <?php echo $_SESSION["name"]; ?></h1>
            <h2>Appointments</h2>
            <table border="1" cellpadding="2" cellspacing="2">
            <tr><td>Doctor</td><td>Time</td><td>Type</td><td>Reminder</td></tr>
            <?php
             echo "<script>console.log('Connecting to db now...');</script>";
             $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
             $server = DB_SERVER;
             if (mysqli_connect_errno()) {
               $error =  mysqli_connect_error();
               echo "<script>";
               echo "console.log('sql: " . json_encode($server) . "');";
               echo "</script>";

               header("Refresh: 4; url=index.php?error=Failed to connect to mysql");
             }

             $database = mysqli_select_db($conn, DB_DATABASE);
             $id = $_SESSION["id"];
             $sql = "Select Doctor.name as doctor, appointment.time, appointment.type, appointment.reminder from brain_central.appointment inner join brain_central.Doctor on $

             echo "<script>console.log('Running sql script now...');</script>";
             $result = mysqli_query($conn, $sql);

             while($query_data = mysqli_fetch_row($result)) {
                echo "<script>console.log('in while loop...');</script>";
                echo "<tr>";
                echo "<td>",$query_data[0], "</td>",
                "<td>",$query_data[1], "</td>",
                "<td>",$query_data[2], "</td>",
                "<td>",$query_data[3], "</td>";
                echo "</tr>";
              }

            ?>
            </table>
            <h2>MRIs</h2>
            <table border="1" cellpadding="2" cellspacing="2">
            <tr><td>Doctor</td><td>Scan Type</td><td>Scan</td></tr>
            <?php
             $sql = "Select Doctor.name as doctor, scans.scantype, scans.scan from brain_central.scans inner join brain_central.Doctor on scans.doctor_id = Doctor.id where pa$

             echo "<script>console.log('Running mri sql script now...');</script>";
             $result = mysqli_query($conn, $sql);
             $target_dir = "scans/";

             while($query_data = mysqli_fetch_row($result)) {
                $source_file = $target_dir . $query_data[2];
                echo "<tr>";
                echo "<td>",$query_data[0], "</td>",
                "<td>",$query_data[1], "</td>",
                "<td><img src='",$source_file, "'alt = 'uploaded image' style='max-width: 100px; max-height:100px;'></td>";
                echo "</tr>";
              }

            ?>
            </table>
            <h2>Overview</h2>
            <table border="1" cellpadding="2" cellspacing="2">
            <tr><td>Diagnosis</td><td>Visit Notes</td><td>Next Steps</td></tr>
            <?php
             $sql = "Select diagnosis, visit_notes, next_steps from brain_central.patient where id='$id'";

             echo "<script>console.log('Running overview sql script now...');</script>";
             $result = mysqli_query($conn, $sql);

             while($query_data = mysqli_fetch_row($result)) {
                echo "<tr>";
                echo "<td>",$query_data[0],"</td>",
                "<td>",$query_data[1],"</td>",
                "<td>",$query_data[2], "</td>";
                echo "</tr>";
              }
            ?>
            </table>

            <a href="logout.php">Logout</a>
            </body>
    </html>

    <?php
} else {
    header("Location: index.php");
}
