<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db.php';
?>

<?php
include 'db.php';

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $course = $_POST['course'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];

    $photo = $_FILES['photo']['name'];
    $target = "uploads/" . basename($photo);

    if (move_uploaded_file($_FILES['photo']['tmp_name'], $target)) {
        $sql = "INSERT INTO students (name, course, age, gender, photo) 
                VALUES ('$name', '$course', $age, '$gender', '$target')";

        if ($conn->query($sql) === TRUE) {
            echo "Student added successfully!";
            header("Location: index.php"); 
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Failed to upload image.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
    <style>
  
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin: 10px 0 5px;
            color: #555;
        }

        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
    </style>

</head>
<body>
    <h2>Add New Student</h2>
    <form action="add.php" method="post" enctype="multipart/form-data">
    <label>Name:</label>
    <input type="text" name="name"><br>

    <label>Course:</label>
    <input type="text" name="course"><br>

    <label>Age:</label>
    <input type="number" name="age"><br>

    <label>Gender:</label>
    <select name="gender">
        <option value="Male">Male</option>
        <option value="Female">Female</option>
    </select><br>

    <label>Photo:</label>
    <input type="file" name="photo"><br>

    <input type="submit" name="submit" value="Add Student">
</form>

</body>
</html>
