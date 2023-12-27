var inactivityTimeout = 10 * 60 * 1000; // Timeout dalam milidetik (10 menit)
var logoutTimer;

function resetLogoutTimer() {
    clearTimeout(logoutTimer);
    logoutTimer = setTimeout(logout, inactivityTimeout);
}

function logout() {
    // Redirect ke halaman logout atau lakukan aksi logout lainnya
    window.location.href = '../controller/Admin/logoutAdmin.php';
}
// Event listener untuk mengatur ulang timer pada setiap aktivitas
document.addEventListener('mousemove', resetLogoutTimer);
document.addEventListener('keydown', resetLogoutTimer);
resetLogoutTimer();