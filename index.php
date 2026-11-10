<?php
include "db.php";

$message = "";

if (isset($_POST['submit'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $department = $_POST['department'];
    $salary = $_POST['salary'];

    $sql = "INSERT INTO employees
    (name, email, phone, gender, department, salary)
    VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "sssssd",
        $name,
        $email,
        $phone,
        $gender,
        $department,
        $salary
    );

    if (mysqli_stmt_execute($stmt)) {
        $message = "Employee Details Saved Successfully!";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employee Details Form</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

    <h2>Employee Registration Form</h2>

    <p class="message">
        <?php echo htmlspecialchars($message); ?>
    </p>

    <form method="POST">

        <label>Employee Name</label>
        <input type="text" name="name" required>

        <label>Email Address</label>
        <input type="email" name="email" required>

        <label>Phone Number</label>
        <input type="text" name="phone" required>

        <label>Gender</label>
        <select name="gender" required>
            <option value="">Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
        </select>

        <label>Department</label>
        <input type="text" name="department" required>

        <label>Salary</label>
        <input type="number" name="salary"
               step="0.01" min="0" required>

        <button type="submit" name="submit">
            Submit Details
        </button>

    </form>

    <h2>Employee Records</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Gender</th>
            <th>Department</th>
            <th>Salary</th>
        </tr>

        <?php

        $result = mysqli_query(
            $conn,
            "SELECT * FROM employees ORDER BY id DESC"
        );

        while ($row = mysqli_fetch_assoc($result)) {

        ?>

        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo htmlspecialchars($row['phone']); ?></td>
            <td><?php echo htmlspecialchars($row['gender']); ?></td>
            <td><?php echo htmlspecialchars($row['department']); ?></td>
            <td><?php echo htmlspecialchars($row['salary']); ?></td>
        </tr>

        <?php } ?>

    </table>

</div>

</body>
</html>