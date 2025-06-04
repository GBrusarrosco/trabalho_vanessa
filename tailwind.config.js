// tailwind.config.js
import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: { // Adicione ou modifique esta seção
                'background': '#fffffe', // Branco para fundos principais de cards/conteúdo
                'headline': '#2b2c34',   // Cinza escuro para títulos e texto principal
                'paragraph': '#2b2c34', // Mesma cor para parágrafos
                'button': '#6246ea',     // Roxo/Índigo para botões primários e destaques
                'button-text': '#fffffe',// Branco para texto de botões
                'stroke': '#2b2c34',     // Para bordas ou elementos de ilustração
                'main-illustration': '#fffffe', // Cor principal em ilustrações (se houver)
                'highlight': '#6246ea',  // Cor de destaque (igual ao botão)
                'secondary': '#d1d1e9',  // Lilás/cinza claro para fundos secundários, divisórias
                'tertiary-action': '#e45858', // Vermelho/Coral para alertas, ações destrutivas
                // Você pode adicionar mais variações se precisar, como tons mais claros/escuros
                'primary': '#6246ea', // Alias para 'button' ou 'highlight' para uso geral
                'danger': '#e45858',  // Alias para 'tertiary-action'
                'light-gray-bg': '#f7fafc', // O cinza claro que você já usa no app.css
            }
        },
    },

    plugins: [forms],
};
