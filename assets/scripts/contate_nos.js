function enviar_Mensagem(form,e) {          
    e.preventDefault();      
    const baseUrl = window.location.origin;
    let nome = form[0];
    let email = form[1];
    let mensagem = form[2];
    let nome_val = nome.value;
    let email_val = email.value;
    let mensagem_val = mensagem.value;
    
    $.ajax({
        type: "GET",
        data: { nome: nome_val,
                email: email_val,
                mensagem: mensagem_val},
        url: baseUrl + "/assets/php/cadastrar_Contate_Nos.php",
        dataType: "json",
        success: function (dados) {
            alert("Mensagem enviada com sucesso!");
            nome.value = "";
            email.value = "";
            mensagem.value = "";
        }, error: function(error) {
            // there was an error
            console.error("Erro:", error);
            alert("Ocorreu um erro ao enviar sua mensagem. Por favor, tente novamente.");
          }
    });
    return false; 
}