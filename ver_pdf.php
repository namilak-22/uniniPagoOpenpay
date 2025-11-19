<?php
session_start();

// Verificar que el PDF existe
$pdfFile = 'temp/'.$_GET['file'] ?? '';
if(!file_exists($pdfFile)) {
    die('El PDF no está disponible');
}

// Configurar variable de sesión para la redirección
$_SESSION['pdf_redirect'] = true;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Visualizar Comprobante</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; text-align: center; }
        iframe { width: 100%; height: 500px; border: 1px solid #ddd; }
        .btn-descargar { 
            display: inline-block; 
            margin-top: 20px; 
            padding: 10px 20px; 
            background: #00AEEF; 
            color: white; 
            text-decoration: none; 
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Su comprobante está listo</h2>
        <iframe src="<?php echo $pdfFile; ?>" ></iframe>
        <br>
        <a  href="descargar_pdf.php?file=<?php echo urlencode($_GET['file']); ?>" class="btn-descargar">Descargar Comprobante</a>
        <a  href="/formulario.php" class="btn-descargar">Cerrar</a>
        
    </div>

    <script>
        // Redirigir después de 10 segundos si no descargan
        /* setTimeout(function() {
            window.location.href = "formulario.php";
        }, 10000); */
    </script>
</body>
</html>