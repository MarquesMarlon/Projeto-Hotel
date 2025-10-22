//primeiro vou criar variáveis para receber os valores e manipular os dados

const form = document.getElementById('email-newsletter');
const inputEmail = document.getElementById('email-input');
const errorMessage = document.getElementById('error-message');
// Newsletter modal elements renamed to avoid Bootstrap conflict
const modal = document.getElementById('modal-newsletter');
const closeModalBtn = document.getElementById('close-modal-news');

// If elements missing on the current page, don't run the newsletter logic
if (!form || !inputEmail || !errorMessage) {
    // nothing to do on pages without newsletter
} else {

function isValidEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}


//obter o valor, mostra mensagem de erro e validação
    form.addEventListener('submit', function (event) {
    event.preventDefault();
    const email = inputEmail.value.trim();

    if (email === '') {
        errorMessage.textContent = 'Por Favor,preencha seu e-mail!';
        inputEmail.focus();
        return;
    }
    if (!isValidEmail(email)) {
        errorMessage.textContent = 'Formato de e-mail inválido!';
        inputEmail.focus();
        return;
    }
        errorMessage.textContent = '';
        form.reset();
        if (modal) showModal();
    });

    function showModal() {
        if (!modal) return;
        modal.classList.remove('hidden');
        modal.setAttribute('aria-hidden','false');
        if (closeModalBtn) closeModalBtn.focus();
    }

    if (closeModalBtn) {
        closeModalBtn.addEventListener('click',() => {
            modal.classList.add('hidden');
            modal.setAttribute('aria-hidden', 'true');
            inputEmail.focus();
        });
    }
}

// header com Efeito Scroll

(function() {
    const header = document.querySelector('.container-navbar'); 
    if(!header) return; 

function onFirstScroll() { 
    header.classList.add('header-bg');
}
document.addEventListener('scroll', onFirstScroll, {passive: true, once: true })

})(); 

(function(){
    const header = document.querySelector('.container-navbar');
    if(!header) return;

    function setBodyPadding() {
        const h = header.offsetHeight;
        document.body.style.paddingTop = h + 'px';
    }

    setBodyPadding();
    window.addEventListener('resize', setBodyPadding);

    function onFirstScroll(){
        header.classList.add('header-bg');
    }
    document.addEventListener('scroll', onFirstScroll, {passive: true, once: true});
})();

