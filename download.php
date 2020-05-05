<?php
session_start();
require_once("connect.php");
if (isset($_GET['file_id'])) {
    $id = $_GET['file_id'];

    // fetch file to download from database
    $stmt = $conn->prepare("SELECT * FROM upload_file WHERE upload_id=$id");
    $stmt->execute();
    $file = $stmt->fetch(PDO::FETCH_ASSOC);

    $filepath = 'uploads/' . $file['fileName'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('uploads/' . $file['fileName']));
        readfile('uploads/' . $file['fileName']);

        exit;
    }
}
?>