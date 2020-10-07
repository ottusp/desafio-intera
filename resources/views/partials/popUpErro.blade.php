<div id="pop-up-container">
    <div class="modal-background"></div>
    <article id="pop-up" class="message is-danger">
        <div class="message-header">
            <p>Erro</p>
            <button onclick="fechaPopUp()" class="delete" aria-label="delete"></button>
        </div>
        @foreach($errors->all() as $error)
            <div class="message-body">
                <p>{{ $error }}</p>
            </div>
        @endforeach
    </article>
</div>
