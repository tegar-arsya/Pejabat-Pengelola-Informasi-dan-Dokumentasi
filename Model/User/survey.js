function generateCaptcha() {
    // Mengambil nilai CAPTCHA dari server
    fetch('../controller/generate_captcha.php')
        .then(response => response.text())
        .then(data => {
            document.getElementById('captcha').textContent = data;
        });
}

document.getElementById('reload-button').addEventListener('click', generateCaptcha);

document.getElementById('mySurvey').addEventListener('submit', function(event) {
    event.preventDefault();

    var userInput = document.getElementById('user-input').value;
    var captchaValue = document.getElementById('captcha').textContent.trim();

    if (userInput === captchaValue) {
        fetch('../controller/data_survey.php', {
            method: 'POST',
            body: new URLSearchParams(new FormData(document.getElementById('mySurvey')))
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: 'Berhasil Terkirim',
                    html: 'Terima kasih telah mengisi Kuesioner Indeks Kepuasan Masyarakat. Mohon masuk ke halaman riwayat permohonan untuk mengunduh jawaban permohonan informasi atau klik link berikut ini <a href="../view/daftarRiwayat" style="color: red; text-decoration: underline;">riwayat permohonan</a>',
                    icon: 'success',
                });
                
                document.getElementById('user-input').value = '';
                generateCaptcha();
            } else {
                Swal.fire(
                    'Error',
                    'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.',
                    'error'
                );
                // Regenerate CAPTCHA
                generateCaptcha();
            }
        });
    } else {
        Swal.fire(
            'Error',
            'CAPTCHA tidak sesuai. Silakan coba lagi.',
            'error'
        );
        // Regenerate CAPTCHA
        generateCaptcha();
    }
});


// Generate CAPTCHA saat halaman dimuat
window.addEventListener('load', generateCaptcha);
