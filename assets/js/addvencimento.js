//function receberTurmaUsuario() {
//  const turmaUsuario = document.getElementById("form_turma_usuario").value;
//console.log(turmaUsuario);

//const dateArr = turmaUsuario.split('-');
//const [year, month, day] = dateArr.map(number);

//let dateInit = new Date(year, month, day);

//dateInit.setMonth(dateInit.getMonth() + 1);

//let daySingle = dateInit.getDate();
//let monthSingle = dateInit.getMonth();
//let yearSingle = dateInit.getFullYear;

//let dataView = daySingle + '/' + monthSingle + '/' + yearSingle

// Enviar os dados para o formulario do arquivo index.html utilizando o atributo ID
//document.getElementById("receber_turma_usuario").value = turmaUsuario;
//}

let selectBloco = document.getElementById('bloco_adds');

selectBloco.onchange = () => {
    let selectUnidade = document.getElementById('unidade_adds');

    fetch("../../consultas/listarunidade.php");
    selectUnidade.innerHTML = "";
}