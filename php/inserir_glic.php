<?php
// php/inserir_glic.php
include_once("conexao.php");

// Recebe dados do POST
$id_paciente = $_POST['paciente_ID_PC'] ?? '';
$glicemia    = $_POST['GLICEMIA'] ?? '';
$data        = $_POST['data'] ?? ''; // YYYY-MM-DD
$hora        = $_POST['hora'] ?? ''; // HH:MM

if (!$id_paciente || $glicemia === '' ) {
    echo "⚠️ Dados insuficientes. Verifique paciente e valor da glicemia.";
    exit;
}

// Verifica colunas existentes na tabela `glicemia`
$cols = [];
$res = $conexao->query("SHOW COLUMNS FROM glicemia");
if ($res) {
    while ($r = $res->fetch_assoc()) {
        $cols[] = strtolower($r['Field']);
    }
} else {
    echo "❌ Não foi possível ler a estrutura da tabela glicemia: " . $conexao->error;
    exit;
}

// Função auxiliar para encontrar coluna por lista de opções
function acharColuna(array $cols, array $opcoes) {
    $colsLower = array_map('strtolower', $cols);
    foreach ($opcoes as $o) {
        if (in_array(strtolower($o), $colsLower)) return strtolower($o);
    }
    return null;
}

// Tenta encontrar colunas de data/hora
$col_paciente = acharColuna($cols, ['paciente_id_pc','paciente_ID_PC','pacienteid','id_pc','id']);
$col_glicemia = acharColuna($cols, ['glicemia','valor','valor_glicemia']);
$col_date = acharColuna($cols, ['data','data_medicao','data_glicemia','data_med','data_medicao']);
$col_time = acharColuna($cols, ['hora','hora_medicao','hora_glicemia','horario']);
$col_datetime = acharColuna($cols, ['datahora','data_hora','datetime','registro_dt','created_at','data_registro']);

// Monta o INSERT dinamicamente conforme colunas encontradas
$campos = [];
$placeholders = [];
$tipos = '';
$valores = [];

// paciente id
if ($col_paciente) {
    $campos[] = $col_paciente;
    $placeholders[] = '?';
    $tipos .= 'i';
    $valores[] = (int)$id_paciente;
} else {
    echo "❌ A tabela 'glicemia' não possui coluna de paciente reconhecível (procure por paciente_ID_PC ou similar).";
    exit;
}

// glicemia
if ($col_glicemia) {
    $campos[] = $col_glicemia;
    $placeholders[] = '?';
    // glicemia pode ser decimal -> passar como string/double
    $tipos .= (strpos($glicemia, '.') !== false) ? 'd' : 'd';
    $valores[] = (float)$glicemia;
} else {
    echo "❌ A tabela 'glicemia' não possui coluna de glicemia reconhecível (procure por 'GLICEMIA' ou similar).";
    exit;
}

// data + hora ou datetime
if ($col_datetime) {
    // combina data e hora em datetime
    $datetime = null;
    if ($data && $hora) {
        $datetime = $data . ' ' . $hora;
    } elseif ($data && !$hora) {
        $datetime = $data . ' 00:00:00';
    } else {
        $datetime = date('Y-m-d H:i:s'); // fallback para now
    }
    $campos[] = $col_datetime;
    $placeholders[] = '?';
    $tipos .= 's';
    $valores[] = $datetime;
} elseif ($col_date && $col_time) {
    // usar col_date e col_time separadas
    $campos[] = $col_date;
    $placeholders[] = '?';
    $tipos .= 's';
    $valores[] = $data ?: date('Y-m-d');

    $campos[] = $col_time;
    $placeholders[] = '?';
    $tipos .= 's';
    $valores[] = $hora ?: date('H:i:s');
} elseif ($col_date && !$col_time) {
    // só data
    $campos[] = $col_date;
    $placeholders[] = '?';
    $tipos .= 's';
    $valores[] = $data ?: date('Y-m-d');
} elseif (!$col_date && !$col_time && !$col_datetime) {
    // nenhuma coluna de data/hora encontrada -> só inserir paciente e glicemia
    // já temos esses dois campos montados
}

// Monta SQL
$sql = "INSERT INTO glicemia (" . implode(',', $campos) . ") VALUES (" . implode(',', $placeholders) . ")";

$stmt = $conexao->prepare($sql);
if (!$stmt) {
    echo "❌ Erro ao preparar query: " . $conexao->error . " | SQL: $sql";
    exit;
}

// Bind dinâmico
$bind_names[] = $tipos;
for ($i=0; $i<count($valores); $i++) {
    $bind_name = 'bind' . $i;
    $$bind_name = $valores[$i];
    $bind_names[] = &$$bind_name;
}
call_user_func_array([$stmt, 'bind_param'], $bind_names);

// Executa
if ($stmt->execute()) {
    echo "✅ Glicemia registrada com sucesso!";
} else {
    echo "❌ Erro ao executar insert: " . $stmt->error;
}

$stmt->close();
$conexao->close();
?>
