<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '/../vendor/autoload.php'; 
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../'); 
$dotenv->load();

$host = $_ENV['DB_HOST'];
$username = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];
$database = $_ENV['DB_DATABASE'];

if (isset($_GET['success_message'])) {
    $success_message = $_GET['success_message'];
    echo "
    <script type='text/javascript'>
        document.addEventListener('DOMContentLoaded', function() {
            var successMessage = document.getElementById('successMessage');
            successMessage.innerHTML = decodeURIComponent('$success_message');
            var successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
            const url = new URL(window.location);
            url.searchParams.delete('success_message');
            window.history.replaceState({}, document.title, url);
        });
    </script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="style.css" />
    <title>PUSPAS | STUPA</title>
</head>

<body id="home">
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm fixed-top" style="background-color: #255a8b">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="img/projects/stupa.png" alt="" width="30" height="24" class="d-inline-block align-text-top rounded-circle img-thumbnail" id="padding-img" />
                STUPA
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto nav-spacing">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#projects">Kobilem</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#gallery">Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#register">Register</a>
                    </li>
                    <?php if (isset($_SESSION['admin'])) : ?>
                        <li class="nav-item">
                            <a class="btn nav-link" href="logout.php">Logout</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Success</h5>
                </div>
                <div class="modal-body">
                    Data berhasil ditambahkan.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Success</h5>
                </div>
                <div class="modal-body" id="successMessage">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
    <section class="jumbotron text-center" id="home">
        <img src="img/projects/stupa.png" alt="logo stupa" width="200" class="rounded-circle img-thumbnail" />
        <h1 class="display-4" style="font-size: 35px; font-weight: normal">STUDI PASTORAL AKHIR PEKAN</h1>
        <h6 class="display-4" style="font-size: 20px; font-weight: normal">PUSPAS KEUSKUPAN MAUMERE</h6>
        <p class="lead mb-5"></p>
        <p data-aos="fade-in" data-aos-delay="2000">Selamat Datang Para Peserta STUPA</p>
        <a type="button" class="btn btn-primary px-5" role="button" href="" target="_blank" data-aos="fade-in" data-aos-delay="2500">Login</a>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="bottom-svg">
            <path fill="#ffff" fill-opacity="1" d="M0,32L48,69.3C96,107,192,181,288,197.3C384,213,480,171,576,128C672,85,768,43,864,53.3C960,64,1056,128,1152,138.7C1248,149,1344,107,1392,85.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
    </section>
    <?php if (isset($_SESSION['admin'])) : ?>
        <div class="row justify-content-center align-items-center h-100">
            <div class="col-md-4 col-sm-12 mb-3">
                <div class="container form-container my-5">
                    <div class="card" style="width: 30rem">
                        <div class="form-box">
                            <h2 class="text-center py-3">Tambah Admin Baru</h2>
                            <form method="post" action="add_admin.php">
                                <div class="form-outline mb-4">
                                    <input type="text" id="username" name="username" class="form-control" required />
                                    <label class="form-label" for="username">Username</label>
                                </div>
                                <div class="form-outline mb-4">
                                    <input type="password" id="password" name="password" class="form-control" required />
                                    <label class="form-label" for="password">Password</label>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary btn-block mb-4">Tambah Admin</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 mb-3">
                <div class="container form-container">
                    <div class="card" style="width: 30rem">
                        <div class="form-box">
                            <h2 class="text-center py-3">Input Data Chatbot</h2>
                            <form method="post" action="chat.php">
                                <div class="form-outline mb-4">
                                    <input type="text" id="question" name="question" class="form-control" required />
                                    <label class="form-label" for="question">Question</label>
                                </div>
                                <div class="form-outline mb-4">
                                    <input type="text" id="answer" name="answer" class="form-control" required />
                                    <label class="form-label" for="answer">Answer</label>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary btn-block mb-4">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container my-5">
            <h2>Data Chatbot</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pertanyaan</th>
                        <th>Jawaban</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $conn = new mysqli($host, $username, $password, $database);
                    if ($conn->connect_error) {
                        die("Koneksi gagal: " . $conn->connect_error);
                    }

                    $sql = "SELECT id, pertanyaan, jawaban FROM chatbot";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        $no = 1;
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $no . "</td>";
                            echo "<td>" . htmlspecialchars($row['pertanyaan']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['jawaban']) . "</td>";
                            echo '<td><a href="chat.php?action=delete&id=' . $row['id'] . '" class="btn btn-danger" onclick="return confirmDelete();">Delete</a></td>';
                            echo "</tr>";
                            $no++;
                        }
                    } else {
                        echo "<tr><td colspan='4' class='text-center'>Tidak ada data</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
    <section id="about" class="bg-image" data-aos="fade-up">
        <div class="container">
            <div class="row text-center mb-3">
                <div class="col">
                    <h2>About STUPA</h2>
                </div>
            </div>
            <div class="row justify-content-center fs-5 text-center">
                <div class="col-md-4 text-justify" data-aos="fade-right">
                    <p class="text-justify">
                        STUPA (Studi Pastoral Akhir Pekan) adalah sebuah program edukasi dan formasi pastoral yang dirancang oleh Pusat Pastoral Keuskupan Maumere untuk memberikan kesempatan belajar kepada umat dan pelayan pastoral di Keuskupan
                        Maumere. Program ini bertujuan untuk meningkatkan pengetahuan dan pemahaman peserta mengenai berbagai aspek teologi, kitab suci, filsafat, serta isu-isu pastoral dan aktual lainnya yang relevan dengan kehidupan menggereja.
                        STUPA didirikan dengan tujuan menyediakan platform pembelajaran yang terstruktur dan mendalam bagi umat yang tidak mendapatkan pendidikan teologi formal seperti para imam. Nama "Studi" dipilih untuk memberikan kesan yang lebih
                        informal dan inklusif dibandingkan "kursus". Program ini awalnya dilaksanakan secara tatap muka, mengundang umat dan pelayan pastoral untuk mengikuti presentasi dan diskusi. Selama pandemi COVID-19, STUPA beralih ke model
                        online menggunakan Zoom dan live streaming di YouTube, yang memungkinkan cakupan peserta yang lebih luas.
                    </p>
                </div>
                <div class="col-md-4" data-aos="fade-left" data-aos-delay="200">
                    <p class="text-justify">
                        Dengan metode hybrid, STUPA dapat diakses oleh peserta dari berbagai lokasi, termasuk mereka yang tidak dapat hadir secara fisik. Tema-tema yang diangkat dalam STUPA mencakup isu-isu teologi, kitab suci, hukum gereja,
                        keluarga, ekonomi, serta dokumen-dokumen gereja yang penting. Program ini menekankan pentingnya diskusi dan interaksi antara peserta dan narasumber untuk memperkaya proses pembelajaran. Transformasi ke dalam format Learning
                        Management System (LMS) merupakan langkah strategis untuk meningkatkan fleksibilitas, aksesibilitas, dan partisipasi peserta dalam pembelajaran. LMS memungkinkan peserta mengakses materi kapan saja dan di mana saja,
                        mendokumentasikan materi dalam bentuk video dan bahan ajar digital, serta menyediakan evaluasi dan sertifikasi untuk mengukur pemahaman peserta dan meningkatkan kualitas program.
                    </p>
                </div>
            </div>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="top-svg">
            <path fill="#e2edff" fill-opacity="1" d="M0,192L48,170.7C96,149,192,107,288,106.7C384,107,480,149,576,154.7C672,160,768,128,864,144C960,160,1056,224,1152,229.3C1248,235,1344,181,1392,154.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
    </section>
    <section id="projects">
        <div class="container">
            <div class="row text-center mb-3">
                <div class="col">
                    <h2>Project</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-4 mb-3">
                    <div class="card" data-aos="flip-left" data-aos-duration="500">
                        <div class="card-body">
                            <h5 class="card-title">KOMISI</h5>
                            <p class="card-text">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec vel egestas dolor, nec dignissim metus. Donec augue elit, rhoncus ac sodales id, porttitor vitae est. Donec laoreet rutrum libero sed pharetra. Duis a arcu
                                convallis, gravida purus eget, mollis diam. Praesent non urna non mauris laoreet ultricies eget at enim. Phasellus lacus odio, ullamcorper ac ipsum in, tincidunt tincidunt massa. Suspendisse ut malesuada sapien, vitae
                                mollis diam. Suspendisse tristique et ex non faucibus. Pellentesque a urna risus. Ut non enim finibus, tempus dui eget, tincidunt sem. Phasellus sed mauris elit. Pellentesque condimentum lorem vitae justo congue, ut semper
                                nisi gravida. Sed viverra nibh eget tincidunt convallis. In egestas non tortor at tempor. Nullam maximus mi ac pharetra dictum.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card" data-aos="flip-left" data-aos-duration="500" data-aos-delay="100">
                        <div class="card-body">
                            <h5 class="card-title">BIRO</h5>
                            <p class="card-text">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec vel egestas dolor, nec dignissim metus. Donec augue elit, rhoncus ac sodales id, porttitor vitae est. Donec laoreet rutrum libero sed pharetra. Duis a arcu
                                convallis, gravida purus eget, mollis diam. Praesent non urna non mauris laoreet ultricies eget at enim. Phasellus lacus odio, ullamcorper ac ipsum in, tincidunt tincidunt massa. Suspendisse ut malesuada sapien, vitae
                                mollis diam. Suspendisse tristique et ex non faucibus. Pellentesque a urna risus. Ut non enim finibus, tempus dui eget, tincidunt sem. Phasellus sed mauris elit. Pellentesque condimentum lorem vitae justo congue, ut semper
                                nisi gravida. Sed viverra nibh eget tincidunt convallis. In egestas non tortor at tempor. Nullam maximus mi ac pharetra dictum.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card" data-aos="flip-left" data-aos-duration="500" data-aos-delay="200">
                        <div class="card-body">
                            <h5 class="card-title">LEMBAGA</h5>
                            <p class="card-text">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec vel egestas dolor, nec dignissim metus. Donec augue elit, rhoncus ac sodales id, porttitor vitae est. Donec laoreet rutrum libero sed pharetra. Duis a arcu
                                convallis, gravida purus eget, mollis diam. Praesent non urna non mauris laoreet ultricies eget at enim. Phasellus lacus odio, ullamcorper ac ipsum in, tincidunt tincidunt massa. Suspendisse ut malesuada sapien, vitae
                                mollis diam. Suspendisse tristique et ex non faucibus. Pellentesque a urna risus. Ut non enim finibus, tempus dui eget, tincidunt sem. Phasellus sed mauris elit. Pellentesque condimentum lorem vitae justo congue, ut semper
                                nisi gravida. Sed viverra nibh eget tincidunt convallis. In egestas non tortor at tempor. Nullam maximus mi ac pharetra dictum.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#ffff" fill-opacity="1" d="M0,192L48,181.3C96,171,192,149,288,149.3C384,149,480,171,576,160C672,149,768,107,864,117.3C960,128,1056,192,1152,229.3C1248,267,1344,277,1392,282.7L1440,288L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
    </section>
    <section id="gallery">
        <div class="container">
            <div class="row text-center mb-3">
                <div class="col">
                    <h2>Gallery</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-3">
                    <a href="#">
                        <img src="img/gallery/thumbnail/1.jpg" alt="Gambar 1" class="img-fluid" />
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="#">
                        <img src="img/gallery/thumbnail/2.jpg" alt="Gambar 2" class="img-fluid" />
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="#">
                        <img src="img/gallery/thumbnail/3.jpg" alt="Gambar 3" class="img-fluid gallery-img" />
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="#">
                        <img src="img/gallery/thumbnail/4.jpg" alt="Gambar 4" class="img-fluid gallery-img" />
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="#">
                        <img src="img/gallery/thumbnail/5.jpg" alt="Gambar 5" class="img-fluid gallery-img" />
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="#">
                        <img src="img/gallery/thumbnail/6.jpg" alt="Gambar 6" class="img-fluid gallery-img" />
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="#">
                        <img src="img/gallery/thumbnail/7.jpg" alt="Gambar 7" class="img-fluid gallery-img" />
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="#">
                        <img src="img/gallery/thumbnail/8.jpg" alt="Gambar 8" class="img-fluid gallery-img" />
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="#">
                        <img src="img/gallery/thumbnail/9.jpg" alt="Gambar 9" class="img-fluid gallery-img" />
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="#">
                        <img src="img/gallery/thumbnail/10.jpg" alt="Gambar 10" class="img-fluid gallery-img" />
                    </a>
                </div>
            </div>
        </div>
    </section>
    <section id="register">
        <div class="container">
            <div class="row text-center mb-3">
                <div class="col">
                    <h2>Register</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="alert alert-success alert-dismissible fade show d-none my-alert" role="alert">
                        <strong>Terimakasih!</strong> Pendaftaran anda sudah terkirim.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <form name="submit-to-google-sheet">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama" aria-describedby="nama" name="nama" />
                        </div>
                        <div class="mb-3">
                            <label for="paroki" class="form-label">Paroki</label>
                            <input type="text" class="form-control" id="paroki" aria-describedby="paroki" name="paroki" />
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" aria-describedby="email" name="email" />
                        </div>
                        <div class="mb-3">
                            <label for="hp" class="form-label">No Handphone</label>
                            <input type="text" class="form-control" id="hp" aria-describedby="hp" name="hp" />
                        </div>
                        <button type="submit" class="btn btn-primary btn-kirim">Kirim</button>

                        <button class="btn btn-primary btn-loading d-none" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        </button>
                    </form>
                    <div class="mt-3 text-center">
                        <p>Sudah punya akun? <a href="" target="_blank">Login</a></p>
                    </div>
                </div>
            </div>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#255a8b" fill-opacity="1" d="M0,288L48,277.3C96,267,192,245,288,224C384,203,480,181,576,192C672,203,768,245,864,234.7C960,224,1056,160,1152,165.3C1248,171,1344,245,1392,282.7L1440,320L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
    </section>
    <footer class="text-white text-center pb-5" style="background-color: #255a8b; position: relative">
        <p>Created with <i class="bi bi-brightness-high text-warning"></i> By <a href="https://www.google.com" class="text-white fw-bold">Rolly Davinsi</a></p>
    </footer>
    <script>
        function confirmDelete() {
            console.log("Fungsi confirmDelete dipanggil");
            return confirm("Apakah Anda yakin ingin menghapus data ini?");
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
            duration: 2000,
        });
        const galleryImage = document.querySelectorAll('.gallery-img');
        galleryImage.forEach((img, i) => {
            img.dataset.aos = 'fade-down';
            img.dataset.aosDelay = i * 100;
            img.dataset.aosDuration = 1000;
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/TextPlugin.min.js"></script>
    <script src="script.js"></script>
    <div id="chatbot-icon">
        <img src="img/projects/chatbot.png" alt="Chatbot" class="chatbot-img" />
    </div>
    <div id="chatbot-box" class="d-none">
        <div class="wrapper">
            <div class="title">STUPABOT</div>
            <div class="form">
                <div class="bot-inbox inbox">
                    <div class="icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="msg-header">
                        <p>Hai, ada yang bisa saya bantu?</p>
                    </div>
                </div>
            </div>
            <div class="typing-field">
                <div class="input-data">
                    <input id="text-pesan" type="text" placeholder="Ketikkan sesuatu disini..." required />
                    <button id="send-btn">Kirim</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>

</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<script>
    $(document).ready(function() {
        function sendMessage() {
            const $pesan = $("#text-pesan").val();
            if ($pesan.trim() !== "") {
                const $msg = '<div class="user-inbox inbox"><div class="msg-header"><p>' + $pesan + '</p></div></div>';
                $(".form").append($msg);
                $("#text-pesan").val('');
                $.ajax({
                    url: 'chat.php',
                    type: 'POST',
                    data: {
                        isi_pesan: $pesan
                    },
                    contentType: 'application/x-www-form-urlencoded',
                    success: function(result) {
                        const $balasan = '<div class="bot-inbox inbox"><div class="icon"><i class="fas fa-user"></i></div><div class="msg-header"><p>' + result + '</p></div></div>';
                        $(".form").append($balasan);
                        $(".form").scrollTop($(".form")[0].scrollHeight);
                    }
                });
            }
        }
        $("#send-btn").on("click", function() {
            sendMessage();
        });
        $("#text-pesan").on("keydown", function(event) {
            if (event.key === "Enter") {
                event.preventDefault();
                sendMessage();
            }
        });
    });
</script>