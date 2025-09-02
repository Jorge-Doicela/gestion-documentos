/**
 * istpet-animations.js
 *
 * Este archivo gestiona la activación de animaciones y efectos visuales
 * dinámicos para el proyecto ISTPET. La mayoría de los efectos se basan
 * en clases de Tailwind CSS.
 */

/*
 |--------------------------------------------------------------------------
 | Animaciones de carga y visualización
 |--------------------------------------------------------------------------
 */

/**
 * Activa la animación de shimmer en un elemento.
 * @param {HTMLElement} element - El elemento HTML en el que se aplicará el efecto.
 */
export function startShimmerEffect(element) {
    element.classList.add('animate-shimmer');
}

/**
 * Desactiva la animación de shimmer en un elemento.
 * @param {HTMLElement} element - El elemento HTML del que se eliminará el efecto.
 */
export function stopShimmerEffect(element) {
    element.classList.remove('animate-shimmer');
}

/*
 |--------------------------------------------------------------------------
 | Efectos basados en eventos del DOM y scroll
 |--------------------------------------------------------------------------
 */

// Configuración para el observador de intersección
const animationObserverOptions = {
    root: null,
    rootMargin: '0px',
    threshold: 0.1 // Porcentaje del elemento visible para activar la animación
};

// Crea un observador que activa la animación cuando el elemento es visible
const animationObserver = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            // Usa el atributo `data-animation` para la clase de animación
            const animationClass = entry.target.dataset.animation;
            if (animationClass) {
                entry.target.classList.add(`animate-${animationClass}`);
            }
            // Deja de observar el elemento para que la animación no se repita
            observer.unobserve(entry.target);
        }
    });
}, animationObserverOptions);

document.addEventListener('DOMContentLoaded', () => {
    // Aplica la animación 'fade-in' a todos los elementos con la clase '.fade-in'
    document.querySelectorAll('.fade-in').forEach(el => {
        el.classList.add('animate-fade-in');
    });

    // Añade y quita la animación de brillo al pasar el cursor sobre elementos
    // con la clase '.glow-on-hover'
    document.querySelectorAll('.glow-on-hover').forEach(element => {
        element.addEventListener('mouseenter', () => {
            element.classList.add('animate-glow');
        });
        element.addEventListener('mouseleave', () => {
            element.classList.remove('animate-glow');
        });
    });

    // Observa todos los elementos con el atributo `data-animation`
    document.querySelectorAll('[data-animation]').forEach(el => {
        animationObserver.observe(el);
    });
});
