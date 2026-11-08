<h1>Liste des formations</h1>
<p>Résultats pour : <?= $_GET['q'] ?? '' ?></p>
<table>
<?php foreach ($formations as $formation): ?>
    <tr>
        <td><?= htmlspecialchars($formation['nom']) ?></td>
        <td><?= (int) $formation['places'] ?></td>
        <td><?= htmlspecialchars($formation['etat']) ?></td>
    </tr>
<?php endforeach; ?>
</table>
