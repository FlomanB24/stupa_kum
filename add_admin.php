<?php
session_start();
ob_start();

if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../vendor/autoload.php'; 
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$host = $_ENV['DB_HOST'];
$username = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];
$dbname = $_ENV['DB_DATABASE'];

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $admin_username = $_POST['username'];
    $admin_password = $_POST['password'];
    if (empty($admin_username) || empty($admin_password)) {
        echo "Username dan password tidak boleh kosong.";
        exit();
    }
    $hashed_password = password_hash($admin_password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
    if ($stmt) {
        $stmt->bind_param("ss", $admin_username, $hashed_password);

        if ($stmt->execute()) {
            header('Location: index.php?success_message=Admin berhasil ditambahkan.');
            exit();
        } else {
            echo "Terjadi kesalahan saat menambahkan admin: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Terjadi kesalahan pada sistem. Silakan coba lagi nanti.";
    }
}

$conn->close();
