$(function(){

    //change language
    $('.js-click-btn').on('click', function(){
        $('.js-btn-' + $(this).attr('data-id')).click();
    })
})