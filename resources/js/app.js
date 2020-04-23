/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

// require('jquery-ui');
// require('jquery-ui/ui/widget');
// require('blueimp-tmpl');
// require('blueimp-load-image');
// require('blueimp-canvas-to-blob');
// require('blueimp-gallery');
// require('blueimp-file-upload');
//
// require('blueimp-file-upload/js/jquery.iframe-transport');
// require('blueimp-file-upload/js/jquery.fileupload');
// require('blueimp-file-upload/js/jquery.fileupload-process');

//require('blueimp-file-upload/js/jquery.fileupload-image');//do not use
// require('blueimp-file-upload/js/jquery.fileupload-audio');//do not use
// require('blueimp-file-upload/js/jquery.fileupload-video');//do not use

// require('blueimp-file-upload/js/jquery.fileupload-validate');

//require('blueimp-file-upload/js/jquery.fileupload-ui');//do not use

// require('blueimp-file-upload/css/jquery.fileupload.css');
// require('blueimp-file-upload/css/jquery.fileupload-ui.css');
// require('blueimp-file-upload/css/jquery.fileupload-ui-noscript.css');
// require('blueimp-gallery/css/blueimp-gallery.min.css');
// require('blueimp-gallery/css/blueimp-gallery-indicator.css');


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
$(() => {
    // 'use strict';
    //
    // let file_upload = $('#fileupload');
    // let upload_max_file_size = $('#upload_max_filesize');
    // file_upload.fileupload();
    //
    // let size = upload_max_file_size.text().slice(0, -1);
    // let max_size = upload_max_file_size.text();
    // let volume = max_size.substr(max_size.length - 1);
    // let maxFileSize = size * 1000000;
    //
    // if (volume === 'G') {
    //     maxFileSize *= 1000;
    // }
    // let mmm = upload_max_file_size.text().slice(0, -1);
    //
    // // Initialize the jQuery File Upload widget:
    // file_upload.fileupload({
    //     // Uncomment the following to send cross-domain cookies:
    //     //xhrFields: {withCredentials: true},
    //     //url: 'server/php/'
    //     maxFileSize: maxFileSize,//mmm * 1000000,//1000000 * 20,// 10000000 == 1 MB
    //     acceptFileTypes: /(\.|\/)(jpeg|png|gif|bmb)$/i,
    //     url: file_upload.attr('action')
    // });
    //
    // // Enable iframe cross-domain access via redirect option:
    // file_upload.fileupload(
    //     'option',
    //     'redirect',
    //     window.location.href.replace(
    //         /\/[^\/]*$/,
    //         '/cors/result.html?%s'
    //     )
    // );
    //
    // //console.log('iam here');
    // // Load existing files:
    // file_upload.addClass('fileupload-processing');
    // $.ajax({
    //     // Uncomment the following to send cross-domain cookies:
    //     //xhrFields: {withCredentials: true},
    //     url: file_upload.fileupload('option', 'url'),
    //     dataType: 'json',
    //     context: file_upload[0]
    // }).always(function () {
    //     $(this).removeClass('fileupload-processing');
    // }).done(function (result) {
    //     $(this).fileupload('option', 'done')
    //         .call(this, $.Event('done'), {result: result});
    // });


    $(document).on('click', '.delete-image', function () {
        let category_id = $(this).data('category_id');
        let id = $(this).data('id');
        let url = '/categories/' + category_id + '/images/' + id;
        axios.delete(url, {}, {'Accept': 'application/json'})
            .then(result => {
                alert(result.data.message);
                $('#image-row-' + id).hide(300);
            })
            .catch(error => {
                alert(error.response.data.message)
            });
    });

    $(document).on('click', '.delete-type', function () {
        let id = $(this).data('id');
        let url = '/types/' + id;
        axios.delete(url, {}, {'Accept': 'application/json'})
            .then(result => {
                alert(result.data.message);
                $('#type-row-' + id).hide(300);
            })
            .catch(error => {
                alert(error.response.data.message)
            });
    });

    $(document).on('change', '.edit_image', function (e) {
        let image_target = $(this).parent().find('.thumbnail img');
        readURL($(this), image_target);
    });

    function readURL(input, target) {
        if (input[0].files && input[0].files[0]) {
            let reader = new FileReader()
            reader.onload = (e) => {
                //$('#certificateImg'+input.id).attr('src', e.target.result).width(40);
                //target.attr('src', e.target.result).width(40);
                target.attr('src', e.target.result)//.width(40)
            }
            reader.readAsDataURL(input[0].files[0])
        } else {
            console.log('no file');
        }
    }
});
const app = new Vue({
    el: '#app',
});
