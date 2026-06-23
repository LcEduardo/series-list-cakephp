<div style="display: flex; align-items: center; justify-content: space-between;">
    <h2>Users</h2>
    <?= $this->Html->link('Add Users', ['action' => 'add'], ['class' => 'button']) ?>
</div>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?= h($user->id) ?></td>
            <td><?= h($user->name) ?></td>
            <td><?= h($user->email) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>