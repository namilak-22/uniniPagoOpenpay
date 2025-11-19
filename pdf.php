<?php 
        require_once 'vendor/autoload.php';
        require_once __DIR__.'/configuracion.php';
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;
        use Dompdf\Dompdf;
        use Dompdf\Options; 
         use Openpay\Data\Openpay;
            $openpay = Openpay::getInstance(MERCHANT_ID,
            PRIVATE_KEY, COUNTRY_CODE, IP_ADDRESS);
            OpenPay::setProductionMode(false);
            
            /* if(!isset($_SESSION)){
            session_start();
            $charge=$_SESSION['charge'];} */
            //$charge=$_GET['charge'];
    
    $dompdf=new Dompdf();
    ob_start();
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/stylesResponse.css">
    <link rel="stylesheet" href="css/normailize.css">
    <style>
        :root {
    --blanco: #ffffff;
    --oscuro: #212121;
    --primario: #00AEEF;
    --gris: #666;
    --grisClaro: #FBFCFC;
    --rojo:#FF0000;
    --verde:#008f39;
}
/*  Globales **/
html {
    font-size: 62.5%;
    box-sizing: border-box; /* Hack para Box Model **/
    scroll-snap-type: y mandatory;
}


*, *:before, *:after {
    box-sizing: inherit;
}
body {
    width: 100%;
    height: 100%;
    font-size: 16px; /* 1rem = 10px */
    font-family: Arial, Helvetica, sans-serif;
    background-image: linear-gradient(to top, var(--grisClaro) 0%, var(--blanco) 100% );
}

.contenedor {
    background-color: var(--grisClaro);
    max-width: 120rem;
    height: auto;
    margin: 0 auto;
}
.contenedor-exito {
    color:var(--verde);
    text-align: center;

}
.contenedor-exito h3{
    color:var(--primario);
    text-align: center;
    font-size: 3.8rem;
}


.contenedor-exito h4{
    color:var(--oscuro);
    text-align: center;
}
.contenedor .error{
    color:var(--rojo);
    text-align: center;
}
.contenedor-parrafos {
    color:var(--oscuro);
    font-size: 1.4rem;
}

.boton {
    background-color: var(--primario);
    color: var(--blanco);
    padding: 1rem 3rem;
    margin-top: 3rem;
    font-size: 2rem;
    text-decoration: none;
    text-transform: uppercase;
    font-weight: bold;
    border-radius: .5rem;
    width: 90%;
    text-align: center;
    border: none;
}
@media (min-width: 768px) {
    .boton {
        width: auto;
    }
}
.boton:hover {
    cursor: pointer;
}

.sombra {
    box-shadow: 0px 5px 15px 0px rgba(112,112,112,0.48);
    background-color: var(--blanco);
    padding: 2rem;
    border-radius: 1rem;
}

/* Tipografia */
h1 {
    font-size: 3.8rem;
}
h2 {
    font-size: 2.8rem;
}
h3 {
    font-size: 1.8rem;
}
h1,h2,h3 {
    text-align: center;
}


/* Titulos */
.titulo span {
    font-size: 2rem;
}

/** Utilidades **/
.w-sm-100 {
    width: 100%;
}
@media (min-width: 768px) {
    .w-sm-100 {
        width: auto;
    }
}
.flex {
    display: flex;
}
.alinear-derecha {
    justify-content: flex-end;
}

/* Span clases */
.number-card{
    font-size: 2.4rem;
    font-weight: bolder;
}
.motivo-pago{
    font-size: 4.5rem;
    font-weight: bolder;
}
.motivo{
    color:var(--rojo);
    font-size: 1.8rem;
    font-weight: bolder;
}
/* IMAGENES */
.logo img{
    width: 40rem;
    height: 10rem;
}


/** Contacto **/

.oculto{
    display: none;
}

    </style>
    <title>Comprobante</title>
