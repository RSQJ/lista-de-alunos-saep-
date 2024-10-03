<?php
// feito 9:20

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
if (isset($_POST['search'])) {
    $searchTerm = $conn->real_escape_string($_POST['search']); // Sanitizando a entrada
}

// Consultando os alunos cadastrados, com filtro por nome ou curso
$query = "SELECT * FROM alunos WHERE nome LIKE '%$searchTerm%' OR curso LIKE '%$searchTerm%'";
$result = $conn->query($query);

// Verificando se há uma mensagem de status na URL
$statusMessage = '';
if (isset($_GET['status'])) {
    switch ($_GET['status']) {
        case 'deleted':
            $statusMessage = "<p class='success'>Aluno excluído com sucesso!</p>";
            break;
        case 'error':
            $statusMessage = "<p class='error'>Ocorreu um erro. Tente novamente.</p>";
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Alunos</title>
    <link rel="stylesheet" href="CSS\cad.css"> <!-- Link para o arquivo CSS -->
    <style>

    /* feito quinta 11:09

/* Reset básico para margens e preenchimentos */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Estilização do corpo */
body {
    font-family: Arial, sans-serif;
    background-color: #080707;
    color: #333;
}

/* Container principal */
.container {
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    background-color: rgb(95, 89, 89);
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

/* Título */
h2 {
    text-align: center;
    color: #ffefef;
}

/* Formulário de pesquisa */
form {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
}

input[type="text"] {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    width: 70%;
    margin-right: 10px;
}

button {
    padding: 10px 15px;
    border: none;
    background-color: #4CAF50;
    color: white;
    border-radius: 4px;
    cursor: pointer;
}

button:hover {
    background-color: #45a049;
}

/* Estilização da tabela */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

th {
    background-color: #f2f2f2;
}

/* Estilo das mensagens de status */
.success {
    color: green;
    text-align: center;
}

.error {
    color: red;
    text-align: center;
}

/* Links de edição e exclusão */
.edit-link, .delete-link {
    padding: 5px 10px;
    border-radius: 4px;
    text-decoration: none;
}

.edit-link {
    background-color: #2196F3;
    color: white;
}

.edit-link:hover {
    background-color: #1976D2;
}

.delete-link {
    background-color: #f44336;
    color: white;
    margin-left: 10px;
}

.delete-link:hover {
    background-color: #d32f2f;
}

/* Link para cadastrar novo aluno */
h2 a {
    text-decoration: none;
    color: #af5d19;
    display: block;
    text-align: center;
    margin-top: 20px;
}
    </style>
</head>
<body>
    <div class="container">
        <h2>Lista de Alunos Cadastrados</h2>

        <?php echo $statusMessage; // Exibir mensagem de status ?>

        <!-- Formulário de pesquisa -->
        <form method="POST" action="">
            <input type="text" name="search" placeholder="Pesquisar por nome ou curso" value="<?php echo htmlspecialchars($searchTerm); ?>">
            <button type="submit">Pesquisar</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Idade</th>
                    <th>Email</th>
                    <th>Curso</th>
                   
                </tr>
            </thead>
            <tbody>
                <?php
                // Listando os alunos cadastrados
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['nome']}</td>
                                <td>{$row['idade']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['curso']}</td>
                                <td>
                                    <a href='editar.php?id={$row['id']}' class='edit-link'>Editar</a>
                                    <a href='deletar.php?id={$row['id']}' class='delete-link'>Excluir</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>Nenhum aluno encontrado.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <h2><a href="index.php">Cadastrar Novo Aluno</a></h2>
    </div>
</body>
</html>

<?php
// Fechando a conexão
$conn->close();
?>
<?php
$aluno = null;

// Verificando se o ID do aluno foi fornecido
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Consultando os dados do aluno
    $query = "SELECT * FROM alunos WHERE id = $id";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $aluno = $result->fetch_assoc();
    }
}

// Processar a atualização do aluno
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['atualizar'])) {
    $nome = $conn->real_escape_string($_POST['nome']);
    $email = $conn->real_escape_string($_POST['email']);
    $curso = $conn->real_escape_string($_POST['curso']);
    $idade = (int)$_POST['idade'];

    $updateQuery = "UPDATE alunos SET nome='$nome', email='$email', curso='$curso', idade=$idade WHERE id=$id";
    if ($conn->query($updateQuery) === TRUE) {
        header("Location: cadatro.php?status=success"); // Redireciona com mensagem de sucesso
        exit();
    } else {
        header("Location: cadatro.php?status=error"); // Redireciona com mensagem de erro
        exit();
    }
}
?>

