<div class="container bg-white py-3 px-4">
    <form action="index.php?pg=send_mail" id="sending-form" method="post">
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
            <select type="text" class="form-control mb-3" name="send_mode">
                <option value="all" selected>
                    <?php
                    echo _s("send to all");
                    ?>
                </option>
                <option value="manual">
                    <?php
                    echo _s("enter manually");
                    ?>
                </option>
            </select>
            <textarea class="form-control d-none" name="addresses" rows="6"></textarea>
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