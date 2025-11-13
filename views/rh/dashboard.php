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
        }

        .chart-title {
            font-size: 0.95rem;
            line-height: 1.4;
            margin-bottom: 1rem;
            font-weight: 600;
            color: #333;
        }

        .chart-wrapper {
            position: relative;
            width: 100%;
            max-width: 500px;
            height: 400px;
            margin: 0 auto;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        canvas {
            max-width: 100% !important;
            height: auto !important;
            display: block;
            margin: 0 auto;
        }

        .suggestions-section {
            margin-top: 2rem;
        }

        .section-title {
            font-size: 1.1rem;
            margin-bottom: 1rem;
            padding: 0 8px;
        }

        .suggestion-card {
            border-left: 4px solid #28a745;
            background: white;
            border-radius: 8px;
            padding: 14px;
            margin-bottom: 12px;
        }

        .suggestion-setor {
            font-size: 0.75rem;
            color: #6c757d;
            margin-bottom: 8px;
            text-transform: uppercase;
            font-weight: 600;
        }

        .suggestion-text {
            font-size: 0.875rem;
            line-height: 1.5;
            color: #333;
            margin-bottom: 8px;
        }

        .suggestion-date {
            font-size: 0.7rem;
            color: #999;
            text-align: right;
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

        @media (min-width: 576px) {
            .container {
                padding: 16px;
            }

            .page-title {
                font-size: 1.5rem;
            }

            .chart-title {
                font-size: 1rem;
            }

            .section-title {
                font-size: 1.25rem;
            }

            .chart-wrapper {
                max-width: 450px;
                max-height: 350px;
            }
        }

        @media (min-width: 768px) {
            body {
                font-size: 15px;
            }

            .container {
                padding: 24px;
            }

            .page-title {
                font-size: 1.75rem;
                margin-bottom: 1.5rem;
            }

            .filter-card {
                padding: 20px;
            }

            .chart-card {
                padding: 20px;
            }

            .chart-wrapper {
                max-width: 500px;
                max-height: 400px;
            }

            .suggestion-card {
                padding: 16px;
            }

            .btn-primary {
                width: auto;
            }
        }

        @media (min-width: 992px) {
            .container {
                max-width: 1140px;
                padding: 32px 24px;
            }

            .page-title {
                font-size: 2rem;
            }

            .chart-wrapper {
                max-width: 550px;
                max-height: 450px;
            }

            .section-title {
                font-size: 1.5rem;
            }
        }
        @media (min-width: 1200px) {
            .container {
                max-width: 1320px;
            }

            .chart-wrapper {
                max-width: 600px;
                max-height: 500px;
            }
        }

        .form-select:focus,
        .btn:focus {
            outline: 2px solid #0d6efd;
            outline-offset: 2px;
        }

        .chart-card, .suggestion-card, .filter-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .chart-card:hover, .suggestion-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
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
                <button id="filtrar" class="btn btn-primary">Filtrar</button>
            </div>
        </div>
    </div>

    <div id="areaGraficos" class="mt-3">
        <div class="alert alert-info text-center">Selecione os filtros e clique em "Filtrar".</div>
    </div>


</div>

<script>
document.addEventListener('DOMContentLoaded', () => {

    carregarSugestoes();

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
                                aspectRatio: 0,
                                plugins: {
                                    legend: {
                                        position: 'bottom',
                                        labels: {
                                            boxWidth: 12,
                                            padding: 10,
                                            font: { 
                                                size: window.innerWidth < 576 ? 10 : 12 
                                            }
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

function carregarSugestoes() {
    const container = document.getElementById('listaSugestoes');
    
    fetch('index.php?page=rh&action=carregarSugestoes')
        .then(res => {
            if (!res.ok) throw new Error('Erro na resposta do servidor');
            return res.json();
        })
        .then(sugestoes => {
            container.innerHTML = '';

            if (!sugestoes || sugestoes.length === 0) {
                container.innerHTML = '<div class="empty-state">Nenhuma sugestão registrada ainda.</div>';
                return;
            }

            sugestoes.forEach(s => {
                const card = document.createElement('div');
                card.className = 'suggestion-card shadow-sm';
                card.innerHTML = `
                    <div class="suggestion-setor">📍 ${s.setor || 'Setor não informado'}</div>
                    <div class="suggestion-text">${s.texto || 'Texto não disponível'}</div>
                    <div class="suggestion-date">${s.data || ''}</div>
                `;
                container.appendChild(card);
            });
        })
        .catch(err => {
            console.error('Erro ao carregar sugestões:', err);
            container.innerHTML =
                '<div class="alert alert-danger text-center">Erro ao carregar as sugestões. Por favor, tente novamente.</div>';
        });
}

let resizeTimeout;
window.addEventListener('resize', () => {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(() => {
        Chart.instances.forEach(chart => {
            if (chart.options.plugins.legend) {
                chart.options.plugins.legend.labels.font.size = window.innerWidth < 576 ? 10 : 12;
            }
            if (chart.options.plugins.datalabels) {
                chart.options.plugins.datalabels.font.size = window.innerWidth < 576 ? 10 : 12;
            }
            chart.update();
        });
    }, 250);
});
</script>
</body>
</html>