const provinsiList = [
    "Nanggroe Aceh Darussalam",
    "Sumatera Utara",
    "Sumatera Barat",
    "Riau",
    "Kepulauan Riau",
    "Jambi",
    "Sumatera Selatan",
    "Bengkulu",
    "Lampung",
    "Bangka Belitung",
    "Banten",
    "DKI Jakarta",
    "Jawa Barat",
    "Jawa Tengah",
    "Daerah Istimewa Yogyakarta",
    "Jawa Timur",
    "Bali",
    "Nusa Tenggara Barat",
    "Nusa Tenggara Timur",
    "Kalimantan Barat",
    "Kalimantan Tengah",
    "Kalimantan Selatan",
    "Kalimantan Timur",
    "Kalimantan Utara",
    "Gorontalo",
    "Sulawesi Barat",
    "Sulawesi Tengah",
    "Sulawesi Selatan",
    "Sulawesi Utara",
    "Sulawesi Tenggara",
    "Maluku",
    "Maluku Utara",
    "Papua Barat",
    "Papua",
    "Papua Tengah",
    "Papua Pegunungan",
    "Papua Selatan",
    "Papua Barat Daya"
];
const selectProvinsi = document.getElementById("provinsi");

provinsiList.forEach(provinsi => {
    const option = document.createElement("option");
    option.value = provinsi;
    option.text = provinsi;
    selectProvinsi.appendChild(option);
});