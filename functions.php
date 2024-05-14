<?php
// Funzione per caricare i dati dalla pagina JSON
function carica_dati_pagina($file_path) {
    $json_data = file_get_contents($file_path);
    return json_decode($json_data);
}

// Funzione per stampare il menu
function stampa_menu($menu_items) {
    foreach ($menu_items as $voce) {
        echo '<li><a class="vociMenu" href="' . $voce->link . '" title="' . $voce->title . '">' . $voce->testo . '</a></li>';
    }
}

// Funzione per stampare il footer
function stampa_footer($footer_data) {
    echo '<p class="pfooter">' . $footer_data->telefono . '<br>email: ' . $footer_data->email . '<br>' . $footer_data->indirizzo . '</p>';
}


// Funzione per stampare i contatti
function stampa_contatti($contatti) {
    foreach ($contatti as $contatto) {
        echo "<li><a href='{$contatto->link}' target='_blank' title='{$contatto->title}'>{$contatto->nome}</a></li>";
    }
}

// Funzione per verificare se tutti i campi del form sono stati compilati
function sonoCompilati($datiForm) {
    foreach ($datiForm as $campo) {
        if (empty($campo)) {
            return false;
        }
    }
    return true;
}

// Funzione per stampare le cards
function stampa_cards($cards) {
    foreach ($cards as $card) {
        printf('
            <a href="%s" class="card" title="%s">
                <div class="card-content">
                    <h3>%s</h3>
                    <p>%s</p>
                    <div><img src="%s" class="imgcard" alt="%s"></div>
                </div>
            </a>
        ', $card->link, $card->titolo, $card->titolo, $card->descrizione, $card->immagine, $card->titolo);
    }
}
