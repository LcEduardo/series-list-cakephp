<h2>Adicionar Série</h2>

<?= $this->Form->create($serie) ?>
    <?= $this->Form->control('title', ['label' => 'Título']) ?>
    <?= $this->Form->control('genre_id', [
        'type' => 'select',
        'options' => $genres,
        'empty' => 'Selecione um gênero',
        'label' => 'Gênero',
    ]) ?>
    <?= $this->Form->control('watched_episodes', ['label' => 'Episódios assistidos']) ?>
    <?= $this->Form->control('qtd_episodes', ['label' => 'Total de episódios']) ?>
    <?= $this->Form->control('rating', ['label' => 'Nota (0 a 10)']) ?>
    <?= $this->Form->button('Salvar') ?>
<?= $this->Form->end() ?>