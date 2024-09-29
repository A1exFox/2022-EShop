<h1>Hello main index</h1>
<?php if (!empty($names)): ?>
    <?php foreach ($names as $name): ?>
        <?php debug($name['name']); ?>
    <?php endforeach; ?>
<?php endif; ?>
