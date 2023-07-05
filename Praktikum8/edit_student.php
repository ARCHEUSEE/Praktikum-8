<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

include("connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {


    $nim = $_POST["nim"];
    $name = $_POST["name"];
    $birth_city = $_POST["birth_city"];
    $birth_date = $_POST["birth_date"];
    $faculty = $_POST["faculty"];
    $department = $_POST["department"];
    $gpa = $_POST["gpa"];


    $updateQuery = "UPDATE student SET name='$name', birth_city='$birth_city', birth_date='$birth_date', faculty='$faculty', department='$department', gpa='$gpa' WHERE nim='$nim'";
    $updateResult = mysqli_query($connection, $updateQuery);

    if ($updateResult) {

        $message = "Data mahasiswa berhasil diupdate.";
        header("Location: student_view.php?message=$message");
        exit;
    } else {
        $message = "Terjadi kesalahan saat mengupdate data mahasiswa: " . mysqli_error($connection);
        header("Location: student_view.php?message=$message");
        exit;
    }
}

if (isset($_GET["nim"])) {
    $nim = $_GET["nim"];


    $query = "SELECT * FROM student WHERE nim = '$nim'";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $student = mysqli_fetch_assoc($result);
    } else {
        $message = "Mahasiswa dengan NIM $nim tidak ditemukan.";
        header("Location: student_view.php?message=$message");
        exit;
    }
} else {
    $message = "NIM mahasiswa tidak tersedia.";
    header("Location: student_view.php?message=$message");
    exit;
}

mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Mahasiswa</title>
    <link href="assets/style.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div id="header">
            <h1 id="logo">Edit Data Mahasiswa</h1>
        </div>
        <hr>
        <nav>
            <ul>
                <li><a href="student_view.php">Tampil</a></li>
                <li><a href="student_add.php">Tambah</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>

        <h2>Edit Data Mahasiswa</h2>
        <form method="POST" action="edit_student.php">
            <input type="hidden" name="nim" value="<?php echo $nim; ?>">

            <label for="name">Nama:</label>
            <input type="text" id="name" name="name" value="<?php echo $student['name']; ?>" required><br>

            <label for="birth_city">Tempat Lahir:</label>
            <input type="text" id="birth_city" name="birth_city" value="<?php echo $student['birth_city']; ?>" required><br>

            <label for="birth_date">Tanggal Lahir:</label>
            <input type="date" id="birth_date" name="birth_date" value="<?php echo $student['birth_date']; ?>" required><br>

            <label for="faculty">Fakultas:</label>
            <input type="text" id="faculty" name="faculty" value="<?php echo $student['faculty']; ?>" required><br>

            <label for="department">Jurusan:</label>
            <input type="text" id="department" name="department" value="<?php echo $student['department']; ?>" required><br>

            <label for="gpa">IPK:</label>
            <input type="text" id="gpa" name="gpa" value="<?php echo $student['gpa']; ?>" required><br>

            <input type="submit" value="Update">
        </form>
    </div>
</body>
</html>
