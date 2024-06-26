function checkClient() {
    var clientSelect = document.getElementById("clients");
    var newClientForm = document.getElementById("newClientForm");

    if (clientSelect.value === "new") {
        newClientForm.style.display = "block";
        document.getElementById("selectClientForm").style.display = "none";
    } else {
        newClientForm.style.display = "none";
    }
}

function submitClientForm() {
    var clientSelect = document.getElementById("clients");
    var aparelhoForm = document.getElementById("aparelhoForm");
    var clientNameInput = document.getElementById("clientName");
    var fkClientesIdInput = document.getElementById("fk_clientes_id");

    if (clientSelect.value !== "new") {
        var clientName = clientSelect.options[clientSelect.selectedIndex].text;
        clientNameInput.value = clientName;
        fkClientesIdInput.value = clientSelect.value;
        document.getElementById("selectClientForm").style.display = "none";
        aparelhoForm.style.display = "block";
    }
}

function showNewClientForm() {
    document.getElementById("newClientForm").style.display = "block";
    document.getElementById("selectClientForm").style.display = "none";
}

function showSelectClientForm() {
    document.getElementById("newClientForm").style.display = "none";
    document.getElementById("selectClientForm").style.display = "block";
    document.getElementById("aparelhoForm").style.display = "none";
    document.getElementById("servicoForm").style.display = "none";
}

function showServicoForm() {
    document.getElementById("aparelhoForm").style.display = "none";
    document.getElementById("servicoForm").style.display = "block";
}

// Função para calcular a data prevista com base na complexidade selecionada
function calculateDataPrevista() {
    var complexidade = document.getElementById("fk_complexidade_id").value;
    var dataEntrada = new Date(document.getElementById("data_entrada").value);
    var diasAdicionar = 0;

    switch (complexidade) {
        case "1":
            diasAdicionar = 2;
            break;
        case "2":
            diasAdicionar = 4;
            break;
        case "3":
            diasAdicionar = 7;
            break;
        case "4":
            diasAdicionar = 10;
            break;
        case "5":
            diasAdicionar = 14;
            break;
        default:
            diasAdicionar = 0;
    }

    var dataPrevista = new Date(dataEntrada);
    dataPrevista.setDate(dataEntrada.getDate() + diasAdicionar);

    var dataPrevistaInput = document.getElementById("data_prevista");
    dataPrevistaInput.value = dataPrevista.toISOString().split('T')[0];
}

// Interceptar o envio do formulário de novo cliente
document.getElementById("newClientForm").addEventListener("submit", function(event) {
    event.preventDefault();
    var formData = new FormData(this);

    fetch("../controls/cadastrarCliente.php", {
        method: "POST",
        body: formData
    }).then(response => response.text())
      .then(result => {
          // Redirecionar para a página de serviços após o cadastro bem-sucedido
          window.location.href = "../views/servicos.php";
      }).catch(error => {
          console.error('Erro:', error);
          alert('Ocorreu um erro ao cadastrar o cliente.');
      });
});


// // Interceptar o envio do formulário de novo serviço
// document.getElementById("servicoForm").addEventListener("submit", function(event) {
//     event.preventDefault();
//     var formData = new FormData(this);

//     fetch("../controls/cadastrarServico.php", {
//         method: "POST",
//         body: formData
//     }).then(response => response.text())
//       .then(result => {
//           alert("Serviço cadastrado com sucesso!");
//           showSelectClientForm();
//       }).catch(error => {
//           console.error('Erro:', error);
//           alert('Ocorreu um erro ao cadastrar o serviço.');
//       });
// });

$(document).ready(function() {
    // Interceptar o envio do formulário de novo aparelho
    $("#aparelhoForm").on("submit", function(event) {
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "../controls/cadastrarAparelho.php",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                var result = JSON.parse(response);
                if (result.status === "success") {
                    // Removida a linha de alerta
                    // alert("Aparelho cadastrado com sucesso!");
                    
                    // Atualizar a lista de aparelhos
                    var aparelhoId = result.aparelho_id;
                    var tipo = result.tipo;
                    var modelo = result.modelo;
                    var newOption = new Option(tipo + " - " + modelo, aparelhoId);
                    $("#fk_aparelho_id").append(newOption).val(aparelhoId);
                    showServicoForm();
                } else {
                    alert(result.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Erro:', error);
                alert('Ocorreu um erro ao cadastrar o aparelho.');
            }
        });
    });
});




// Função para definir a data atual no campo de data de entrada
function setDataAtual() {
    var dataEntradaInput = document.getElementById("data_entrada");
    var hoje = new Date().toISOString().split('T')[0];
    dataEntradaInput.value = hoje;
}

// Chamar a função quando a página for carregada
document.addEventListener("DOMContentLoaded", function() {
    setDataAtual();
});
