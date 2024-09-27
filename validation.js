// Função para validar o formulário
function validateForm() {
    var name = document.getElementById('name').value.trim();
    var email = document.getElementById('email').value.trim();
    var password = document.getElementById('password').value.trim();

    // Validação dos campos obrigatórios
    if (name === "") {
        alert('O campo Nome é obrigatório.');
        return false; // Impede o envio do formulário
    }

    if (email === "") {
        alert('O campo Email é obrigatório.');
        return false; // Impede o envio do formulário
    }

    if (password === "") {
        alert('O campo Senha é obrigatório.');
        return false; // Impede o envio do formulário
    }

    // Validação do formato do email
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        alert('Por favor, insira um email válido.');
        return false; // Impede o envio do formulário
    }

    // Validação da senha
    if (password.length < 8) {
        alert('A senha deve conter pelo menos 8 caracteres.');
        return false; // Impede o envio do formulário
    }

    // Validação do nome (somente letras e espaços)
    var namePattern = /^[A-Za-zÀ-ÖØ-ÿ\s]+$/;
    if (!namePattern.test(name)) {
        alert('O nome deve conter apenas letras e espaços.');
        return false; // Impede o envio do formulário
    }

    // Se todas as validações passaram, permite o envio do formulário
    return true;
}
