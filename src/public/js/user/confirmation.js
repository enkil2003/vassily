(function ($){
    var TIME_TO_REDIRECT = 5000;
    function redirectToLoginPage() {
        window.location = '/login';
    }
    setTimeout(redirectToLoginPage, TIME_TO_REDIRECT);
})(jQuery);