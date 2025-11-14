<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel RH - Pesquisa de Clima</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>

   <style>
        * {
            box-sizing: border-box;
        }

        body {
            background-color: #f8f9fa;
            font-size: 14px;
            padding: 0;
            margin: 0;
        }

        .container {
            padding: 12px;
            max-width: 100%;
        }

        .page-title {
            font-size: 1.25rem;
            line-height: 1.4;
            margin-bottom: 1rem;
            padding: 0 8px;
        }

        .filter-card {
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 1rem;
        }

        .form-label {
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .form-select {
            font-size: 0.875rem;
            padding: 10px 12px;
            border-radius: 8px;
        }

        .btn-primary {
            padding: 12px 16px;
            font-size: 0.9rem;
            font-weight: 600;
            border-radius: 8px;
            width: 100%;
        }

        .chart-card {
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 1rem;
            background: white;
            height: 100%;
        }

        .chart-title {
            font-size: 0.95rem;
            line-height: 1.4;
            margin-bottom: 50px;
            font-weight: 600;
            color: #333;
        }

        .chart-wrapper {
            position: relative;
            width: 100%;
            max-width: 600px;
            height: 100%;
            margin: 0 auto;
        }

        .chart-wrapper-bar {
            position: relative;
            width: 100%;
            max-width: 900px;
            height: 100%;
            margin: 0 auto;
        }

        canvas {
            max-width: 100% !important;
            height: auto !important;
        }

        .alert {
            font-size: 0.875rem;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .loading-state, .empty-state {
            text-align: center;
            padding: 24px 16px;
            color: #6c757d;
            font-size: 0.875rem;
        }

        .geral-card {
            color: black;
            margin-top: 2rem;
            border: none !important;
        }

        .geral-card .chart-title {
            color: black;
            font-size: 1.2rem;
            font-weight: 700;
        }
    </style>
</head>

<body>
<div class="container">

    <h2 class="page-title text-center fw-bold">📊 Painel RH - Pesquisa de Clima Organizacional</h2>

    <div class="card filter-card shadow-sm border-0">
        <div class="row g-3">
            <div class="col-12 col-sm-6 col-lg-5">
                <label for="categoria" class="form-label">Categoria</label>
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

            <div class="col-12 col-sm-6 col-lg-5">
                <label for="setor" class="form-label">Setor</label>
                <select id="setor" class="form-select">
                    <option value="">Todos</option>
                    <option>Administrativo</option>
                    <option>Produção</option>
                    <option>Manutenção</option>
                    <option>Controle de Qualidade</option>
                    <option>Logística</option>
                </select>
            </div>

            <div class="col-12 col-lg-2 d-flex align-items-end">
                <button id="filtrar" class="btn btn-primary w-100">Filtrar</button>
            </div>
        </div>
    </div>

    <div id="areaGraficos" class="mt-3">
        <div class="alert alert-info text-center">Selecione os filtros e clique em "Filtrar".</div>
    </div>

    <div class="text-center mt-4 mb-5 d-flex flex-column gap-3">

        <a href="index.php?page=pesquisa&action=sugestoes" 
           class="btn btn-success px-4 py-2 fw-semibold shadow-sm">
            💡 Ver sugestões de melhorias
        </a>

        <a href="index.php?page=rh&action=insatisfeitas" 
           class="btn btn-danger px-4 py-2 fw-semibold shadow-sm">
            😕 Ver painel de insatisfação
        </a>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', () => {

    document.getElementById('filtrar').addEventListener('click', () => {
        const categoria = document.getElementById('categoria').value;
        const setor = document.getElementById('setor').value;

        const areaGraficos = document.getElementById('areaGraficos');
        areaGraficos.innerHTML = '<div class="loading-state">Carregando dados...</div>';

        fetch(`index.php?page=rh&action=dadosGraficos&categoria=${encodeURIComponent(categoria)}&setor=${encodeURIComponent(setor)}`)
            .then(res => {
                if (!res.ok) throw new Error('Erro na resposta do servidor');
                return res.json();
            })
            .then(dados => {
                areaGraficos.innerHTML = '';

                if (!dados || dados.length === 0) {
                    areaGraficos.innerHTML = '<div class="alert alert-warning text-center">Nenhum dado encontrado para os filtros selecionados.</div>';
                    return;
                }

                dados.forEach((item, i) => {
                    const card = document.createElement('div');
                    card.className = 'card chart-card shadow-sm border-0';
                    
                    const canvasId = `graf${i}`;
                    card.innerHTML = `
                        <h6 class="chart-title text-center">${item.pergunta}</h6>
                        <div class="chart-wrapper">
                            <canvas id="${canvasId}"></canvas>
                        </div>
                    `;
                    areaGraficos.appendChild(card);

                    setTimeout(() => {
                        const ctx = document.getElementById(canvasId);
                        if (!ctx) return;

                        const respostas = item.respostas || {};
                        const total = Object.values(respostas).reduce((a, b) => a + b, 0);

                        if (total === 0) {
                            card.querySelector('.chart-wrapper').innerHTML = '<p class="empty-state">Sem respostas para esta pergunta</p>';
                            return;
                        }

                        new Chart(ctx, {
                            type: 'pie',
                            data: {
                                labels: Object.keys(respostas),
                                datasets: [{
                                    data: Object.values(respostas),
                                    backgroundColor: [
                                        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#FF9F40',
                                        '#9966FF', '#FF6384', '#C9CBCF'
                                    ],
                                    borderWidth: 2,
                                    borderColor: '#fff'
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: true,
                                aspectRatio: 2,
                                plugins: {
                                    legend: {
                                        position: 'bottom',
                                        labels: {
                                            boxWidth: 12,
                                            padding: 15,
                                        }
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                const label = context.label || '';
                                                const value = context.parsed || 0;
                                                const percent = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                                return value > 0 ? `${label}: ${value} (${percent}%)` : '';
                                            }
                                        }
                                    },
                                    datalabels: {
                                        color: '#fff',
                                        formatter: (value) => {
                                            const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                            return value > 0 && percentage >= 5 ? percentage + "%" : "";
                                        },
                                        font: { 
                                            weight: 'bold', 
                                            size: window.innerWidth < 576 ? 10 : 12 
                                        }
                                    }
                                }
                            },
                            plugins: [ChartDataLabels]
                        });
                    }, 100);
                });
                
            })
            .catch(err => {
                console.error('Erro ao carregar os dados:', err);
                areaGraficos.innerHTML = 
                    '<div class="alert alert-danger text-center">Erro ao carregar os dados. Por favor, tente novamente.</div>';
            });
    });
});
</script>

</body>
</html>
