<?php
// Inclui a conexão com o banco
include_once("./php/conexao.php");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Controle de Diabetes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f8f8;
            margin: 0;
            padding: 20px;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .card {
            background: white;
            border-radius: 8px;
            box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.2);
            padding: 15px;
            width: 380px;
        }

        .card h2 {
            margin: 0;
            padding: 10px;
            text-align: center;
            color: white;
            border-radius: 5px;
        }

        .medicamentos h2,
        .paciente h2,
        .imc h2 {
            background: #0097a7;
        }

        .controle h2 {
            background: #2e7d32;
        }

        .grafico h2 {
            background: #0097a7;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table th {
            background: purple;
            color: white;
            padding: 8px;
        }

        table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            background: purple;
            color: white;
            text-align: center;
            text-decoration: none;
            margin-top: 10px;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            border: none;
        }

        .btn:hover {
            background: #6a1b9a;
        }

        input {
            padding: 5px;
            margin: 5px 0;
            width: calc(100% - 10px);
        }

        .resultado {
            margin-top: 10px;
            font-weight: bold;
            color: #333;
        }
    </style>
</head>
<body>

<div class="container">

    <!-- Medicamentos -->
    <div class="card medicamentos">
        <h2>Medicamentos de todos os pacientes</h2>
        <?php include_once("./php/consulta_med.php"); ?>
        <button class="btn" onclick="Cadastro()">Registros Paciente/Medicamentos</button>
    </div>

    <!-- Paciente -->
    <div class="card paciente">
        <h2>Paciente</h2>
        <?php include_once("./php/consulta_pac.php"); ?>
    </div>

    <!-- IMC -->
    <div class="card imc">
        <h2>IMC</h2>
        <form method="POST">
            <label for="nomePaciente">Nome Paciente:</label>
            <input type="text" name="nome_pc" id="nomePaciente" placeholder="Digite o nome" required>
            <button type="submit" class="btn">Calcular IMC</button>
        </form>

        <div class="resultado">
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nome_pc'])) {
                include("./php/imc.php");
            }
            ?>
        </div>
    </div>
</div>

<!-- Controle Diabetes -->
<div class="card controle" style="margin-top: 20px; width: 100%;">
    <h2>Controle Diabetes</h2>
    <a class="btn" onclick="registrarGlicemia()">Registrar Glicemia</a>
</div>

<!-- Gráfico Histórico de Glicemia -->
<div class="card grafico" style="margin-top:20px; width:100%;">
    <h2>Histórico de Glicemia</h2>
    <form id="formBuscaGlicemia">
        <input type="text" id="nomeBusca" placeholder="Digite o nome do paciente" required>
        <button type="submit" class="btn">Buscar Glicemia</button>
    </form>
    <canvas id="graficoGlicemia" width="400" height="100"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
function registrarGlicemia() {
    alert("Redirecionando para a página de registro de glicemia...");
    window.location.href = "Registro.php";
}

function Cadastro() {
    alert("Redirecionando para a página de cadastro de paciente/medicamentos...");
    window.location.href = "Cadastro.html";
}

// Gráfico dinâmico de glicemia
let chartGlicemia;
document.getElementById('formBuscaGlicemia').addEventListener('submit', async function(e){
    e.preventDefault();
    const nome = document.getElementById('nomeBusca').value.trim();
    if(!nome) return;

    const res = await fetch(`./php/grafico.php?nome=${encodeURIComponent(nome)}`);
    const json = await res.json();
    const ctx = document.getElementById('graficoGlicemia').getContext('2d');

    if(chartGlicemia) chartGlicemia.destroy();

    if(json.data.length === 0){
        alert("Nenhum dado de glicemia encontrado para esse paciente!");
        return;
    }

    chartGlicemia = new Chart(ctx,{
        type:'line',
        data:{
            labels: json.labels,
            datasets:[{
                label:'Glicemia (mg/dL)',
                data: json.data,
                borderColor:'#2e7d32',
                backgroundColor:'rgba(46,125,50,0.2)',
                fill:true,
                tension:0.3
            }]
        },
        options:{
            responsive:true,
            plugins:{
                legend:{position:'top'},
                title:{display:true,text:`Histórico de Glicemia - ${nome}`}
            },
            scales:{
                y:{beginAtZero:false,title:{display:true,text:'mg/dL'}},
                x:{title:{display:true,text:'Data'}}
            }
        }
    });
});
</script>

</body>
</html>
