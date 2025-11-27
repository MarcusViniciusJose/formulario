<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Sugestões de Melhoria</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container py-4 px-3">

    <h2 class="text-center mb-4">📬 Sugestões de Melhoria</h2>

    <?php if (empty($sugestoes)): ?>
        <div class="alert alert-secondary text-center">Nenhuma sugestão encontrada.</div>
    <?php else: ?>
        <div class="list-group">
            <?php foreach ($sugestoes as $s): ?>
                <div class="list-group-item shadow-sm mb-2 rounded">
                    <p class="mb-1"><?= nl2br(htmlspecialchars($s['sugestao'])) ?></p>
                    <small class="text-muted">
                        Enviada em <?= date('d/m/Y H:i', strtotime($s['created_at'])) ?>
                    </small>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="text-center mt-4">
        <a href="?page=rh" class="btn btn-secondary">Voltar ao dashboard</a>
    </div>

</div>

</body>
</html>
