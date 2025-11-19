const nivel = document.querySelector('#nivel');
const mes = document.querySelector('.aparecer'); 
const cbx = document.querySelector('.aparecer1'); 
const cod = document.querySelector('.aparecer2'); 
const dip = document.querySelector('.aparecer3'); 
const pago = document.querySelector('#pago');
const duracion = document.querySelector('#mensual');
const diplom = document.querySelector('#diplo');
const inputCheckCode = document.getElementById('chkcod');
const inputCodigo = document.getElementById('codigo');

// Almacenar precios originales para restaurarlos cuando sea necesario
const preciosOriginales = {
    licenciatura: 5000.00,
    maestria: 5000.00,
    doctorado: 8000.00,
    especialidad: {
        9: 2700.00,
        12: 3400.00
    },
    diplomado: {
        3: 1600.00,
        6: 2000.00,
        9: 2700.00,
        12: 3400.00
    }
};

document.addEventListener('DOMContentLoaded', () => {
    mes.classList.add('oculto');
    cod.classList.add('oculto');
    dip.classList.add('oculto');
    duracion.value = '';
    pago.value = '$5,000.00';
    pago.setAttribute('readonly', true);
    selectAnio();
    
    $('#pay-button').on('click', function(event) {
        if (pago.value.length == 0) {
            imprimirAlerta('Selecciona la duración del nivel a estudiar', 'error');
            return false;
        } else if (document.getElementById('anio').value == '') {
            imprimirAlerta('Selecciona el año', 'error');
            return false;
        } else if (document.getElementById('tarjeta').value == '') {
            imprimirAlerta('Escribe el número de tarjeta', 'error');
            return false;
        } else if (document.getElementById('titular').value == '' || document.getElementById('nombre').value == '') {
            imprimirAlerta('Escribe el nombre del titular', 'error');
            return false;
        } else if (document.getElementById('cvv').value == '') {
            imprimirAlerta('Escribe el cvv de la tarjeta', 'error');
            return false;
        } else if (!validarEmail(document.getElementById('email').value)) {
            imprimirAlerta('Correo no válido', 'error');
            return false;
        } else {
            event.preventDefault();
            $("#pay-button").prop("disabled", true);
            OpenPay.token.extractFormAndCreate('payment-form', success_callbak, error_callbak);
        }
    });
});

$(document).ready(function() {
    OpenPay.setId('mrxyxft3btwbbovm2q5s');
    OpenPay.setApiKey('pk_35d298fd863145f5959e0fbc3b832bff');
    var deviceSessionId = OpenPay.deviceData.setup("payment-form", "deviceIdHiddenFieldName");
    OpenPay.setSandboxMode(false);
});

nivel.addEventListener('change', () => {
    inputCheckCode.checked = false;
    cbx.classList.add('oculto'); // OCULTAR CHECKBOX POR DEFECTO
    cod.classList.add('oculto');
    mes.classList.add('oculto');
    dip.classList.add('oculto');

    if (nivel.value == 'especialidad') {
        pago.value = '';
        mes.classList.remove('oculto');
        cbx.classList.remove('oculto'); // MOSTRAR CHECKBOX PARA ESPECIALIDAD
        duracion.value = '';
        duracion.addEventListener('change', () => {
            if (duracion.value == '9') {
                pago.value = '$2,700.00';
            } else if (duracion.value == '12') {
                pago.value = '$3,400.00';
            } else {
                pago.value = '';
            }
        });
    } else if (nivel.value == 'diplomado') {
        pago.value = '';
        dip.classList.remove('oculto');
        // NO mostrar checkbox para diplomado
        diplom.value = '';
        diplom.addEventListener('change', () => {
            if (diplom.value == '3') {
                pago.value = '$1,600.00';
            } else if (diplom.value == '6') {
                pago.value = '$2,000.00';
            } else if (diplom.value == '9') {
                pago.value = '$2,700.00';
            } else if (diplom.value == '12') {
                pago.value = '$3,400.00';
            } else {
                pago.value = '';
            }
        });
    }

    switch (nivel.value) {
        case 'licenciatura':
            pago.value = '$10.00';
            cbx.classList.remove('oculto'); // MOSTRAR CHECKBOX PARA LICENCIATURA
            break;
        case 'maestria':
            pago.value = '$5,000.00';
            cbx.classList.remove('oculto'); // MOSTRAR CHECKBOX PARA MAESTRÍA
            break;
        case 'doctorado':
            pago.value = '$8,000.00';
            cbx.classList.remove('oculto'); // MOSTRAR CHECKBOX PARA DOCTORADO
            break;
        default:
            // Para especialidad y diplomado ya se manejan arriba
            break;
    }
});

