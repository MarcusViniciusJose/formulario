<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Pesquisa de Clima Organizacional - Aerocris</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="card shadow-lg border-0">
            <div class="card-body">
                <h2 class="text-center mb-4">Pesquisa de Clima Organizacional - Aerocris</h2>
                <form method="POST" action="?page=salvar">
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Selecione seu setor:</label>
                        <select name="setor_id" class="form-select" required>
                            <option value="">-- Escolha seu setor --</option>
                            <?php foreach ($setores as $setor): ?>
                                <option value="<?= $setor['id'] ?>"><?= htmlspecialchars($setor['nome']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <?php foreach ($categorias as $categoria): ?>
                        <div class="card my-4">
                            <div class="card-header bg-primary text-white fw-bold">
                                <?= htmlspecialchars($categoria['nome']) ?>
                            </div>
                            <div class="card-body">
                                <?php foreach ($perguntas[$categoria['id']] as $pergunta): ?>
                                    <div class="mb-3">
                                        <label class="form-label"><?= htmlspecialchars($pergunta['texto']) ?></label>
                                        <div class="d-flex justify-content-between">
                                            <?php
                                            $opcoes = [
                                                'Discordo Totalmente',
                                                'Discordo Parcialmente',
                                                'Nem Concordo Nem Discordo',
                                                'Concordo Parcialmente',
                                                'Concordo Totalmente'
                                            ];
                                            foreach ($opcoes as $opcao):
                                            ?>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        name="respostas[<?= $pergunta['id'] ?>]"
                                                        value="<?= $opcao ?>" required>
                                                    <label class="form-check-label"><?= $opcao ?></label>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <div class="text-center">
                        <button type="submit" class="btn btn-success btn-lg">Enviar Respostas</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</body>
</html>
