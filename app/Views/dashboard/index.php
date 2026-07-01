<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - AtendeLab</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <span class="navbar-brand">AtendeLab</span>
        <a class="btn btn-outline-light" href="?controller=auth&action=logout">Sair</a>
    </div>
</nav>
<div class="container mt-4">
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h1 class="h4">Área restrita</h1>
            <p class="mb-0">Bem-vindo, <strong><?= htmlspecialchars($usuario['nome'], ENT_QUOTES, 'UTF-8') ?></strong>!</p>
            <p class="text-muted">Perfil: <?= htmlspecialchars($usuario['perfil'], ENT_QUOTES, 'UTF-8') ?></p>
            <a class="btn btn-primary" href="?controller=usuarios&action=listar">Testar rota protegida de usuarios</a>
        </div>
    </div>

    <!-- Cards de indicadores que o script vai preencher -->
    <div class="row g-3">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-secondary small">Pessoas cadastradas</div>
                    <div class="display-6 fw-semibold" id="totalPessoas">—</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-secondary small">Tipos de atendimento</div>
                    <div class="display-6 fw-semibold" id="totalTipos">—</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-secondary small">Atendimentos registrados</div>
                    <div class="display-6 fw-semibold" id="totalAtendimentos">—</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- api.js precisa vir ANTES do script que o usa -->
<script src="/atendelab/public/assets/js/api.js"></script>
<script>
document.addEventListener('DOMContentLoaded', async () => {
    const targets = {
        pessoas: document.getElementById('totalPessoas'),
        tipos: document.getElementById('totalTipos'),
        atendimentos: document.getElementById('totalAtendimentos')
    };

    for (const [controller, element] of Object.entries(targets)) {
        try {
            const response = await AtendeLabApi.get(controller, 'listar');
            element.textContent = AtendeLabApi.toList(response).length;
        } catch (error) {
            element.textContent = '!';
            element.title = error.message;
        }
    }
});
</script>
</body>
</html>