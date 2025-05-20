document.addEventListener('DOMContentLoaded', function () {
    const galleryImage = document.querySelectorAll('.gallery-img');

    galleryImage.forEach((img, i) => {
        img.dataset.aos = 'fade-down';
        img.dataset.aosDelay = i * 100;
        img.dataset.aosDuration = 1000;
    });

    AOS.init({
        once: true,
        duration: 2000,
    });
});
gsap.registerPlugin(TextPlugin);
gsap.to('.lead', {
    duration: 2, delay: 1.5, text: '"Duc in Altum Menuju Komunitas Pejuangan yang Merawat Kehidupan"'
});

gsap.from('.jumbotron img', {
    duration: 1, rotateY: 360, opacity: 0
});

gsap.from('.navbar', {
    duration: 1.5, y: '-100%', opacity: 0, ease: 'bounce'
});

gsap.from('.display-4', {
    duration: 1, x: -50, opacity: 0, delay: 0.5, ease: 'back'
});

const scriptURL = 'https://script.google.com/macros/-/-----------------------------/----------------';
const form = document.forms['submit-to-google-sheet'];
const btnKirim = document.querySelector('.btn-kirim');
const btnLoading = document.querySelector('.btn-loading');
const myAlert = document.querySelector('.my-alert');

form.addEventListener('submit', (e) => {
    e.preventDefault();
    btnLoading.classList.toggle('d-none');
    btnKirim.classList.toggle('d-none');
    fetch(scriptURL, { method: 'POST', body: new FormData(form) })
        .then((response) => {
            btnLoading.classList.toggle('d-none');
            btnKirim.classList.toggle('d-none');
            myAlert.classList.toggle('d-none');
            form.reset();
            console.log('Success!', response);
        })
        .catch((error) => console.error('Error!', error.message));
});

document.addEventListener('DOMContentLoaded', function () {
    const sections = document.querySelectorAll('section');
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
    window.addEventListener('scroll', function () {
        let current = '';
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.clientHeight;
            if (pageYOffset >= sectionTop - sectionHeight / 3) {
                current = section.getAttribute('id');
            }
        });
        navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === '#' + current) {
                link.classList.add('active');
            }
        });
    });
});
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('chatbot-icon').addEventListener('click', function () {
        var chatbotBox = document.getElementById('chatbot-box');
        chatbotBox.classList.toggle('d-none');
    });
});
document.addEventListener('DOMContentLoaded', function () {
    const adminForm = document.querySelector('form[action="chat.php"]');
    if (adminForm) {
        adminForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(adminForm);
            const submitButton = adminForm.querySelector('button[type="submit"]');
            const loadingText = 'Loading...';
            const originalText = submitButton.textContent;
            submitButton.disabled = true;
            submitButton.textContent = loadingText;
            fetch('chat.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.text())
                .then(result => {
                    console.log('Success:', result);
                    // Tampilkan modal sukses
                    $('#successModal').modal('show');
                    adminForm.reset();
                    submitButton.disabled = false;
                    submitButton.textContent = originalText;
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                    submitButton.disabled = false;
                    submitButton.textContent = originalText;
                });
        });
    }
});