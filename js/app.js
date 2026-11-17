// js/app.js

document.addEventListener('DOMContentLoaded', () => {
    console.log("Website initialized.");
});

function changeLanguage(lang) {
    const domain = window.location.hostname;
    
    if (lang === 'si') {
        // Revert to original language (Sinhala)
        document.cookie = 'googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
        document.cookie = 'googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/; domain=.' + domain + ';';
        window.location.reload();
        return;
    }

    const select = document.querySelector('.goog-te-combo');
    if (select) {
        select.value = lang;
        select.dispatchEvent(new Event('change'));
    } else {
        // Robust fallback: set cookie direct and reload
        document.cookie = 'googtrans=/si/' + lang + '; path=/;';
        document.cookie = 'googtrans=/si/' + lang + '; path=/; domain=.' + domain + ';';
        window.location.reload();
    }
}
