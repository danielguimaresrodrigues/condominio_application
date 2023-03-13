window.onload = function () {
    const data = new Date();
    const dia = String(data.getDate()).padStart(2, '0');
    const mes = String(data.getMonth() + 1).padStart(2, '0');
    const ano = data.getFullYear();

    const dataAtual = ano + "-" + mes + "-" + dia;
    const dataInicio = ano + "-" + "01" + "-" + "01";

    document.getElementById("data_ini").value = dataInicio;
    document.getElementById("data_fim").value = dataAtual;

    var total_pg = $("#total_paginas").val();

    $.ajax({
        url: '../consultas/listarecebidospagos.php',
        type: 'POST',
        data: {
            data_ini: dataInicio,
            data_fim: dataAtual,
            total_pg: total_pg
        },
        success: function (data) {
            $("#table_rp").html(data);
        }
    })
}