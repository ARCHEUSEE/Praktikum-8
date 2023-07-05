<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

include("connection.php");

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["nim"])) {
    $nim = $_GET["nim"];

    $deleteQuery = "DELETE FROM student WHERE nim='$nim'";
    $deleteResult = mysqli_query($connection, $deleteQuery);

    if ($deleteResult) {
        $message = "Data mahasiswa dengan NIM $nim berhasil dihapus.";
    } else {
        $message = "Terjadi kesalahan saat menghapus data mahasiswa: " . mysqli_error($connection);
    }

    header("Location: student_view.php?message=$message");
    exit;
} else {
    $message = "NIM mahasiswa tidak tersedia.";
    header("Location: student_view.php?message=$message");
    exit;
}

mysqli_close($connection);
?>
