<?php
// feito quinta 9:30
// Conexão com o banco de dados
$servername = "localhost";
$username = "Renato";
$password = "AZincorreta2";
$dbname = "Escola";
$port = 3307;

// Criando a conexão
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Verificando a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verificando se os dados foram enviados via POST
if (isset($_POST['id']) && isset($_POST['nome']) && isset($_POST['idade']) && isset($_POST['email'])) {
    $id = (int)$_POST['id'];
    $nome = $conn->real_escape_string($_POST['nome']);
    $idade = (int)$_POST['idade'];
    $email = $conn->real_escape_string($_POST['email']);

    // Atualizando o aluno no banco de dados
    $updateQuery = "UPDATE alunos SET nome='$nome', idade=$idade, email='$email' WHERE id=$id";
    if ($conn->query($updateQuery) === TRUE) {
        header("Location: cadatro.php?status=sucesso"); // Redireciona com mensagem de sucesso
        exit();
    } else {
        header("Location: cadatro.php?status=erro"); // Redireciona com mensagem de erro
        exit();
    }
} else {
    header("Location: cadatro.php?status=erro"); // Redireciona se dados estiverem faltando
    exit();
}

// Fechando a conexão
$conn->close();
?>