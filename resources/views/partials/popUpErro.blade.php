<style>
    #pop-up-container {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;

        z-index: 50;

        display: flex;
        align-items: center;
        justify-content: center;
    }

    #pop-up {
        position: absolute;

        max-width: 50rem;
    }
</style>

<div id="pop-up-container">
    <div class="modal-background"></div>
    <article id="pop-up" class="message is-danger">
        <div class="message-header">
            <p>Erro</p>
            <button onclick="fechaPopUp()" class="delete" aria-label="delete"></button>
        </div>
        <div class="message-body">
            {{ session('erro') }}
        </div>
    </article>
</div>
