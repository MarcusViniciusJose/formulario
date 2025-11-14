<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Pesquisa de Clima Organizacional - Aerocris</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-size: 1rem;
        }

        .container {
            padding: 1rem;
        }

        .card {
            border: none;
            border-radius: 12px;
        }

        .card-header {
            background-color: #0d6efd;
            color: #fff;
            font-weight: 600;
            font-size: 1.1rem;
            text-align: center;
            padding: 1rem;
        }

        .question-block {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 1.2rem;
            margin-bottom: 1.8rem;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        .question-label {
            font-weight: 700;
            color: #212529;
            margin-bottom: 0.8rem;
            display: block;
            line-height: 1.4;
        }

        .form-check {
            display: flex;
            align-items: center;
            margin-bottom: 0.6rem;
        }

        .form-check-input {
            width: 1.3rem;
            height: 1.3rem;
            margin-right: 0.6rem;
        }

        .form-check-label {
            font-size: 1rem;
            flex: 1;
        }

        .btn-success {
            width: 100%;
            padding: 14px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 10px;
        }

        .option-group {
            display: flex;
            flex-direction: column;
            gap: 0.8rem;
        }

        @media (min-width: 768px) {
            .option-group {
                flex-direction: row;
                flex-wrap: wrap;
                gap: 1.2rem 2rem;
            }

            .form-check-label {
                font-size: 1.05rem;
            }

            .container {
                max-width: 900px;
                margin: 0 auto;
            }
        }

        .section-title {
            color: #0d6efd;
            font-weight: 700;
            text-align: center;
            margin-bottom: 2rem;
        }

        .alert {
            border-radius: 10px;
            font-size: 1.05rem;
        }
    </style>
</head>
<body>

    <div class="container">

        <div class="card shadow-lg p-4">
            <h2 class="section-title">Pesquisa de Clima Organizacional - Aerocris</h2>

            <form method="POST" action="?page=pesquisa&action=confirmar">

                <div class="mb-4">
                    <label class="form-label fw-bold">Selecione seu setor:</label>
                    <select name="setor_id" class="form-select form-select-lg shadow-sm" required>
                        <option value="">-- Escolha seu setor --</option>
                        <?php foreach ($setores as $setor): ?>
                            <option value="<?= $setor['id'] ?>"><?= htmlspecialchars($setor['nome']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <?php $numPergunta = 1; ?>
                <?php foreach ($categorias as $categoria): ?>
                    <div class="card my-4 border-0">
                        <div class="card-header">
                            <?= htmlspecialchars($categoria['nome']) ?>
                        </div>
                        <div class="card-body p-3">
                            <?php foreach ($perguntas[$categoria['id']] as $pergunta): ?>
                                <div class="question-block">
                                    <label class="question-label">
                                        <?= $numPergunta++ ?>. <?= htmlspecialchars($pergunta['texto']) ?>
                                    </label>
                                    <div class="option-group">
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
                                            <div class="form-check">
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

                <div class="card my-4 border-0">
                    <div class="card-header  text-white text-center">
                        Sugestões de Melhorias
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="sugestao" class="form-label fw-bold">
                                Gostaria de deixar alguma sugestão para melhorar o ambiente, os processos ou a comunicação na Aerocris?
                            </label>
                            <textarea name="sugestao" id="sugestao" class="form-control shadow-sm" rows="4" 
                                placeholder="Escreva aqui sua sugestão..." style="border-radius:10px;"></textarea>
                        </div>
                    </div>
                </div>


                <button type="submit" class="btn btn-success mt-3">Enviar Respostas</button>

            </form>
        </div>
    </div>

</body>
</html>
