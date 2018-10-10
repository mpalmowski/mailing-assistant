<?php
include 'ssl.php';

function printTable($db, $name)
{
    if (!$db->isConnected()) {
        return;
    }

    $columns = $db->getColumns();
    $nr_of_columns = sizeof($columns);
    $result = $db->select(implode(", ", $columns), $name);
    $text = _s($name);

    echo <<< HTML
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th colspan="$nr_of_columns" scope="col">$text</th>
            </tr>
            <tr>
HTML;

    foreach ($columns as $column_name){
        $column_name = _s($column_name);
        echo "<th scope='col'>$column_name</th>";
    }

    echo <<< HTML
            </tr>
        </thead>
        <tbody>
HTML;

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo <<< HTML
            <tr>
HTML;

            foreach ($columns as $column_name){
                echo "<td>$row[$column_name]</td>";
            }

            echo <<< HTML
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
<div class="container-fluid">
    <?php
    printTable($database, $conf->get("db_subscribers_table"));
    ?>
</div>
