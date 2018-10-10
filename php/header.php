<header class="mb-3">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Mailing Assistant</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php?pg=main">
                        <?php
                        echo _s('sending')
                        ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?pg=settings">
                        <?php
                        echo _s('settings')
                        ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?pg=show_base">
                        <?php
                        echo _s('database')
                        ?>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</header>