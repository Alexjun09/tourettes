<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' href='css/output.css'>
    <link rel='icon' href='../media/logo.png' type='image/x-icon'>
    <title>Manejo de Citas</title>
    <style>
        #journal-scroll::-webkit-scrollbar {
            width: 4px;
            cursor: pointer;
        }
        #journal-scroll::-webkit-scrollbar:horizontal {
            height: 0px;
        }
        #journal-scroll::-webkit-scrollbar-track {
            background-color: rgba(229, 231, 235, var(--bg-opacity));
            cursor: pointer;
        }
        #journal-scroll::-webkit-scrollbar-thumb {
            cursor: pointer;
            background-color: #a0aec0;
        }
    </style>
</head>
<body class='font-extralight grid grid-rows-[1fr_min-content] text-primary'>
    <div class='h-screen w-screen flex flex-col'>
        <!-- header -->
        <div class='px-20 flex flex-row justify-between items-center py-4'>
            <a class='h-16' href='./index.php'>
                <img src='../media/logoindex.png' alt='' class='h-full'>
            </a>
            <nav class='flex flex-row gap-10 text-primary text-lg'>
                <a href='./educacion.php'>Educación</a>
                <a href='./pedir-cita.php'>Pedir Cita</a>
                <a href='./comunidad.php'>Comunidad</a>
                <a href='./contacto.php'>About Us</a>
            </nav>
            <a class='rounded-tl-xl rounded-br-xl border-br-xl bg-primary text-white py-2 px-10' href='./mi-cuenta.php'>Mi Cuenta</a>
        </div>
        <!-- body -->
        <div class='flex font-extralight flex-col w-full h-full items-center justify-center gap-6 px-72'>
            <?php
            require_once './bbdd/database.php';
            session_start();
            if (!isset($_SESSION['idPaciente'])) {
                header('Location: sign-in.html');
                exit;
            }

            $cita = $_GET['cita'] ?? '';
            if ($cita === 'exito') {
                echo "
                <div class='w-full h-fit bg-secondary flex flex-col justify-center items-center text-white text-center text-body p-10 gap-2'>
                    <p>¡Muchas gracias por utilizar nuestros servicios!</p>
                    <div class=''>
                        <img src='../media/envelope.png' alt='' class='max-h-[300px]'>
                    </div>
                    <p>En breve, recibirá un correo electrónico con los datos de su cita</p>
                </div>
                ";
            } elseif ($cita === 'eliminado') {
                echo "
                <div class='w-full h-fit bg-secondary flex flex-col justify-center items-center text-white text-center text-body p-10 gap-4'>
                    <h2 class='text-[24px] font-bold'>Cita Anulada con Éxito</h2>
                    <p>Tu cita ha sido anulada correctamente. Si necesitas reprogramar o tienes alguna pregunta, estamos aquí para ayudarte.</p>
                    <div class='flex flex-col gap-2 mt-4'>
                        <a href='./pedir-cita.php' class='rounded-md bg-primary text-white py-2 px-6'>Programar Nueva Cita</a>
                        <a href='./mi-cuenta.php' class='rounded-md bg-primary text-white py-2 px-6'>Ver Mis Citas</a>
                        <a href='./contacto.php' class='rounded-md bg-primary text-white py-2 px-6'>Contactar Soporte</a>
                    </div>
                </div>
                ";
            } else {
                echo "
                <div class='w-full h-fit bg-secondary flex flex-col justify-center items-center text-white text-center text-body p-10 gap-2'>
                    <p>¡Lo sentimos!</p>
                    <p>No se ha podido realizar la cita en este momento.</p>
                </div>
                ";
            }
            ?>
            <div class='w-full flex items-start'>
                <a href='./listado-de-psicologos.php' class='rounded-md border border-primary text-primary py-2 px-6'>Volver</a>
            </div>
        </div>
    </div>
    <!-- footer -->
    <div class='h-28 flex flex-row bg-contraste px-12 items-center justify-between'>
        <p>gLabs© 2023. Todos Los Derechos Reservados</p>
        <div class='flex flex-row gap-4'>
            <a href=''>
                <img class='w-10 h-10' src='../media/x.png' alt='x'>
            </a>
            <a href=''>
                <img class='w-10 h-10' src='../media/insta.png' alt='insta'>
            </a>
            <a href=''>
                <img class='w-10 h-10' src='../media/facebook.png' alt='facebook'>
            </a>
        </div>
    </div>
</body>
</html>
