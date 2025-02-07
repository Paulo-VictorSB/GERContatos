<?php

use GERcontactos\Database;

require_once('header.php');

// check if there is a id in the url (query string)
if(empty($_GET['id'])){
    header("Location: index.php");
    exit();
}

// include files
require_once('config.php');
require_once('libraries/Database.php'); 

// get contact data
$id = $_GET['id'];
$database = new Database(MYSQL_CONFIG);
$params = [
    ':id' => $id
];

// check if the delete answer was given
if(empty($_GET['delete'])){
    $results = $database->execute_query("SELECT * FROM contactos WHERE id = :id", $params);
    $contact = $results->results[0];
} else {
    $database->execute_non_query("DELETE FROM contactos WHERE id = :id", $params);
    header("Location: index.php");
    exit;
}

?>

<div class="row">
    <div class="col text-center">
        <h3>Deseja eliminar o seguinte contacto?</h3>

        <div class="my-4">
            <div>
                <span class="me-5">Nome: <strong><?=$contact->nome?></strong></span>
                <span>Telefone: <strong><?=$contact->telefone?></strong></span>
            </div>
        </div>

        <a href="index.php" class="btn btn-outline-dark yes-no-width">Não</a>
        <a href="eliminar_contato.php?id=<?=$id?>&delete=yes" class="btn btn-outline-dark yes-no-width">Sim</a>
    </div>
</div>

<?php
require_once('footer.php');
?>