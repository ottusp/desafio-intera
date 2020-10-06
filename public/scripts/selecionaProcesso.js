function toggleCadastro() {
    let modal = document.getElementById('modal');

    if(modal.classList.contains('is-active')) {
        modal.classList.remove('is-active');
    } else {
        modal.classList.add('is-active');
    }
}

function mostraCadastro(index) {
    let squadContainer = document.getElementById('modal-squad-container');
    squadContainer.innerHTML = `${squad}`;

    let empresaContainer = document.getElementById('modal-empresa-container');
    empresaContainer.innerHTML = `${empresas[index]}`;

    let vagaContainer = document.getElementById('modal-vaga-container');
    vagaContainer.innerHTML = `${vagas[index]}`;

    let processoInput = document.getElementById('processo-id-input');
    processoInput.setAttribute('value', processosIds[index]);

    toggleCadastro();
}

function fechaPopUp() {
    let popUp = document.getElementById('pop-up-container');
    popUp.style.display = 'none';
}
