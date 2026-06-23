<?= $this->Form->create($user, ['type' => 'post']) ?>
<?= $this->Form->control('name') ?>
    <?= $this->Form->control('email') ?>
    <?= $this->Form->control('password') ?>
    <?= $this->Form->control('age') ?>
    <?= $this->Form->button('Salvar') ?>
<?= $this->Form->end() ?>