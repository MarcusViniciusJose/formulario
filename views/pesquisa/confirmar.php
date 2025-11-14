<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Confirmação - Pesquisa de Clima</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container py-4 px-3">
    <h2 class="text-center mb-4">Confirmação de Respostas</h2>

    <div class="alert alert-info text-center">
        <strong>Setor selecionado:</strong> 
        <?php
            require_once __DIR__ . '/../../models/Setor.php';
            $setorModel = new Setor();
            $setorData = $setorModel->listar();
            foreach ($setorData as $s) {
                if ($s['id'] == $setor_id) {
                    echo htmlspecialchars($s['nome']);
                    break;
                }
            }
        ?>
    </div>

    <form method="POST" action="?page=pesquisa&action=salvar" class="w-100">
        <input type="hidden" name="setor_id" value="<?= htmlspecialchars($setor_id) ?>">
        <?php foreach ($respostas as $codigo => $valor): ?>
            <input type="hidden" name="respostas[<?= htmlspecialchars($codigo) ?>]" value="<?= htmlspecialchars($valor) ?>">
        <?php endforeach; ?>

        <input type="hidden" name="sugestao" value="<?= htmlspecialchars($sugestao) ?>">

        <div class="card shadow-sm border-0 mb-3">
            <div class="card-header bg-primary text-white">
                <strong>Suas respostas</strong>
            </div>
            <div class="card-body p-2 p-sm-3">
                <ul class="list-group list-group-flush small">
                    <?php
                    require_once __DIR__ . '/../../models/Pergunta.php';
                    $pModel = new Pergunta();
                    $todasPerguntas = $pModel->getAll();

                    $todasPerguntasFlat = [];
                    foreach ($todasPerguntas as $p) {
                        $todasPerguntasFlat[$p['id']] = [
                            'texto' => $p['texto'],
                            'categoria' => $p['categoria_nome']
                        ];
                    }

                    foreach ($respostas as $codigo => $valor):
                        if (!isset($todasPerguntasFlat[$codigo])) continue;
                        $pergunta = $todasPerguntasFlat[$codigo];
                    ?>
                    <li class="list-group-item">
                        <strong><?= htmlspecialchars($pergunta['categoria']) ?>:</strong><br>
                        <?= htmlspecialchars($pergunta['texto']) ?><br>
                        <span class="text-muted"><em>Sua resposta:</em> <?= htmlspecialchars($valor) ?></span>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <?php if (!empty($sugestao)): ?>
            <div class="card shadow-sm border-0 mt-3">
                <div class="card-header bg-primary text-white">
                    <strong>Sua sugestão de melhoria</strong>
                </div>
                <div class="card-body">
                    <p class="mb-0"><?= nl2br(htmlspecialchars($sugestao)) ?></p>
                </div>
            </div>
        <?php endif; ?>

        <div class="text-center mt-4 d-flex flex-column flex-sm-row justify-content-center gap-2">
            <a href="javascript:history.back()" class="btn btn-secondary flex-fill flex-sm-grow-0 px-4">Voltar e editar</a>
            <button type="submit" class="btn btn-success flex-fill flex-sm-grow-0 px-4">Confirmar e enviar</button>
        </div>
    </form>
</div>
</body>
</html>
