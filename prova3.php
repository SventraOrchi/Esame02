<?php
// Carica il file delle funzioni
require_once 'functions.php';

// Carica i dati dalla pagina JSON
$data = carica_dati_pagina('dati_pagina.json');
$contatti = $data->contatti;

// Verifica se il form è stato inviato
$formInviato = false;
$campiForm = [];
$erroriForm = [];
$successoInvio = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $formInviato = true;
    $campiForm = $_POST;

    // Controlla se tutti i campi del form sono stati compilati
    if (!sonoCompilati($_POST)) {
        // Trova il primo campo non compilato
        foreach ($_POST as $campo => $valore) {
            if (empty($valore)) {
                $erroriForm[$campo] = "Campo obbligatorio";
            }
        }
    } else {
        // Verifica le regole di validazione personalizzate
        $nomeCognome = $_POST['name'];
        $email = $_POST['email'];
        $messaggio = $_POST['message'];

        // Verifica se il nome e cognome ha almeno 5 caratteri
        if (strlen($nomeCognome) < 5) {
            $erroriForm['name'] = "Il nome e cognome devono contenere almeno 5 caratteri";
        }

        // Verifica se l'email contiene il simbolo "@"
        if (strpos($email, '@') === false) {
            $erroriForm['email'] = "Inserisci un'email valida";
        }

        // Verifica se il messaggio ha almeno 20 caratteri
        if (strlen($messaggio) < 20) {
            $erroriForm['message'] = "Il messaggio deve contenere almeno 20 caratteri";
        }

        // Se non ci sono errori di compilazione del form, procedi con l'invio
        if (empty($erroriForm)) {
            $successoInvio = true;
            $contenutoPagina = "Nome: " . $_POST['name'] . "\n";
            $contenutoPagina .= "Email: " . $_POST['email'] . "\n";
            $contenutoPagina .= "Messaggio: " . $_POST['message'];

            // Crea un nuovo file con il contenuto del modulo
            $nomeFile = "modulo_compilato_" . date("YmdHis") . ".txt";
            $file = fopen($nomeFile, "w") or die("Impossibile creare il file!");
            fwrite($file, $contenutoPagina);
            fclose($file);
        }
    }
}

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
                <?php
                    // Stampa il menu
                    stampa_menu($data->menu);
                ?>
            </ul>
        </nav>
    </header>

    <div class="paginaform">
        <section>
            <h2>Contatti</h2>
            <nav class="contatti">
                <ul>
                    <?php
                        // Stampa i contatti
                        stampa_contatti($contatti);
                    ?>
                </ul>
            </nav>
        </section>
        <section>
            <h2>Scrivimi</h2>
            <form action="#" method="POST" novalidate>
                <?php
                    foreach ($data->form as $campo) {
                        echo "<label for='{$campo->id}'>{$campo->label}</label>";
                        if ($campo->type === 'textarea') {
                            echo "<textarea id='{$campo->id}' name='{$campo->name}' rows='{$campo->rows}' cols='{$campo->cols}'";
                            if ($campo->required) {
                                echo " required";
                            }
                            echo ">";
                            echo htmlspecialchars($campiForm[$campo->name] ?? '');
                            echo "</textarea>";

                            // Messaggio di errore
                            if (isset($erroriForm[$campo->name])) {
                                echo "<span class='errore'>{$erroriForm[$campo->name]}</span>";
                            }

                            // Descrizione del campo
                            if (isset($erroriForm[$campo->name])) {
                                switch ($campo->name) {
                                    case 'name':
                                        echo "<span class='descrizione-campo'>. Il nome e cognome devono contenere almeno 5 caratteri</span>";
                                        break;
                                    case 'email':
                                        echo "<span class='descrizione-campo'>. Inserisci un'email valida</span>";
                                        break;
                                    case 'message':
                                        echo "<span class='descrizione-campo'>. Il messaggio deve contenere almeno 20 caratteri</span>";
                                        break;
                                    default:
                                        break;
                                }
                            }
                        } else {
                            echo "<input type='{$campo->type}' id='{$campo->id}' name='{$campo->name}'";
                            if ($campo->required) {
                                echo " required";
                            }
                            echo " value='";
                            echo htmlspecialchars($campiForm[$campo->name] ?? '');
                            echo "'>";

                            // Messaggio di errore
                            if (isset($erroriForm[$campo->name])) {
                                echo "<span class='errore'>{$erroriForm[$campo->name]}</span>";
                            }

                            // Descrizione del campo
                            if (isset($erroriForm[$campo->name])) {
                                switch ($campo->name) {
                                    case 'name':
                                        echo "<span class='descrizione-campo'>. Il nome e cognome devono contenere almeno 5 caratteri</span>";
                                        break;
                                    case 'email':
                                        echo "<span class='descrizione-campo'>. Inserisci un'email valida</span>";
                                        break;
                                    case 'message':
                                        echo "<span class='descrizione-campo'>. Il messaggio deve contenere almeno 20 caratteri</span>";
                                        break;
                                    default:
                                        break;
                                }
                            }
                        }
                        echo "<br><br>";
                    }
                ?>
                <input type="submit" value="Invia">
            </form>
        </section>
    </div>

    <?php if ($formInviato && !$successoInvio && !sonoCompilati($_POST)) { ?>
        <p style="color: red;">Compila tutti i campi obbligatori.</p>
    <?php } elseif ($_SERVER["REQUEST_METHOD"] == "POST" && $successoInvio) { ?>
        <p style="color: green;">La compilazione del form è stata inviata con successo!</p>
    <?php } ?>

    <footer>
        <?php stampa_footer($data->footer); ?>
    </footer>
</body>
</html>