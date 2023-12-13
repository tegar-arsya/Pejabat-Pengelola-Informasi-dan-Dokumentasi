
document.addEventListener("DOMContentLoaded", function () {
    const provinsiSelect = document.getElementById("provinsi");
    const kotaKabupatenSelect = document.getElementById("kota_kabupaten");

    // Ambil data provinsi dari API
    fetch("https://tegar-arsya.github.io/api-indonesia/api/provinces.json")
        .then(response => response.json())
        .then(provinces => {
            // Isi opsi Provinsi
            provinces.forEach(provinsi => {
                const option = document.createElement("option");
                option.value = provinsi.id;
                option.text = provinsi.name;
                provinsiSelect.appendChild(option);
            });
        })
        .catch(error => console.error("Error fetching provinsi data:", error));

    // Tambahkan event listener untuk menangani perubahan pada Provinsi
    provinsiSelect.addEventListener("change", function () {
        const selectedProvinsiId = provinsiSelect.value;

        // Ambil data kota/kabupaten dari API berdasarkan provinsi yang dipilih
        fetch(`https://tegar-arsya.github.io/api-indonesia/api/regencies/${selectedProvinsiId}.json`)
            .then(response => response.json())
            .then(regencies => {
                // Hapus opsi Kota/Kabupaten yang ada sebelumnya
                kotaKabupatenSelect.innerHTML = "<option value='' selected disabled>Pilih Kota/Kabupaten</option>";

                // Isi opsi Kota/Kabupaten
                regencies.forEach(kotaKabupaten => {
                    const option = document.createElement("option");
                    option.value = kotaKabupaten.id;
                    option.text = kotaKabupaten.name;
                    kotaKabupatenSelect.appendChild(option);
                });
            })
            .catch(error => console.error("Error fetching kota/kabupaten data:", error));
    });
});
