<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $cidade = $_POST['cidade'];
    $uf = $_POST['uf'];
    $telefone = $_POST['tel'];
    $email = $_POST['email'];
    $senha = $_POST['pass'];

    // Parâmetros de conexão do Banco de Dados
    $host = 'localhost';
    $dbUsername = 'loane';
    $dbPassword = '123456';
    $dbName = 'desenvolvimento_web';

    // Crie um novo objeto MySQL e estabeleça uma conexão
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

    // Checar conexão
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    // Exemplo: Inserir os dados em um banco de dados fictício
    $sql = "INSERT INTO adotante (nome, cidade, uf, telefone, email, senha) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $nome, $cidade, $uf, $telefone, $email, $senha);
    $stmt->execute();

    // Verifique se foi bem sucedido
    if ($stmt->affected_rows > 0) {
        echo "Adotante cadastrado com sucesso.";
        $stmt->close();

        header("Location: login.html");
        exit();
    } else {
        echo "Error inserting data.";
        $stmt->close();

        header("Location: cadastro-adotar.html");
        exit();
    }

    // Feche a instrução e a conexão com o banco de dados
    $conn->close();
}