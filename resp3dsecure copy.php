<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/stylesResponse.css">
    <link rel="stylesheet" href="css/normailize.css">
    <title>Respuesta 3D Secure</title>
</head>
<body>
    <h1>3D Secure</h1>
     <?php
        require_once 'vendor/autoload.php';
        require_once __DIR__.'/configuracion.php';

        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;
        use Dompdf\Dompdf;

        use Openpay\Data\Openpay;

        $openpay = Openpay::getInstance(MERCHANT_ID,
        PRIVATE_KEY, COUNTRY_CODE, IP_ADDRESS);
        OpenPay::setProductionMode(false);
    ?>
        <div class="contenedor">
    <?php
        // Página de confirmación (customer return)
        if (isset($_GET['id'])) {
            $charge_id = $_GET['id'];
    
        try {
            $charge = $openpay->charges->get($charge_id);
        
        // Verificar el estado del pago
            switch ($charge->status) {
            case 'completed':
                // Pago exitoso
                mostrarConfirmacionExito($charge);
                break;
                
            case 'cancelled':
                // Pago cancelado
                mostrarConfirmacionCancelado($charge);
                break;
                
            case 'failed':
                // Pago fallido
                mostrarConfirmacionFallido($charge);
                break;
                
            default:
                // Pago pendiente
                mostrarConfirmacionPendiente($charge);
        }
        
        } catch (Exception $e) {
            // Manejar error
            echo "Error: " . $e->getMessage();
        }
        }
    ?>  
      <?php
        function mostrarConfirmacionExito($charge) {
            //session_start();
            //$_SESSION['charge']=$charge;
        // header('Location: /../pdf.php');
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
                <p>Nombre del Alumno: <?php echo $_POST['nombre'];//$charge->customer->name; ?></p>
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
        //window.open('<?php echo $pdfUrl; ?>', '_blank');
        
        // Opcional: Eliminar el PDF después de un tiempo (ejemplo con AJAX)
        /* setTimeout(function(){
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'eliminar_pdf.php?file=<?php echo $pdfFileName; ?>', true);
            xhr.send();
        }, 10000); // 10 segundos */
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
        $mail->addStringAttachment(__DIR__.'temp/pagoUnini_'.time().'.pdf', 'comprobantePago.pdf', 'base64', 'application/pdf');
        $mail->Subject = 'Comprobante de Pago Adjunto';
            $mail->Body    = '
                <h2>Hola,</h2>
                <p>Un alumno ha realizado un pago.</p>
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
            //header("Location: ver_pdf.php?file=".basename($pdfName));
            echo '<script>window.location.href = "ver_pdf.php?file=' . basename($pdfName) . '";</script>';
            exit();
        }

        function mostrarConfirmacionCancelado($charge) {
            // Mostrar página de pago cancelado
            echo '<div id="contenido-a-pdf">';
            echo '<div class="contenedor error">';
            echo '<h2>Pago cancelado</h2>';
            echo '<div class="contenedor parrafos">';
            echo '<p>El pago fue cancelado. ID: '.$charge->id.'</p>';
            echo '</div>'; 
            echo '<button class="boton" onclick="generarPDF()">Guardar como PDF</button>';
            echo '<br>';
            echo '<button class="boton" onclick="history.go(-2);">Cerrar</button>';
            echo '</div>';
            echo '</div>';
            echo '<script>';
            echo'        function generarPDF() {';
            echo  'const elemento = document.getElementById("contenido-a-pdf");';
            
            echo '        html2pdf()';
            echo '      .from(elemento)';
            echo '       .save("informacionPago.pdf");';
            echo     '       }';
            echo '</script>';  
        }

        function mostrarConfirmacionFallido($charge) {
            // Mostrar página de pago fallido
            echo '<div id="contenido-a-pdf">';
            echo '<div class="contenedor error">';
            echo '<h2>Pago fallido</h2>';
            echo '<div class="contenedor parrafos">';
            echo '<p>El pago no pudo ser procesado. ID: '.$charge->id.'</p>';
            if (isset($charge->error_message)) {
                echo '<p>Error: '.$charge->error_message.'</p>';
            }
            echo '</div>'; 
            echo '<button class="boton" onclick="generarPDF()">Guardar como PDF</button>';
            echo '<br>';
            echo '<button class="boton" onclick="history.go(-2);">Cerrar</button>';
            echo '</div>';
            echo '</div>';
            echo '<script>';
            echo'        function generarPDF() {';
            echo  'const elemento = document.getElementById("contenido-a-pdf");';
            
            echo '        html2pdf()';
            echo '      .from(elemento)';
            echo '       .save("informacionPago.pdf");';
            echo     '       }';
            echo '</script>';    
        }

        function mostrarConfirmacionPendiente($charge) {
            // Mostrar página de pago pendiente
            echo '<div id="contenido-a-pdf">';
            echo '<div class="contenedor error">';
            echo '<h2>Pago pendiente</h2>';
            echo '<div class="contenedor parrafos">';
            echo '<p>Estamos procesando tu pago. ID: '.$charge->id.'</p>';
            echo '</div>';
            echo '<button class="boton" onclick="generarPDF()">Guardar como PDF</button>';
            echo '<br>';
            echo '<button class="boton" onclick="history.go(-2);">Cerrar</button>'; 
            echo '</div>';
            echo '</div>'; 
            echo '<script>';
            echo'        function generarPDF() {';
            echo  'const elemento = document.getElementById("contenido-a-pdf");';
            
            echo '        html2pdf()';
            echo '      .from(elemento)';
            echo '       .save("informacionPago.pdf");';
            echo     '       }';
            echo '</script>'; 
        }

    ?>    
        </div>
    
   <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js">
    
   </script>
</body>
</html>