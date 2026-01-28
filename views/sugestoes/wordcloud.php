
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Nuvem de Palavras - 5W2H</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/7.8.5/d3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3-cloud/1.2.7/d3.layout.cloud.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.29/jspdf.plugin.autotable.min.js"></script>

    <style>
        :root {
            --primary: #6366f1;
            --secondary: #8b5cf6;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #06b6d4;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            padding: 30px 15px;
        }

        .container-fluid {
            max-width: 1400px;
            margin: 0 auto;
        }

        .page-header {
            text-align: center;
            margin-bottom: 40px;
            animation: fadeInDown 0.6s ease;
        }

        .page-header h1 {
            font-size: 3rem;
            font-weight: 800;
            color: white;
            margin-bottom: 15px;
            text-shadow: 3px 3px 6px rgba(0,0,0,0.3);
            letter-spacing: -1px;
        }

        .page-header .subtitle {
            font-size: 1.2rem;
            color: rgba(255,255,255,0.9);
            font-weight: 300;
        }

        .main-grid {
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 25px;
            margin-bottom: 25px;
        }

        .wordcloud-section {
            background: white;
            border-radius: 24px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.25);
            overflow: hidden;
            animation: fadeIn 0.6s ease;
        }

        .section-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            padding: 25px 30px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .section-header h2 {
            font-size: 1.4rem;
            font-weight: 700;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .wordcloud-body {
            padding: 40px;
            background: linear-gradient(to bottom, #ffffff 0%, #f8fafc 100%);
            position: relative;
            min-height: 600px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #wordcloud {
            width: 100%;
            height: 600px;
        }

        #wordcloud text {
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-family: 'Arial', sans-serif;
            font-weight: 800;
        }

        #wordcloud text:hover {
            filter: brightness(1.4) drop-shadow(4px 4px 8px rgba(0,0,0,0.4));
        }

        .sidebar {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .stats-card, .legend-card, .actions-card, .filter-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            overflow: hidden;
            animation: fadeInRight 0.6s ease;
        }

        .card-header-mini {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            padding: 18px 20px;
            color: white;
            font-weight: 700;
            font-size: 1rem;
        }

        .stats-body, .filter-body {
            padding: 20px;
        }

        .stat-item {
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 12px;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            border-left: 4px solid var(--info);
        }

        .stat-item:last-child {
            margin-bottom: 0;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary);
            line-height: 1;
            margin-bottom: 8px;
        }

        .stat-label {
            font-size: 0.85rem;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
        }

        .legend-body {
            padding: 20px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            margin-bottom: 10px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .legend-item:hover {
            background: #f8fafc;
            transform: translateX(5px);
        }

        .legend-color {
            width: 24px;
            height: 24px;
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }

        .legend-text {
            font-size: 0.9rem;
            color: #475569;
            font-weight: 500;
        }

        .actions-body {
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .btn-action {
            width: 100%;
            padding: 14px 20px;
            border-radius: 12px;
            border: none;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
        }

        .btn-export {
            background: linear-gradient(135deg, var(--success) 0%, #059669 100%);
            color: white;
        }

        .btn-export:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
        }

        .btn-back {
            background: linear-gradient(135deg, #64748b 0%, #475569 100%);
            color: white;
        }

        .btn-back:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(100, 116, 139, 0.4);
        }

        .btn-reload {
            background: linear-gradient(135deg, var(--info) 0%, #0891b2 100%);
            color: white;
        }

        .btn-reload:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(6, 182, 212, 0.4);
        }

        .modal-content {
            border-radius: 24px;
            border: none;
            overflow: hidden;
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            padding: 30px;
            border: none;
        }

        .modal-title {
            font-size: 1.6rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .modal-body {
            padding: 35px;
            background: #f8fafc;
            max-height: 70vh;
            overflow-y: auto;
        }

        .palavra-selected {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            border-radius: 16px;
            padding: 25px;
            text-align: center;
            margin-bottom: 30px;
            box-shadow: 0 8px 24px rgba(99, 102, 241, 0.3);
        }

        .palavra-selected-label {
            font-size: 0.9rem;
            opacity: 0.9;
            margin-bottom: 10px;
        }

        .palavra-badge-large {
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .form-group-5w2h {
            background: white;
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            border-left: 5px solid;
        }

        .form-group-5w2h:hover {
            box-shadow: 0 8px 24px rgba(0,0,0,0.12);
            transform: translateY(-2px);
        }

        .form-group-5w2h.what { border-color: #6366f1; }
        .form-group-5w2h.why { border-color: #8b5cf6; }
        .form-group-5w2h.where { border-color: #ec4899; }
        .form-group-5w2h.when { border-color: #ef4444; }
        .form-group-5w2h.who { border-color: #06b6d4; }
        .form-group-5w2h.how { border-color: #10b981; }
        .form-group-5w2h.howmuch { border-color: #f59e0b; }

        .form-label-5w2h {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 15px;
            font-weight: 700;
            color: #1e293b;
            font-size: 1.05rem;
        }

        .badge-5w2h {
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 800;
            letter-spacing: 1px;
            color: white;
        }

        .badge-what { background: #6366f1; }
        .badge-why { background: #8b5cf6; }
        .badge-where { background: #ec4899; }
        .badge-when { background: #ef4444; }
        .badge-who { background: #06b6d4; }
        .badge-how { background: #10b981; }
        .badge-howmuch { background: #f59e0b; }

        .form-control, .form-select {
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            padding: 14px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
            outline: none;
        }

        .modal-footer {
            background: white;
            border: none;
            padding: 25px 35px;
            gap: 12px;
        }

        .btn-modal {
            padding: 14px 32px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-cancel {
            background: #e2e8f0;
            color: #475569;
        }

        .btn-cancel:hover {
            background: #cbd5e1;
            transform: translateY(-2px);
        }

        .btn-save {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(99, 102, 241, 0.4);
        }

        .loading-overlay {
            position: absolute;
            inset: 0;
            background: rgba(255,255,255,0.95);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
            z-index: 10;
        }

        .loading-overlay.active {
            opacity: 1;
            pointer-events: all;
        }

        .spinner {
            width: 60px;
            height: 60px;
            border: 6px solid #e2e8f0;
            border-top: 6px solid var(--primary);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        .loading-text {
            margin-top: 20px;
            color: #64748b;
            font-weight: 600;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInRight {
            from { opacity: 0; transform: translateX(20px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @media (max-width: 992px) {
            .main-grid {
                grid-template-columns: 1fr;
            }

            .page-header h1 {
                font-size: 2rem;
            }

            #wordcloud {
                height: 450px;
            }
        }

        .alert-custom {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            animation: slideInRight 0.4s ease;
        }

        @keyframes slideInRight {
            from { transform: translateX(400px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="page-header">
        <h1>☁️ Análise Inteligente de Sugestões</h1>
        <p class="subtitle">Sistema de Gestão com Metodologia 5W2H</p>
    </div>

    <div class="main-grid">
        <div class="wordcloud-section">
            <div class="section-header">
                <h2>
                    <span>📊</span>
                    Nuvem de Palavras Interativa
                </h2>
                <span style="font-size: 0.9rem; opacity: 0.9;">Clique para criar planos</span>
            </div>
            <div class="wordcloud-body">
                <div class="loading-overlay active" id="loadingOverlay">
                    <div class="spinner"></div>
                    <div class="loading-text">Gerando visualização...</div>
                </div>
                <svg id="wordcloud"></svg>
            </div>
        </div>


            <div class="stats-card">
                <div class="card-header-mini">📈 Estatísticas</div>
                <div class="stats-body">
                    <div class="stat-item">
                        <div class="stat-number" id="totalPalavras">0</div>
                        <div class="stat-label">Palavras Únicas</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number" id="totalSugestoes">0</div>
                        <div class="stat-label">Total de Sugestões</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number" id="totalPlanos">0</div>
                        <div class="stat-label">Planos Criados</div>
                    </div>
                </div>
            </div>

            <div class="legend-card">
                <div class="card-header-mini">🎨 Legenda</div>
                <div class="legend-body">
                    <div class="legend-item">
                        <div class="legend-color" style="background: #10b981;"></div>
                        <div class="legend-text">Com Plano de Ação</div>
                    </div>
                </div>
            </div>

            <div class="actions-card">
                <div class="card-header-mini">⚡ Ações Rápidas</div>
                <div class="actions-body">
                    <button class="btn-action btn-export" onclick="exportarPlanos()">
                        <span>📥</span> Exportar Planos
                    </button>
                    <button class="btn-action btn-reload" onclick="location.reload()">
                        <span>🔄</span> Atualizar Dados
                    </button>
                    <a href="?page=pesquisa&action=sugestoes" class="btn-action btn-back">
                        <span>←</span> Voltar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal5w2h" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <span>📋</span> Plano de Ação - Metodologia 5W2H
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="palavra-selected">
                    <div class="palavra-selected-label">Palavra-chave selecionada:</div>
                    <div class="palavra-badge-large" id="palavraSelecionada"></div>
                </div>

                <form id="form5w2h">
                    <div class="form-group-5w2h what">
                        <label class="form-label-5w2h">
                            <span class="badge-5w2h badge-what">WHAT</span>
                            O que será feito?
                        </label>
                        <textarea class="form-control" id="what" rows="2" placeholder="Descreva de forma clara e objetiva a ação que será realizada..." required></textarea>
                    </div>

                    <div class="form-group-5w2h why">
                        <label class="form-label-5w2h">
                            <span class="badge-5w2h badge-why">WHY</span>
                            Por que será feito?
                        </label>
                        <textarea class="form-control" id="why" rows="2" placeholder="Explique a justificativa, importância e benefícios esperados..." required></textarea>
                    </div>

                    <div class="form-group-5w2h where">
                        <label class="form-label-5w2h">
                            <span class="badge-5w2h badge-where">WHERE</span>
                            Onde será feito?
                        </label>
                        <input type="text" class="form-control" id="where" placeholder="Ex: Departamento de TI, Filial Centro, Setor de Vendas...">
                    </div>

                    <div class="form-group-5w2h when">
                        <label class="form-label-5w2h">
                            <span class="badge-5w2h badge-when">WHEN</span>
                            Quando será feito?
                        </label>
                        <input type="date" class="form-control" id="when">
                    </div>

                    <div class="form-group-5w2h who">
                        <label class="form-label-5w2h">
                            <span class="badge-5w2h badge-who">WHO</span>
                            Quem será o responsável?
                        </label>
                        <input type="text" class="form-control" id="who" placeholder="Nome completo do responsável ou equipe responsável..." required>
                    </div>

                    <div class="form-group-5w2h how">
                        <label class="form-label-5w2h">
                            <span class="badge-5w2h badge-how">HOW</span>
                            Como será feito?
                        </label>
                        <textarea class="form-control" id="how" rows="3" placeholder="Descreva o método, processo, etapas ou procedimentos que serão seguidos..."></textarea>
                    </div>

                    <div class="form-group-5w2h howmuch">
                        <label class="form-label-5w2h">
                            <span class="badge-5w2h badge-howmuch">HOW MUCH</span>
                            Quanto vai custar?
                        </label>
                        <input type="text" class="form-control" id="howMuch" placeholder="Ex: R$ 5.000,00 | Entre R$ 3.000 e R$ 5.000 | Sem custos adicionais...">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal btn-cancel" data-bs-dismiss="modal">
                    Cancelar
                </button>
                <button type="button" class="btn-modal btn-save" onclick="salvarPlano()">
                    💾 Salvar Plano de Ação
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
const sugestoes = <?= json_encode($sugestoes ?? [], JSON_UNESCAPED_UNICODE) ?>;
const planosDB  = <?= json_encode($planos ?? [], JSON_UNESCAPED_UNICODE) ?>;

const categorias = { 
    "Área de descanso": ["descanso", "área de descanso", "pausa", "intervalo"], 
    "Grupo de melhoria contínua": ["grupo"], 
    "Comunicação interna": ["comunicação", "informação", "alinhamento", "feedback"], 
    "Cargos e Salários": ["salário", "cargo", "plano de carreira", "remuneração", "salario"], 
    "Ergonomia": ["ergonomia", "cadeira", "postura", "conforto"], 
    "Convênio médico": ["convênio", "plano de saúde", "médico", "Unimed", "saude", "convenio", "medico",], 
    "Vale alimentação": ["vale alimentação", "refeição", "VR", "VA"], 
    "Feedbacks": ["feedback", "retorno", "avaliação"], 
    "Uniforme completo": ["uniforme", "epi", "roupa"], 
    "Gympass": ["gympass", "academia", "exercício", "gynpass", "gym"], 
    "Infraestrutura": ["infraestrutura", "estrutura", "equipamento", "máquina", "descanso", "banheiro"], 
    "Treinamentos": ["treinamento", "curso", "capacitação"] 
};

const planosMap = {};
planosDB.forEach(p => planosMap[p.palavra] = p);

const width  = 950;
const height = 650;
let palavrasList = [];
let palavraAtual = "";

function gerarPalavras(textos) {
    const resultado = [];

    Object.entries(categorias).forEach(([categoria, chaves]) => {
        let ocorrencias = 0;

        textos.forEach(txt => {
            if (!txt) return;
            const lower = txt.toLowerCase();
            if (chaves.some(p => lower.includes(p))) {
                ocorrencias++;
            }
        });

        if (ocorrencias > 0) {
            resultado.push({
                text: categoria,
                size: 12 + ocorrencias * 3
            });
        }
    });

    return resultado;
}

palavrasList = gerarPalavras(sugestoes);
renderizarNuvem();

function renderizarNuvem() {
    d3.select("#wordcloud").selectAll("*").remove();
    document.getElementById("loadingOverlay").classList.add("active");

    if (!palavrasList.length) {
        mostrarMensagemVazia();
        return;
    }

    d3.layout.cloud()
        .size([width, height])
        .words(palavrasList)
        .padding(12)
        .rotate(() => 0)
        .font("Arial")
        .fontSize(d => d.size)
        .on("end", desenhar)
        .start();
}

function desenhar(words) {
    const cores = d3.scaleOrdinal()
        .range(["#6366f1", "#8b5cf6", "#06b6d4", "#ec4899", "#10b981", "#f59e0b"]);

    const svg = d3.select("#wordcloud")
        .attr("width", width)
        .attr("height", height)
        .append("g")
        .attr("transform", `translate(${width/2},${height/2})`);

    svg.selectAll("text")
        .data(words)
        .enter()
        .append("text")
        .style("font-size", d => d.size + "px")
        .style("font-weight", "800")
        .style("fill", d => planosMap[d.text] ? "#10b981" : cores(d.text))
        .attr("text-anchor", "middle")
        .attr("transform", d => `translate(${d.x},${d.y})rotate(${d.rotate})`)
        .text(d => d.text)
        .style("cursor", "pointer")
        .on("click", (_, d) => abrirPlano(d.text));

    document.getElementById("loadingOverlay").classList.remove("active");
    atualizarEstatisticas();
}

function atualizarEstatisticas() {
    document.getElementById("totalPalavras").textContent   = palavrasList.length;
    document.getElementById("totalSugestoes").textContent = sugestoes.length;
    document.getElementById("totalPlanos").textContent    = Object.keys(planosMap).length;
}

function abrirPlano(palavra) {
    palavraAtual = palavra;
    document.getElementById("palavraSelecionada").textContent = palavra.toUpperCase();
    document.getElementById("form5w2h").reset();

    if (planosMap[palavra]) {
        const p = planosMap[palavra];
        what.value     = p.what || "";
        why.value      = p.why || "";
        where.value    = p.where || "";
        when.value     = p.when || "";
        who.value      = p.who || "";
        how.value      = p.how || "";
        howMuch.value = p.how_much || "";
    }

    new bootstrap.Modal(document.getElementById("modal5w2h")).show();
}

function salvarPlano() {
    const plano = {
        palavra: palavraAtual,
        what: what.value.trim(),
        why: why.value.trim(),
        where: where.value.trim(),
        when: when.value,
        who: who.value.trim(),
        how: how.value.trim(),
        howMuch: howMuch.value.trim()
    };

    if (!plano.what || !plano.why || !plano.who) {
        mostrarAlerta("Preencha WHAT, WHY e WHO", "warning");
        return;
    }

    fetch("?page=sugestoes&action=salvarPlano", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(plano)
    })
    .then(r => r.json())
    .then(res => {
        if (res.success) {
            mostrarAlerta("Plano salvo com sucesso", "success");
            setTimeout(() => location.reload(), 1200);
        } else {
            mostrarAlerta(res.message, "danger");
        }
    });
}

function exportarPlanos() {
    if (!Object.keys(planosMap).length) {
        mostrarAlerta("Nenhum plano criado", "warning");
        return;
    }

    const doc = new jspdf.jsPDF("landscape", "mm", "a4");

    doc.setFontSize(16);
    doc.text("Planos de Ação 5W2H", 148, 15, { align: "center" });

    const linhas = Object.values(planosMap).map(p => [
        p.palavra,
        p.what,
        p.why,
        p.where,
        p.when || "-",
        p.who,
        p.how,
        p.how_much || "-"
    ]);

    doc.autoTable({
        startY: 25,
        head: [["PALAVRA","WHAT","WHY","WHERE","WHEN","WHO","HOW","HOW MUCH"]],
        body: linhas,
        styles: { fontSize: 8 },
        headStyles: { fillColor: [99,102,241] }
    });

    doc.save("planos_5w2h.pdf");
}

function mostrarAlerta(msg, tipo) {
    alert(msg);
}

function mostrarMensagemVazia() {
    const svg = d3.select("#wordcloud")
        .attr("width", width)
        .attr("height", height);

    svg.append("text")
        .attr("x", width/2)
        .attr("y", height/2)
        .attr("text-anchor", "middle")
        .attr("fill", "#94a3b8")
        .attr("font-size", "22px")
        .text("Nenhuma sugestão encontrada");

    document.getElementById("loadingOverlay").classList.remove("active");
}
</script>


</body>
</html>