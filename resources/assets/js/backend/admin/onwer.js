$(window).on('load', function () {
    $('label input:checkbox').each(function (index, element) {
        if ($(element).is(':checked')) {
            $('#socials').append($(element).closest('div').find('.social div').clone());
        }
    });
});
$(function () {
    CKEDITOR.replace('textarea__sidebar-des', {
        filebrowserBrowseUrl: 'ckfinder/ckfinder.html',
        filebrowserUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
        filebrowserUploadMethod: 'form',
        enterMode: CKEDITOR.ENTER_BR,
        shiftEnterMode: CKEDITOR.ENTER_P,
    });
    const preview_image = function () {
        let file_upload = $(this).val();
        $('.step').remove();
        if (file_upload != '') {
            const url_demo = URL.createObjectURL(event.target.files[0]);
            $('.avatar').removeClass('hidden');
            const url_old = $('.avatar #img__show').attr('src');
            if (url_old != undefined || url_old.trim() != '') {
                URL.revokeObjectURL($('.avatar #img__show').attr('src'));
            }
            if ($('#img__avatar').length) {
                $('.pre-show').before('<div class="step left right"></div>');
            }
            $('.avatar #img__show').attr('src', url_demo);
        } else {
            $('.avatar #img__show').attr('src', '');
            $('.avatar #img__show').addClass('hidden');
        }
    };
    $('.btn-choose').on('click', function () {
        $('.file__choose').click();

        $('.file__choose').on('change', preview_image);
    });

    $('.btn__add-field').on('click', function () {
        $('#socials').find('div').remove();
        $('label input:checkbox').each(function (index, element) {
            if ($(element).is(':checked')) {
                $('#socials').append($(element).closest('div').find('.social div').clone());
            }
        });
    });
});
