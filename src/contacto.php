<?php
require_once './bbdd/database.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/output.css">
    <link rel="icon" href="../media/logo.png" type="image/x-icon">
    <script src="./scripts/procesar-contacto.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Pedir Cita</title>
</head>

<body class="font-extralight grid grid-rows-[1fr_min-content] text-primary">

    <div class="h-screen w-screen flex flex-col">
        <!-- header -->
        <header class="px-20 flex flex-row justify-between items-center py-4">
            <a class="h-16" href="./index.php">
                <img src="../media/logoindex.png" alt="" class="h-full">
            </a>
            <nav class="flex flex-row gap-10 text-primary text-lg">
                <a href="./educacion.php">Educación</a>
                <a href="./listado-de-psicologos.php">Pedir Cita</a>
                <a href="./comunidad.php">Comunidad</a>
                <a href="./contacto.php">Contacto</a>
            </nav>
            <!-- Suponiendo que ya iniciaste la sesión con session_start(); al principio de tu script PHP -->
            <div class="flex flex-row justify-between items-center gap-4">
                <!-- Otros elementos del header aquí -->

                <!-- Verificar si existe el id de paciente en la sesión -->
                <?php if (isset($_SESSION['idPaciente'])) : ?>
                    <!-- Botón Mi Cuenta para usuarios logueados -->
                    <a class="rounded-tl-xl rounded-br-xl border-br-xl bg-primary text-white py-2 px-10" href="./mi-cuenta.php">Mi Cuenta</a>
                    <a href="#" onclick="confirmarCerrarSesion();">
                        <img src="../media/cerrar-sesion.png" alt="Cerrar Sesión" class="rounded-tl-xl rounded-br-xl h-10">
                    </a>
                <?php else : ?>
                    <!-- Botones Sign in y Sign up para usuarios no logueados -->
                    <a class="rounded-tl-xl rounded-br-xl border-br-xl bg-primary text-white py-2 px-6" href="./sign-in.html">Sign in</a>
                    <a class="rounded-tl-xl rounded-br-xl border-br-xl bg-primary text-white py-2 px-6" href="./sign-up.html">Sign up</a>
                <?php endif; ?>

                <!-- Otros elementos del header aquí -->
            </div>
        </header>
        <!-- body -->
        <div class="flex font-extralight flex-col w-full h-full">
            <p class="text-title text-center">Contacto</p>
            <!-- <div class="flex flex-row w-full px-44">
               
                <div class="col-span-3 w-full border border-black">
                    <img src="" alt="">
                </div>
            </div> -->
            <p class="text-subtitle text-center">Formulario</p>
            <div class="w-full h-full relative flex flex-row justify-center items-center">
                <img src="../media/fondo-contacto.png" alt="" class="w-full h-[500px] absolute z-10">
                <div class="flex flex-row absolute w-full h-[500px] justify-center items-center">
                    <div class="absolute w-full h-full z-40">
                        <div class="flex flex-col gap-2 w-min h-full px-20 py-10">
                            <div onclick="" id="botonInformacionDeContacto" class="flex-1 flex flex-col cursor-pointer items-center justify-center text-center mx-auto w-full h-fit text-white hover:text-contraste gap-2">
                                <img src="../media/personita.png" alt="" class="w-7 m-1">
                                <p class="block text-xs pb-2 whitespace-nowrap">Nosotros</p>
                            </div>
                            <div onclick="" id="botonFormularioDeContacto" class="flex-1 flex flex-col cursor-pointer items-center justify-center text-center mx-auto w-full h-fit text-white hover:text-contraste gap-2">
                                <img src="../media/telefonito.png" alt="" class="w-7 m-1">
                                <p class="block text-xs pb-2">Formulario</p>
                            </div>
                            <div onclick="" id="botonFAQs" class="flex-1 flex flex-col cursor-pointer items-center justify-center text-center mx-auto w-full h-fit text-white hover:text-contraste gap-2">
                                <img src="../media/lupita.png" alt="" class="w-7 m-1">
                                <p class="block text-xs pb-2">FAQs</p>
                            </div>
                        </div>
                    </div>
                    <!-- información de contacto -->
                    <div id="informacionDeContacto" class="flex flex-row items-center justify-center gap-3 z-30">
                        <div class="flex flex-col rounded-lg max-w-[400px] bg-white ">
                            <div class="flex flex-col bg-contraste rounded-lg p-4">
                                <div class="flex flex-row items-center gap-4">
                                    <img src="../media/alex.png" alt="careto" class="rounded-full max-w-24">
                                    <p class="text-body">Alejandro Junyent</p>
                                </div>
                                <p>Programador talentoso y solitario, más cómodo con el código que con las complejidades
                                    de las interacciones sociales.
                                </p>
                            </div>
                            <div class="flex flex-col rounded-b-lg gap-2 p-4">
                                <div class="flex flex-row items-center gap-2">
                                    <img src="../media/envelopes.png" alt="envelope" class="max-h-7">
                                    <p>alex@glabs.es</p>
                                </div>
                                <div class="flex flex-row items-center gap-2">
                                    <img src="../media/github.png" alt="github" class="max-h-7">
                                    <p>github.com/Alexito</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col rounded-lg max-w-[400px] bg-white ">
                            <div class="flex flex-col bg-contraste rounded-lg p-4">
                                <div class="flex flex-row items-center gap-4">
                                    <img src="../media/aaron.png" alt="careto" class="rounded-full max-w-24">
                                    <p class="text-body">Aaron Escudero</p>
                                </div>
                                <p>Programador talentoso y solitario, más cómodo con el código que con las complejidades
                                    de las interacciones sociales.
                                </p>
                            </div>
                            <div class="flex flex-col rounded-b-lg gap-2 p-4">
                                <div class="flex flex-row items-center gap-2">
                                    <img src="../media/envelopes.png" alt="envelope" class="max-h-7">
                                    <p>Aaron@glabs.es</p>
                                </div>
                                <div class="flex flex-row items-center gap-2">
                                    <img src="../media/github.png" alt="github" class="max-h-7">
                                    <p>github.com/Aaroncito</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col rounded-lg max-w-[400px] bg-white ">
                            <div class="flex flex-col bg-contraste rounded-lg p-4">
                                <div class="flex flex-row items-center gap-4">
                                    <img src="../media/dani.png" alt="careto" class="rounded-full max-w-24">
                                    <p class="text-body">Daniel Herrero</p>
                                </div>
                                <p>Programador talentoso y solitario, más cómodo con el código que con las complejidades
                                    de las interacciones sociales.
                                </p>
                            </div>
                            <div class="flex flex-col rounded-b-lg gap-2 p-4">
                                <div class="flex flex-row items-center gap-2">
                                    <img src="../media/envelopes.png" alt="envelope" class="max-h-7">
                                    <p>daniel@glabs.es</p>
                                </div>
                                <div class="flex flex-row items-center gap-2">
                                    <img src="../media/github.png" alt="github" class="max-h-7">
                                    <p>github.com/Danicito</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- formulario de contacto -->
                    <div class="hidden w-full h-full flex justify-center items-center" id="formularioDeContacto">
                        <form action="server/procesar-contacto.php" method="post" class="text-white flex flex-col z-50 w-[40%]" name="formulario" id="formulario">
                            <input type="text" name="nombre" placeholder="Nombre Completo" class="outline-none border-b border-white text-white w-full bg-transparent pb-2">
                            <br>
                            <input type="text" name="telefono" placeholder="Telefono" class="outline-none border-b border-white text-white w-full bg-transparent pb-2">
                            <br>
                            <input type="email" name="email" placeholder="Email" class="outline-none border-b border-white text-white w-full bg-transparent pb-2">
                            <br>
                            <textarea name="motivo" id="motivo" placeholder="Motivo" class="border border-white text-white bg-transparent p-2 outline-none"></textarea>
                            <br>
                            <div class="flex flex-row items-center gap-2">
                                <input type="checkbox" name="terminos">
                                <p>Terminos y condiciones</p>
                            </div>
                            <br>
                            <button class="border-2 border-white py-2 px-8 bg-transparent rounded-full w-fit">Enviar</button>
                        </form>
                    </div>
                    <!-- FAQs -->
                    <div id="FAQs" class="hidden z-50">
                    <div id="accordion-collapse" data-accordion="collapse" class="bg-white rounded-xl flex flex-col min-w-[1400px]">
    <h2 id="accordion-collapse-heading-1">
        <button type="button" class="flex items-center justify-between p-2 w-full font-medium text-left border border-gray-200  border-b-0 text-contraste  bg-gray-100   rounded-t-xl" data-accordion-target="#accordion-collapse-body-1" aria-expanded="true" aria-controls="accordion-collapse-body-1">
            <span class="text-base">¿Cómo puedo ponerme en contacto con un especialista en síndrome de Tourette?</span>
            <svg data-accordion-icon class="w-6 h-6 shrink-0 rotate-180" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
        </button>
    </h2>
    <div id="accordion-collapse-body-1" aria-labelledby="accordion-collapse-heading-1">
        <div class="p-5 border border-gray-200  border-b-0 bg-white">
            <p class="mb-2 text-gray-500 ">Para contactar a un especialista en síndrome de Tourette, te recomendaría seguir algunos pasos específicos. En primer lugar, consulta con tu médico de cabecera o de atención primaria. Ellos podrán proporcionarte recomendaciones y referencias de especialistas en tu área. Además, puedes buscar en línea en directorios médicos especializados o utilizar herramientas de búsqueda proporcionadas por instituciones médicas y hospitales. Asegúrate de verificar las credenciales y la experiencia del especialista antes de programar una consulta.</p>
        </div>
    </div>
    <h2 id="accordion-collapse-heading-2">
        <button type="button" class="flex items-center    justify-between p-2 w-full font-medium border border-gray-200  border-b-0 text-left text-contraste  bg-gray-100   " data-accordion-target="#accordion-collapse-body-2" aria-expanded="false" aria-controls="accordion-collapse-body-2">
            <span class="text-base">¿Esta página ofrece recursos educativos sobre el síndrome de Tourette?</span>
            <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
        </button>
    </h2>
    <div id="accordion-collapse-body-2" class="hidden" aria-labelledby="accordion-collapse-heading-2">
        <div class="p-5 border border-gray-200  border-b-0 bg-white">
            <p class="mb-2 text-gray-500 ">Sí, nuestro sitio web está comprometido a proporcionar una amplia gama de recursos educativos sobre el síndrome de Tourette. Estos recursos incluyen artículos detallados escritos por expertos en el campo, videos informativos que explican los síntomas y tratamientos del síndrome, enlaces a organizaciones de apoyo y grupos de investigación, así como también materiales descargables como folletos y guías para pacientes y cuidadores. Nuestro objetivo es proporcionar información precisa y comprensible que pueda ayudar a las personas a entender mejor el síndrome de Tourette y cómo manejarlo.</p>
        </div>
    </div>
    <!-- Pregunta 3 -->
    <h2 id="accordion-collapse-heading-3">
        <button type="button" class="flex items-center justify-between p-2 w-full font-medium text-left border border-gray-200  border-b-0 text-contraste  bg-gray-100   " data-accordion-target="#accordion-collapse-body-3" aria-expanded="false" aria-controls="accordion-collapse-body-3">
            <span class="text-base">¿Dónde puedo encontrar historias o testimonios de personas con síndrome de Tourette?</span>
            <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
        </button>
    </h2>
    <div id="accordion-collapse-body-3" class="hidden" aria-labelledby="accordion-collapse-heading-3">
        <div class="p-5 border border-gray-200  border-b-0 bg-white">
            <p class="mb-2 text-gray-500 ">En nuestra página, hemos creado un espacio dedicado a compartir historias y testimonios reales de personas que viven con el síndrome de Tourette. Estas historias son relatos auténticos de individuos que han experimentado los desafíos y triunfos asociados con el síndrome. Además, ofrecemos entrevistas en profundidad, videos personales y blogs escritos por personas con síndrome de Tourette y sus seres queridos. Creemos que compartir estas experiencias puede ayudar a construir comunidad, aumentar la conciencia y fomentar la comprensión sobre el síndrome de Tourette.</p>
        </div>
    </div>
    <!-- Pregunta 4 -->
    <h2 id="accordion-collapse-heading-4">
        <button type="button" class="flex items-center justify-between p-2 w-full font-medium text-left border border-gray-200  border-b-0 text-contraste  bg-gray-100   " data-accordion-target="#accordion-collapse-body-4" aria-expanded="false" aria-controls="accordion-collapse-body-4">
            <span class="text-base">¿Ofrece la página asesoramiento o apoyo emocional en línea para personas afectadas por el síndrome de Tourette?</span>
            <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
        </button>
    </h2>
    <div id="accordion-collapse-body-4" class="hidden" aria-labelledby="accordion-collapse-heading-4">
        <div class="p-5 border border-gray-200  border-b-0 bg-white">
            <p class="mb-2 text-gray-500 ">Sí, entendemos que vivir con el síndrome de Tourette puede ser desafiante y emocionalmente exigente, tanto para quienes lo padecen como para sus familiares y cuidadores. Es por eso que ofrecemos servicios de asesoramiento y apoyo emocional en línea a través de nuestra plataforma. Trabajamos con profesionales de la salud mental capacitados y compasivos que pueden brindar orientación, apoyo y recursos a las personas afectadas por el síndrome de Tourette. Nuestro objetivo es proporcionar un espacio seguro y comprensivo donde las personas puedan compartir sus preocupaciones, recibir apoyo y encontrar esperanza en su viaje hacia el bienestar emocional.</p>
        </div>
    </div>
    <!-- Pregunta 5 -->
    <h2 id="accordion-collapse-heading-5">
        <button type="button" class="flex items-center justify-between p-2 w-full font-medium text-left border border-gray-200  border-b-0 text-contraste  bg-gray-100   " data-accordion-target="#accordion-collapse-body-5" aria-expanded="false" aria-controls="accordion-collapse-body-5">
            <span class="text-base">¿Cómo puedo unirme a la comunidad o foro en línea relacionado con el síndrome de Tourette en esta página?</span>
            <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
        </button>
    </h2>
    <div id="accordion-collapse-body-5" class="hidden" aria-labelledby="accordion-collapse-heading-5">
        <div class="p-5 border border-gray-200  border-b-0 bg-white">
            <p class="mb-2 text-gray-500 ">Para unirte a nuestra comunidad en línea sobre el síndrome de Tourette, simplemente regístrate en nuestro sitio web y accede a la sección de la comunidad. Una vez que hayas creado una cuenta, podrás participar en debates, hacer preguntas, compartir recursos y conectarte con otras personas que comparten experiencias similares. Nuestra comunidad en línea es un lugar de apoyo mutuo, comprensión y solidaridad, donde las personas pueden encontrar consuelo, compartir conocimientos y construir relaciones significativas.</p>
        </div>
    </div>
    <!-- Pregunta 6 -->
    <h2 id="accordion-collapse-heading-6">
        <button type="button" class="flex items-center justify-between p-2 w-full font-medium text-left border border-gray-200  border-b-0 text-contraste  bg-gray-100   rounded-b-xl" data-accordion-target="#accordion-collapse-body-6" aria-expanded="false" aria-controls="accordion-collapse-body-6">
            <span class="text-base">¿Qué debo hacer si encuentro un error en el sitio web o tengo problemas técnicos al navegar?</span>
            <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
        </button>
    </h2>
    <div id="accordion-collapse-body-6" class="hidden" aria-labelledby="accordion-collapse-heading-6">
        <div class="p-5 border border-gray-200  border-b-0 bg-white">
            <p class="mb-2 text-gray-500 ">Si encuentras algún error en nuestro sitio web o experimentas problemas técnicos mientras navegas, queremos saberlo para poder solucionarlo de inmediato. Por favor, contáctanos utilizando nuestro formulario de contacto o envíanos un correo electrónico detallando el problema que estás experimentando. Nuestro equipo técnico revisará el problema y trabajará diligentemente para solucionarlo lo antes posible. Agradecemos tus comentarios y tu ayuda para mejorar nuestra plataforma y garantizar una experiencia óptima para todos nuestros usuarios.</p>
        </div>
    </div>
