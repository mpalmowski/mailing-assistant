<?php
include "conf.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conf->set();
    $conf->save();
}

$conf->load();
?>
<section>
    <div class="col h-100 justify-content-center flex-column d-flex">
        <div class="row w-100 justify-content-center flex-row d-flex">
            <form action="index.php?pg=settings" class="main_form bg-light" method="post">
                <?php
                foreach ($conf->params as $key => $param) {
                    echo "
                <div class='row m-0 justify-content-between'>
                    <div class='form-group col p-0'>
                        <label>$key</label>
                        <input type='text' class='form-control' name=$key value=$param>
                    </div>
                </div>
                    ";
                }
                ?>
                <button class="btn btn-primary" type="submit">Zapisz</button>
            </form>
        </div>
    </div>
</section>