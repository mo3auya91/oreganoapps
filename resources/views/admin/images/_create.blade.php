@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
{{--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">--}}
    <!-- blueimp Gallery styles -->
    <link rel="stylesheet" href="//blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
    <!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
    <link rel="stylesheet" href="{{url('jQuery_File_Upload_10_13_1/css/jquery.fileupload.css')}}">
    <link rel="stylesheet" href="{{url('jQuery_File_Upload_10_13_1/css/jquery.fileupload-ui.css')}}">
    <!-- CSS adjustments for browsers with JavaScript disabled -->
    <noscript>
        <link rel="stylesheet" href="{{url('jQuery_File_Upload_10_13_1/css/jquery.fileupload-noscript.css')}}">
    </noscript>
    <noscript>
        <link rel="stylesheet" href="{{url('jQuery_File_Upload_10_13_1/css/jquery.fileupload-ui-noscript.css')}}">
    </noscript>
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Add New Images to {{$category->title}}</div>
                    <div class="card-body">
                        <section class="pageInner-content">
                            <div class="container">
                                <div class="row">
                                    <!-- left column -->
                                    <div class="col-md-12">
                                        <!-- general form elements -->
                                        <div class="box box-primary">
                                            <form id="fileupload" method="POST" enctype="multipart/form-data"
                                                  action="{{route('categories.images.store',['category'=>$category->id])}}">
                                            @csrf
                                            {{--                                                <noscript>--}}
                                            {{--                                                    <input type="hidden" name="redirect"--}}
                                            {{--                                                           value="https://blueimp.github.io/jQuery-File-Upload/">--}}
                                            {{--                                                </noscript>--}}
                                            <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                                                <div class="row fileupload-buttonbar">
                                                    <div class="col-lg-7">
                                                        <!-- The fileinput-button span is used to style the file input field as button -->
                                                        <span class="btn btn-success fileinput-button">
                                                            <i class="glyphicon glyphicon-plus"></i>
                                                            <span>{{__('Add Files')}}</span>
                                                            <input type="file" name="files[]" multiple>
                                                            {{--accept="video/mp4,video/quicktime"--}}
                                                        </span>
                                                        <button type="submit" class="btn btn-primary start">
                                                            <i class="glyphicon glyphicon-upload"></i>
                                                            <span>{{__('jquery_upload.start_upload')}}</span>
                                                        </button>
                                                        <button type="reset" class="btn btn-warning cancel">
                                                            <i class="glyphicon glyphicon-ban-circle"></i>
                                                            <span>{{__('jquery_upload.cancel_upload')}}</span>
                                                        </button>
                                                    {{--<button type="button" class="btn btn-danger delete">--}}
                                                    {{--<i class="glyphicon glyphicon-trash"></i>--}}
                                                    {{--<span>{{__('jquery_upload.delete')}}</span>--}}
                                                    {{--</button>--}}
                                                    {{--<input type="checkbox" class="toggle">--}}
                                                    <!-- The global file processing state -->
                                                        <span class="fileupload-process"></span>
                                                    </div>
                                                    <!-- The global progress state -->
                                                    <div class="col-lg-5 fileupload-progress fade">
                                                        <!-- The global progress bar -->
                                                        <div class="progress progress-striped active" role="progressbar"
                                                             aria-valuemin="0"
                                                             aria-valuemax="100">
                                                            <div class="progress-bar progress-bar-success"
                                                                 style="width:0%;"></div>
                                                        </div>
                                                        <!-- The extended global progress state -->
                                                        <div class="progress-extended">&nbsp;</div>
                                                    </div>
                                                </div>
                                                <!-- The table listing the files available for upload/download -->
                                                <table role="presentation" class="table table-striped">
                                                    <tbody class="files"></tbody>
                                                </table>
                                            </form>
                                            <br>
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h3 class="panel-title">{{__('jquery_upload.notes')}}</h3>
                                                </div>
                                                <div class="panel-body">
                                                    <ul>
                                                        <li>{{__('jquery_upload.max_upload_size')}}
                                                            <strong
                                                                id="upload_max_filesize">{{ini_get('upload_max_filesize')}}</strong>.
                                                        </li>
                                                        <li>{{__('jquery_upload.you_can')}}
                                                            <strong>{{__('jquery_upload.drag')}}
                                                                &amp; {{__('jquery_upload.drop')}}</strong> {{__('jquery_upload.drag_drop')}}
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- The blueimp Gallery widget -->
                                        <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls"
                                             data-filter=":even">
                                            <div class="slides"></div>
                                            <h3 class="title"></h3>
                                            <a class="prev">‹</a>
                                            <a class="next">›</a>
                                            <a class="close">×</a>
                                            <a class="play-pause"></a>
                                            <ol class="indicator"></ol>
                                        </div>
                                    </div>
                                    <!--/.col (left) -->
                                </div>
                            </div>
                        </section>
                        <!-- The template to display files available for upload -->
                        <!-- The template to display files available for download -->
                        <script id="template-upload" type="text/x-tmpl">
                            {% for (var i=0, file; file=o.files[i]; i++) { %}
                                {% var x= Math.random().toString(36).slice(-5);%}
                                <tr class="template-upload fade">
                                    <td>
                                        <span class="preview"></span>
                                    </td>
                                    <td style="max-width:100px !important;overflow:hidden">
                                        <p class="name">{%=file.name%}</p>
                                        <strong class="error text-danger"></strong>
                                    </td>
                                    <td style="width:200px !important;">
                                        <p><input style="width:100%;" type="text" value="{%=file.name%}" name="{%=x%}"></p>
                                    </td>
                                    <td>
                                        <p class="size">Processing...</p>
                                        <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
                                    </td>
                                    <td>
                                        {% if (!i && !o.options.autoUpload) { %}
                                            <button class="btn btn-primary start" disabled>
                                                <i class="glyphicon glyphicon-upload"></i>
                                                <span>Start</span>
                                            </button>
                                        {% } %}
                                        {% if (!i) { %}
                                            <button class="btn btn-warning cancel">
                                                <i class="glyphicon glyphicon-ban-circle"></i>
                                                <span>Cancel</span>
                                            </button>
                                        {% } %}
                                    </td>
                                </tr>
                            {% } %}


                        </script>
                        <script id="template-download" type="text/x-tmpl">

                            {% for (var i=0, file; file=o.files[i]; i++) { %}
                                <tr class="template-download fade">
                                    <td>
                                        <span class="preview">
                                            {% if (file.vimeo_thumbnail_url) { %}
                                                <a href="{%=file.vimeo_url%}" title="{%=file.name%}" target="_blank" download="{%=file.name%}" data-gallery><img src="{%=file.vimeo_thumbnail_url%}"></a>
                                            {% } %}
                                        </span>
                                    </td>
                                    <td>
                                        <p class="name">
                                            {% if (file.vimeo_url) { %}
                                                <a href="{%=file.vimeo_url%}" title="{%=file.name%}" target="_blank" download="{%=file.name%}" {%=file.vimeo_thumbnail_url?'data-gallery':''%}>{%=file.name%}</a>
                                            {% } else { %}
                                                <span>{%=file.name%}</span>
                                            {% } %}
                                        </p>
                                        {% if (file.error) { %}
                                            <div><span class="label label-danger">Error</span> {%=file.error%}</div>
                                        {% } %}
                                    </td>
                                    <td>
                                        <span class="size">{%=o.formatFileSize(file.size)%}</span>
                                    </td>
                                    <td>
                                        {% if (!file.vimeo_delete_url) { %}
                                            <button class="btn btn-warning cancel">
                                                <i class="glyphicon glyphicon-ban-circle"></i>
                                                <span>Cancel</span>
                                            </button>
                                        {% } %}
                                    </td>
                                </tr>
                            {% } %}
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://code.jquery.com/jquery-3.5.0.js" integrity="sha256-r/AaFHrszJtwpe+tHyNi/XCfMxYpbsRg2Uqn0x3s2zc=" crossorigin="anonymous"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
{{--    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>--}}
    <!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
    <script src="{{url('jQuery_File_Upload_10_13_1/js/vendor/jquery.ui.widget.js')}}"></script>
    <!-- The Templates plugin is included to render the upload/download listings -->
    <script src="//blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
    <!-- The Load Image plugin is included for the preview images and image resizing functionality -->
    <script src="//blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
    <!-- The Canvas to Blob plugin is included for image resizing functionality -->
    <script src="//blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
    <!-- blueimp Gallery script -->
    <script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>

    <!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/jquery.iframe-transport/1.0.1/jquery.iframe-transport.js"></script>
    <!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
    <script src="{{url('jQuery_File_Upload_10_13_1/js/jquery.iframe-transport.js')}}"></script>
    <!-- The basic File Upload plugin -->
    <script src="{{url('jQuery_File_Upload_10_13_1/js/jquery.fileupload.js')}}"></script>
    <!-- The File Upload processing plugin -->
    <script src="{{url('jQuery_File_Upload_10_13_1/js/jquery.fileupload-process.js')}}"></script>
    <!-- The File Upload image preview & resize plugin -->
    <script src="{{url('jQuery_File_Upload_10_13_1/js/jquery.fileupload-image.js')}}"></script>
    <!-- The File Upload audio preview plugin -->
    <script src="{{url('jQuery_File_Upload_10_13_1/js/jquery.fileupload-audio.js')}}"></script>
    <!-- The File Upload video preview plugin -->
    <script src="{{url('jQuery_File_Upload_10_13_1/js/jquery.fileupload-video.js')}}"></script>
    <!-- The File Upload validation plugin -->
    <script src="{{url('jQuery_File_Upload_10_13_1/js/jquery.fileupload-validate.js')}}"></script>
    <!-- The File Upload user interface plugin -->
    <script src="{{url('jQuery_File_Upload_10_13_1/js/jquery.fileupload-ui.js')}}"></script>

    <script>
        $(function () {
            'use strict';
            var size = $('#upload_max_filesize').text().slice(0, -1);
            var max_size = $('#upload_max_filesize').text();
            var volume = max_size.substr(max_size.length - 1);
            var maxFileSize = size * 1000000;
            if (volume == 'G') {
                maxFileSize *= 1000;
            }
            var mmm = $('#upload_max_filesize').text().slice(0, -1);
            //console.log(mmm);
            // Initialize the jQuery File Upload widget:
            $('#fileupload').fileupload({
                // Uncomment the following to send cross-domain cookies:
                // xhrFields: {withCredentials: true},
                //url: 'server/php/'
                maxFileSize: maxFileSize,//mmm * 1000000,//1000000 * 20,// 10000000 == 1 MB
                //acceptFileTypes: /(\.|\/)(mp4|mov|avi|mkv)$/i,
                acceptFileTypes: /(\.|\/)(png|jpeg|jpg|gif|bmb|svg)$/i,
                url: $('#fileupload').attr('action')
            });

            // Enable iframe cross-domain access via redirect option:
            $('#fileupload').fileupload(
                'option',
                'redirect',
                window.location.href.replace(
                    /\/[^\/]*$/,
                    '/cors/result.html?%s'
                )
            );

            if (window.location.hostname === 'blueimp.github.io') {
                //console.log('Demo');
                // Demo settings:
                $('#fileupload').fileupload('option', {
                    url: "{{url('/')}}",
                    // Enable image resizing, except for Android and Opera,
                    // which actually support image resizing, but fail to
                    // send Blob objects via XHR requests:
                    disableImageResize: /Android(?!.*Chrome)|Opera/
                        .test(window.navigator.userAgent),
                    maxFileSize: 99999,
                    acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i
                });
                // Upload server status check for browsers with CORS support:
                if ($.support.cors) {
                    $.ajax({
                        url: "{{url('/')}}",//'//jquery-file-upload.appspot.com/',
                        type: 'HEAD'
                    }).fail(function () {
                        $('<div class="alert alert-danger"/>')
                            .text('Upload server currently unavailable - ' +
                                new Date())
                            .appendTo('#fileupload');
                    });
                }
            } else {
                console.log('iam here');
                // Load existing files:
                $('#fileupload').addClass('fileupload-processing');
                $.ajax({
                    // Uncomment the following to send cross-domain cookies:
                    //xhrFields: {withCredentials: true},
                    url: $('#fileupload').fileupload('option', 'url'),
                    dataType: 'json',
                    context: $('#fileupload')[0]
                }).always(function () {
                    $(this).removeClass('fileupload-processing');
                }).done(function (result) {
                    $(this).fileupload('option', 'done')
                        .call(this, $.Event('done'), {result: result});
                });
            }
        });
    </script>
    <!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
    <!--[if (gte IE 8)&(lt IE 10)]>
    <script src="{{url('jQuery_File_Upload_10_13_1/js/cors/jquery.xdr-transport.js')}}"></script>
    <![endif]-->
@endsection
