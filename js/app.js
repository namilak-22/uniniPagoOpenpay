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

document.addEventListener('DOMContentLoaded', () => {
    mes.classList.add('oculto');
    //cbx.classList.add('oculto');
    cod.classList.add('oculto');
    dip.classList.add('oculto');
    duracion.value = '';
    pago.value = '$1.00';
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
    OpenPay.setApiKey('pk_44d8187166d74edb8ae59dced8b9675d'); // MODO PRUEBA
    var deviceSessionId = OpenPay.deviceData.setup("payment-form", "deviceIdHiddenFieldName");
    OpenPay.setSandboxMode(true);
});

nivel.addEventListener('change', () => {
    inputCheckCode.checked = false;
    cbx.classList.add('oculto');
    cod.classList.add('oculto');
    mes.classList.add('oculto');
    dip.classList.add('oculto');

    if (nivel.value == 'especialidad') {
        pago.value = '';
        mes.classList.remove('oculto');
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
        //cbx.classList.remove('oculto'); // MOSTRAR CHECKBOX PARA DIPLOMADO
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
            cbx.classList.remove('oculto');
            break;
        case 'maestria':
            pago.value = '$5,000.00';
            cbx.classList.remove('oculto');
            break;
        case 'doctorado':
            pago.value = '$8,000.00';
            cbx.classList.remove('oculto');
            break;
        default:
			//cbx.classList.add('oculto');
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
        // Restaurar el precio original según el nivel seleccionado
        switch (nivel.value) {
            case 'licenciatura':
                pago.value = '$10.00';
                break;
            case 'maestria':
                pago.value = '$5,000.00';
                break;
            case 'doctorado':
                pago.value = '$8,000.00';
                break;
            case 'diplomado':
                // Restaurar precio según duración de diplomado
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
                break;
            case 'especialidad':
                // Restaurar precio según duración de especialidad
                if (duracion.value == '9') {
                    pago.value = '$2,700.00';
                } else if (duracion.value == '12') {
                    pago.value = '$3,400.00';
                } else {
                    pago.value = '';
                }
                break;
        }
    }
}

function checa() {
            
            if (document.getElementById('chkcod').checked) {
				cod.classList.remove('oculto');
                inputCodigo.value="";
            }
            else if (nivel.value=='doctorado') {
				cod.classList.add('oculto');
				document.getElementById('pago').value='$8,000.00';
			} 
	else {
				
                cod.classList.add('oculto');
				document.getElementById('pago').value='$5,000.00';
            }
        }

function valida_codigos(){
	let micodigo=document.getElementById('codigo').value;
	//alert(micodigo);
	switch (micodigo){
		case 'UNINI50':
			document.getElementById('pago').value= (nivel.value=='maestria' ? '$2,500.00' : '$5,000.00');
			break;
		case 'DOUNINI50':
			document.getElementById('pago').value=(nivel.value=='doctorado' ? '$4,000.00' : '$8,000.00');
			break;
		case 'LIUNINI50':
			document.getElementById('pago').value= (nivel.value=='licenciatura' ? '$2,500.00' : '$5,000.00');
			break;
        default:
            document.getElementById('pago').value='$5,000.00';
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