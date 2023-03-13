const openModalButton = document.querySelector("#open_modal");
const closeModalButton = document.querySelector("#close_modal");
const CloseModalButton2 = document.querySelector("#voltar");
const confirmaButton = document.querySelector("#salva");
const modal = document.querySelector("#modal");
const fade = document.querySelector("#fade");

const toggleModal = () => {
	modal.classList.toggle("hide");
	fade.classList.toggle("hide");
}

[confirmaButton].forEach((el) => {
	el.addEventListener("click", () => listar());
});

[openModalButton, closeModalButton, fade, CloseModalButton2].forEach((el) => {
	el.addEventListener("click", () => toggleModal());
});