<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel RH - Pesquisa de Clima</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>
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
                    <option>Administrativo</option>
                    <option>Produção</option>
                    <option>Manutenção</option>
                    <option>Controle de Qualidade</option>
                    <option>Logística</option>
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
                card.innerHTML = `<h6 class="text-center mb-3">${item.pergunta}</h6><canvas id="graf${i}" height="150"></canvas>`;
                container.appendChild(card);

                const ctx = document.getElementById(`graf${i}`).getContext('2d');
                const total = Object.values(item.respostas).reduce((a, b) => a + b, 0);

                new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: Object.keys(item.respostas),
                        datasets: [{
                            data: Object.values(item.respostas),
                            backgroundColor: [
                                '#FF6384','#FF9F40','#FFCD56','#4BC0C0','#36A2EB'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    boxWidth: 15,
                                    font: { size: 14 }
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
                                formatter: (value, ctx) => {
                                    const sum = ctx.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                                    const percentage = sum > 0 ? ((value / sum) * 100).toFixed(1) : 0;
                                    return value > 0 ? percentage + "%" : ""; // Oculta 0%
                                },
                                font: {
                                    weight: 'bold',
                                    size: 13
                                }
                            }
                        }
                    },
                    plugins: [ChartDataLabels]
                });
            });
        })
        .catch(err => {
            console.error('Erro ao carregar os dados:', err);
            document.getElementById('areaGraficos').innerHTML = 
                '<div class="alert alert-danger text-center">Erro ao carregar os dados. Verifique o console.</div>';
        });
});
</script>
</body>
</html>