inputCheckCode.addEventListener('change', function() {
    checa();
});

inputCodigo.addEventListener('keyup', function() {
    valida_codigos();
});

function checa() {
    if (document.getElementById('chkcod').checked) {
        cod.classList.remove('oculto');
        inputCodigo.value = "";
    } else {
        cod.classList.add('oculto');
        restaurarPrecioOriginal();
    }
}

function restaurarPrecioOriginal() {
    switch (nivel.value) {
        case 'licenciatura':
            pago.value = '$' + preciosOriginales.licenciatura.toLocaleString('es-MX', {minimumFractionDigits: 2});
            break;
        case 'maestria':
            pago.value = '$' + preciosOriginales.maestria.toLocaleString('es-MX', {minimumFractionDigits: 2});
            break;
        case 'doctorado':
            pago.value = '$' + preciosOriginales.doctorado.toLocaleString('es-MX', {minimumFractionDigits: 2});
            break;
        case 'diplomado':
            // Restaurar precio según duración de diplomado
            if (diplom.value && preciosOriginales.diplomado[diplom.value]) {
                pago.value = '$' + preciosOriginales.diplomado[diplom.value].toLocaleString('es-MX', {minimumFractionDigits: 2});
            } else {
                pago.value = '';
            }
            break;
        case 'especialidad':
            // Restaurar precio según duración de especialidad
            if (duracion.value && preciosOriginales.especialidad[duracion.value]) {
                pago.value = '$' + preciosOriginales.especialidad[duracion.value].toLocaleString('es-MX', {minimumFractionDigits: 2});
            } else {
                pago.value = '';
            }
            break;
        default:
            pago.value = '';
            break;
    }
}
function valida_codigos() {
    let micodigo = document.getElementById('codigo').value;
    
    // Si el código está vacío, restaurar el precio original
    if (!micodigo.trim()) {
        restaurarPrecioOriginal();
        return;
    }
    
    switch (micodigo) {
        case 'UNINI50':
            if (nivel.value == 'maestria') {
                pago.value = '$2,500.00';
            } else if (nivel.value == 'licenciatura') {
                pago.value = '$2,500.00';
            } else if (nivel.value == 'especialidad') {
                // Aplicar 50% de descuento a especialidad
                if (duracion.value == '9') {
                    pago.value = '$1,350.00';
                } else if (duracion.value == '12') {
                    pago.value = '$1,700.00';
                }
            }
            break;
        case 'DOUNINI50':
            if (nivel.value == 'doctorado') {
                pago.value = '$4,000.00';
            }
            break;
        case 'LIUNINI50':
            if (nivel.value == 'licenciatura') {
                pago.value = '$5.00';
            }
            break;
        default:
            // Si el código no coincide con ninguno conocido, restaurar precio original
            restaurarPrecioOriginal();
            break;
    }
}

function selectAnio() {
    const selectAnio = document.getElementById('anio');
    const ultimoAnio = new Date().getFullYear() % 100 + 10;
    for (let i = new Date().getFullYear() % 100; i <= ultimoAnio; i++) {
        selectAnio.innerHTML += `<option value="${i}">${i}</option>`;
    }
}

function success_callbak(response) {
    $('#token_id').val(response.data.id);
    $('#payment-form').submit();
}

function error_callbak(response) {
    var desc = response.data.description != undefined ?
        response.data.description : response.message;
    let errorCallback = `${response.status} ${desc}`;
    imprimirAlerta(errorCallback, 'error');
    $("#pay-button").prop("disabled", false);
}

function validarEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function imprimirAlerta(mensaje, tipo) {
    Swal.fire({
        title: mensaje,
        icon: tipo,
        draggable: true
    });
}