import "./bootstrap";
import "parsleyjs";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

// Importar CKEditor Classic Build
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";

// Inicializar CKEditor en el textarea con id 'contenido' si existe
document.addEventListener("DOMContentLoaded", () => {
    const editorElement = document.querySelector("#contenido");
    if (editorElement) {
        ClassicEditor.create(editorElement).catch((error) => {
            console.error(error);
        });
    }
});
