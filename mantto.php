<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sitio en Mantenimiento - UNINI</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            color: #333;
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .container {
            max-width: 800px;
            width: 100%;
            text-align: center;
        }
        
        .logo {
            max-width: 220px;
            height: auto;
            margin-bottom: 30px;
        }
        
        .maintenance-card {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            padding: 40px;
            text-align: center;
            margin-bottom: 30px;
            transition: transform 0.3s ease;
        }
        
        .maintenance-card:hover {
            transform: translateY(-5px);
        }
        
        h1 {
            color: #0c4da2;
            margin-bottom: 20px;
            font-size: 2.8rem;
            font-weight: 700;
        }
        
        .construction-image {
            max-width: 100%;
            height: auto;
            margin: 30px 0;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .message {
            font-size: 1.4rem;
            color: #6c757d;
            margin: 20px 0;
            padding: 0 10px;
        }
        
        .divider {
            height: 3px;
            width: 80px;
            background: linear-gradient(to right, #0c4da2, #e63946);
            margin: 25px auto;
            border-radius: 3px;
        }
        
        .contact-info {
            margin-top: 30px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 10px;
            font-size: 1.1rem;
        }
        
        .contact-info a {
            color: #0c4da2;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .contact-info a:hover {
            color: #e63946;
            text-decoration: underline;
        }
        
        .social-links {
            margin-top: 25px;
            display: flex;
            justify-content: center;
            gap: 20px;
        }
        
        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            background-color: #f1f8ff;
            color: #0c4da2;
            border-radius: 50%;
            font-size: 1.3rem;
            transition: all 0.3s ease;
        }
        
        .social-links a:hover {
            background-color: #0c4da2;
            color: white;
            transform: translateY(-3px);
        }
        
        footer {
            text-align: center;
            margin-top: 40px;
            padding: 20px;
            color: #6c757d;
            font-size: 0.95rem;
        }
        
        @media (max-width: 768px) {
            .maintenance-card {
                padding: 25px;
            }
            
            h1 {
                font-size: 2.2rem;
            }
            
            .message {
                font-size: 1.2rem;
            }
        }
        
        @media (max-width: 480px) {
            h1 {
                font-size: 1.8rem;
            }
            
            .message {
                font-size: 1.1rem;
            }
            
            .contact-info {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Logo de la universidad -->
        <img src="img/UNINI.jpg" alt="UNINI Universidad" class="logo">
        
        <div class="maintenance-card">
            <h1>Servicio en Mantenimiento</h1>
            
            <div class="divider"></div>
            
            <!-- Imagen de construcción -->
            <img src="img/pagina-en-mantenimiento.jpg" alt="Equipo de construcción trabajando" class="construction-image">
            
            <div class="divider"></div>
            
            <p class="message">Estamos realizando tareas de mantenimiento para mejorar nuestro formulario de pago.</p>
            
            
            
            <div class="social-links">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>
        
        <footer>
            <p>© 2023 Universidad Internacional Iberoamericana - UNINI. Todos los derechos reservados.</p>
        </footer>
    </div>
</body>
</html>