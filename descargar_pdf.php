<?php
//use misClases\Email;
session_start();
$pdfFile = 'temp/'.$_GET['file'] ?? '';
if(!file_exists($pdfFile)) {
    die('Archivo no encontrado');
}

// Descarga
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="PagoUnini.pdf"');
header('Content-Length: ' . filesize($pdfFile));
readfile($pdfFile);
/* $mail=new Email($pdfFile,'Admnistrador UNINI');
$mail->enviarMail(); */

// Eliminar archivo temporal
unlink($pdfFile);

// Redirigir después de la descarga
if(isset($_SESSION['pdf_redirect'])) {
    unset($_SESSION['pdf_redirect']);
    echo '<script>window.location.href = "formulario.php";</script>';
}
exit();
?>