<?php
include 'conexao.php';
if (isset($_POST['submit'])){
    $descricao = $_POST['descricao'];
    $valor = $_POST['valor'];
    $data = $_POST['data'];
    $fixa = $_POST['fixa'];

    $tipo = $_POST['tipo']; 
    try {
        $sql = "INSERT INTO lancamentos (descricao, valor, tipo, data, fixa) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt-> execute([$descricao, $valor, $tipo, $data, $fixa]);
        echo "Lancamentos cadastrada com sucesso!";
    } catch (PDOException $e) {
        echo "Erro ao cadastrar lancamentos: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html> 
<html lang="pt-br"> 
<head> 
    <meta charset="UTF-8"> 
    <title>Cadastro de Despesas</title> 
</head> 
<body>  
    <a href="index.php"><button>Voltar</button></a>
    <h2>Lancamentos</h2>
    <h2>Cadastro de Despesas</h2> 
    <form action="lancamentos.php" method="post"> 
        Descrição: <input type="text" name="descricao" required><br> 
        Valor: <input type="number" step="0.01" name="valor" required><br> 
        Data: <input type="date" name="data" required><br> 
        Fixa: <select name="fixa"> 
                <option value="não">Não</option> 
                <option value="sim">Sim</option>        
              </select><br>
              tipo: <select name="tipo">
                    <option value="entrada">Entrada</option>
                    <option value="saida">Saida</option>
</select><br> 
        <input type="submit" name="submit" value="Cadastrar Despesa"> 
    </form>
    <h2>Despesas Cadastradas</h2>
    <table border="1">
        <tr>
            <th>Descrição</th>
            <th>Valor</th>
            <th>Data</th>
            <th>Fixa</th>
        </tr>
        <?php
        $sql = "SELECT descricao, tipo, valor, data, fixa FROM lancamentos";
        foreach ($conn->query($sql) as $row) {
            echo "<tr>
                    <td>{$row['descricao']}</td>
                    <td>R$ {$row['valor']}</td>
                    <td>{$row['tipo']}</td>
                    <td>{$row['data']}</td>
                    <td>{$row['fixa']}</td>
                  </tr>";
        }
        ?>
</body> 
</html>