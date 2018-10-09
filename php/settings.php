<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conf->set();
    $conf->save();
}

function printCategory($category, $params){
    $category = _s($category);
    echo <<< HTML
    <h5 class="category-header">$category</h5>
    <div class="settings-category">
HTML;

    foreach ($params as $name => $value){
        $name_str = _s($name);
        echo <<< HTML
        <div class='row justify-content-around align-items-center p-3'>
            <div class="col-md">
                <label>$name_str</label>
            </div>
            <div class="col-md">
                <input type='text' class='form-control' name=$name value=$value>
            </div>
        </div>
HTML;

    }

    echo '</div>';
}

?>
<div class="container">
    <form action="index.php?pg=settings" class="py-3" method="post">
        <?php
        foreach ($conf->params as $category => $params) {
            printCategory($category, $params);
        }
        ?>
        <button class="btn btn-primary" type="submit">Zapisz</button>
    </form>
</div>