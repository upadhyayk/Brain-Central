<!DOCTYPE html>
<html>
<head>
    <title> Login </title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <form action="add_appointment_php.php" method="post">
        <h2>Add Appointment</h2>
        <?php if(isset($_GET['error'])) { ?>
            <p class="error"> <?php echo $_GET["error"]; ?></p>
        <?php } ?>
        <label>Appointment Type</label>
        <select id="appointment_type" name="appointment_type">
                <option value="MRI Scan">MRI Scan</option>
                <option value="Follow Up">Follow Up</option>
                <option value = "Surgery">Surgery</option>
        </select><br>
        <label>Doctor:</label>
        <select id="appointment_doctor" name="appointment_doctor">
                <option value="Davis">Davis</option>
                <option value="Hamming">Hamming</option>
        </select><br>
        <label>Appointment Time</label>
        <input type="datetime-local" id="appointmenttime" name="appointmenttime"><br>
        <label>Reminder</label>
        <input type="datetime-local" id="remindertime" name="remindertime"><br>

        <button type="submit">Add</button>
    </form>
</body>
</html>