</div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- footer -->
    <div class="h-28 flex flex-row bg-contraste px-12 items-center justify-between">
        <p>gLabs© 2023. Todos Los Derechos Reservados</p>
        <div class="flex flex-row gap-4">
            <a href="">
                <img class="w-10 h-10" src="../media/x.png" alt="x">
            </a>
            <a href="">
                <img class="w-10 h-10" src="../media/insta.png" alt="insta">
            </a>
            <a href="">
                <img class="w-10 h-10" src="../media/facebook.png" alt="facebook">
            </a>
        </div>
    </div>

</body>

</html>
<script>
    const botonInformacionDeContacto = document.getElementById('botonInformacionDeContacto');
    const botonFormularioDeContacto = document.getElementById('botonFormularioDeContacto');
    const botonFAQs = document.getElementById('botonFAQs');
    const informacionDeContacto = document.getElementById('informacionDeContacto');
    const formularioDeContacto = document.getElementById('formularioDeContacto');
    const FAQs = document.getElementById('FAQs');

    botonInformacionDeContacto.addEventListener('click', () => {
        informacionDeContacto.classList.remove('hidden');
        formularioDeContacto.classList.add('hidden');
        FAQs.classList.add('hidden');
    });

    botonFormularioDeContacto.addEventListener('click', () => {
        informacionDeContacto.classList.add('hidden');
        formularioDeContacto.classList.remove('hidden');
        FAQs.classList.add('hidden');
    });

    botonFAQs.addEventListener('click', () => {
        informacionDeContacto.classList.add('hidden');
        formularioDeContacto.classList.add('hidden');
        FAQs.classList.remove('hidden');
    });


//Cerrar sesion
    function confirmarCerrarSesion() {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¿Quieres cerrar la sesión?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1D3A46',
            cancelButtonColor: '#92AAB3',
            confirmButtonText: 'Cerrar Sesión',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Asumiendo que tienes un archivo logout.php que maneja el cierre de sesión
                window.location.href = './server/logout.php';
            }
        });
        return false; // Evita la navegación
    }

</script>
<script src="https://unpkg.com/flowbite@1.3.3/dist/flowbite.js"></script>