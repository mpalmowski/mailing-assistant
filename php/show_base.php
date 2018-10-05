<?php
include 'ssl.php';
include 'database.php';
include 'conf.php';

$conf->load();
$db = $database->connect($conf->params['db_servername'], $conf->params['db_username'], $conf->params['db_password'], $conf->params['db_name']);

function printTable($db, $name){
    $result = $db->query("SELECT * FROM $name");

    echo <<< HTML
    <table class="table table-bordered">
        <thead>
            <tr>
                <th colspan="2" scope="col">$name</th>
            </tr>
            <tr>
                <th scope="col">id</th>
                <th scope="col">e-mail</th>
            </tr>
        </thead>
        <tbody>
HTML;

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $id = $row["id"];
            $e_mail = $row["e_mail"];
            echo <<< HTML
            <tr>
                <td>
                    $id
                </td>
                <td>
                    $e_mail
                </td>
            </tr>
HTML;
        }
    }

    echo <<< HTML
        </tbody>
    </table>
HTML;

}

?>
<section>
    <div class="row text-center">
        <div class="col">
            <?php
            printTable($db, "clients");
            ?>
        </div>
        <div class="col">
            <?php
            printTable($db, "distributors");
            ?>
        </div>
    </div>
</section>
