function addSubcategoryItem(id, name) {
    var li = '<li class="draggable" id="order_'+id+'">'+
        '<span class="dragMe"></span>'+
        '<span class="name editable" id="'+id+'">'+name+
        '</span><span id="'+id+'" class="removeMe"></span></li>';
    $("#sortable").append(li);
}
$('.removeMe').live('click', function() {
    var $this = $(this);
    var id = $this.attr('id');
    $.get(
        "/admin/subcategory/ajax/request/remove",
        {'id': id},
        function (e) {
            $this.parent().remove();
        },
        'json'
    );
});
$('.editMe').live('click', function() {
    var $this = $(this);
    var id = $this.attr('id');
    var value;
    $.get(
        "/admin/subcategory/ajax/request/editme",
        {'id': id},
        function (e) {
            $this.parent().remove();
        },
        'json'
    );
});
$(document).ready(function() {
$('#category').change(function(){
    $('#modifySubcategory #sortable').css('display', 'none');
    $("#sortable").empty();
    var value = $(this).val();
    if(value != -1) {
        $.get(
            "/admin/subcategory/ajax/request/subcategoriesList",
            {'parentCategoryId': value},
            function (response) {
                var i;
                for(i in response) {
                    addSubcategoryItem(response[i].id, response[i].name);
                    /** @TODO add inline edition */
                    $('.editable').editable("/admin/subcategory/ajax/request/modifySubcategoryName", { 
                        height: 10,
                        tooltip: 'click para editar'
                    });
                }
                $('#modifySubcategory #sortable').css('display', 'inline-block');
            },
            'json'
        )
    }
});
$("#sortable").sortable({
    update : function () {
        var order = $('#sortable').sortable('serialize');
        $("#info").load("/admin/category/ajax/request/setSubcategoriesOrder/?"+order);
    }
});
$('#parentCategoryContainer').tabs();
});