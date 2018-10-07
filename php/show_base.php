<?php
include 'ssl.php';

function printTable($db, $name){
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
