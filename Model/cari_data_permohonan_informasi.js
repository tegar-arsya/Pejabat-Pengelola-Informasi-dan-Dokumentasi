function cariData() {
    var nik = document.getElementById("nik").value;
    var nama = document.getElementById("nama").value;
    var registrasi = document.getElementById("registrasi").value;

    // Kirim permintaan ke server menggunakan Fetch API
    fetch('cari_data.php', {
        method: 'POST',
        body: JSON.stringify({ nik: nik, nama: nama, registrasi: registrasi }),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        // Manipulasi tabel untuk menampilkan hasil pencarian
        var tableBody = document.querySelector('.table tbody');
        tableBody.innerHTML = ''; // Bersihkan isi tabel sebelum menambahkan data baru

        // Iterasi melalui data hasil pencarian dan tambahkan ke tabel
        data.forEach(function(row) {
            var newRow = `<tr>
                            <td>${row.tanggal}</td>
                            <td>${row.nama}</td>
                            <td>${row.no_hp}</td>
                            <td>${row.informasi}</td>
                            <td>${row.opd}</td>
                            <td>
                                <button class="btn btn-info btn-sm" onclick="showDetail()">Detail</button>
                                <button class="btn btn-danger btn-sm" onclick="hapusData(${row.id})">Hapus</button>
                                <button class="btn btn-success btn-sm" onclick="verifikasiData(${row.id})">Verifikasi</button>
                            </td>
                        </tr>`;
            tableBody.innerHTML += newRow;
        });
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
