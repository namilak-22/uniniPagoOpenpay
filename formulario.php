<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/normalize.css">
    <link href="css/stylesOpenPay.css" rel="stylesheet">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://js.openpay.mx/openpay.v1.min.js"></script>
    <script type='text/javascript' src="https://js.openpay.mx/openpay-data.v1.min.js"></script>

    <title>UNINI</title>
</head>

<body>
    <?php require_once __DIR__ . '/openpay.php';
    ?>

    <div class="contenedor">
        <form method='POST' class="formulario" action='' id="payment-form">
            <div class="pymnt-cntnt">
                <div class="card-expl">
                    <div class="credit">
                        <h4>Tarjetas de crédito</h4>
                    </div>
                    <div class="debit">
                        <h4>Tarjetas de débito</h4>
                    </div>
                </div>
            </div>
            <input type="hidden" name="token_id" id="token_id">
            <fieldset>
                <legend>Formulario de Pago</legend>
                <div class="contenedor-campo">
                    <div class="campo">
                        <label for="nombre">Nombre Completo</label>
                        <input type="text" class="input-text" placeholder="Tu nombre" id="nombre" name="nombre" onkeydown="return (event.keyCode!=13)">
                    </div>
                    <div class="campo">
                        <label>Nivel a estudiar</label>
                        <select name="nivel" id="nivel">
                            <option value="licenciatura" selected>Licenciatura</option>
                            <option value="diplomado">Diplomado</option>
                            <option value="especialidad">Especialidad</option>
                            <option value="maestria">Maestría</option>
                            <option value="doctorado">Doctorado</option>
                        </select>
						<div class="aparecer1">
                        	<div class="form-check">
                            	<input class="form-check-input" type="checkbox" value="" id="chkcod">
                            	<label class="form-check-label" for="chkcod">Tengo código</label>
                        	</div>
						</div>
                    </div>
                    <div class="aparecer3">
                        <div class="campo ">
                            <label>Duración Diplomado</label>
                            <select name="diplomado" id="diplo">
                                <option value="" selected>
                                    < ---Seleccione uno --->
                                </option>
                                <option value=3>3 meses</option>
                                <option value=6>6 meses</option>
                                <option value=9>9 meses</option>
                                <option value=12>12 meses</option>
                            </select>
                        </div>
                    </div>
                    <div class="aparecer">
                        <div class="campo ">
                            <label>Duración Especialidad</label>
                            <select name="mensualidad" id="mensual">
                                <option value="" selected>
                                    < ---Seleccione uno --->
                                </option>
                                <option value=9>9 meses</option>
                                <option value=12>12 meses</option>
                            </select>
                        </div>
                    </div>
                    <div class="aparecer2">
                        <div class="campo">
                            <label for="codigo">Código</label>
                            <input type="text" class="input-text" id="codigo" maxlength="10" onkeydown="return (event.keyCode!=13)">
                        </div>
                    </div>
                    <div class="campo">
                        <label for="pago">Importe a Pagar</label>
                        <input type="text" class="input-text" id="pago" name="pago">
                    </div>
                    <div class="campo">
                        <label for="tarjeta">Número Tarjeta</label>
                        <input type="text" class="input-text" placeholder="Tu número de tarjeta" id="tarjeta" onkeydown="return (event.keyCode!=13)" data-openpay-card="card_number" maxlength="16">
                    </div>
                    <div class="campo">
                        <label for="titular">Titular Tarjeta</label>
                        <input type="text" class="input-text" placeholder="Nombre titular" id="titular" name="titular" onkeydown="return (event.keyCode!=13)" data-openpay-card="holder_name">
                    </div>
                    <div class="campo">
                        <label for="titular">Correo Titular</label>
                        <input type="email" class="input-text" placeholder="Introduce email" id="email" name="email" onkeydown="return (event.keyCode!=13)" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
                    </div>
                    <div class="campo combo-fecha">
                        <label for="exp">Fecha Expiración (mes/año): </label>
                        <select name="exp" id="exp" data-openpay-card="expiration_month">
                            <option value="1" selected>01</option>
                            <option value=2>02</option>
                            <option value=3>03</option>
                            <option value=4>04</option>
                            <option value=5>05</option>
                            <option value=6>06</option>
                            <option value=7>07</option>
                            <option value=8>08</option>
                            <option value=9>09</option>
                            <option value=10>10</option>
                            <option value=11>11</option>
                            <option value=12>12</option>
                        </select>
                        <select id="anio" data-openpay-card="expiration_year">
                            <option value="">año</option>
                        </select>
                    </div>
                    <div class="campo campo-cvv">
                        <label for="cvv">CVV</label>
                        <div class="campo-cvv">
                            <input type="password" class="input-text" id="cvv" maxlength="3"
                                onkeydown="return (event.keyCode!=13)" data-openpay-card="cvv2">
                            <img src="/img/cvv.png" alt="muestra cvv" id="imgCvv">
                        </div>
                    </div>
                    <input type="submit" value="Enviar" class="boton" id="pay-button">

                </div>
            </fieldset>
            <div class="openpay">
                <div class="openpay-item">
                    <div class="logo-container"></div>
                    <div class="text-content">
                        <p>Transacciones realizadas vía:</p>
                    </div>
                </div>

                <div class="divider"></div>

                <div class="openpay-item">
                    <div class="shield-container"></div>
                    <div class="text-content">
                        <p>Tus pagos se realizan de forma segura con encriptación de 256 bits</p>
                    </div>
                </div>
            </div>
            <div class="footer_logo">
                <img src="/img/UEA.jpg" alt="Imagen UEA">
                <img src="/img/UNINI.jpg" alt="Imagen UNINI">
                <img src="/img/UNIB.jpg" alt="Imagen UNIB">
                <img src="/img/UNIROMANA.jpg" alt="Imagen UNIROMANA">
            </div>
        </form>

    </div>

    <script src='js/app.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>