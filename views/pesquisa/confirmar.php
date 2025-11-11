<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Confirmação - Pesquisa de Clima</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container my-5">
    <h2 class="text-center mb-4">Confirmação de Respostas</h2>

    <div class="alert alert-info">
        <strong>Setor selecionado:</strong> 
        <?php
            require_once __DIR__ . '/../../models/Setor.php';
            $setorModel = new Setor();
            $setorData = $setorModel->listar();
            foreach ($setorData as $s) {
                if ($s['id'] == $setor) echo htmlspecialchars($s['nome']);
            }
        ?>
    </div>

    <form method="POST" action="?action=salvar">
        <input type="hidden" name="setor" value="<?= htmlspecialchars($setor) ?>">
        <?php foreach ($respostas as $codigo => $valor): ?>
            <input type="hidden" name="respostas[<?= htmlspecialchars($codigo) ?>]" value="<?= htmlspecialchars($valor) ?>">
        <?php endforeach; ?>

        <div class="card">
            <div class="card-header bg-primary text-white">
                <strong>Suas respostas</strong>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <?php
                    require_once __DIR__ . '/../../models/Pergunta.php';
                    $pModel = new Pergunta();
                    $todasPerguntas = $pModel->getAll();
                    $todasPerguntasFlat = [];
                    foreach ($todasPerguntas as $cat => $lista) {
                        foreach ($lista as $p) {
                            $todasPerguntasFlat[$p['codigo']] = [
                                'texto' => $p['texto'],
                                'categoria' => $p['categoria']
                            ];
                        }
                    }

                    foreach ($respostas as $codigo => $valor): 
                        $pergunta = $todasPerguntasFlat[$codigo];
                    ?>
                    <li class="list-group-item">
                        <strong><?= htmlspecialchars($pergunta['categoria']) ?>:</strong> 
                        <?= htmlspecialchars($pergunta['texto']) ?><br>
                        <em>Sua resposta:</em> <?= htmlspecialchars($valor) ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="javascript:history.back()" class="btn btn-secondary px-4">Voltar e editar</a>
            <button type="submit" class="btn btn-success px-4">Confirmar e enviar</button>
        </div>
    </form>
</div>
</body>
</html>
