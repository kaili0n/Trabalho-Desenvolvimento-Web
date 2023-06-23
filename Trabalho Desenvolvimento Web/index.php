<!DOCTYPE html  >
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="favicon-16x16.png " type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@300;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="CSS/reset.css">
    <link rel="stylesheet" href="CSS/index.css">
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
    <div id="banner">
        <h1>Amor de verdade não se compra, se encontra!</h1>
    </div>

    <h1>Conheça o Mundo da Adoção</h1>
    <p id="lema">Nós fazemos a conexão entre quem deseja adotar um pet com uma rede de mais de 133 ONGs e protetores parceiros. Aqui você pode encontrar centenas de animais disponíveis, após escolher seu pet, fazemos a ligação entre doador e futuro tutor, para que possa ser concluído todo o processo de adoção. E por fim, nossos animais tenham um final feliz!
    </p>

    <div id="informacoes">
        <div class="box">
            <ul>
                <li><img src="img/formulario.png"></li>
                <h1>Inscreva-se</h1>
                <p>Faça sua inscrição em nosso site, preenchendo o formulário que disponibilizamos aqui que a ONG/protetor</p>
            </ul>
        </div>
        <div class="box">
            <ul>
                <li><img src="img/pesquisa.png"></li>
                <h1>O encontro</h1>
                <p>Ache nossos animais na aba "Adote", lá você terá imagens e todas as informações que precisa para encontrar o seu amigo.</p>
            </ul>
        </div>
        <div class="box">
            <ul>
                <li><img src="img/adocao.png"></li>
                <h1>Primeiro contato</h1>
                <p>Após escolher seu peludo, você apenas precisa selecionar a opção de "Interesse", nos trocaremos dados entre você e o doador, para que possa ser combinada a entrega do novo membro da família.</p>
            </ul>
        </div>
    </div>

    <div id="incentivo">
        <h1>Campanha de Adoção</h1>
        <p>Uma seleção especial de peludinhos que buscam um lar para chamar de seu. Aqui você terá várias informações, como fotos, idade, raça, ficha medica e região onde se encontra. Escolha com o coração esperamos que encontre um pet disponível e bem pertinho de você.</p>
    </div>

    <?php

        // Parametros de conexão do banco de dados
        $host = 'localhost';
        $dbUsername = 'loane';
        $dbPassword = '123456';
        $dbName = 'desenvolvimento_web';

        // Crie um novo objeto MySQLi e estabeleça uma conexão
        $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

        // Verificar conexao
        if ($conn->connect_error) {
            die('Connection failed: ' . $conn->connect_error);
        }

        // Prepare a consulta SQL para selecionar animais com base no filtro nome_doador
        $query = "SELECT * FROM pet LIMIT 10";
        $stmt = $conn->prepare($query);
        $stmt->execute();

        // Obter o conjunto de resultados
        $result = $stmt->get_result();

        if($result && $result->num_rows > 0) {

            // Buscar todas as linhas do conjunto de resultados como uma matriz associativa
            while ($animalArray = $result->fetch_assoc()) {
                $animal = (object)$animalArray;
                $html_animal = "    
                <div class='feed'>
                        <div id='postagem'>
                            <form action='gerenciamento.php' method='POST'>
                                <img id='fotoausente' src='img/adicionar-foto.png'>
                                <table>
                                     <tr>
                                        <td colspan='2' id='pet'><h1>$animal->nome</h1></td>
                                        <input type='hidden' name='nome' value='$animal->nome'>
                                        <input type='hidden' name='delete' value='true'>
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
                                        <td>Idade</td>
                                        <td>$animal->idade</td>
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
                                </table>
                            </form>
                        </div>
                    </div>";
                echo $html_animal;
            }
        }
    ?>
        }
    <footer>
        <ul>
            <li><img src="img/CLUBE DA ADOÇÃO-2.png" alt="logo Adote um pet"></li>
            <li>Mundo da Adoção é um programa criado para estreitar laços entre pessoas que têm o sonho de adotar um pet e nossas ONGs e protetores parceiros. Vamos juntos incentivar a adoção, conscientizar sobre a posse responsável e fomentar a cultura de doação em prol do bem-estar animal.</li>
        </ul>
    </footer>
</body>
</html>
