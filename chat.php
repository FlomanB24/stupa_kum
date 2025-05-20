<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
ob_start();

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$host = $_ENV['DB_HOST'];
$username = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];
$dbname = $_ENV['DB_DATABASE'];

$koneksi = new mysqli($host, $username, $password, $dbname);

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    if (!isset($_SESSION['admin'])) {
        echo "Hanya admin yang dapat menghapus data.";
        exit();
    }
    $id = $_GET['id'];
    $stmt = $koneksi->prepare("DELETE FROM chatbot WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            ob_clean();
            header('Location: index.php?');
            exit();
        } else {
            echo "Terjadi kesalahan saat menghapus data: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Terjadi kesalahan pada sistem. Silakan coba lagi nanti.";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['question']) && isset($_POST['answer'])) {
    $pertanyaan = $_POST['question'];
    $jawaban = $_POST['answer'];

    $pertanyaan = htmlspecialchars($pertanyaan, ENT_QUOTES, 'UTF-8');
    $jawaban = htmlspecialchars($jawaban, ENT_QUOTES, 'UTF-8');

    $stmt = $koneksi->prepare("INSERT INTO chatbot (pertanyaan, jawaban) VALUES (?, ?)");
    if ($stmt) {
        $stmt->bind_param("ss", $pertanyaan, $jawaban);

        if ($stmt->execute()) {
            ob_clean();
            exit();
        } else {
            echo "Terjadi kesalahan saat menyimpan data: " . $stmt->error;
        }
        $stmt->close();
    } else {
        error_log("Kesalahan pada query: " . $koneksi->error);
        echo "Terjadi kesalahan pada sistem. Silakan coba lagi nanti.";
    }
} elseif (isset($_POST['isi_pesan'])) {
    $pesan = $_POST['isi_pesan'];
    $pesan = htmlspecialchars($pesan, ENT_QUOTES, 'UTF-8');

    if (empty($pesan)) {
        echo "Pesan tidak boleh kosong.";
        exit();
    }
    error_log("Pesan yang diterima: " . $pesan); // Debugging
    $stmt = $koneksi->prepare("SELECT jawaban FROM chatbot WHERE pertanyaan LIKE CONCAT('%', ?, '%') COLLATE utf8mb4_general_ci");
    if ($stmt) {
        $stmt->bind_param("s", $pesan);

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            $balasan = $data['jawaban'];
            echo $balasan;
        } else {
            echo "Maaf, saya belum menemukan jawaban yang kamu maksud, :(";
        }

        $stmt->close();
    } else {
        error_log("Kesalahan pada query: " . $koneksi->error);
        echo "Terjadi kesalahan pada sistem. Silakan coba lagi nanti.";
    }
} else {
    echo "Pesan tidak ditemukan.";
}

$koneksi->close();
ob_end_flush();
