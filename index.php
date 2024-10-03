<?php
// feito 9:13

// Conexão com o banco de dados
$servername = "localhost";
$username = "Renato";
$password = "AZincorreta2";
$dbname = "Escola";
$port= 3307;

// Criando a conexão
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Verificando a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Inicializando a variável de pesquisa
$searchTerm = '';

// Verificando se há uma mensagem de status na URL
$statusMessage = '';
if (isset($_GET['status'])) {
    switch ($_GET['status']) {
        case 'success':
            $statusMessage = "<p class='success'>Aluno cadastrado com sucesso!</p>";
            break;
        case 'error':
            $statusMessage = "<p class='error'>Ocorreu um erro. Tente novamente.</p>";
            break;
    }
}

// Processar o cadastro de um novo aluno
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cadastro'])) {
    // Coletando os dados do formulário
    $nome = $conn->real_escape_string($_POST['nome']);
    $idade = (int)$_POST['idade']; // Convertendo para inteiro
    $email = $conn->real_escape_string($_POST['email']);
    $curso = $conn->real_escape_string($_POST['curso']);

    // Inserindo o aluno no banco de dados
    $insertQuery = "INSERT INTO alunos (nome, idade, email, curso) VALUES ('$nome', $idade, '$email', '$curso')";
    if ($conn->query($insertQuery) === TRUE) {
        header("Location: cadatro.php?status=success"); // Redireciona com mensagem de sucesso
        exit();
    } else {
        header("Location: cadatro.php?status=error"); // Redireciona com mensagem de erro
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Aluno</title>
    <link rel="stylesheet" href="style.css"> <!-- Link para o arquivo CSS -->
    <style>
      /* feito quinta 10:19


      
/* Reset básico para garantir consistência entre navegadores */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Arial', sans-serif;
    background-color: #020101;
    color: #f0f0f0;
    line-height: 1.6;
}

.container {
    max-width: 600px;
    margin: 50px auto;
    background-color: #242121;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(78, 63, 63, 0.1);
}

h2 {
    text-align: center;
    color: #bbbbbb;
    margin-bottom: 20px;
}

form {
    display: flex;
    flex-direction: column;
}

.form-group {
    margin-bottom: 15px;
}

label {
    font-size: 14px;
    color: #555;
    margin-bottom: 5px;
}

input[type="text"],
input[type="email"],
input[type="number"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
}

button[type="submit"] {
    padding: 12px;
    background-color: #af5d19;
    color: white;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button[type="submit"]:hover {
    background-color: #9c2d0b;
}

/* Mensagens de status */
.success {
    color: #28a745;
    text-align: center;
    margin-top: 10px;
}

.error {
    color: #dc3545;
    text-align: center;
    margin-top: 10px;
}

/* Link para lista de alunos */
a {
    display: block;
    text-align: center;
    text-decoration: none;
    color: #007bff;
    margin-top: 20px;
    font-size: 16px;
}

a:hover {
    text-decoration: underline;
}
    </style>
</head>
<body>
    <div class="container">
        <h2>Cadastro de Aluno</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="curso">Curso:</label>
                <input type="text" id="curso" name="curso" required>
            </div>
            <div class="form-group">
                <label for="idade">Idade:</label>
                <input type="number" id="idade" name="idade" required>
            </div>
            <button type="submit" name="cadastro">Cadastrar</button>
        </form>

        <?php echo $statusMessage; // Exibir mensagem de status ?>

        <h2><a href="cadatro.php">Lista de Alunos Cadastrados</a></h2>
    </div>
</body>
</html>

<?php
// Fechando a conexão
$conn->close();
?>