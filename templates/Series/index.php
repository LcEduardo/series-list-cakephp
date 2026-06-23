<h2>List</h2>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Watched Episodes</th>
            <th>User</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($series as $serie): ?>
        <tr>
            <td><?= h($serie->id) ?></td>
            <td><?= h($serie->title) ?></td>
            <td><?= h($serie->watched_episodes) ?></td>
            <td><?= h($serie->user->name) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
