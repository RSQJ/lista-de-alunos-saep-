<?php
// feito na quinta 9:23
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

// Verificando se o ID do aluno foi fornecido
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Obtendo os dados atuais do aluno
    $selectQuery = "SELECT * FROM alunos WHERE id = $id";
    $result = $conn->query($selectQuery);

    if ($result->num_rows > 0) {
        $aluno = $result->fetch_assoc();
    } else {
        echo "Aluno não encontrado.";
        exit();
    }
} else {
    echo "ID do aluno não foi fornecido.";
    exit();
}

// Fechando a conexão
$conn->close();
?>

<!-- Formulário HTML para editar o aluno -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Aluno</title>
</head>
<body>
    <h2>Editar Aluno</h2>
    <form action="update.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $aluno['id']; ?>">
        Nome: <input type="text" name="nome" value="<?php echo $aluno['nome']; ?>"><br>
        Idade: <input type="number" name="idade" value="<?php echo $aluno['idade']; ?>"><br>
        Email: <input type="email" name="email" value="<?php echo $aluno['email']; ?>"><br>
        <input type="submit" value="Atualizar">
        <link rel="stylesheet" href="editar.css"> <!-- Link para o arquivo CSS -->
        <style>
 /* feito quinta 11:01


 
/* Reset básico para margens e preenchimentos */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Estilização do corpo */
body {
    font-family: Arial, sans-serif;
    background-color: #020101;
    color: #f0f0f0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

/* Container do formulário */
.container {
    max-width: 400px;
    padding: 20px;
    background-color: #6b4d4d;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(78, 63, 63, 0.1);
}

/* Título do formulário */
h2 {
    text-align: center;
    color: #ffefef;
    margin-bottom: 20px;
}

/* Estilo do formulário */
form {
    display: flex;
    flex-direction: column;
}

/* Estilo dos campos do formulário */
input[type="text"],
input[type="number"],
input[type="email"],
input[type="submit"] {
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

/* Estilo do botão de submit */
input[type="submit"] {
    background-color: #af5d19;
    color: white;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #9c2d0b;
}
        </style>

    </form>
</body>
</html>