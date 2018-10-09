<?php
include 'ssl.php';

function printTable($db, $name){
    if(!$db->isConnected()){
        return;
    }

    $result = $db->select("*", $name);
    $text = _s($name);

    echo <<< HTML
    <table class="table table-bordered">
        <thead>
            <tr>
                <th colspan="2" scope="col">$text</th>
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
            echo <<< HTML
            <tr>
                <td>
                    $row[id]
                </td>
                <td>
                    $row[e_mail]
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
        <div class="row">
            <div class="col">
                <?php
                printTable($database, "clients");
                ?>
            </div>
            <div class="col">
                <?php
                printTable($database, "distributors");
                ?>
            </div>
        </div>
</section>
