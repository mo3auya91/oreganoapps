/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');


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

    $(document).on('click', '.delete-category', function () {
        let id = $(this).data('id');
        let url = '/categories/' + id;
        axios.delete(url, {}, {'Accept': 'application/json'})
            .then(result => {
                alert(result.data.message);
                $('#category-row-' + id).hide(300);
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
