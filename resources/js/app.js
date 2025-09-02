/**
 * app.js
 *
 * El punto de entrada principal para los scripts de tu aplicación.
 */

// Importaciones de dependencias principales
import './bootstrap';
import $ from 'jquery';
import 'parsleyjs';
import Alpine from 'alpinejs';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import '@fortawesome/fontawesome-free/css/all.css';

// Importaciones de estilos y scripts del proyecto
import '../css/app.css';
import './istpet-animations';

/*
 |--------------------------------------------------------------------------
 | Inicialización de Alpine.js
 |--------------------------------------------------------------------------
 */
window.Alpine = Alpine;
Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    /*
     |--------------------------------------------------------------------------
     | Inicialización de CKEditor
     |--------------------------------------------------------------------------
     */
    const editorElement = document.querySelector('#contenido');
    if (editorElement) {
        ClassicEditor.create(editorElement, {
            toolbar: [
                'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|', 'undo', 'redo'
            ],
            mediaEmbed: {
                previewsInData: true
            }
        }).catch(error => {
            console.error('Error al inicializar CKEditor:', error);
        });
    }

    /*
     |--------------------------------------------------------------------------
     | Inicialización de Parsley.js
     |--------------------------------------------------------------------------
     */
    window.Parsley = require('parsleyjs');
    const forms = document.querySelectorAll('form[data-parsley-validate]');
    forms.forEach(form => {
        $(form).parsley();
    });
});
