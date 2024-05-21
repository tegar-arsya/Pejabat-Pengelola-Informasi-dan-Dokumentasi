<?php
class VerifikasiPermohonan {
    private $conn;
    private $nomer_registrasi;

    public function __construct($conn, $nomer_registrasi) {
        $this->conn = $conn;
        $this->nomer_registrasi = $nomer_registrasi;
    }

    public function tampilkanData() {
        $query = "SELECT * FROM verifikasi_permohonan WHERE nomer_registrasi = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $this->nomer_registrasi);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->tampilkanTableRow($row);
            }
        } else {
            $this->tampilkanAlternatifData();
        }
    }

    private function tampilkanTableRow($row) {
        echo "<tr>";
        echo "<td><strong>Nama :</strong></td>";
        echo "<td>{$row['nama_pengguna']}</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td><strong>Tanggal Permohonan:</strong></td>";
        echo "<td>" . (!empty ($row['tanggal_permohonan']) ? htmlspecialchars(date('d-m-Y H:i:s', strtotime($row['tanggal_permohonan']))) : '') . "</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td><strong>Nomor Register:</strong></td>";
        echo "<td>{$row['nomer_registrasi']}</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td><strong>Informasi yang Diminta:</strong></td>";
        echo "<td>{$row['informasi_yang_dibutuhkan']}</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td><strong>Alasan Pengguna Informasi:</strong></td>";
        echo "<td>{$row['alasan_pengguna_informasi']}</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td><strong>OPD Yang Dituju:</strong></td>";
        echo "<td>{$row['opd_yang_dituju']}</td>";
        echo "</tr>";
    }

    private function tampilkanAlternatifData() {
        $query_alternatif = "SELECT p.nomer_registrasi, p.nama_pengguna, p.opd_yang_dituju, p.tanggal_permohonan, r.nik, r.foto_ktp, r.no_hp, r.alamat, p.informasi_yang_dibutuhkan, p.alasan_pengguna_informasi
                            FROM registrasi r
                            JOIN permohonan_informasi p ON p.id_user = r.nik
                            WHERE p.nomer_registrasi = ?";
        $stmt = $this->conn->prepare($query_alternatif);
        $stmt->bind_param("s", $this->nomer_registrasi);
        $stmt->execute();
        $result_alternatif = $stmt->get_result();

        while ($row_alternatif = $result_alternatif->fetch_assoc()) {
            $this->tampilkanTableRow($row_alternatif);

            // Ambil tanggal dari kolom tanggal_permohonan
            $tanggal = $row_alternatif['tanggal_permohonan'];
            $status = "Belum Diverifikasi";

            // Tambahkan status "Belum Diverifikasi" ke dalam objek timelineData
            // $timelineData[] = array("date" => $tanggal, "status" => $status);
            $timelineData[] = array("date" => date('d-m-Y H:i:s', strtotime($tanggal)), "status" => $status);
        }
    }
}

// Penggunaan:
$verifikasiPermohonan = new VerifikasiPermohonan($conn, $nomer_registrasi);
$verifikasiPermohonan->tampilkanData();
?>
