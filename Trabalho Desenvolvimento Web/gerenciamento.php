<?php
session_start();

// Parâmetros de conexão do banco de dados
$host = 'localhost';
$dbUsername = 'loane';
$dbPassword = '123456';
$dbName = 'desenvolvimento_web';

if (!isset($_SESSION['doador_nome'])) {
    die('Doador nao logado!');
}

$nome_doador =  $_SESSION['doador_nome'];

// Crie um novo objeto MySQLi e estabeleça uma conexão
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

// Verificar conexão
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        $nome = $_POST['nome'];
        // Prepare the delete statement
        $stmt = $conn->prepare("DELETE FROM pet WHERE nome = ?");
        $stmt->bind_param("s", $nome);

        // Execute a instrução de exclusão
        if ($stmt->execute()) {
            // Deletion successful
            echo "Pet with nome '$nome' has been deleted.";
        } else {
            // Deletion failed
            echo "Error deleting pet.";
        }
    }else{
        // Recuperar dados POST
        $nome = $_POST['nome'];
        $idade = $_POST['idade'];
        $especie = $_POST['especie'];
        $raca = $_POST['raca'];
        $local = $_POST['local'];
        $procedimentos = $_POST['procedimentos'];
        $informacoes = $_POST['informacoes'];

        // Prepare e execute a consulta SQL para inserir dados no banco de dados
        $stmt = $conn->prepare("INSERT INTO pet (nome, idade, especie, raca, local, procedimentos, informacoes, nome_doador) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sissssss", $nome, $idade, $especie, $raca, $local, $procedimentos, $informacoes, $nome_doador);
        $stmt->execute();
    }
    // Feche a instrução
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="C:\Users\kaill\OneDrive\Desktop\Trabalho Desenvolvimento Web\PUBLIC\IMG\favicon-16x16.png" type="image/x-icon">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@400;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="CSS/reset.css">
        <link rel="stylesheet" href="CSS/gerenciamento.css">
        <title>Mundo da Adoção</title>
    </head>
    <body>
    <header>
        <nav>
            <ul>
                <li><img id="logo" src="IMG/LOGO.png" alt="logo Adote um pet"></li>
                <li><a href="index.html">Quero adotar</li></a>
                <li><a href="gerenciamento.php">Meus animais</li></a>
                <li><a href="login.html">Login</a></li>
                <li>
                    <div class="dropdown">
                        <span>Cadastro</span>
                        <div class="dropdown-content">
                            <span>Cadastro Doador</span>
                            <span>Cadastro Adotante</span>
                        </div>
                    </div>
                </li>
            </ul>
        </nav>
        <script>
            document.querySelector('.dropdown-content span:nth-child(1)').addEventListener('click', function() {
                window.location.href = 'cadastro-doador.html';
            });

            document.querySelector('.dropdown-content span:nth-child(2)').addEventListener('click', function() {
                window.location.href = 'cadastro-adotar.html';
            });
        </script>
    </header>
        <h1 id="banner">Gerencie seus animais</h1>
            <?php
                // Prepare a consulta SQL para selecionar animais com base no filtro nome_doador
                $query = "SELECT * FROM pet WHERE nome_doador = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("s", $nome_doador);

                $stmt->execute();

                // Obter o conjunto de resultados
                $result = $stmt->get_result();

                if($result && $result->num_rows > 0){
                    // Fetch all rows from the result set as an associative array
                    while ($animalArray = $result->fetch_assoc()) {
                        $animal = (object) $animalArray;
                        $html_animal = "
                        <div class='feed'>
                        <div id='postagem'>
                            <form action='gerenciamento.php' method='POST'>
                                <img src='img/adicionar-foto.png'>
                                <table>
                                     <tr>
                                        <td id='nome'>Nome</td>
                                        <td>$animal->nome</td>
                                        <input type='hidden' name='nome' value='$animal->nome'>
                                        <input type='hidden' name='delete' value='true'>
                                    </tr>
                                    <tr>
                                        <td>Idade</td>
                                        <td>$animal->idade</td>
                                    </tr>
                                    <tr>
                                        <td>Espécie</td>
                                        <td>$animal->especie</td>
                                    </tr>
                                    <tr>
                                        <td>Raça</td>
                                        <td>$animal->raca</td>
                                    </tr>
                                    <tr>
                                        <td>&#128205; Local</td>
                                        <td>$animal->local</td>
                                    </tr>
                                    <tr id='texto'>
                                        <td>Procedimentos</td>
                                        <td>$animal->procedimentos</td>
                                    </tr>
                                    <tr id='texto'>
                                        <td>Informações complementares</td>
                                        <td>$animal->informacoes</td>
                                    </tr>
                                    <tr>
                                        <td><button type='submit'>Excluir</button></td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                        </div>";
                        echo $html_animal;
                    }
                }
            // Feche a instrução e a conexão com o banco de dados
            $stmt->close();
            //NOVO PET
            ?>
            <form action="gerenciamento.php" method="POST">
                <div id="postagem">
                    <img src="img/adicionar-foto.png">
                    <table>
                        <tr>
                            <td id="nome">Nome</td>
                            <td><input type="text" name="nome" required></td>
                        </tr>
                        <tr>
                            <td>Idade</td>
                            <td><input type="text" name="idade" required></td>
                        </tr>
                        <tr>
                            <td>Espécie</td>
                            <td><input type="text" name="especie" required></td>
                        </tr>
                        <tr>
                            <td>Raça</td>
                            <td><input type="text" name="raca" required></td>
                        </tr>
                        <tr>
                            <td>&#128205; Local</td>
                            <td><input type="text" name="local" required></td>
                        </tr>
                        <tr id="texto">
                            <td>Procedimentos</td>
                            <td><input type="text" name="procedimentos"></td>
                        </tr>
                        <tr id="texto">
                            <td>Informações complementares</td>
                            <td><input type="text" name="informacoes"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><button type="submit">Salvar</button></td>
                        </tr>
                    </table>
                </div>
            </form>
    </body>
</html>
<?php
    $conn->close();
