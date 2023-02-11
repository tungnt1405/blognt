'use strict';
import * as Common from './common';

const datepicker = () => {
    if ($('#datepicker').length) {
        $('#datepicker').datepicker({
            rtl: true,
            dateFormat: 'dd-mm-yy',
            showAnim: 'slide',
            clearBtn: true,
            autoClose: true,
            endDate: new Date(),
            onSelect: function (datetext) {
                var d = new Date(); // for now

                var h = d.getHours();
                h = h < 10 ? '0' + h : h;

                var m = d.getMinutes();
                m = m < 10 ? '0' + m : m;

                var s = d.getSeconds();
                s = s < 10 ? '0' + s : s;

                datetext = datetext + ' ' + h + ':' + m + ':' + s;

                $('#datepicker').val(datetext);
            },
        });
    }
};
const input = {
    init() {
        // update and new
        this.autoSlug();

        // posts all
        this.selectAllPosts();
    },
    autoSlug() {
        $('#title').on('keyup', function () {
            const title = $(this).val();
            $('#slug').val(Common.to_slug(title));
        });
    },
    selectAllPosts() {
        $('.js-delete-close').on('click', function () {
            $('.js-checkbox-all').prop('checked', false);
            $('.js-checkbox-post').prop('checked', false);
            $('.js-delete-post').addClass('hidden');
        });

        // click checkbox label
        $('.js-checkbox-all').on('change', () => {
            if ($('.js-checkbox-all').is(':checked')) {
                $('.js-checkbox-post').prop('checked', true);
                $('.js-delete-post').removeClass('hidden');
                return;
            }

            $('.js-checkbox-post').prop('checked', false);
            $('.js-delete-post').addClass('hidden');
        });

        // click all checkbox post
        $('.js-checkbox-post').on('change', () => {
            const checkboxChecked = $('input.js-checkbox-post:checked').length;
            const checkboxPosts = $('input.js-checkbox-post').length;
            if (checkboxChecked > 0) {
                $('.js-delete-post').removeClass('hidden');
            } else {
                $('.js-delete-post').addClass('hidden');
            }

            if (checkboxChecked === checkboxPosts) {
                $('.js-checkbox-all').prop('checked', true);
                return;
            }

            $('.js-checkbox-all').prop('checked', false);
        });
    },
    changeStatus() {
        const url = $(this).attr('data-path');
        const method = $(this).attr('data-method');

        $.ajax({
            url: url,
            type: method,
            dataType: 'json',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                status: $(this).val(),
            },
            beforeSend: function () {
                console.log('Send request updated!');
                Common.showLoading();
            },
            success: function (res) {
                Common.hideLoading(2000);
                setTimeout(() => {
                    console.log(res.message);
                    location.reload();
                }, 2200);
            },
            error: function (xhr, err) {
                console.log('====== Status Response ========\n', xhr.status + ' ' + xhr.statusText);
                Common.hideLoading(2000);
                setTimeout(() => {
                    alert('Error! Contact the system administrator');
                }, 2200);
            },
            always: function () {
                Common.hideLoading();
            },
        });
    },
    getInputCheckbox() {
        let listPosts = [];
        $('.js-checkbox-post:checked').each(function () {
            listPosts.push($(this).val());
        });

        return listPosts;
    },
};
const btn = {
    init() {
        this.showInputParentId();
        this.changeStatusPost();
        this.addPostParentId();
        this.searchOptions();
    },
    showInputParentId() {
        $('#checkbox-series').on('change', () => {
            if ($('#checkbox-series').is(':checked')) {
                $('#checkbox-series').val('1');
                $('#js-post-type').removeClass('hidden');
                return;
            }

            $('#checkbox-series').val('0');
            $('#js-post-type').addClass('hidden');
            $('#js-post-addParent').addClass('hidden');
            $('input[name="post_type"]').filter('[value=1]').prop('checked', true);
            $('input[name="post_type"]').filter('[value=2]').prop('checked', false);
        });
    },
    changeStatusPost() {
        $('#checkbox-status').on('change', () => {
            if ($('#checkbox-status').is(':checked')) {
                $('#checkbox-status').val('1');
                return;
            }

            $('#checkbox-status').val('0');
        });
    },
    addPostParentId() {
        $('input[name="post_type"]').on('change', () => {
            const additional = $('input[name="post_type"]:checked').val();

            if (additional === '2') {
                $('#js-post-addParent').removeClass('hidden');
                return;
            }
            $('#js-post-addParent').addClass('hidden');
        });
    },
    searchOptions() {
        $('.search-options').on('click', function () {
            $('.posts-category-search').toggleClass('hidden');
            $('.posts-status-search').toggleClass('hidden');
            if ($('.posts-category-search').hasClass('hidden') && $('.posts-status-search').hasClass('hidden')) {
                const html = `
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                `;
                $(this).html('').append(html);
            } else {
                const html = `
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                `;
                $(this).html('').append(html);
            }
        });
    },
    handleBtnDelete() {
        const listPosts = input.getInputCheckbox();
        const url = $(this).attr('data-path');
        const method = $(this).attr('data-method');

        $.ajax({
            url: url,
            type: method,
            dataType: 'json',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                ids: listPosts,
            },
            beforeSend: function () {
                console.log('Send request delete!');
                Common.showLoading();
            },
            success: function (res) {
                Common.hideLoading(2000);
                setTimeout(() => {
                    console.log(res.message);
                    location.reload();
                }, 2200);
            },
            error: function (xhr, err) {
                console.log('====== Status Response ========\n', xhr.status + ' ' + xhr.statusText);
                Common.hideLoading(2000);
                setTimeout(() => {
                    alert('Error! Contact the system administrator');
                }, 2200);
            },
            always: function () {
                Common.hideLoading();
            },
        });
    },
};

$(document).ready(function () {
    datepicker();

    //handle event input
    input.init();

    // handle button
    btn.init();

    // CKEDITOR
    if ($('#description').length && $('#content').length) {
        CKEDITOR.replace('description', {
            width: '100%',
        });
        CKEDITOR.replace('content', {
            width: '100%',
        });
    }

    // Handle elements with data triggers
    $('[data-trigger]').each(function (e) {
        $(this).on($(this).attr('data-trigger'), input.changeStatus);
    });

    // handle button delete posts
    $('.js-delete-handle, .js-soft-delete-handle').on('click', btn.handleBtnDelete);
});
