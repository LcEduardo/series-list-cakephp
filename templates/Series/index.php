<body>
    <h1>Series List</h1>
    <ul>
        <?php foreach ($series as $serie): ?>
            <li><?= h($serie['title']) ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>