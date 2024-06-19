function generateCaptcha() {
    // Mengambil nilai CAPTCHA dari server
    fetch('../Model/Captcha/generate_captcha.php')
        .then(response => response.text())
        .then(data => {
            document.getElementById('captcha').textContent = data;
        });
}

document.getElementById('reload-button').addEventListener('click', generateCaptcha);

document.getElementById('myForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Mencegah tindakan bawaan formulir

    var userInput = document.getElementById('user-input').value;
    var captchaValue = document.getElementById('captcha').textContent.trim();

    if (userInput === captchaValue) {
        // CAPTCHA benar, kirim data ke server menggunakan fetch API
        fetch('../controller/simpandataformulirpermohonaninformasipublik.php', {
                method: 'POST',
                body: new URLSearchParams(new FormData(document.getElementById('myForm')))
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Jika penyimpanan data di server berhasil, tampilkan popup SweetAlert2
                    Swal.fire({
                        title: 'Berhasil Terkirim',
                        html: 'Permohonan informasi publik anda telah berhasil terkirim, untuk detail lebih lanjut mohon untuk dicek di bagian <a href="../view/daftarRiwayat" style="color: red; text-decoration: underline;">riwayat permohonan</a>',
                        icon: 'success',
                    });

                    // Clear input CAPTCHA dan isi ulang CAPTCHA
                    document.getElementById('user-input').value = '';
                    generateCaptcha();
                } else {
                    // Jika penyimpanan data di server gagal, tampilkan pesan kesalahan
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
        // CAPTCHA salah, tampilkan pesan kesalahan
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