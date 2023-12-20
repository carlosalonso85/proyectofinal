$(document).ready(
    function slider(){
    // Asignamos el elemento #slider a la variable slider
    const slider = $("#slider");

    // Inicializamos el plugin Slick con las opciones deseadas
    slider.slick({
        // Mostrar solo tres imágenes cada vez
        slidesToShow: 3,
        // Avanzar de tres en tres imágenes
        slidesToScroll: 3,
        // Avanzar automáticamente
        autoplay: true,
        // Transición de 2 segundos entre imágenes
        autoplaySpeed: 3000,
        // Textos de los botones de navegación
        // Ocultar los dots de navegación
        dots: false,
        responsive: [
        {
            // Si la pantalla es menor a 800px
            breakpoint: 800,
            // Mostrar solo dos imágenes a la vez
            settings: {
                // Mostrar solo dos imágenes
                slidesToShow: 2,
                //La transicion será de 1 en 1
                slidesToScroll: 1,
                //Se ocultarán los botones personalizados 
                arrows: false,
                // Muestra los dots de navegación
                dots: true,
                //No se moverá automáticamente
                autoplay: false
            }
        }
        ]
    });
});



