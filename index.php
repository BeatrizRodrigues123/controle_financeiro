<?php
include 'conexao.php'; // 
echo "Bem-vindo ao sistema de controle financeiro!";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    
    <title>Controle financeiro pessoal</title>
</head>
<body>
    <h1>Controle financeiro pessoal</h1>
    <a href="lancamentos.php"><button> Acessar Lancamentos</button></a>
    <?php

try {
    $stmt= $conn->query("SELECT *, MONTH (data)as mes, YEAR (data) as ano FROM lancamentos ORDER BY data DESC");
    
    $lancamentosPorMes =[];
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $lancamentosPorMes[$row['ano']][$row['mes']][] = $row;
        }
        foreach ($lancamentosPorMes as $ano =>$meses) {
            foreach ($meses as $mes => $lancamentos) {
                echo "<h3>" . DateTime::createFromFormat('!m', $mes)->format('F') ."$ano</h3>";            
                    echo "<table border='1'>
                    <tr>
                        <th>descricao</th>
                        <th>valor</th>
                        <th>tipo</th>
                        <th>data</th>
                        <th>fixa</th>
                    </tr>"; 
                    foreach ($lancamentos as $lancamento) {
                        echo "<tr>
                        <td>{$lancamento['descricao']}</td>
                        <td>R$ {$lancamento['valor']}</td>
                        <td>{$lancamento['tipo']}</td> 
                        <td>" . date("d/m/Y", strtotime ($lancamento['data']))."</td>
                        <td>{$lancamento['fixa']}</td> 
                        </tr>";
                        
                    }
                echo "</table><br>";
            }
        }
    }catch (PDOException $e) {
        echo "Erro ao consultar lancamentos: ". $e->getMessage();
    }
    ?>
</body>
</html>
