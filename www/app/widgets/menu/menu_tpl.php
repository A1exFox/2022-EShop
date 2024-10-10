<?php /** @var $category array */ ?>
<?php if (isset($category['children'])): ?>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle"
           href="category/<?= $category['slug'] ?>"
           data-bs-toggle="dropdown"><?= $category['title'] ?></a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <?= $this->getMenuHtml($category['children']) ?>
        </ul>
    </li>
<?php else: ?>
    <li class="nav-item">
        <a class="nav-link" href="category/<?= $category['slug'] ?>">
            <?= $category['title'] ?>
        </a>
    </li>
<?php endif; ?>