<div class="container bg-white">
    <form action="index.php?pg=send_mail" class="main_form" method="post">
        <div class="row m-0 justify-content-between">
            <div class="form-group col p-0">
                <label>
                    <?php
                    echo _s("recipient type");
                    ?>
                </label>
                <select class="form-control" name="recipient_type">
                    <option value="client">
                        <?php
                        echo _s("client");
                        ?>
                    </option>
                    <option value="associate">
                        <?php
                        echo _s("associate");
                        ?>
                    </option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label>
                <?php
                echo _s("message topic");
                ?>
            </label>
            <input type="text" class="form-control" name="subject">
        </div>
        <div class="form-group">
            <label>
                <?php
                echo _s("message content");
                ?>
            </label>
            <textarea class="form-control" name="message" rows="3"></textarea>
        </div>
        <div class="form-group">
            <label>
                <?php
                echo _s("recipients");
                ?>
            </label>
            <textarea class="form-control" name="addresses" rows="6"></textarea>
        </div>
        <button class="btn btn-primary" type="submit">
            <?php
            echo _s("send");
            ?>
        </button>
    </form>
</div>