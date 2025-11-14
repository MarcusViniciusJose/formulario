<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Perguntas com Alta Insatisfação</title>
<link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

<style>
.card-alerta {
    border-left: 6px solid #dc3545;
    background: #ffe5e5;
}
.percent-badge {
    font-size: 1rem;
    font-weight: bold;
}
</style>
</head>

<body class="bg-light">

<div class="container py-4">

    <h2 class="text-center fw-bold mb-4">⚠️ Perguntas com Alta Insatisfação</h2>
    <p class="text-center text-secondary mb-4">
        Listagem de perguntas com índice de insatisfação superior a <b>35%</b>.
    </p>

    <?php if (empty($resultados)): ?>
        <div class="alert alert-success text-center p-4">
            🎉 Excelente! Nenhuma pergunta atingiu nível crítico de insatisfação.
        </div>
    <?php endif; ?>

    <?php foreach ($resultados as $item): ?>
        <div class="card card-alerta shadow-sm mb-3 p-3">
            <h5 class="fw-bold"><?= htmlspecialchars($item['pergunta']) ?></h5>

            <div class="d-flex justify-content-between mt-2">
                <span class="text-muted">
                    Total de respostas: <b><?= $item['total'] ?></b>
                </span>

                <span class="percent-badge text-danger">
                    😟 Insatisfação: <?= $item['insatisfacao'] ?>%
                </span>
            </div>

            <div class="mt-3 text-end">
                <a href="#" class="btn btn-outline-danger btn-sm">
                    📄 Criar Plano de Ação
                </a>
            </div>
        </div>
    <?php endforeach; ?>

    <div class="text-center mt-4">
        <a href="index.php?page=rh" class="btn btn-primary px-4">
            ⬅ Voltar ao painel
        </a>
    </div>

</div>

</body>
</html>
