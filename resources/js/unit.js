$(document).ready(function () {

    if ($('input[name=unit_add_module]').length) {
        add_unit();

        $('.unit-add-button').on('click', function () {
            add_unit();
            return false;
        });

    }

    if ($('input[name=unit_edit_module]').length) {

        $('.unit-add-button').on('click', function () {
            add_unit();
            return false;
        });

        $('.unit-template-base').each(function () {
            let tmp = $(this)
            tmp.find('.unit-type').on('change', function () {
                // tmp.find('.unit-type-all').hide();
                let val = $(this).val()
                let tmp_ = ''
                if (val === 'text') {
                    tmp_ = '.unit-type-text'
                }
                if (val === 'photo') {
                    tmp_ = '.unit-type-photo'
                }
                if (val === 'photo_text') {
                    tmp_ = '.unit-type-photo_text'
                }
                if (val === 'poll') {
                    tmp_ = '.unit-type-poll'
                }

                if (tmp_ !== '') {
                    tmp.find('.unit-type-all').hide();
                    tmp.find(tmp_).show();
                }

            });
            tmp.find('.unit-type').trigger('change')

            tmp.find('.unit-add-inline-button').on('click', function () {
                let element = $(this).closest('.units-inline-module').find('.unit-inline-blocks');
                add_inline_button(element);
                return false;
            });

            tmp.find('.unit-delete').on('click', function () {
                $(this).parent().remove();
            });

            tmp.find('.unit-inline-button-type').on('change', function () {
                tmp.find('.button-all').hide();
                let val = $(this).val()
                let tmp_ = ''
                if (val === 'url') {
                    tmp_ = '.button-link'
                }
                if (val === 'web_app') {
                    tmp_ = '.button-link'
                }
                tmp.find(tmp_).show();
            });
        });


    }

    function add_unit() {
        let tmp = $('#unit-template')
            .clone()
            .appendTo('.unit-blocks')
            .removeClass('d-none')
            .removeAttr('id')
        tmp.find('.unit-type-all').hide()
        tmp.find('.unit-type-text').show()

        tmp.find('.unit-type').on('change', function () {
            tmp.find('.unit-type-all').hide();
            let val = $(this).val()
            let tmp_ = ''
            if (val === 'text') {
                tmp_ = '.unit-type-text'
            }
            if (val === 'photo') {
                tmp_ = '.unit-type-photo'
            }
            if (val === 'photo_text') {
                tmp_ = '.unit-type-photo_text'
            }
            if (val === 'poll') {
                tmp_ = '.unit-type-poll'
            }
            tmp.find(tmp_).show();
        });

        tmp.find('.unit-add-inline-button').on('click', function () {
            let element = $(this).closest('.units-inline-module').find('.unit-inline-blocks');
            add_inline_button(element);
            return false;
        });

        tmp.find('.unit-delete').on('click', function () {
            $(this).parent().remove();
        });
    }

    function add_inline_button(element) {
        let tmp = $('#unit-inline-template')
            .clone()
            .removeClass('d-none')
            .removeAttr('id');
        tmp.find('.button-all').hide();
        tmp.find('.button-link').show();

        tmp.find('.unit-inline-button-type').on('change', function () {
            tmp.find('.button-all').hide();
            let val = $(this).val()
            let tmp_ = ''
            if (val === 'url') {
                tmp_ = '.button-link'
            }
            if (val === 'web_app') {
                tmp_ = '.button-link'
            }
            tmp.find(tmp_).show();
        });

        let item = element.append(tmp);

        item.find('.unit-inline-delete').on('click', function () {
            $(this).parent().remove();
        });
    }

    $('#send-add').submit(function () {
        //Просматривать каждый элемент кнопки, если она не пустая, то получать id родителя и добавлять в элемент
        let myControls = $(this).find($('input[name="unit_id[]"]'));
        for (let i = 0; i < myControls.length; i++) {
            let getControls = $(myControls[i]).parent().find('.unit-type-button').filter(':visible');
            for (let j = 0; j < getControls.length; j++) {
                let text = $(getControls[j]).find('input[name="unit_inline_caption[]"]');
                let link = $(getControls[j]).find('input[name="unit_inline_link[]"]');
                let button_type = $(getControls[j]).find('select[name="unit_inline_button_type[]"]');

                //Если есть текст кнопки и если есть ссылка ИЛИ тип кнопки не url/web_app (ИЛИ тип кнопки web_app_captcha (там ссылка не нужна)
                if (text.val() && (link.val() || (button_type.val() !== 'url' && button_type.val() !== 'web_app' && button_type.val() === 'web_app_captcha'))) {
                    $(getControls[j]).find('input[name="unit_inline_id[]"]').attr('name', 'unit_inline_id[' + i + ']');
                    $(text).attr('name', 'unit_inline_id[' + i + '][' + j + '][caption]');

                    if (button_type.val() !== 'web_app_captcha') {
                        $(link).attr('name', 'unit_inline_id[' + i + '][' + j + '][link]');
                    }

                    $(button_type).attr('name', 'unit_inline_id[' + i + '][' + j + '][type]');
                }
            }

        }
    });

});
