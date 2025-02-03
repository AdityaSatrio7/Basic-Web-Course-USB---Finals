<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Database_UAS";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$response = array("valid" => false, "message" => "");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    //validasi login form
    if (empty($username) || empty($password)) {
        $response["message"] = "Username dan password tidak boleh kosong.";
        echo json_encode($response);
        exit;
    }

    //SQL statement untuk fetch password dari database
    $stmt = $conn->prepare("SELECT Password_hash FROM Credentials WHERE Username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    //fetch password dari database
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        //verifikasi password
        if (password_verify($password, $user["Password_hash"])) {
            //set session
            $_SESSION["login"] = true;
            //set response
            $response["valid"] = true;
            $response["message"] = "Login berhasil";
        } else {
            $response["message"] = "Password salah.";
        }
    } else {
        $response["message"] = "Username tidak ditemukan.";
    }
    $stmt->close();
}

echo json_encode($response);
$conn->close();
?>