<?php
$host = 'localhost';
$user = 'root'; // Default user untuk XAMPP
$pass = ''; // Default password untuk XAMPP biasanya kosong
$dbname = 'db_ppid';

$backup_file = 'C:/xampp/htdocs/backup/db_backup_' . date('Y-m-d-H-i-s') . '.sql';
$command = "C:/xampp/mysql/bin/mysqldump --user={$user} --password={$pass} --host={$host} {$dbname} > {$backup_file}";

system($command);
?>
