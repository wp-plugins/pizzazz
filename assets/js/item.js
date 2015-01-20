jQuery(document).ready(function($) {
    $('<option>').val('saveOrder').text(Pizzazz.pizzazzMediaAction).appendTo("select[name='action']");
    $('<option>').val('saveOrder').text(Pizzazz.pizzazzMediaAction).appendTo("select[name='action2']");

    $('body').delegate('#doaction', 'click', function(button){
        button.preventDefault();
        if($('select[name="action"]').val() == 'saveOrder' && !$('#cb-select-all-1').prop('checked')){
            $('#cb-select-all-1').click();
        }
        $('#posts-filter').submit();
    });

});