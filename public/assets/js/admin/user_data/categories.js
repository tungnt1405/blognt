'use strict';
const hanldeButton = {
    init: function () {
        this.addCategory();
        this.cancelCategory();
        this.clickBtnTrigger();
    },
    addCategory: function () {
        $('.btn-add-category').on({
            click: function () {
                $('#frm-add-category').removeClass('hidden').addClass('block md:table-row');
                $(this).addClass('hidden');
            },
        });
    },
    cancelCategory: function () {
        $('.btn-cancel').on({
            click: function (e) {
                e.preventDefault();
                $('#frm-add-category').removeClass('block md:table-row').addClass('hidden');
                $('.btn-add-category').removeClass('hidden');
                $('.input-category').val('');
            },
        });
    },
    clickBtnTrigger: function () {
        $('[data-trigger]').each(function () {
            $(this).on($(this).attr('data-trigger'), function (e) {
                e.preventDefault();
                let url = $(this).attr('data-path');
                let method = $(this).attr('data-method');
                let cf = confirm('Muốn xoá nó hay không?');
                if (cf) {
                    $('form.frmUpdateCategory_' + $(this).attr('data-id')).attr('action', url);
                    $('form.frmUpdateCategory_' + $(this).attr('data-id') + ' ~ input[name="_method"]').val(method);
                    $('form.frmUpdateCategory_' + $(this).attr('data-id')).submit();
                }
            });
        });
    },
};
$(function () {
    hanldeButton.init();
});
