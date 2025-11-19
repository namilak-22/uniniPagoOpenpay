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
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobante de Pago - UNINI</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');
        
        body {
            font-family: /* 'Roboto', sans-serif; */Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
            color: #333;
            font-size: 18px;
            line-height: 1.6;
        }
        
        .receipt-container {
            /* width: 21cm;
            min-height: 29.7cm; */
            margin: 0 auto;
            padding: 0;
            background: white;
        }
        
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px 10px 20px;
            background: linear-gradient(135deg, #1a3a8f, #0d6e9e);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .university-logo {
            margin-top: 0;
            height: 70px;
            width: auto;
            max-width: 200px;
        }
        
        .success-badge {
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 2px 8px;
            border-radius: 30px;
            font-size: 20px;
            font-weight: 500;
            white-space: nowrap;
        }
        
        .university-address {
            text-align: center;
            padding: 5px;
            background-color: rgba(0, 0, 0, 0.1);
            font-size: 15pxpx;
            color: black;
            font-weight: bold;
        }
        
        .receipt-content {
            padding: 15px 20px;
        }
        
        .section-title {
            font-size: 14px;
            color: #1a3a8f;
            border-bottom: 1px solid #1a3a8f;
            padding-bottom: 3px;
            margin: 12px 0 8px 0;
        }
        
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            padding-bottom: 6px;
            border-bottom: 1px dashed #e0e0e0;
        }
        
        .detail-label {
            font-weight: 500;
            color: #666;
            width: 45%;
        }
        
        .detail-value {
            font-weight: 400;
            text-align: right;
            width: 50%;
        }
        
        .amount-section {
            text-align: center;
            margin: 15px 0;
            padding: 12px;
            background-color: #f8f9fa;
            border-radius: 5px;
            border: 1px solid #e0e0e0;
        }
        
        .amount-label {
            font-size: 14px;
            color: #666;
            margin-bottom: 2px;
        }
        
        .amount {
            font-size: 28px;
            font-weight: 700;
            color: #1a3a8f;
        }
        
        .card-icon {
            width: 30px;
            height: auto;
            vertical-align: middle;
            margin-left: 5px;
        }
        
        .transaction-info {
            margin-top: 15px;
        }
        
        .transaction-id {
            background-color: #f1f1f1;
            padding: 6px;
            border-radius: 3px;
            font-family: monospace;
            word-break: break-all;
            margin-top: 3px;
            font-size: 14px;
        }
        
        .status-badge {
            display: inline-block;
            background-color: #e8f5e9;
            color: #2e7d32;
            padding: 4px 8px;
            border-radius: 12px;
            font-weight: 500;
            font-size: 12px;
        }
        
        .footer {
            text-align: center;
            padding: 10px;
            background-color: #f8f9fa;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #e0e0e0;
            position: absolute;
            bottom: 10px;
            width: 100%;
            box-sizing: border-box;
        }
        
        @media print {
            body {
                background: none;
                margin: 0;
                padding: 0;
            } 
            .receipt-container {
                box-shadow: none;
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 0;
            } 
            .footer {
                position: fixed; 
                bottom: 0;
            }
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <!-- Encabezado compacto -->
        <div class="header-container">
           <?php 
                        $imagePath = __DIR__.'/img/UNINI.jpg';
                        $imageData = base64_encode(file_get_contents($imagePath));
                        echo '<img class="university-logo" src="data:image/jpeg;base64,'.$imageData.'">';
                    ?>
            <div class="success-badge">¡Pago exitoso!</div>
        </div>
        <div class="university-address">Calle 15 36, Campeche, Campeche</div>
        
        <div class="receipt-content">
            <div class="section-title">INFORMACIÓN DEL PAGO</div>
            
            <div class="detail-row">
                <span class="detail-label">Nombre del Alumno:</span>
                <span class="detail-value"><?php echo $charge->customer->last_name; ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Titular de la cuenta:</span>
                <span class="detail-value"><?php echo $charge->customer->name; ?></span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Concepto del pago:</span>
                <span class="detail-value"><?php echo strtoupper($charge->description);?></span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Fecha y hora:</span>
                <span class="detail-value"><?php echo $charge->operation_date; ?></span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Estado:</span>
                <span class="detail-value"><span class="status-badge"> <?php echo $charge->status; ?></span></span>
            </div>
            
            <div class="amount-section">
                <div class="amount-label">Monto total</div>
                <div class="amount">$ <?php echo number_format($charge->amount, 2) . ' '. $charge->currency;?></div>
            </div>
            
            <div class="section-title">INFORMACIÓN DE PAGO</div>
            
            <div class="detail-row">
                <span class="detail-label">Método de pago:</span>
                <span class="detail-value">
                   <?php echo $charge->card->type . ' '.$charge->card->brand; ?>
                    
                </span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Número de tarjeta:</span>
                <span class="detail-value"><?php echo $charge->card->card_number; ?></span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Autenticación:</span>
                <span class="detail-value">Compra 3D Secure</span>
            </div>
            
            <div class="transaction-info">
                <div class="detail-row">
                    <span class="detail-label">ID de autorización:</span>
                    <span class="detail-value"><?php echo $charge->authorization;?></span>
                </div>
                
                <div>
                    <div class="detail-label">ID de transacción:</div>
                    <div class="transaction-id"><?php echo $charge->id;?></div>
                </div>
            </div>
        </div>
        
        <div class="footer">
            <p> Para cualquier aclaración, contacte a la Admninistración del Colegio</p>
            <p>© Universidad Internacional Iberoamericana. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>
           
    <?php
        $html=ob_get_clean();
        $options = $dompdf->getOptions();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true); 
        $options->set('defaultPaperSize', 'letter');
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
            $mail->Host = MAIL_HOST;
            $mail->SMTPAuth = true;
            $mail->Port = MAIL_PORT;
            $mail->Username = MAIL_USERNAME;
            $mail->Password = MAIL_PASSWORD;

            $mail->setFrom(MAIL_FROM, MAIL_FROM_NAME);
            $mail->addAddress(MAIL_TO, MAIL_TO_NAME);
            $mail->Subject = 'Notificación Pago ';
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';

            $pdfContent = $dompdf->output();
            $mail->addStringAttachment($pdfContent, 'comprobantePago.pdf', 'base64', 'application/pdf');
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