'use strict';
const hanldeButton = {
    init: function(){
        this.addLanguage();
        this.cancelLanguage();
        this.clickBtnTrigger();
    },
    addLanguage : function(){
        $('.btn-add-language').on({
            'click': function(){
                $('#frm-add-language').removeClass('hidden').addClass('block md:table-row');
                $(this).addClass('hidden');
            }
        });
    },
    cancelLanguage: function(){
        $('.btn-cancel').on({
            'click' : function(e){
                e.preventDefault();
                $('#frm-add-language').removeClass('block md:table-row').addClass('hidden');
                $('.btn-add-language').removeClass('hidden');
                $('.input-language, .input-symbol').val('');
            }
        });
    },
    clickBtnTrigger: function(){
        $('[data-trigger]').each(function(){
            $(this).on($(this).attr('data-trigger'), function(e){
                e.preventDefault();
                let url = $(this).attr('data-path');
                let method = $(this).attr('data-method');
                let cf = confirm('Muốn xoá nó hay không?');
                if(cf){
                    $('form.frmUpdateLanguage_'+$(this).attr('data-id')).attr('action', url);
                    $('form.frmUpdateLanguage_'+$(this).attr('data-id') + ' ~ input[name="_method"]').val(method);
                    $('form.frmUpdateLanguage_'+$(this).attr('data-id')).submit();
                }
            })
        });
    },
};
$(function(){
    hanldeButton.init();
})