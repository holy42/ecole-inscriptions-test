<h1>Mes inscriptions</h1>
<ul>
<?php foreach ($lignes as $ligne): ?>
    <li><?= htmlspecialchars($ligne['formation']['nom'] ?? '') ?> : du <?= htmlspecialchars($ligne['debut']) ?> au <?= htmlspecialchars($ligne['fin']) ?></li>
<?php endforeach; ?>
</ul>
