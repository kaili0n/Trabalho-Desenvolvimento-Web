<?php

// Recuperar dados POST
$username = $_POST['username'];
$pass = $_POST['pass'];

// Parametros de conexao do banco de dados
$host = 'localhost';
$dbUsername = 'loane';
$dbPassword = '123456';
$dbName = 'desenvolvimento_web';

// Crie um novo objeto MySQLi e estabeleça uma conexão
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

// Verifique conexão
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Prepare e execute a consulta SQL para verificar o nome de usuário e a senha no banco de dados
$stmt = $conn->prepare("SELECT nome FROM doador WHERE email = ? AND pass = ?");
$stmt->bind_param("ss", $username, $pass);
$stmt->execute();

// Vincular o resultado a uma variável
$stmt->bind_result($nome);

// Buscar o resultado
if ($stmt->fetch()) {
    // Successful login
    echo "Logado com sucesso $nome!";

    // Opcionalmente, você também pode armazenar os dados do doador em variáveis de sessão para acesso imediato
    session_start();
    $_SESSION['doador_nome'] = $nome;
    header("Location: gerenciamento.php");
    exit();
}  else {
    // Prepare e execute a consulta SQL para verificar o nome de usuário e a senha no banco de dados
    $stmt = $conn->prepare("SELECT nome FROM adotante WHERE email = ? AND senha = ?");
    $stmt->bind_param("ss", $username, $pass);
    $stmt->execute();

    // Vincular o resultado a uma variável
    $stmt->bind_result($nome);

    // Buscar o resultado
    if ($stmt->fetch()){

        echo "Logado com sucesso $nome!";

        // Opcionalmente, você também pode armazenar os dados do doador em variáveis de sessão para acesso imediato
        session_start();
        $_SESSION['adotante_nome'] = $nome;
        header("Location: index.php");
        exit();
    }
    else {
        // Login invalido
        echo "Usuário ou senha inválidos!";
    }
}

// Feche a instrução e a conexão com o banco de dados
$stmt->close();
$conn->close();
?>
