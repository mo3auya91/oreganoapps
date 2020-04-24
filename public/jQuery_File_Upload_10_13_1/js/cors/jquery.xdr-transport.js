/*
 * jQuery XDomainRequest Transport Plugin
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2011, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * https://opensource.org/licenses/MIT
 *
 * Based on Julian Aubourg's ajaxHooks xdr.js:
 * https://github.com/jaubourg/ajaxHooks/
 */

/* global define, require, XDomainRequest */

(function (factory) {
  'use strict';
  if (typeof define === 'function' && define.amd) {
    // Register as an anonymous AMD module:
    define(['jquery'], factory);
  } else if (typeof exports === 'object') {
    // Node/CommonJS:
    factory(require('jquery'));
  } else {
    // Browser globals:
    factory(window.jQuery);
  }
})(function ($) {
  'use strict';
  if (window.XDomainRequest && !$.support.cors) {
    $.ajaxTransport(function (s) {
      if (s.crossDomain && s.async) {
        if (s.timeout) {
          s.xdrTimeout = s.timeout;
          delete s.timeout;
        }
        var xdr;
        return {
          send: function (headers, completeCallback) {
            var addParamChar = /\?/.test(s.url) ? '&' : '?';
            /**
             * Callback wrapper function
             *
             * @param {number} status HTTP status code
             * @param {string} statusText HTTP status text
             * @param {object} [responses] Content-type specific responses
             * @param {string} [responseHeaders] Response headers string
             */
            function callback(status, statusText, responses, responseHeaders) {
              xdr.onload = xdr.onerror = xdr.ontimeout = $.noop;
              xdr = null;
              completeCallback(status, statusText, responses, responseHeaders);
            }
            xdr = new XDomainRequest();
            // XDomainRequest only supports GET and POST:
            // if (s.type === 'POST') {
            //   s.url = s.url + addParamChar + '_token='+document.head.querySelector('meta[name="csrf-token"]').content;
            //   s.type = 'POST';
            // }
            if (s.type === 'DELETE') {
              s.url = s.url + addParamChar + '_method=DELETE' + '_token='+document.head.querySelector('meta[name="csrf-token"]').content;
              s.type = 'POST';
            } else if (s.type === 'PUT') {
              s.url = s.url + addParamChar + '_method=PUT' + '_token='+document.head.querySelector('meta[name="csrf-token"]').content;
              s.type = 'POST';
            } else if (s.type === 'PATCH') {
              s.url = s.url + addParamChar + '_method=PATCH' + '_token='+document.head.querySelector('meta[name="csrf-token"]').content;
              s.type = 'POST';
            }
            xdr.open(s.type, s.url);
            xdr.onload = function () {
              callback(
                200,
                'OK',
                { text: xdr.responseText },
                'Content-Type: ' + xdr.contentType
              );
            };
            xdr.onerror = function () {
              callback(404, 'Not Found');
            };
            if (s.xdrTimeout) {
              xdr.ontimeout = function () {
                callback(0, 'timeout');
              };
              xdr.timeout = s.xdrTimeout;
            }
            xdr.send((s.hasContent && s.data) || null);
          },
          abort: function () {
            if (xdr) {
              xdr.onerror = $.noop();
              xdr.abort();
            }
          }
        };
      }
    });
  }
});