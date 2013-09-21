$(document).ready(function() {
    $('#categories').change(function() {
        $('#subcategories').removeAttr('disabled').find('option').remove();
        $('#gridHolder').empty();
        if($(this).val() == '-1') {
            $('#subcategories').append($('<option>', { 'value' : '-1' }).text('Primero debe seleccionar una categoria')).attr('disabled','disabled');
            return;
        }
        $.post(
            '/admin/products/get-subcategories',
            {'category': $(this).val()},
            function(response) {
                $('#subcategories').append($('<option>', { 'value' : '-1' }).text('Seleccione una subcategoria')).removeAttr('disabled');
                var i, id, value;
                for(i in response) {
                    id = response[i].id;
                    value = response[i].name;
                    $('#subcategories').append($('<option>', { 'value' : id }).text(value));
                }
            },
            'json'
        );
     });
    $('#subcategories').change(function() {
        if($(this).val() == '-1') {
            $('#gridHolder').empty();
            return;
        }
        $.post(
            '/admin/products/get-product-grid',
            {'subcategories_id': $(this).val()},
            function(response) {
                $('#gridHolder').html(response);
                $('#gridHolder').show().find('table').tablesorter();
            },
            'html'
        );
    });
    $('.column-remove div').live('click', function() {
        var id = $(this).attr('data-id');
        var $this = $(this);
        $.post(
            '/admin/products/remove/id/',
            {'id' : id},
            function(response) {
            	$this.parent().parent().remove();
            }
        );
    });
    /* @TODO configuracion global del table sorter, quizas es mejor otro lugar */
    $.tablesorter.defaults.widgets = ['zebra'];
    $.tablesorter.defaults.sortList = [[0,0]];
    $('#parentCategoryContainer').tabs();
});