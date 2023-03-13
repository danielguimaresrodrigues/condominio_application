const alterasenha = document.getElementById("alterasenha");
const msgAlertErroLogin = document.getElementById("msgAlertErroLogin");

alterasenha.addEventListener("submit", async (e) => {
    e.preventDefault();

    const dadosForm = new FormData(lofinForm);

    const dados = await fetch("../../db/validar.php")
});