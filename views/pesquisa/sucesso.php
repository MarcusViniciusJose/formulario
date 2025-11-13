<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Pesquisa Enviada com Sucesso</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            max-width: 500px;
            margin: 50px auto;
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .checkmark {
            font-size: 70px;
            color: #28a745;
            animation: pop 0.5s ease-in-out;
        }
        @keyframes pop {
            0% { transform: scale(0.5); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
    </style>
</head>
<body>

<div class="card text-center p-4 bg-white">
    <div class="checkmark mb-3">✅</div>
    <h4 class="mb-3 text-success fw-bold">Pesquisa enviada com sucesso!</h4>
    <p class="text-muted">Agradecemos sua colaboração na melhoria do nosso ambiente de trabalho.<br>
    Sua resposta foi registrada e enviada ao RH.</p>

    <hr class="my-4">

</div>

</body>
</html>
