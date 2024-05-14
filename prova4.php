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
    <link rel="icon" type="image/xicon" href="/SItoProva/Immagini/favicon.ico">
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
                <?php
                    // Stampa il menu
                    stampa_menu($data->menu);
                ?>
            </ul>
        </nav>
    </header>
   
    <div class="paginalavoro">
        <section>
            <h2><?php echo $data->paginalavoro->titolo; ?></h2>
                
            <p class="para"><?php echo $data->paginalavoro->testo; ?>
            
            <!-- Aggiunta del link della pagina del lavoro finta-->
            <a href="<?php echo $data->paginalavoro->link; ?>" target="_blank" title="<?php echo $data->paginalavoro->link_title; ?>"><?php echo $data->paginalavoro->link_text; ?></a>
</p>
            <div class="Immagini">
                <img id="image" src="<?php echo $data->paginalavoro->immagine; ?>" width="800" alt="computer">
            </div>
        </section>
    </div>

    <footer>
        <?php stampa_footer($data->footer); ?>
    </footer>
</body>
</html>