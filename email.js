const input = document.getElementById("email-input");

// descobrir o valor que tem no elemento 
const formulario = document.getElementById("email-newsletter");  // criei a váriável formulario  que recebe o valor dentro do elemento

// Capturar o evento de envio do form
formulario.addEventListener('submit', function (evento) {
    evento.preventDefault();
    const inputValue = input.value;
    console.log(inputValue);
    alert("Evento de Captura com Sucesso" + inputValue);
})

// PASSO 4 - FUNÇÃO MOSTRAR MENSAGEM 
function mostrarmensagem(tipo, mensagem) {
console.log(`mostrando mensagem (${tipo}); `, mensagem); 

//esconder ambas as mensagens:
ElementoErro.classList.add(`hidden`)
ElementoSucesso.classList.add(`hidden`)
}
// PASSO 1 -  CRIAR ELEMENTOS HTML PARA MENSAGENS DE ERRO E SUCESSO
const ElementoErro = document.createElement("p");









// Fazer a Validação do E-mail






// Capturar o e-mail 