</head>
<body>
    <div id="contenido-a-pdf">
            <div class="contenedor-exito">
                <div class="logo">
                    <?php 
                        $imagePath = __DIR__.'/img/UNINI.jpg';
                        $imageData = base64_encode(file_get_contents($imagePath));
                        echo '<img src="data:image/jpeg;base64,'.$imageData.'">';
                    ?>
                </div>
                 <h1>¡Pago exitoso!</h1>
                <h4>CALLE 15 36 CAMPECHE CAMPECHE</h4>
                <h4>VENTA</h4>
            <div class="contenedor-parrafos">
                <p>Número de Tarjeta: <span class="number-card"> <?php echo $charge->card->card_number; ?></span></p>
                 <p>Tipo Tarjeta: <?php echo $charge->card->type; ?></p>
                <p>Marca Tarjeta: <?php echo $charge->card->brand; ?></p>
                <p>Nombre del Alumno: <?php echo $charge->customer->name; ?></p>
                <p>Concepto del pago: <span class="motivo"><?php echo strtoupper($charge->description);?></span></p>
                <p>Compra con 3D Secure</p>
                <p>ID de transacción: <?php echo $charge->id;?></p>
                <p>ID de autorización: <?php echo $charge->authorization;?></p>
                <p><span class="motivo-pago">$ <?php echo number_format($charge->amount, 2) . ' '. $charge->currency;?></span></p>
                <p>Fecha: <?php echo $charge->operation_date; ?></p>
                <p>Status: <?php echo $charge->status; ?></p>
               
            </div>
            </div> 
    </div> 
    <script>
        // Abrir el PDF en nueva pestaña
        window.open('<?php echo $pdfUrl; ?>', '_blank');
        
        // Opcional: Eliminar el PDF después de un tiempo (ejemplo con AJAX)
        setTimeout(function(){
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'eliminar_pdf.php?file=<?php echo $pdfFileName; ?>', true);
            xhr.send();
        }, 10000); // 10 segundos
    </script>
    
</body>
</html>
<?php 

$html=ob_get_clean();
$options = $dompdf->getOptions();
$options->set('isRemoteEnabled', true);
$options->set('isHtml5ParserEnabled', true); 
$dompdf->setOptions($options);
$dompdf->loadHtml($html, 'UTF-8');
$dompdf->render();
//$dompdf->stream("pagoUnini.pdf", array("Attachment" => false));

//Guardar temporalmente
$output = $dompdf->output();
$pdfName = 'temp/pagoUnini_'.time().'.pdf';
file_put_contents($pdfName, $output);
//generar Correo
$mail = new PHPMailer(true);
try{
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '0b344fecee2cb2';
        $mail->Password = 'a64963970787a6';

        $mail->setFrom('cuentas@unini.com','unini.com');
        $mail->addAddress('cuentas@unini.com', 'unini.com');
        $mail->Subject='Notificación Pago ';
        $mail->isHTML(TRUE);
        $mail->CharSet='UTF-8';

        $pdfContent = $dompdf->output();
        $mail->addStringAttachment($pdfContent, 'comprobantePago.pdf', 'base64', 'application/pdf');
        $mail->Subject = 'Comprobante de Pago Adjunto';
            $mail->Body    = '
                <h2>Hola,</h2>
                <p>Se ha realizado un pago; adjunto encontrarás tu comprobante en formato PDF.</p>
                <p>Fecha de emisión: '.date('d/m/Y').'</p>
                <p>Saludos cordiales</p>
            ';
            $mail->AltBody = 'Adjunto encontrarás tu comprobante en formato PDF. Fecha: '.date('d/m/Y');

            $mail->send();

}
catch(Exception $e){
    echo "Error al enviar el correo: {$mail->ErrorInfo}";
}
 // Redirigir a la página de visualización
header("Location: ver_pdf.php?file=".basename($pdfName));
exit();

//echo $html;
?> 