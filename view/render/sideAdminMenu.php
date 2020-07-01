<nav class="col-md-2 d-none d-md-block bg-green sidebar">
    <div class="sidebar-sticky pt-2">
        <ul class="nav flex-column">
            <?php
            foreach ($data as $page): ?>
                <li class="nav-item">
                    <a class="d-flex align-items-center nav-link<?php
                    if (strpos($_SERVER['REQUEST_URI'], $page['uri'])) {
                        echo ' active';
                    } ?>" href="/admin<?= $page['uri'] ?>">
                        <?= $page['icon'] ?>
                        <?= $page['name'] ?>
                    </a>
                </li>
            <?php
            endforeach; ?>
        </ul>
    </div>
</nav>
