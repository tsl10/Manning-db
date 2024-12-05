<?php

// Database connection details
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

use PHPMailer/PHPMailer/PHPMailer;
use PHPMailer/PHPMailer/Exception;

$servername = "localhost";
$username = "kamilmwg_test";
$password = "Test@db24";
$dbname = "kamilmwg_cv_management";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle logout request
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit('POST request method required');
}

// Check if $_FILES is empty
if (empty($_FILES) || !isset($_FILES['cv'])) {
    exit('No file uploaded or $_FILES is empty.');
}

// Check if email and percentage are provided
if (empty($_POST['email']) || empty($_POST['percentage'])) {
    exit('Email address and rank percentage are required.');
}

// Sanitize and validate inputs
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$percentage = filter_var($_POST['percentage'], FILTER_VALIDATE_FLOAT);

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit('Invalid email address.');
}

if ($percentage === false || $percentage < 0 || $percentage > 100) {
    exit('Invalid rank percentage. Please enter a value between 0 and 100.');
}

// Define error messages
$errorMessages = [
    UPLOAD_ERR_OK => 'File uploaded successfully.<br>',
    UPLOAD_ERR_PARTIAL => 'File only partially uploaded.',
    UPLOAD_ERR_NO_FILE => 'No file was uploaded.',
    UPLOAD_ERR_FORM_SIZE => 'File exceeds MAX_FILE_SIZE in the HTML form.',
    UPLOAD_ERR_INI_SIZE => 'File exceeds upload_max_filesize in php.ini.',
    UPLOAD_ERR_NO_TMP_DIR => 'Temporary folder not found.',
    UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
    UPLOAD_ERR_EXTENSION => 'File upload stopped by a PHP extension.',
];

// Check for upload errors
if ($_FILES["cv"]["error"] !== UPLOAD_ERR_OK) {
    exit($errorMessages[$_FILES["cv"]["error"]] ?? 'Unknown upload error.');
}

// Reject uploaded files larger than 5MB
if ($_FILES["cv"]["size"] > 5242880) {
    exit('File too large (max 5MB).');
}

// Use fileinfo to get the MIME type of the uploaded file
$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime_type = $finfo->file($_FILES["cv"]["tmp_name"]);

// Allowed MIME types
$allowedMimeTypes = [
    "application/pdf",
    "application/msword",
    "application/vnd.openxmlformats-officedocument.wordprocessingml.document"
];

// Validate the MIME type of the uploaded file
if (!in_array($mime_type, $allowedMimeTypes)) {
    exit("Invalid file type. Allowed types: PDF, DOC, DOCX.");
}

// Sanitize filename
$pathinfo = pathinfo($_FILES["cv"]["name"]);
$base = preg_replace("/[^\w-]/", "_", $pathinfo["filename"]);
$extension = isset($pathinfo["extension"]) ? $pathinfo["extension"] : '';
$filename = $extension ? "$base.$extension" : $base;
$destination = __DIR__ . "/uploads/$filename";

// Ensure the uploads directory exists
if (!is_dir(__DIR__ . "/uploads")) {
    if (!mkdir(__DIR__ . "/uploads", 0777, true)) {
        exit("Failed to create uploads directory.");
    }
}

// Add a numeric suffix if the file already exists
$i = 1;
while (file_exists($destination)) {
    $filename = $extension ? "$base($i).$extension" : "$base($i)";
    $destination = __DIR__ . "/uploads/$filename";
    $i++;
}

// Check directory permissions
if (!is_writable(__DIR__ . "/uploads")) {
    if (!chmod(__DIR__ . "/uploads", 0777)) {
        exit("Uploads directory is not writable and chmod failed.");
    }
}

// Move the uploaded file to the destination directory
if (!move_uploaded_file($_FILES["cv"]["tmp_name"], $destination)) {
    exit("Can't move uploaded file. Possible reasons: incorrect path, insufficient permissions, or open_basedir restriction.");
}

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO cvs (email, filename, mime_type, size, uploaded_at, rank_percentage) VALUES (?, ?, ?, ?, NOW(), ?)");
$stmt->bind_param("sssdi", $email, $filename, $mime_type, $_FILES["cv"]["size"], $percentage);

// Execute the statement
if ($stmt->execute()) {
    echo $errorMessages[UPLOAD_ERR_OK];
} else {
    echo "Error: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();

// Email notification settings
$admin_email = "akshatabansode7304@gmail.com";
$subject = "New CV Uploaded";
$message = "A new CV has been uploaded by $email.\n\nFilename: $filename\nMIME Type: $mime_type\nSize: {$_FILES["cv"]["size"]} bytes\nRank Percentage: $percentage%";

// PHPMailer setup
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'akshatabansode7304@gmail.com';
    $mail->Password = 'cvdo qurv lrbn kmiu';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('no-reply@example.com', 'Mailer');
    $mail->addAddress($admin_email);

    $mail->isHTML(false);
    $mail->Subject = $subject;
    $mail->Body = $message;

    $mail->send();
    echo 'Notification sent to admin.';
} catch (Exception $e) {
    echo "Failed to send notification to admin. Mailer Error: {$mail->ErrorInfo}";
}
?>

<!-- Logout button -->
<form action="" method="post">
    <button type="submit" name="logout" class="btn btn-danger">Logout</button>
</form>
