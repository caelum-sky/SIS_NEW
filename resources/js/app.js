import './bootstrap';

import Alpine from 'alpinejs';
import * as bootstrap from 'bootstrap';
import $ from 'jquery';
import Swal from 'sweetalert2';

window.Alpine = Alpine;
window.bootstrap = bootstrap;
window.$ = window.jQuery = $;
window.Swal = Swal;

if ($.fn) {
    $.fn.modal = function (action) {
        return this.each(function () {
            const instance = bootstrap.Modal.getOrCreateInstance(this);

            if (action === 'show') {
                instance.show();
            } else if (action === 'hide') {
                instance.hide();
            } else if (action === 'toggle') {
                instance.toggle();
            }
        });
    };
}

Alpine.start();
