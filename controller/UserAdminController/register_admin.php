<?php
require_once '../../../controller/koneksi/config.php';

class UserAdmin {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function registerUser($name, $username, $password, $role) {
        // Use prepared statements with parameter binding
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = $this->conn->prepare("INSERT INTO user_admin (nama_pengguna, username, password, role) VALUES (?, ?, ?, ?)");
        
        // Check if prepare() succeeded
        if ($sql === false) {
            return "Error preparing statement: " . $this->conn->error;
        }

        $sql->bind_param("ssss", $name, $username, $hashed_password, $role);

        if ($sql->execute()) {
            return true;
        } else {
            return "Error executing statement: " . $sql->error;
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userAdmin = new UserAdmin($conn);
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Call the registerUser method to handle registration
    $result = $userAdmin->registerUser($name, $username, $password, $role);
    if ($result === true) {
        header("Location:  ../../../view/Admin/Form/loginadmin");
        exit();
    } else {
        echo $result; // Display error message if registration fails
    }
}

$conn->close();
?>
