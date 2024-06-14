const form = document.getElementById("form")
const nome = document.getElementById("nome")
const username = document.getElementById("username")
const email = document.getElementById("email")
const password = document.getElementById("password")
const telefone = document.getElementById("telefone")
const cargo = document.getElementById("cargo")

form.addEventListener("submit", (event) => {
    event.preventDefault();

    checkInputUsername();
})
 

function checkInputUsername(){
    const username =username.value;

    if(usernameValue === ""){
        errorInput(username, "preencha um usuario")
    }else{
        const formItem =username.parentElemet;
        formItem.classList = "form-content"
    }
} 

function errorInput(input, menssage){
    const formItem = input.parentElemet;
    const textmessege = formItem.querySelector("a") 

    textmessege.innertext = menssage; 

    formItem.className = "form-content error"
}