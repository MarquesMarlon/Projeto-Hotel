//primeiro vou criar variáveis para receber os valores e manipular os dados

const form = document.getElementById('email-newsletter');
const inputEmail = document.getElementById('email-input');
const errorMessage = document.getElementById('error-message');
const modal = document.getElementById('modal');
const closeModalBtn = document.getElementById('close-modal');

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
    showModal();
});

function showModal() {
    modal.classList.remove('hidden');
    modal.setAttribute('aria-hidden','false');
    closeModalBtn.focus();
}

closeModalBtn.addEventListener('click',() => {
    modal.classList.add('hidden');
    modal.setAttribute('aria-hidden', 'true');
    inputEmail.focus();
});

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

