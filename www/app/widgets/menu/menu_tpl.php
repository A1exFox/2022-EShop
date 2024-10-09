<?php
/**
 * @var $category array
 * @var $tab string
 * @var $id int
 * @var $isChild bool
 */
?>
<li class="nav-item <?php if ($isChild) echo 'dropdown' ?>">
    <a class="nav-link <?php if ($isChild) echo 'dropdown-toggle' ?>"
       href="category/<?= $category['slug'] ?>"
        <?php if ($isChild) echo 'data-bs-toggle="dropdown"' ?>><?= $category['title'] ?></a>
    <?php if($isChild): ?>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <?= $this->getMenuHtml($category['children']) ?>
        </ul>
    <?php endif; ?>
</li>