/**
 * Behavior for show cart view
 * @param $ jQuery
 * @param boolean showLogin defines if login box should be displayed
 */
(function($) {
    var STEP_1_SELECTOR = '.step1Holder';
    var STEP_2_SELECTOR = '.step2Holder';
    var STEP_3_SELECTOR = '.step3Holder';
    var STEP_4_SELECTOR = '.step4Holder';
    var ANOTHER_ADDRESS_SELECTOR = "#reception-anotherAddress:checked";
    var PICKUP_SELECTOR = "#reception-pickup:checked";
    var PAY_METHOD_SELECTOR = "#payMethod-transaction:checked";
    var buyAsGuest = false;
    
    function setCursor() {
        $('.cartGrid input:first-child:eq(0)').putCursorAtEnd();
    }
    function hasProducts() {
        return $('.cartGrid input:first-child').length > 0;
    }
    function allowOnlyNumeric() {
        $('.cartGrid input:first-child').allowOnlyNumeric();
    }
    function cartProductQuantityUpdate() {
        $('#cartProductQuantity').text($('.cartGrid tbody tr').length);
    }
    /**
     * Shows the hidden loggin div
     * @param string step original step the user intented to see
     * @return void
     */
    function showLoginModal(step) {
        $.fancybox({
            'helpers': {overlay: {opacity: 0.2}},
            'autoScale': true,
            'transitionIn': 'fade',
            'transitionOut': 'fade',
            'href': '#framedLoggin'
        });
        $('#buyAsGuest').bind(
            'click',
            function(e) {
                e.preventDefault();
                buyAsGuest = true;
                $.fancybox.close();
                hideAllSteps(step);
                
                // hide steps for users
                $('label[for="reception-send"], .deliveryData').css('visibility', 'hidden');
                
                // reposition "otherAddress" form
                $('label[for="reception-anotherAddress"]').css('top', '100px');
                $('.otherAddress').css('top', '-57px');
                $('.step2Holder .separator').css('top', '-58px');
                // check a radio for the next step as default
                $('#reception-anotherAddress').click();
            }
        );
        // tab to next field on enter
        $('#framedLoggin input[name="usernameOrEmail"]').keypress(
            function(e) {
                var code = (e.keyCode ? e.keyCode : e.which);
                if (code == 13) {
                    $('#framedLoggin input[name="password"]').focus();
                }
            }
        );
        // proced to login on enter
        $('#framedLoggin input[name="password"]').keypress(
            function(e) {
                var code = (e.keyCode ? e.keyCode : e.which);
                if (code == 13) {
                    $('#ajaxLoginSubmit').click();
                }
            }
        );
    }
    
    /**
     * Hide all steps, and optionaly can exclude one
     * @param exclude optional step to be excluded
     * @return void
     */
    function hideAllSteps(exclude) {
        var selector = null;
        var step = null;
        $(
            STEP_1_SELECTOR + "," +
            STEP_2_SELECTOR + "," +
            STEP_3_SELECTOR + "," +
            STEP_4_SELECTOR
        ).hide();
        switch(exclude) {
            case 1:
                selector = STEP_1_SELECTOR;
                step = '.step1';
                break;
            case 2:
                selector = STEP_2_SELECTOR;
                step = '.step2';
                break;
            case 3:
                selector = STEP_3_SELECTOR;
                step = '.step3';
                break;
            case 4:
                selector = STEP_4_SELECTOR;
                step = '.step4';
                break;
        }
        $(step).fadeTo(0, 1).addClass('enabled');
        $(selector).show();
    }
    /**
     * Sums all the subtotal prices from the cart and populates the total tag
     * @return void
     */
    function updateTotalPrice() {
        // change total price
        var total = 0;
        $('.cartGrid .subtotal span').each(
            function() {
                total +=  parseFloat($(this).text());
            }
        );
        // change cart's total sum price as formatted text
        // minor fix, it seems sprintf isn't working as expected, is also made on line 63
        total = $.sprintf("%.2f", total);
        if(total === '.0') {
            total = "0.00";
        }
        $('.noteAndPrice .total span').text(total);
    }
    /**
     * Removes a product from the cart and the ui
     * @param int id product id
     * @param string row css seletor to delete
     * @TODO I can take the id from the rowProductHolder, as in the data-id attribute inside the holder,
     * making simpler the method's interface.
     */
    function removeProduct(id, rowProductHolder) {
        $.get(
            '/cart/ajax-calls/do/remove',
            {'id': id},
            function(response) {
                if (response.result) {
                    rowProductHolder.remove();
                    updateTotalPrice();
                    cartProductQuantityUpdate();
                }
            },
            'json'
        );
        // if we still have at least one product
        if (hasProducts()) {
            // grab the first input type and put the cursor there, it's nicer!
            setCursor();
        }
    }
    /**
     * Shows the confirmation overlay
     * @TODO This is very coupled, as "context" need exactly the actual html from show-cart.phtml
     * @param object context jquery object
     * @return void
     */
    function showDeleteConfirmationOverlay(context) {
        $.confirm({
            'title': '¿Desea eliminar este producto?',
            'message': 'Esta apunto de eliminar este item. <br />Esto no puede revertirse! Continuar?',
            'buttons'    : {
                'Si'    : {
                    'class' : 'blue',
                    'action': function(){
                        removeProduct(context.attr('data-id'), context.parent().parent().parent());
                    }
                },
                'No' : {
                    'class'    : 'gray',
                    'action': function(){
                        // if the user didn't want to delete the product, set at least 1 as quantity
                        context.val(1);
                        // recalculate subtotal
                        var priceHolder = context.parent().parent().parent().find('.subtotal span');
                        var unitPrice = priceHolder.parent().attr('data-price');
                        priceHolder.text(unitPrice);
                        // update total
                        updateTotalPrice();
                        // persist the actual quantity in the backend
                        persistProductQuantityUpdate(context, 1);
                    }
                }
            }
        });
    }
    /**
     * Updates the product subtotal price
     * @TODO This is very coupled, as "context" need exactly the actual html from show-cart.phtml
     * @param object context jquery object
     * @return void
     */
    function updateProductSubtotal(context) {
        var priceHolder = context.parent().parent().parent().find('.subtotal span');
        var quantity = context.val();
        if (quantity == "") {
            priceHolder.text("0.00");
            updateTotalPrice();
            return;
        } 
        var unitPrice = priceHolder.parent().attr('data-price');
        // change product's subtotal price as formatted text
        var subtotal = $.sprintf("%.2f", parseFloat(unitPrice*parseInt(quantity)));
        // minor fix, it seems sprintf isn't working as expected, is made also on line 23 
        if (subtotal == ".0") {
            subtotal = "0.00";
            showDeleteConfirmationOverlay(context);
        }
        priceHolder.text(subtotal);
    }
    function persistProductQuantityUpdate(context, quantity) {
        var id = context.attr('data-id');
        $.get(
            '/cart/ajax-calls',
            {
                'do': 'update',
                'id': id,
                'quantity': quantity
            },
            function(response) {
                if (response.result) {
                    updateProductSubtotal(context);
                    updateTotalPrice();
                }
            },
            'json'
        );
    }
    // init
    $('#payMethod-arrival').click(); // this is here because i didn't wanted to search how to set a radio element from a radio group with zend framework
                                     // this element should be checked from within forms/Checkout.php
    allowOnlyNumeric();
    setCursor();
    // Behavior for the cart's remove button
    $('.removeBtn').click(
        function() {
            removeProduct($(this).attr('data-id'), $(this).parent().parent());
        }
    );
    // Input fields behavior
    $('.cartGrid input[type="text"]').keyup(
        function(e) {
            // update ui price
            var $this = $(this);
            var quantity = parseInt($this.val());
            if (quantity === 0) {
                showDeleteConfirmationOverlay($this);
                return;
            }
            if (!quantity) {
                updateProductSubtotal($this);
                return;
            }
            // persist quantity update
            persistProductQuantityUpdate($this, quantity);
        }
    ).blur(function(e){
        var $this = $(this);
        if ($this.val() == "") {
            showDeleteConfirmationOverlay($this);
        }
    });
    // steps behavior
    $('.steps .step1').bind(
        'click.nextStep',
        function() {
            hideAllSteps(1);
        }
    );
    
    $('.steps .step2').bind(
        'click.nextStep',
        function() {
            if (!ConfigJs.user) {
                if (!buyAsGuest) {
                    showLoginModal(2);
                    return;
                }
            }
            hideAllSteps(2);
        }
    ).fadeTo(0, .5);
    $('#buy').bind(
        'click.nextStep',
        function() {
            if (!ConfigJs.user) {
                if (!buyAsGuest) {
                    showLoginModal(2);
                    return;
                }
            }
            hideAllSteps(2);
        }
    );
    
    $('.steps .step3, #step2Button').bind(
        'click.nextStep',
        function() {
            if (!ConfigJs.user) {
                if (!buyAsGuest) {
                    showLoginModal(3);
                    return;
                }
            }
            if (stepsValidator.form()) {
                hideAllSteps(3);
            }
        }
    );
    $('.steps .step3').fadeTo(0, .5);
    
    $('.steps .step4,  #step3Button').bind(
        'click.nextStep',
        function() {
            if (!ConfigJs.user) {
                if (!buyAsGuest) {
                    showLoginModal(3);
                    return;
                }
            }
            if (stepsValidator.form()) {
                $('#cartForm').submit();
            }
        }
    );
    $('.steps .step4').fadeTo(0, .5);
    
    var stepsValidator = $('#cartForm').validate({
        errorElement: "div",
        errorPlacement: function(error, element) {
            error.appendTo( element.parent() );
        },
        rules: {
            // Another Address
            name: {
                required: ANOTHER_ADDRESS_SELECTOR,
            },
            lastname: {
                required: ANOTHER_ADDRESS_SELECTOR,
            },
            email: {
                required: ANOTHER_ADDRESS_SELECTOR,
            },
            address: {
                required: ANOTHER_ADDRESS_SELECTOR,
            },
            zip: {
                required: ANOTHER_ADDRESS_SELECTOR
            },
            homePhone: {
                required: ANOTHER_ADDRESS_SELECTOR
            },
            city: {
                required: ANOTHER_ADDRESS_SELECTOR
            },
            state: {
                required: ANOTHER_ADDRESS_SELECTOR
            },
            // Pick up
            name: {
                required: PICKUP_SELECTOR
            },
            lastname: {
                required: PICKUP_SELECTOR
            },
            identification: {
                required: PICKUP_SELECTOR
            },
            phone: {
                required: PICKUP_SELECTOR
            }
        },
        messages: {
            // Another Address
            address: "debe ingresar una dirección valida",
            zip: 'debe ingresar un código postal valido',
            homePhone: 'debe ingresar un teléfono valido',
            city: 'debe ingresar una ciudad valida',
            state: 'debe ingresar una provincia valida',
            // Pick up
            name: 'debe ingresar un nombre valido',
            lastname: 'debe ingresar un apellido valido',
            identification: 'debe ingresar un DNI valido',
            phone: 'debe ingresar un teléfono valido'
        }
    });
    $('.receptionSelection label').bind(
        'click.clearForm',
        function() {
            stepsValidator.resetForm();
        }
    );
    $('label[for="payMethod-transaction"]').bind(
        'click.changeButtonName',
        function() {
            $('#step3Button').text('CONTINUAR');
        }
    );
    $('label[for="payMethod-arrival"]').bind(
        'click.changeButtonName',
        function() {
            $('#step3Button').text('CONFIRMAR COMPRA');
        }
    );
    
    $('#ajaxLoginSubmit').bind(
        'click.login',
        function() {
            $.post(
                '/user/ajax-login',
                {
                    usernameOrEmail: $("#framedLoggin input[name='usernameOrEmail']").val(),
                    password: $("#framedLoggin input[name='password']").val()
                },
                function(response) {
                    if (response.hasIdentity) {
                        $.fancybox.close();
                        ConfigJs.user = true;
                        hideAllSteps(2);
                        $('.userData .fullname').text(response.userData.name + ' ' + response.userData.lastname);
                        $('.userData .address').text(response.userData.address + ' ' + response.userData.city);
                        $('.userData .province').text(response.userData.province);
                        
                        $('.logout, .userControlPanel, .myCart', $('#userMenu')).show();
                        $('.login, .register', $('#userMenu')).remove();
                        $('#nameField, #lastnameField, #emailField').remove();
                    } else {
                        $('.messageBox').text(response.error.userFriendlyMessage).css('color', '#F00');
                    }
                },
                'json'
            );
        }
    );
})(jQuery);
