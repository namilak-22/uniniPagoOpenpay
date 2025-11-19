<?php
require_once 'vendor/autoload.php';
require_once __DIR__.'/configuracion.php';

use Openpay\Data\Openpay;

if($_SERVER['REQUEST_METHOD']==='POST'){

$openpay = Openpay::getInstance(MERCHANT_ID,
 PRIVATE_KEY, COUNTRY_CODE, IP_ADDRESS);
 OpenPay::setProductionMode(false);
$customer = array(
     'name' => $_POST['titular'],
     'last_name' => $_POST['nombre'],
     'email' => $_POST['email']
    
    );
     

    try {
		
    $chargeData = array(
        'method' => 'card',
        'source_id' => $_POST['token_id'], // Token generado con OpenPay.JS
        'amount' => floatval(str_replace(",","",str_replace("$","",$_POST['pago']))),
        'description' => $_POST['nivel'],
        'order_id' => 'ORDEN-' . uniqid(),
        'use_3d_secure' => true, // Habilitar 3D Secure
        'redirect_url' => REDIRECT_URL, // URL de retorno
        'customer' => $customer,
        'device_session_id' =>$_POST["deviceIdHiddenFieldName"]
    );
    $charge = $openpay->charges->create($chargeData);
	
    // Si requiere autenticación 3DS
    if (isset($charge->payment_method->url)) {
		echo '<script type="text/javascript">' . 'window.location.replace("' . $charge->payment_method->url . '");</script>';
        //header('Location: ' . $charge->payment_method->url);
        exit;
    }
    
    // Si no requiere autenticación adicional
    echo "Pago exitoso. ID: " . $charge->id;
    
} catch (Exception $e) {
    /* echo "Error: " . $e->getMessage(); */
    $mensajeError='No se pudo realizar la transacción';
    $mensaje='<script type="text/javascript">
    alert("';
        $errorMsg = $e-> getMessage();
	    $errorCode = $e-> getCode();
        switch($errorCode){
            case ('3001'):
                $mensajeError;
                break;
            case ('3003'):
                $mensajeError;
                break;
            case ('3004'):
                $mensajeError;
                break;
            case ('3005'):
                $mensajeError;
                break;
            case ('2010'):
                $mensajeError;
                break;
            default:
                $mensajeError;
        }
        $mensaje.='ERROR '. $mensajeError . ' '. $errorCode. ' '. $errorMsg ;
        $mensaje.='"); </script>';
        echo $mensaje;
}

    
   
}
?>