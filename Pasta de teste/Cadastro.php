<?php include './php/conexao.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Cadastro</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="form">
    <h2>Cadastro de Paciente</h2>
    <form id="formPaciente">
        <label>Nome:<input type="text" name="nome" required></label>
        <label>Idade:<input type="number" name="idade" required></label>
        <label>Peso:<input type="number" name="peso" step="0.1" required></label>
        <label>Altura:<input type="number" name="altura" step="0.1" required></label>
        <label>Sexo:
            <select name="sexo" required>
                <option value="">Selecione</option>
                <option>Masculino</option>
                <option>Feminino</option>
            </select>
        </label>
        <button type="submit">Registrar Paciente</button>
    </form>
</div>

<div class="form">
    <h2>Cadastro de Medicamento</h2>
    <form id="formMedicamento">
        <label>Nome do Paciente:<input type="text" name="paciente_nome" required></label>
        <label>Medicamento:<input type="text" name="medicamento" required></label>
        <label>Dosagem:<input type="text" name="dosagem" required></label>
        <label>Tipo:
            <select name="tipo" required>
                <option value="">Selecione</option>
                <option>Comprimido</option>
                <option>Injeção</option>
                <option>Cápsula</option>
                <option>Outro</option>
            </select>
        </label>
        <button type="submit">Registrar Medicamento</button>
    </form>
</div>

<div class="form">
    <h2>Buscar Paciente</h2>
    <input type="text" id="buscaNome" placeholder="Digite o nome do paciente">
    <button onclick="buscarPaciente()">Buscar</button>
</div>

<div id="resultadoBusca"></div>

<a href="index.php" class="voltar">⬅ Voltar para Controle</a>

<script>
document.getElementById('formPaciente').addEventListener('submit', async (e) => {
    e.preventDefault();
    const dados = new FormData(e.target);
    const res = await fetch('./php/salvar_paciente.php', { method: 'POST', body: dados });
    const texto = await res.text();
    alert(texto);
    e.target.reset();
});

document.getElementById('formMedicamento').addEventListener('submit', async (e) => {
    e.preventDefault();
    const dados = new FormData(e.target);
    const res = await fetch('./php/salvar_medicamento.php', { method: 'POST', body: dados });
    const texto = await res.text();
    alert(texto);
    e.target.reset();
});

async function buscarPaciente() {
    const nome = document.getElementById('buscaNome').value.trim();
    if (!nome) return alert("Digite o nome do paciente.");
    const res = await fetch('./php/buscar_paciente.php?nome=' + encodeURIComponent(nome));
    const html = await res.text();
    document.getElementById('resultadoBusca').innerHTML = html;
}
</script>

</body>
</html>
