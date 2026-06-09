$(document).ready(function(){
    // Plus button click event
    $(".btn-plus").click(function(){
        var input = $(this).siblings('input');
        var currentValue = parseInt(input.val());
        input.val(currentValue + 1);
    });

    // Minus button click event
    $(".btn-minus").click(function(){
        var input = $(this).siblings('input');
        var currentValue = parseInt(input.val());
        if(currentValue > 1){
            input.val(currentValue - 1);
        }
    });
});