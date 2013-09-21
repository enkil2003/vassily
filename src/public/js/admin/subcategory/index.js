(function($) {

function resetForm() {
    $('#subcategoryContainer, #submitContainer').hide();
}
function clearFields() {
    $('#category').val(-1);
    $('#name').val('');
    $('#nameError').hide();
}
$('#category').change(function(){
    var value = $(this).val();
    if (value == -1) {
        resetForm();
        return;
    }
    $('#subcategoryContainer, #submitContainer').show();
});
$('#name').keyup(function(){
    if ($(this).val() != '' && $('#name').val() != $('#name').attr('placeholder')) {
        $('#submit').removeAttr('disabled');
    } else {
        $('#submit').attr('disabled', 'disabled');
    }
});
$('#submit').click(function(e){
    e.preventDefault();
    var error = false;
    if ($('#name').val() == '' || $('#name').val() == $('#name').attr('placeholder')) {
        error = true;
        $('#nameError').show();
    }
    if (error) {
        return;
    }
    $.post(
        '/admin/subcategory/index',
        {
            'category': $('#category').val(),
            'name': $('#name').val()
        },
        function(response) {
            if(response.success) {
                $('#formMessenger').html('<strong>Subcategoria agregada con exito</strong><br />la subcategoria no aparecera mientras no tenga productos');
                resetForm();
                clearFields();
            }
        },
        'json'
    );
});
$('#parentCategoryContainer').tabs();
})(jQuery);