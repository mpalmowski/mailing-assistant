<div class="container bg-white py-3 px-4">
    <form action="index.php?pg=send_mail" id="sending-form" method="post">
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
    </form>
    <button class="btn btn-primary" form="sending-form" type="submit">
        <?php
        echo _s("send");
        ?>
    </button>
    <button class="btn btn-secondary" id="test_message">
        <?php
        echo _s("send test message");
        ?>
    </button>
</div>