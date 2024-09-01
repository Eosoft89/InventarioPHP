<?php

function PrintError ($error){
    echo(
        '<article class="message is-danger">
            <div class="message-header">
                <p>Error</p>
                <button class="delete" aria-label="delete"></button>
            </div>
            <div class="message-body">
                <strong>Ha ocurrido un error!</strong>
                <p>'.$error.'</p>
            </div>
        </article>'
    );    
}
?>