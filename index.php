<?php

use GERcontactos\Database;

require_once('header.php');

// include necessary files

require_once('config.php');
require_once('libraries/Database.php');

$contats = null;
$total_contats = 0;
$search = null;
$database = new Database(MYSQL_CONFIG);

// check if there as a post from search

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    // search for results

    $search = $_POST['text_search'];
    $params = [
        ':search' => '%' . $search . '%'
    ];

    $results = $database->execute_query(
    "SELECT * FROM contactos " . 
    "WHERE nome LIKE :search OR telefone LIKE :search ".
    "ORDER BY id DESC", 
    $params);

} else {
    $results = $database->execute_query(
    "SELECT * FROM contactos " . 
    "ORDER BY id DESC");
}

$contats = $results->results;
$total_contats = $results->affected_rows;



?>

<!-- search & add new -->
<div class="row align-items-center mb-3">
    <div class="col">

        <form action="index.php" method="post">
            <div class="row">
                <div class="col-auto"><input type="text" class="form-control" name="text_search" id="text_search" minlength="3" maxlength="20" required></div>
                <div class="col-auto"><input type="submit" class="btn btn-outline-dark" value="Procurar"></div>
                <div class="col-auto"><a href="index.php" class="btn btn-outline-dark">Ver tudo</a></div>
            </div>
        </form>

    </div>

    <div class="col text-end">
        <a href="adicionar_contato.php" class="btn btn-outline-dark">Adicionar contato</a>
    </div>
</div>

<!-- show contact's table -->
<div class="row">
    <div class="col">

        <?php if($total_contats == 0): ?>
            <!-- no results -->
            <p class="text-center opacity-75 mt-3">Não foram encontrados contato registados.</p>
        <?php else :?>
            <!-- widh results -->
            <table class="table table-sm table-striped table-bordered">
                <thead class="bg-dark text-white">
                    <tr>
                        <th width="40%">Nome</th>
                        <th width="30%">Telefone</th>
                        <th width="15%"></th>
                        <th width="15%"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($contats as $contact): ?>
                    <tr>
                        <td><?=$contact->nome?></td>
                        <td><?=$contact->telefone?></td>
                        <td class="text-center"><a href="editar_contato.php?id=<?=$contact->id?>">Editar</a></td>
                        <td class="text-center"><a href="eliminar_contato.php?id=<?=$contact->id?>">Eliminar</a></td>
                    </tr>
                    <?php endforeach; ?>                                    
                </tbody>
            </table>
            <!-- total results-->
            <div class="row">
                <div class="col">
                    <p>Total: <strong><?=$total_contats ?></strong></p>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php
require_once('footer.php');
?>