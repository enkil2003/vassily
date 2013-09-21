$('document').ready(function(){
    /** @TODO documentar para que las 3 lineas siguientes o moverlas a la seccion correspondiente */
    $('#promotion #imagepromotion, #promotion #descriptionpromotion').equalHeightColumns();
    $('#yourProject .fixedHeight').equalHeightColumns();
    $('#newAndOfers figcaption a').vAlign();
    // placeholder html support for ie8
    if(!Modernizr.input.placeholder){
        $("input, textarea").each(function(){
            if($(this).val() == "" && $(this).attr("placeholder") != ""){
                $(this).val($(this).attr("placeholder")).css('color', '#AAA');
                $(this).focus(function(){
                    if ($(this).val()==$(this).attr("placeholder")) $(this).val("");
                    $(this).css('color', '#000');
                });
                $(this).blur(function(){
                    if ($(this).val()=="") $(this).val($(this).attr("placeholder")).css('color', '#AAA');
                });
            }
        });
        $("form").submit(function(){
            $("input, textarea").each(function(){
                if ($(this).attr("placeholder") != ""){
                    if ($(this).val()==$(this).attr("placeholder")) $(this).val("");
                }
            });
        });
    }
    // newsletter
    // @TODO esto podria cargarlo solo cuando necesito el newsletter de social
    // los css se encuentran en layout.css
    $('#quickNewsletterFormHolder button').click(
        function (event) {
            event.preventDefault();
            $.get(
                '/index/ajax-calls/do/addToNewsletter',
                {
                    'email': $('#quickNewsletterFormHolder input[name="email"]').val(),
                    'name': $('#quickNewsletterFormHolder input[name="name"]').val()
                },
                function (response) {
                    if (response.added == true) {
                        $(
                            "#quickNewsletterFormHolder input[name='email']," +
                            "#quickNewsletterFormHolder input[name='name']"
                        ).val('');
                        $('#quickNewsletterStatusMessenger')
                            .text(
                                'Su email ha sido agregado con exito, por favor valide ' +
                                'el mail de confirmacion que le hemos enviado'
                            ).hide().fadeIn('slow').delay(5000).fadeOut('slow');
                    }
                    
                },
                'json'
            );
        }
    );
});
