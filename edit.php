<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';

$id = $_GET['id'];

$result = $conn->query("SELECT * FROM students WHERE id=$id");
$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $course = $_POST['course'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];

    if (!empty($_FILES['new_photo']['name'])) {
        $new_photo = $_FILES['new_photo']['name'];
        $target = "uploads/" . basename($new_photo);
        move_uploaded_file($_FILES['new_photo']['tmp_name'], $target);

        $sql = "UPDATE students SET name='$name', course='$course', age=$age, gender='$gender', photo='$target' WHERE id=$id";
    } else {
        $sql = "UPDATE students SET name='$name', course='$course', age=$age, gender='$gender' WHERE id=$id";
    }

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
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
        select,
        input[type="file"] {
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

        .photo-preview {
            text-align: center;
            margin-bottom: 20px;
        }

        .photo-preview img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 10px;
        }
    </style>
</head>
<body>

<h2>Edit Student</h2>
<form method="POST" enctype="multipart/form-data">
    Name:
    <input type="text" name="name" value="<?php echo $row['name']; ?>" required><br>
    Course:
    <input type="text" name="course" value="<?php echo $row['course']; ?>" required><br>
    Age:
    <input type="number" name="age" value="<?php echo $row['age']; ?>" required><br>
    Gender:
    <select name="gender" required>
        <option value="Male" <?php if ($row['gender'] == 'Male') echo 'selected'; ?>>Male</option>
        <option value="Female" <?php if ($row['gender'] == 'Female') echo 'selected'; ?>>Female</option>
    </select><br>

    <div class="photo-preview">
        <label>Current Photo:</label><br>
        <?php if (!empty($row['photo'])): ?>
            <img src="<?php echo $row['photo']; ?>" alt="Student Photo">
        <?php else: ?>
            <p>No photo uploaded.</p>
        <?php endif; ?>
    </div>

    <label>Change Photo:</label>
    <input type="file" name="new_photo"><br>

    <input type="submit" value="Update Student">
</form>

</body>
</html>
