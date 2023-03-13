$(function () {
    // Executa assim que o botão de salvar for clicado
    $('#salva').click(function (e) {

        // Cancela o envio do formulário
        e.preventDefault();

        // Pega os valores dos inputs e coloca nas variáveis
        var nome_cliente = $('#nome_cliente').val();
        var nascimento = $('#nascimento').val();
        var cpf = $('#cpf').val();
        var cnpj = $('#cnpj').val();
        var rg = $('#rg').val();
        var email = $('#email').val();
        var celular = $('#celular').val();
        var cep_cliente = $('#cep_cliente').val();
        var rua_cliente = $('#rua_cliente').val();
        var numero_cliente = $('#numero_cliente').val();
        var complemento_cliente = $('#complemento_cliente').val();
        var bairro_cliente = $('#bairro_cliente').val();
        var uf_cliente = $('#uf_cliente').val();
        var cidade_cliente = $('#cidade_cliente').val();

        // Método post do Jquery
        $.post('registracliente.php', {
            nome_cliente: nome_cliente,
            nascimento: nascimento,
            cpf: cpf,
            cnpj: cnpj,
            rg: rg,
            email: email,
            celular: celular,
            cep_cliente: cep_cliente,
            rua_cliente: rua_cliente,
            numero_cliente: numero_cliente,
            complemento_cliente: complemento_cliente,
            bairro_cliente: bairro_cliente,
            uf_cliente: uf_cliente,
            cidade_cliente: cidade_cliente
        }, function (resposta) {
            // Valida a resposta
            if (resposta == 1) {
                // Limpa os inputs
                //$('input, textarea').val('');
                document.getElementById('rua_cliente').value = nome_proj
                alert('Mensagem enviada com sucesso.');
            } else {
                alert(resposta);
            }
        });

    });
});