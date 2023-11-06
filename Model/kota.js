const kotaKabupatenList = [
    "Kabupaten Banjarnegara",
    "Kabupaten Banyumas",
    "Kabupaten Batang",
    "Kabupaten Blora",
    "Kabupaten Boyolali",
    "Kabupaten Brebes",
    "Kabupaten Cilacap",
    "Kabupaten Demak",
    "Kabupaten Grobogan",
    "Kabupaten Jepara",
    "Kabupaten Karanganyar",
    "Kabupaten Kebumen",
    "Kabupaten Kendal",
    "Kabupaten Klaten",
    "Kabupaten Kudus",
    "Kabupaten Magelang",
    "Kabupaten Pati",
    "Kabupaten Pekalongan",
    "Kabupaten Pemalang",
    "Kabupaten Purbalingga",
    "Kabupaten Purworejo",
    "Kabupaten Rembang",
    "Kabupaten Semarang",
    "Kabupaten Sragen",
    "Kabupaten Sukoharjo",
    "Kabupaten Tegal",
    "Kabupaten Temanggung",
    "Kabupaten Wonogiri",
    "Kabupaten Wonosobo",
    "Kota Magelang",
    "Kota Pekalongan",
    "Kota Salatiga",
    "Kota Semarang",
    "Kota Surakarta",
    "Kota Tegal"
];

// Mendapatkan elemen select
const selectKotaKabupaten = document.getElementById("kota_kabupaten");

kotaKabupatenList.forEach(kota_kabupaten => {
    const option = document.createElement("option");
    option.value = kota_kabupaten;
    option.text = kota_kabupaten;
    selectKotaKabupaten.appendChild(option);
});
