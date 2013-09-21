/**
Makes the textbox to accept only numeric input
*/

(function($) {
    $.fn.allowOnlyNumeric = function() {

        /**
        The interval code is commented as every 250 ms onchange of the textbox gets fired.
        */

        //  var createDelegate = function(context, method) {
        //      return function() { method.apply(context, arguments); };
        //  };

        /**
        Checks whether the key is only numeric.
        */
        var isValid = function(key) {
            var validChars = "0123456789";
            var validChar = validChars.indexOf(key) != -1;
            return validChar;
        };

        /**
        Fires the key down event to prevent the control and alt keys
        */
        var keydown = function(evt) {
            if (evt.ctrlKey || evt.altKey) {
                evt.preventDefault();
            }
        };

        /**
        Fires the key press of the text box   
        */
        var keypress = function(evt) {
            var scanCode;
            //scanCode = evt.which;
            if (evt.charCode) { //For ff
                scanCode = evt.charCode;
            }
            else { //For ie
                scanCode = evt.keyCode;
            }

            if (scanCode && scanCode >= 0x20 /* space */) {
                var c = String.fromCharCode(scanCode);
                if (!isValid(c)) {
                    evt.preventDefault();
                }
            }
        };

        /**
        Fires the lost focus event of the textbox   
        */
        var onchange = function() {
            var result = [];
            var enteredText = $(this).val();
            for (var i = 0; i < enteredText.length; i++) {
                var ch = enteredText.substring(i, i + 1);
                if (isValid(ch)) {
                    result.push(ch);
                }
            }
            var resultString = result.join('');
            if (enteredText != resultString) {
                $(this).val(resultString);
            }

        };

        //var _filterInterval = 250;
        //var _intervalID = null;

        //var _intervalHandler = null;

        /**
        Dispose of the textbox to unbind the events.
        */
        this.dispose = function() {
            $(this).die('change', onchange);
            $(this).die('keypress', keypress);
            $(this).die('keydown', keydown);
            //window.clearInterval(_intervalHandler);
        };

        $(this).live('change', onchange);
        $(this).live('keypress', keypress);
        $(this).live('keydown', keydown);
        //_intervalHandler = createDelegate(this, onchange);
        //_intervalID = window.setInterval(_intervalHandler, _filterInterval);
    }
})(jQuery);
