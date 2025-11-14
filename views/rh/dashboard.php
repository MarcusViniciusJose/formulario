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

            .chart-wrapper {
                max-width: 650px;
                height: 100%;
            }

            .chart-wrapper-bar {
                height: 100%;
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
                height: 100%;
            }

            .chart-wrapper {
                max-width: 700px;
                height: 100%;
            }

            .chart-wrapper-bar {
                height: 600px;
                height: 100%;
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
                max-width: 750px;
                height: 100%;
            }

            .chart-wrapper-bar {
                max-width: 1000px;
                height: 100%;
            }
        }

        @media (min-width: 1200px) {
            .container {
                max-width: 1320px;
            }

            .chart-wrapper {
                max-width: 800px;
                height: 100%;
            }

            .chart-wrapper-bar {
                max-width: 1100px;
                height: 100%;
            }
        }

        .form-select:focus,
        .btn:focus {
            outline: 2px solid #0d6efd;
            outline-offset: 2px;
        }

        .chart-card, .filter-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .chart-card:hover {
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
                <button id="filtrar" class="btn btn-primary w-100">Filtrar</button>
            </div>
        </div>
    </div>

    <div id="areaGraficos" class="mt-3">
        <div class="alert alert-info text-center">Selecione os filtros e clique em "Filtrar".</div>
    </div>

    <div class="text-center mt-4 mb-5">
        <a href="index.php?page=pesquisa&action=sugestoes" class="btn btn-success px-4 py-2 fw-semibold shadow-sm">
            💡 Ver sugestões de melhorias
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
                

                let totaisGerais = {};

                dados.forEach(item => {
                    Object.entries(item.respostas).forEach(([opcao, qtd]) => {
                        if (qtd > 0) {
                            totaisGerais[opcao] = (totaisGerais[opcao] || 0) + qtd;
                        }
                    });
                });

                const totalGeral = Object.values(totaisGerais).reduce((a, b) => a + b, 0);

                


                if (totalGeral > 0) {

                const concordoTotal = 
                    (totaisGerais["Concordo Totalmente"] || 0) +
                    (totaisGerais["Concordo Parcialmente"] || 0);

                const discordoTotal = 
                    (totaisGerais["Discordo Totalmente"] || 0) +
                    (totaisGerais["Discordo Parcialmente"] || 0);

                const pctConcordo = totalGeral > 0 ? ((concordoTotal / totalGeral) * 100).toFixed(1) : 0;
                const pctDiscordo = totalGeral > 0 ? ((discordoTotal / totalGeral) * 100).toFixed(1) : 0;
                    const cardGeral = document.createElement('div');
                    cardGeral.className = 'card chart-card geral-card shadow-lg border-0';

                    cardGeral.innerHTML = `
                        <h5 class="chart-title text-center mb-3">
                            📈 Resultado Geral da Pesquisa
                        </h5>

                        <p class="text-center text-black-50 mb-3 small">
                            Total de ${totalGeral} respostas coletadas — 
                            👍 Nível de satisfação: <b>${pctConcordo}%</b> | 
                            👎 Nível de insatisfação: <b>${pctDiscordo}%</b>
                        </p>

                        <div class="chart-wrapper-bar">
                            <canvas id="graficoGeral"></canvas>
                        </div>
                    `;

                    areaGraficos.appendChild(cardGeral);

                    setTimeout(() => {
                        const ctxGeral = document.getElementById('graficoGeral');

                        const ordenado = Object.entries(totaisGerais)
                            .sort(([,a], [,b]) => b - a);
                        
                        const labels = ordenado.map(([label]) => label);
                        const values = ordenado.map(([, value]) => value);

                        new Chart(ctxGeral, {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Quantidade de Respostas',
                                    data: values,
                                    backgroundColor: [
                                        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#FF9F40',
                                        '#9966FF', '#FF6384', '#C9CBCF'
                                    ],
                                    borderColor: [
                                         '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#FF9F40',
                                        '#9966FF', '#FF6384', '#C9CBCF'
                                    ],
                                    borderWidth: 2,
                                    borderRadius: 8,
                                    borderSkipped: false
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: true,
                                aspectRatio: 2,
                                indexAxis: 'y',
                                plugins: {
                                    legend: { 
                                        display: false
                                    },
                                    tooltip: {
                                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                        padding: 12,
                                        titleFont: { size: 14, weight: 'bold' },
                                        bodyFont: { size: 13 },
                                        callbacks: {
                                            label: function(ctx) {
                                                const qtd = ctx.parsed.x;
                                                const pct = ((qtd / totalGeral) * 100).toFixed(1);
                                                return `${qtd} respostas (${pct}%)`;
                                            }
                                        }
                                    },
                                    datalabels: {
                                        anchor: 'end',
                                        align: 'end',
                                        color: '#000',
                                        formatter: (value) => {
                                            const pct = ((value / totalGeral) * 100).toFixed(1);
                                            return value > 0 ? `${value} (${pct}%)` : '';
                                        },
                                        font: {
                                            weight: 'bold',
                                            size: window.innerWidth < 576 ? 11 : 13
                                        }
                                    }
                                },
                                scales: {
                                    x: {
                                        beginAtZero: true,
                                        ticks: { 
                                            stepSize: 1,
                                            color: '#000',
                                            font: { size: 12 }
                                        },
                                        grid: {
                                            color: 'rgba(255, 255, 255, 0.1)'
                                        }
                                    },
                                    y: {
                                        ticks: {
                                            color: '#000',
                                            font: { 
                                                size: window.innerWidth < 576 ? 10 : 12,
                                                weight: '500'
                                            }
                                        },
                                        grid: {
                                            display: false
                                        }
                                    }
                                }
                            },
                            plugins: [ChartDataLabels]
                        });
                    }, 200);
                }

            })
            .catch(err => {
                console.error('Erro ao carregar os dados:', err);
                areaGraficos.innerHTML = 
                    '<div class="alert alert-danger text-center">Erro ao carregar os dados. Por favor, tente novamente.</div>';
            });
    });
});
            
           


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