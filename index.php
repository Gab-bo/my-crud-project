<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Student List</title>
    <link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
    <h2>Student Records</h2>
    <a href="add.php">Add New Student</a>
    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th><th>Name</th><th>Course</th><th>Age</th><th>Gender</th><th>Action</th>
        </tr>
        <?php
        $result = $conn->query("SELECT * FROM students");
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['name']}</td>
                <td>{$row['course']}</td>
                <td>{$row['age']}</td>
                <td>{$row['gender']}</td>
                <td>
                    <a href='edit.php?id={$row['id']}'>Edit</a> |
                    <a href='delete.php?id={$row['id']}' onclick=\"return confirm('Delete this record?')\">Delete</a>
                </td>
            </tr>";
        }
        ?>
    </table>
</body>
</html>
