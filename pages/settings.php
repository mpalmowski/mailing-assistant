<?php
/**
 * @param Conf $conf
 */
function printSettings($conf)
{
    $directory = "conf/settings.json";
    $file = fopen($directory, "r");
    $json = fread($file, filesize($directory));
    fclose($file);
    $settings = json_decode($json, true);
    foreach ($settings as $category => $fields) {
        $category_str = _s($category);
        echo <<< HTML
        <h5 class="category-header">$category_str</h5>
        <div class="settings-category">
HTML;
        foreach ($fields as $name => $field) {
            if (is_null($conf->get($name)))
                continue;
            if ($field["type"] == "input")
                printInput($name, $conf->get($name));
            else if ($field["type"] == "select")
                printSelect($name, $conf->get($name), $field["options"]);
        }
        echo '</div>';
    }
}

function printSelect($name, $value, $options)
{
    $name_str = _s($name);
    echo <<< HTML
    <div class='row justify-content-around align-items-center p-3'>
        <div class="col-md">
            <label>$name_str</label>
        </div>
        <div class="col-md">
            <select type='text' class='form-control' name=$name>
HTML;
    foreach ($options as $option){
        $option_str = _s($option);
        $selected = $option == $value ? "selected" : "";
        echo "<option value=$option $selected>$option_str</option>";
    }
    echo <<< HTML
            </select>
        </div>
    </div>
HTML;
}

function printInput($name, $value)
{
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

?>
<div class="container">
    <form id="settings-form" action="index.php?pg=settings" class="py-3" method="post">
        <?php
        printSettings($conf);
        ?>
    </form>
</div>
<div class="footer">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <button class="btn btn-primary" type="submit" form="settings-form">
                <?php
                echo _s("save");
                ?>
            </button>
        </div>
    </div>
</div>