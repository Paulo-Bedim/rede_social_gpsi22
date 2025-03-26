// javascript.js

function O(i) { return typeof i == 'object' ? i : document.getElementById(i) }
function S(i) { return O(i).style                                            }
function C(i) { return document.getElementsByClassName(i)                    }

function toggleDarkMode() {
    const body = document.body;
    body.classList.toggle('dark-mode');
    const isDarkMode = body.classList.contains('dark-mode');
    localStorage.setItem('darkMode', isDarkMode ? 'enabled' : 'disabled');
    updateButtonText(isDarkMode);
}

function updateButtonText(isDarkMode) {
    const button = document.getElementById('dark-mode-toggle');
    if (isDarkMode) {
        button.innerHTML = '<span class="icon">🌙</span> Modo Claro';
    } else {
        button.innerHTML = '<span class="icon">☀️</span> Modo Escuro';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const darkMode = localStorage.getItem('darkMode');
    if (darkMode === 'enabled') {
        document.body.classList.add('dark-mode');
        updateButtonText(true);
    } else {
        updateButtonText(false);
    }
});