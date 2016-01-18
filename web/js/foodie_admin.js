function initializeAdmin() {
    $("#sortable").sortable();
    $("#sortable").disableSelection();

    $('.inline-editable').editable(function (value, settings) {
        return (value);
    }, {
        event: 'dblclick',
        style: 'inherit',
        onblur: 'submit'
    });
    
    $(".close-button").click(function () {
       this.parentElement.remove();
    })
}

function addDish(markup) {
    $("#dish ul").append(markup);
    initializeAdmin();
}

function submitDish() {
    $("#dish ul li").each(function () {
        var input = $("<input>").attr({ "type": "hidden", "name": "dish_types[]" }).val($(this).text());
        $('#dish_form').append(input);
    });
    $('#dish_form').submit();
}

function addCookingType(markup) {
    $("#cookingType ul").append(markup);
    initializeAdmin();
}

function submitCookingType() {
    $("#cookingType ul li").each(function () {
        var input = $("<input>").attr({ "type": "hidden", "name": "cooking_types[]" }).val($(this).text());
        $('#cookingType_form').append(input);
    });
    $('#cookingType_form').submit();
}