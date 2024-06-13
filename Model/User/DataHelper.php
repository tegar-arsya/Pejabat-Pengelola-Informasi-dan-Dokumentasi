<?php
                            $query = "SELECT * FROM verifikasi_permohonan WHERE nomer_registrasi = '$nomer_registrasi'";
                            $result = $conn->query($query);

                            // Menambahkan data dari tbl_rejected
                            $queryRejected = "SELECT * FROM tbl_rejected WHERE nomer_registrasi = '$nomer_registrasi'";
                            $resultRejected = $conn->query($queryRejected);

                            $isRejected = $resultRejected->num_rows > 0;

                            if ($result->num_rows > 0) {
                                // Data ditemukan, tampilkan atau proses data di sini
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td><strong>Nama :</strong></td>";
                                    echo "<td>" . htmlspecialchars($row['nama_pengguna'], ENT_QUOTES, 'UTF-8') . "</td>";
                                    echo "</tr>";

                                    echo "<tr>";
                                    echo "<td><strong>Tanggal Permohonan:</strong></td>";
                                    echo "<td>" . (!empty($row['tanggal_permohonan']) ? htmlspecialchars(date('d-m-Y H:i:s', strtotime($row['tanggal_permohonan']))) : '') . "</td>";                                    echo "</tr>";

                                    echo "<tr>";
                                    echo "<td><strong>Nomor Register:</strong></td>";
                                    echo "<td>" . htmlspecialchars($row['nomer_registrasi'], ENT_QUOTES, 'UTF-8') . "</td>";
                                    echo "</tr>";

                                    echo "<tr>";
                                    echo "<td><strong>Informasi yang Diminta:</strong></td>";
                                    echo "<td>" . htmlspecialchars($row['informasi_yang_dibutuhkan'], ENT_QUOTES, 'UTF-8') . "</td>";
                                    echo "</tr>";

                                    echo "<tr>";
                                    echo "<td><strong>Alasan Pengguna Informasi:</strong></td>";
                                    echo "<td>" . htmlspecialchars($row['alasan_pengguna_informasi'], ENT_QUOTES, 'UTF-8') . "</td>";
                                    echo "</tr>";

                                    echo "<tr>";
                                    echo "<td><strong>OPD Yang Dituju:</strong></td>";
                                    echo "<td>" . htmlspecialchars($row['opd_yang_dituju'], ENT_QUOTES, 'UTF-8') . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                $query_alternatif = "SELECT p.nomer_registrasi, p.nama_pengguna, p.opd_yang_dituju, p.tanggal_permohonan, r.nik, r.foto_ktp, r.no_hp, r.alamat, p.informasi_yang_dibutuhkan, p.alasan_pengguna_informasi
                                                FROM registrasi r
                                                JOIN permohonan_informasi p ON p.id_user = r.nik
                                                WHERE p.nomer_registrasi = '$nomer_registrasi'";

                                $result_alternatif = $conn->query($query_alternatif);
                                while ($row_alternatif = $result_alternatif->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td><strong>Nama :</strong></td>";
                                    echo "<td>" . htmlspecialchars($row_alternatif['nama_pengguna'], ENT_QUOTES, 'UTF-8') . "</td>";
                                    echo "</tr>";

                                    echo "<tr>";
                                    echo "<td><strong>Tanggal Permohonan:</strong></td>";
                                    echo "<td>" . (!empty($row_alternatif['tanggal_permohonan']) ? htmlspecialchars(date('d-m-Y H:i:s', strtotime($row_alternatif['tanggal_permohonan']))) : '') . "</td>";                                    echo "</tr>";

                                    echo "<tr>";
                                    echo "<td><strong>Nomor Register:</strong></td>";
                                    echo "<td>" . htmlspecialchars($row_alternatif['nomer_registrasi'], ENT_QUOTES, 'UTF-8') . "</td>";
                                    echo "</tr>";

                                    echo "<tr>";
                                    echo "<td><strong>Informasi yang Diminta:</strong></td>";
                                    echo "<td>" . htmlspecialchars($row_alternatif['informasi_yang_dibutuhkan'], ENT_QUOTES, 'UTF-8') . "</td>";
                                    echo "</tr>";

                                    echo "<tr>";
                                    echo "<td><strong>Alasan Pengguna Informasi:</strong></td>";
                                    echo "<td>" . htmlspecialchars($row_alternatif['alasan_pengguna_informasi'], ENT_QUOTES, 'UTF-8') . "</td>";
                                    echo "</tr>";

                                    echo "<tr>";
                                    echo "<td><strong>OPD Yang Dituju:</strong></td>";
                                    echo "<td>" . htmlspecialchars($row_alternatif['opd_yang_dituju'], ENT_QUOTES, 'UTF-8') . "</td>";
                                    echo "</tr>";

                                    // Ambil tanggal dari kolom tanggal_permohonan
                                    $tanggal = $row_alternatif['tanggal_permohonan'];

                                    $status = "Belum Diverifikasi";

                                    // Tambahkan status "Belum Diverifikasi" ke dalam objek timelineData
                                    // $timelineData[] = array("date" => $tanggal, "status" => $status);
                                    $timelineData[] = array("date" => date('d-m-Y H:i:s', strtotime($tanggal)), "status" => $status);
                                }
                            }

                            ?>