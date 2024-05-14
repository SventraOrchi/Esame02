<?php
// Carica il file delle funzioni
require_once 'functions.php';

// Carica i dati dalla pagina JSON
$data = carica_dati_pagina('dati_pagina.json');
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data->titolo; ?></title>
    <link href="Css/stile.min.css" type="text/css" rel="stylesheet">
    <link rel="icon" type="image/xicon" href="/SItoProva/Immagini/favicon.png">
    <meta name="description" content="<?php echo $data->descrizione; ?>">
</head>
<body>
    <header>
        <nav class="hamburger-menu">
            <input id="controllo" type="checkbox">
            <label class="label-controllo" for="controllo">
                <span></span>
            </label>
            <ul id="menu">
                <?php stampa_menu($data->menu); ?>
            </ul>
        </nav>
    </header>
   
    <div class="secondapagina">
        <?php stampa_cards($data->cards); ?>
    </div>

    <footer>
        <?php stampa_footer($data->footer); ?>
    </footer>
</body>
</html>