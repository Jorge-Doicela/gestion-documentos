import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import plugin from 'tailwindcss/plugin';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],
    theme: {
        extend: {
            // Paleta de colores optimizada
            colors: {
                institutional: {
                    light: '#5684AE',
                    DEFAULT: '#2C5E87', // Azul oscuro dominante
                    dark: '#1D4568',
                },
                steel: {
                    light: '#8AB1D6', // Azul claro para gradientes
                    DEFAULT: '#5E8FB4',
                    dark: '#487299',
                },
                gold: {
                    light: '#FFDB58',
                    DEFAULT: '#FFC700', // Un dorado más brillante
                    dark: '#C99E00',
                },
                eco: '#22C55E',
                success: '#34D399',
                warning: '#FBBF24',
                danger: '#EF4444',
                info: '#60A5FA',
                'glass-light': 'rgba(255, 255, 255, 0.2)',
                'glass-dark': 'rgba(0, 0, 0, 0.2)',
            },

            // Fuentes personalizadas
            fontFamily: {
                sans: ['Figtree', 'Inter', ...defaultTheme.fontFamily.sans],
                serif: ['Merriweather', ...defaultTheme.fontFamily.serif],
                display: ['Montserrat', ...defaultTheme.fontFamily.sans],
            },

            // Espaciado y tamaños
            spacing: {
                '128': '32rem',
                '144': '36rem',
            },
            fontSize: {
                'xxs': '0.65rem',
            },

            // Sombras, fondos y transiciones
            boxShadow: {
                '3xl': '0 35px 60px -15px rgba(0, 0, 0, 0.3)',
                'soft-lg': '0 8px 15px rgba(0, 0, 0, 0.08)',
                'gold-glow': '0 0 15px rgba(255, 199, 0, 0.7)',
                'card-hover': '0 10px 20px rgba(0, 0, 0, 0.15)',
            },
            backgroundImage: {
                'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
                'gradient-main': 'linear-gradient(225deg, #2C5E87 0%, #5684AE 100%)',
                'gradient-gold': 'linear-gradient(225deg, #FFC700 0%, #C99E00 100%)',
                'gradient-accent': 'linear-gradient(135deg, #FFC700 0%, #FFDB58 100%)',
            },
            transitionDuration: { '400': '400ms' },
            borderRadius: { '4xl': '2rem' },
            backdropBlur: { 'xs': '2px', '10': '10px' },
            zIndex: { '60': '60', '70': '70', '80': '80' },
            maxWidth: { '8xl': '90rem' },
            gridTemplateColumns: { '16': 'repeat(16, minmax(0, 1fr))' },

            // Animaciones y keyframes optimizados
            animation: {
                'fade-in': 'fade-in 1s ease-out',
                'fade-in-up': 'fade-in-up 1s ease-out',
                'fade-in-down': 'fade-in-down 1s ease-out',
                'slide-in-right': 'slide-in-right 1s ease-out',
                'slide-in-left': 'slide-in-left 1s ease-out',
                'bounce-soft': 'bounce-soft 1s infinite',
                'pulse-accent': 'pulse-accent 2s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                'float': 'float 3s ease-in-out infinite',
                'scale-in': 'scale-in 0.5s ease-out',
                'shimmer': 'shimmer 2s infinite linear',
                'glow': 'glow 1.5s ease-in-out infinite',
                'slide-up-fade': 'slide-up-fade 0.5s ease-out',
                'scale-in-center': 'scale-in-center 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94)',
                'pulse-border': 'pulse-border 2s cubic-bezier(0.4, 0, 0.6, 1) infinite',
            },
            keyframes: {
                'fade-in': { from: { opacity: 0 }, to: { opacity: 1 } },
                'fade-in-up': { from: { opacity: 0, transform: 'translateY(20px)' }, to: { opacity: 1, transform: 'translateY(0)' } },
                'fade-in-down': { from: { opacity: 0, transform: 'translateY(-20px)' }, to: { opacity: 1, transform: 'translateY(0)' } },
                'slide-in-right': { from: { transform: 'translateX(100%)' }, to: { transform: 'translateX(0)' } },
                'slide-in-left': { from: { transform: 'translateX(-100%)' }, to: { transform: 'translateX(0)' } },
                'bounce-soft': { '0%, 100%': { transform: 'translateY(-5%)' }, '50%': { transform: 'translateY(0)' } },
                'pulse-accent': { '0%, 100%': { transform: 'scale(1)', filter: 'drop-shadow(0 0 5px rgba(255, 199, 0, 0.5))' }, '50%': { transform: 'scale(1.05)', filter: 'drop-shadow(0 0 10px rgba(255, 199, 0, 0.7))' } },
                'float': { '0%, 100%': { transform: 'translateY(0)' }, '50%': { transform: 'translateY(-10px)' } },
                'scale-in': { '0%': { transform: 'scale(0)' }, '100%': { transform: 'scale(1)' } },
                'shimmer': { '100%': { transform: 'translateX(100%)' } },
                'glow': { '0%, 100%': { filter: 'drop-shadow(0 0 5px theme(colors.gold.DEFAULT))' }, '50%': { filter: 'drop-shadow(0 0 10px theme(colors.gold.DEFAULT))' } },
                'slide-up-fade': { from: { opacity: 0, transform: 'translateY(10px)' }, to: { opacity: 1, transform: 'translateY(0)' } },
                'scale-in-center': { '0%': { transform: 'scale(0.95)', opacity: 0 }, '100%': { transform: 'scale(1)', opacity: 1 } },
                'pulse-border': { '0%, 100%': { boxShadow: '0 0 0 0 rgba(255, 199, 0, 0.5)' }, '50%': { boxShadow: '0 0 0 10px rgba(255, 199, 0, 0)' } },
            },
        },
    },

    // Plugins de Tailwind
    plugins: [
        forms,
        plugin(function ({ addUtilities, theme }) {
            const newUtilities = {
                // Utilidades de botones mejoradas
                '.btn-primary': {
                    backgroundColor: theme('colors.gold.DEFAULT'),
                    color: theme('colors.institutional.dark'),
                    padding: '0.75rem 1.5rem',
                    borderRadius: theme('borderRadius.lg'),
                    fontWeight: theme('fontWeight.bold'),
                    transition: 'background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease',
                    '&:hover': {
                        backgroundColor: theme('colors.gold.dark'),
                        transform: 'translateY(-2px)',
                        boxShadow: theme('boxShadow.soft-lg'),
                    },
                    '&:focus-visible': {
                        outline: 'none',
                        boxShadow: '0 0 0 4px ' + theme('colors.gold.DEFAULT') + '30',
                    },
                },
                '.btn-secondary': {
                    backgroundColor: theme('colors.white'),
                    color: theme('colors.institutional.DEFAULT'),
                    padding: '0.75rem 1.5rem',
                    borderRadius: theme('borderRadius.lg'),
                    fontWeight: theme('fontWeight.bold'),
                    borderWidth: '1px',
                    borderColor: theme('colors.institutional.DEFAULT'),
                    transition: 'background-color 0.3s ease, transform 0.2s ease',
                    '&:hover': {
                        backgroundColor: theme('colors.gray.100'),
                        transform: 'translateY(-2px)',
                    },
                    '&:focus-visible': {
                        outline: 'none',
                        boxShadow: '0 0 0 4px ' + theme('colors.institutional.DEFAULT') + '30',
                    },
                },

                // Efectos de Glassmorphism
                '.glass': {
                    backgroundColor: theme('colors.glass-light'),
                    backdropFilter: 'blur(12px)',
                    border: '1px solid rgba(255, 255, 255, 0.18)',
                    boxShadow: theme('boxShadow.soft-lg'),
                },
                '.glass-dark': {
                    backgroundColor: theme('colors.glass-dark'),
                    backdropFilter: 'blur(12px)',
                    border: '1px solid rgba(0, 0, 0, 0.18)',
                    boxShadow: '0 8px 15px rgba(0, 0, 0, 0.2)',
                },

                // Efecto hover para tarjetas (con grupo)
                '.card-hover': {
                    transition: 'transform 0.3s ease, box-shadow 0.3s ease',
                    '&:hover': {
                        transform: 'translateY(-5px)',
                        boxShadow: theme('boxShadow.card-hover'),
                    },
                },

                // Efecto shimmer mejorado con variables
                '.shimmer-bg': {
                    position: 'relative',
                    overflow: 'hidden',
                    '--shimmer-color': theme('colors.gray.200'),
                    '--shimmer-highlight': theme('colors.gray.100'),
                    background: 'linear-gradient(to right, var(--shimmer-color) 0%, var(--shimmer-highlight) 20%, var(--shimmer-color) 40%)',
                    backgroundSize: '1000px 100%',
                    animation: 'shimmer 2s infinite linear',
                },

                // Texto con gradiente
                '.text-gradient': {
                    backgroundClip: 'text',
                    webkitBackgroundClip: 'text',
                    color: 'transparent',
                    backgroundImage: theme('backgroundImage.gradient-accent'),
                },

                // Texto con gradiente animado
                '.text-gradient-animated': {
                    backgroundImage: theme('backgroundImage.gradient-gold'),
                    backgroundSize: '200% auto',
                    animation: 'shimmer-text 2s linear infinite',
                    backgroundClip: 'text',
                    webkitBackgroundClip: 'text',
                    color: 'transparent',
                },

                // Contenedor personalizado
                '.container-custom': {
                    maxWidth: theme('maxWidth.8xl'),
                    margin: '0 auto',
                    padding: '0 1rem',
                },

                // Desplazamiento suave
                '.scroll-smooth': {
                    scrollBehavior: 'smooth',
                },
            };

            addUtilities(newUtilities, ['responsive', 'hover', 'focus', 'group-hover', 'focus-visible']);
        }),
    ],
};
