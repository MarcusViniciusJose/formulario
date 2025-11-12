<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel RH - Pesquisa de Clima</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-light">
<div class="container my-5">
    <h2 class="text-center mb-4">📊 Painel RH - Pesquisa de Clima Organizacional</h2>

    <div class="card p-4 shadow-sm mb-4">
        <div class="row g-3">
            <div class="col-md-5">
                <label class="form-label">Categoria</label>
                <select id="categoria" class="form-select">
                    <option value="">Todas</option>
                    <option>Melhoria contínuas e processos</option>
                    <option>Ambiente e condições de trabalho</option>
                    <option>Reconhecimento e valorização</option>
                    <option>Liderança e gestão</option>
                    <option>Comunicação</option>
                    <option>Relações interpessoais e trabalho em equipe</option>
                    <option>Desenvolvimento e crescimento</option>
                    <option>Comprometimento e pertencimento</option>
                    <option>Benefícios</option>
                </select>
            </div>

            <div class="col-md-5">
                <label class="form-label">Setor</label>
                <select id="setor" class="form-select">
                    <option value="">Todos</option>
                    <option>Administração</option>
                    <option>Ajustagem</option>
                    <option>Centro de Usinagem</option>
                    <option>Compras</option>
                    <option>Controle de Qualidade</option>
                    <option>Departamento Pessoal</option>
                    <option>Engenharia</option>
                    <option>Expedição</option>
                    <option>Ferramental</option>
                    <option>Fresa Convencional</option>
                    <option>Gestão da Qualidade</option>
                    <option>Manutenção</option>
                    <option>PCP</option>
                    <option>Produção</option>
                    <option>Recebimento</option>
                    <option>Recursos Humanos</option>
                    <option>Serra</option>
                    <option>Setup</option>
                    <option>Suprimentos</option>
                    <option>Torno CNC</option>
                </select>
            </div>

            <div class="col-md-2 d-flex align-items-end">
                <button id="filtrar" class="btn btn-primary w-100">Filtrar</button>
            </div>
        </div>
    </div>

    <div id="areaGraficos" class="mt-4">
        <div class="alert alert-info text-center">Selecione filtros e clique em "Filtrar".</div>
    </div>
</div>

<script>
document.getElementById('filtrar').addEventListener('click', () => {
    const categoria = document.getElementById('categoria').value;
    const setor = document.getElementById('setor').value;


    
    fetch(`index.php?page=rh&action=dadosGraficos&categoria=${encodeURIComponent(categoria)}&setor=${encodeURIComponent(setor)}`)
        .then(res => res.json())
        .then(dados => {
            const container = document.getElementById('areaGraficos');
            container.innerHTML = '';

            if (dados.length === 0) {
                container.innerHTML = '<div class="alert alert-warning text-center">Nenhum dado encontrado.</div>';
                return;
            }

            dados.forEach((item, i) => {
                const card = document.createElement('div');
                card.className = 'card mb-4 p-3 shadow-sm';
                card.innerHTML = `<h6>${item.pergunta}</h6><canvas id="graf${i}" height="80"></canvas>`;
                container.appendChild(card);

                const ctx = document.getElementById(`graf${i}`).getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: Object.keys(item.respostas),
                        datasets: [{
                            label: 'Quantidade de respostas',
                            data: Object.values(item.respostas),
                            backgroundColor: [
                                '#FF6384','#FF9F40','#FFCD56','#4BC0C0','#36A2EB'
                            ]
                        }]
                    },
                    options: { scales: { y: { beginAtZero: true } } }
                });
            });
        });
});
</script>
</body>
</html>
