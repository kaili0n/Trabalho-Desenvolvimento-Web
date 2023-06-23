<?php

// Recuperar POST data
$tipo_entidade = $_POST['tipo_entidade'];
$nome = $_POST['nome'];
$cidade = $_POST['cidade'];
$local  = $_POST['local'];
$uf = $_POST['uf'];
$tel = $_POST['tel'];
$email = $_POST['email'];
$pass = $_POST['pass'];
$petNome = $_POST['petNome'];
$especie = $_POST['especie'];
$raca = $_POST['raca'];
$idade = $_POST['idade'];
$procedimentos = $_POST['procedimentos'];
$informacoes = $_POST['informacoes'];

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

// Prepare e execute o SQL para inserir dados no banco de dados
$stmt = $conn->prepare("INSERT INTO doador (tipo_entidade, nome, cidade, uf, tel, email, pass, petNome, especie, raca, idade, procedimentos, informacoes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssssssiss", $tipo_entidade, $nome, $cidade, $uf, $tel, $email, $pass, $petNome, $especie, $raca, $idade, $procedimentos, $informacoes);
$stmt->execute();

// Verifique se foi bem sucedido
if ($stmt->affected_rows > 0) {
    echo "Doador cadastrado com sucesso.";
    $stmt->close();

    // Prepare e execute a consulta SQL para inserir PET DATA no banco de dados
    $stmt = $conn->prepare("INSERT INTO pet (nome, idade, especie, raca, local, procedimentos, informacoes, nome_doador) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sissssss", $petNome, $idade, $especie, $raca, $local, $procedimentos, $informacoes, $nome);
    $stmt->execute();

    header("Location: login.html");
    exit();
} else {
    echo "Error inserting data.";
    $stmt->close();

    header("Location: cadastro-doador.html");
    exit();
}

// Feche a instrução e a conexão com o banco de dados
$conn->close();