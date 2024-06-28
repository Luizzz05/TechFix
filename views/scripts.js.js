document.addEventListener('DOMContentLoaded', function() {
    // Função para verificar cliente
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

    // Função para submeter o formulário de seleção de cliente
    function submitClientForm() {
        var clientSelect = document.getElementById("clients");
        var clientId = clientSelect.value;

        if (clientId) {
            document.getElementById("fk_clientes_id").value = clientId;
            document.getElementById("clientName").value = clientSelect.options[clientSelect.selectedIndex].text;
            showAparelhoForm();
        }
    }

    // Função para mostrar o formulário de aparelho
    function showAparelhoForm() {
        document.getElementById("newClientForm").style.display = "none";
        document.getElementById("selectClientForm").style.display = "none";
        document.getElementById("aparelhoForm").style.display = "block";
    }

    // Função para mostrar o formulário de novo cliente
    function showNewClientForm() {
        document.getElementById("selectClientForm").style.display = "none";
        document.getElementById("newClientForm").style.display = "block";
    }

    // Função para mostrar o formulário de seleção de cliente
    function showSelectClientForm() {
        document.getElementById("newClientForm").style.display = "none";
        document.getElementById("aparelhoForm").style.display = "none";
        document.getElementById("servicoForm").style.display = "none";
        document.getElementById("selectClientForm").style.display = "block";
    }

    // Função para mostrar o formulário de serviço
    function showServicoForm() {
        document.getElementById("selectClientForm").style.display = "none";
        document.getElementById("aparelhoForm").style.display = "none";
        document.getElementById("servicoForm").style.display = "block";
    }

    // Função para calcular a data prevista
    function calculateDataPrevista() {
        var complexidadeSelect = document.getElementById("fk_complexidade_id");
        var dataEntrada = document.getElementById("data_entrada").value;
        var dataPrevista = document.getElementById("data_prevista");

        if (complexidadeSelect.value && dataEntrada) {
            var prazoDias = complexidadeSelect.options[complexidadeSelect.selectedIndex].getAttribute('data-prazo');
            var entradaDate = new Date(dataEntrada);
            entradaDate.setDate(entradaDate.getDate() + parseInt(prazoDias));

            var dia = ("0" + entradaDate.getDate()).slice(-2);
            var mes = ("0" + (entradaDate.getMonth() + 1)).slice(-2);
            var ano = entradaDate.getFullYear();

            dataPrevista.value = `${ano}-${mes}-${dia}`;
        }
    }

    // Intercepta o envio dos formulários
    document.getElementById("selectClientForm").addEventListener("submit", function (e) {
        e.preventDefault();
        submitClientForm();
    });

    document.getElementById("newClientForm").addEventListener("submit", function (e) {
        e.preventDefault();
        showAparelhoForm();
    });

    document.getElementById("aparelhoForm").addEventListener("submit", function (e) {
        e.preventDefault();
        showServicoForm();
    });

    // Define a data atual
    function setDataAtual() {
        var dataAtual = new Date().toISOString().split('T')[0];
        document.getElementById("data_entrada").value = dataAtual;
    }

    // Chama a função para definir a data atual no carregamento da página
    setDataAtual();

    // Disponibiliza as funções globalmente
    window.checkClient = checkClient;
    window.submitClientForm = submitClientForm;
    window.showAparelhoForm = showAparelhoForm;
    window.showNewClientForm = showNewClientForm;
    window.showSelectClientForm = showSelectClientForm;
    window.showServicoForm = showServicoForm;
    window.calculateDataPrevista = calculateDataPrevista;
});
