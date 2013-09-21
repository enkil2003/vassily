(function($) {
    var product_id = null;
    var hasSelectedFiles = false;
    var NUMERIC_ERROR = 'Solo valores numericos';
    var PRICE_ERROR = 'Ingrese un precio';
    var CHOOSE_AN_IMAGE = 'Debe seleccionar una imagen';
    var IMAGE_ADD_STATUS_MESSAGE = 'se han añadido imagenes para el producto';
    var PRODUCT_ADD_MESSAGE = 'El producto ha sido agregado con exito';
    var UPLOAD_SUCCESS_MESSAGE = 'archivos han sido subidos con exito';
    var CHOOSE_A_CATEGORY_MESSAGE = 'Debe ingresar una categoria';
    var SELECT_A_TITLE_MESSAGE = 'Debe ingresar un nombre como titulo';
    var WITH_ERRORS_MESSAGE = 'con errores';
    var TAB_ERROR_COLOR = '#8A1F11';
    var TAB_BACKGROUND_ERROR_COLOR = '#FBE3E4';
    var TAB_BACKGROUND_COLOR = '#FFF';
    var SUBMIT_DISABLED_FONT_COLOR = '#CCC';
    function clearErrors() {
        $('.error').hide();
        $('#productForm a').css('color', '#555');
        $('#productForm li.ui-state-active a').css('color','#000');
        $('#productForm .ui-tabs-panel.ui-widget-content.ui-corner-bottom')
            .css('background-color', TAB_BACKGROUND_COLOR);
    }
    function clearForm() {
        $('#productForm .subcategoriesCheckboxes input:checkbox').attr('checked', false);
        $('#productForm #name, #productForm #price, #productForm #description, #productForm #width, '
                + '#productForm #height, #productForm #depth, #productForm #materials').val('');
        $('#productForm #status-message').text('');
        $('#productForm #thumbImages img, #productForm div.remove').remove();
        var uploader = $('#uploader').pluploadQueue();
    }
    function saveSuccess() {
        clearForm();
        $.get(
            '/admin/products/add-images-to-product',
            {},
            function () {},
            'json'
        );
        $('#messenger').text(PRODUCT_ADD_MESSAGE).dialog(
            {
                modal: true,
                draggable: false,
                close: function(event, ui) {
                    window.location = '/admin/products';
                }
            }
        );
    } 
    $("#productForm .formElements, .categoriesTab, .images").tabs();
    // initialize tinymce
    $('#productForm textarea').tinymce({
        theme : "simple"
     }).css({'width': '507px','height': '200px'});
    // Prevents 'enter' to submits the form 
    $('input').live("keypress", function(e) {
        // ENTER PRESSED
        if (e.keyCode == 13) {
            // FOCUS ELEMENT 
            var inputs = $(this).parents("form").eq(0).find(":input:visible");
            var idx = inputs.index(this);
            if (idx == inputs.length - 1) {
                inputs[0].select()
            } else {
                inputs[idx + 1].focus(); //  handles submit buttons
                inputs[idx + 1].select();
            }
            return false;
        }
    });
    // traduccion para el plupload
    plupload.addI18n({
        'Select files' : 'Elija archivos:',
        'Add files to the upload queue and click the start button.' : 'Agregue archivos a la cola de subida y haga click en el boton de iniciar.',
        'Filename' : 'Nombre de archivo',
        'Status' : 'Estado',
        'Size' : 'Tama&ntilde;o',
        'Add files' : 'Agregue archivos',
        'Stop current upload' : 'Detener subida actual',
        'Start uploading queue' : 'Iniciar subida de cola',
        'Uploaded %d/%d files': 'Subidos %d/%d archivos',
        'N/A' : 'No disponible',
        'Drag files here.' : 'Arrastre archivos aqu&iacute;',
        'File extension error.': 'Error de extensi&oacute;n de archivo.',
        'File size error.': 'Error de tama&ntilde;o de archivo.',
        'Init error.': 'Error de inicializaci&oacute;n.',
        'HTTP Error.': 'Error de HTTP.',
        'Security error.': 'Error de seguridad.',
        'Generic error.': 'Error gen&eacute;rico.',
        'IO error.': 'Error de entrada/salida.',
        'Stop Upload': 'Detener Subida.',
        'Add Files': 'Agregar Archivos',
        'Start Upload': 'Comenzar Subida.',
        '%d files queued': '%d archivos en cola.'
    });
    $("#uploader").pluploadQueue({
        // General settings
        runtimes : 'gears,html5,browserplus,flash,silverlight',
        url : '/admin/products/upload-image/',
        max_file_count: 4,
        max_file_size : '10mb',
        chunk_size : '1mb',
        unique_names : true,
        rename: true,
        sortable: true,
        // Specify what files to browse for
        filters : [
            {title : "Image files", extensions : "jpg,gif,png"}
        ],
        // Flash settings
        flash_swf_url : '/js/jquery/plupload/js/plupload.flash.swf',
        // Silverlight settings
        silverlight_xap_url : '/js/jquery/plupload/js/plupload.silverlight.xap',
        preinit : {
            init : function() {
                $('#images .plupload_button.plupload_start').remove();
            },
            UploadComplete: function(up, files) {
                saveSuccess();
            }
        }
    });
    // Client side form validation
    $('form').submit(function(e) {
        var uploader = $('#uploader').pluploadQueue();

        // Files in queue upload them first
        if (uploader.files.length > 0) {
            // When all files are uploaded submit form
            uploader.bind('StateChanged', function() {
                if (uploader.files.length === (uploader.total.uploaded + uploader.total.failed)) {
                    $('form')[0].submit();
                }
            });
                
            uploader.start();
        } else {
            alert('You must queue at least one file.');
        }

        return false;
    });
    
    // ******************************************
    // there is no native method to do this below
    // ******************************************
//    $('#uploader_start').remove();
    $('.plupload_button.plupload_start').remove();
    // remove images button
    var imagesToDelete = new Array();
    $('#productForm #thumbImages .remove').click(function(){
        var filename = $(this).attr('data-filename');
        if ($.inArray(filename, imagesToDelete) == -1) {
            var hidden = $('<input type="hidden" name="imagesToDelete[]" />').val(filename);
            $('#productForm input[type="submit"]').parent().append(hidden);
            imagesToDelete.push(filename);
            $(this).prev().fadeTo('slow', .2).addClass('toRemove');
        } else {
            var i;
            var _tempImagesToDelete = new Array();
            for (i in imagesToDelete) {
                if (filename != imagesToDelete[i]) {
                    _tempImagesToDelete.push(imagesToDelete[i]);
                }
            }
            $('#productForm input[value="'+filename+'"]').remove();
            imagesToDelete = _tempImagesToDelete;
            $(this).prev().fadeTo('slow', 1).removeClass('toRemove');
        }
        if (($('#productForm #thumbImages .remove').length - $('#productForm #thumbImages .toRemove').length) == 4) {
            $('#uploader_browse').hide();
        } else {
            $('#uploader_browse').show();
        }
    });
    
    if ($('#productForm #thumbImages .remove').length == 4) {
        $('#uploader_browse').hide();
    }
    // Submit logic
    $('#productForm #submit').click(function(e) {
        e.preventDefault();
        submitForm();
    });
    
    function submitForm() {
        clearErrors();
        var error = false;
        var $this;
        var subcategoriesId = new Array();
        $('#productForm .subcategoriesCheckboxes input:checkbox').each(function(e) {
            $this = $(this);
            if ($(this).attr('checked') != undefined) {
                subcategoriesId.push($this.val());
            }
        });
        // tengo q tener como minimo una categoria
        if (subcategoriesId.length == 0) {
            error = true;
            $('#productForm .subcategoriesError').show().text(CHOOSE_A_CATEGORY_MESSAGE);
            $('#productForm #categoriesTabHolder .ui-tabs-panel.ui-widget-content.ui-corner-bottom')
                .css({
                    'background-color': TAB_BACKGROUND_ERROR_COLOR,
                    '-moz-border-radius': '4px',
                    'border-radius': '4px',
                    'margin-top' : '2px'
                });
        }
        if (
            $('#productForm #name').val() == '' ||
            $('#productForm #name').val() == $('#productForm #name').attr('placeholder')
        ) {
            error = true;
            $('#productForm .nameError').show().text(SELECT_A_TITLE_MESSAGE);
            $('#productForm #li-description a').css('color', TAB_ERROR_COLOR);
        }
        
        if (
            $('#productForm #price').val() == '' ||
            $('#productForm #price').val() == $('#productForm #price').attr('placeholder') ||
            isNaN($('#productForm #price').val())
        ) {
            error = true;
            $('#productForm .priceError').show().text(PRICE_ERROR);
            $('#productForm #li-description a').css('color', TAB_ERROR_COLOR);
        }
        
        if (
            isNaN($('#productForm #width').val())
        ) {
            error = true;
            $('#productForm .widthError').show().text(NUMERIC_ERROR);
            $('#productForm #li-measures a').css('color', TAB_ERROR_COLOR);
        }
        
        if (
            isNaN($('#productForm #height').val())
        ) {
            error = true;
            $('#productForm .heightError').show().text(NUMERIC_ERROR);
            $('#productForm #li-measures a').css('color', TAB_ERROR_COLOR);
        }
        
        if (
            isNaN($('#productForm #depth').val())
        ) {
            error = true;
            $('#productForm .depthError').show().text(NUMERIC_ERROR);
            $('#productForm #li-measures a').css('color', TAB_ERROR_COLOR);
        }
        // if im editting the product...
        if ($('#id').length == 1) {
            if (
                $('#uploader').plupload('getUploader').files.length < 1 &&
                $('#thumbImages .imageHolder .toRemove').length == $('#thumbImages .imageHolder img').length
            ) {
                error = true;
                $('#productForm .imagesError').show().text(CHOOSE_AN_IMAGE);
                $('#productForm .images a').css('color', TAB_ERROR_COLOR);
            }
            // if im creating a new one
        } else {
            var uploader = $('#uploader').pluploadQueue();
            if(uploader.files.length < 1) {
                error = true;
                $('#productForm .imagesError').show().text(CHOOSE_AN_IMAGE);
                $('#productForm .images a').css('color', TAB_ERROR_COLOR);
            }
        }
        
        if(error) {
            return;
        }
        $('#submit').attr('disabled', 'disabled').css({'cursor': 'default', 'color': SUBMIT_DISABLED_FONT_COLOR});
        var imagesToDelete = new Array();
        $('#productForm input[name="imagesToDelete[]"]').each(function(e) {
            imagesToDelete.push($(this).val());
        });
        $.post(
            "/admin/products/save-product-ajax",
            {
                'id': $('#productForm #id').val(),
                'name': $('#productForm #name').val(),
                'description': $('#productForm #description').val(),
                'price': $('#productForm #price').val(),
                'width': $('#productForm #width').val(),
                'height': $('#productForm #height').val(),
                'depth': $('#productForm #depth').val(),
                'materials': $('#productForm #materials').val(),
                'subcategories' : subcategoriesId,
                'imagesToDelete[]' : imagesToDelete
            },
            function (response) {
                product_id = response.product_id;
                //start uploading files
                var uploader = $('#uploader').pluploadQueue();
                uploader.start();
            },
            'json'
        );
    }
})(jQuery);