
<?php
class Database {
    private $host;
    private $db;
    private $user;
    private $pass;
    private $port;
    private $pdo;

    // feito a conexão 8:43 
    public function __construct($host, $db, $user, $port) {
        $this->host = $host;
        $this->db = $db;
        $this->user = $user;
        $this->port = $port;
    }

    // Função para conectar ao banco de dados
    public function connect() {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->db};port={$this->port};charset=utf8";
            $this->pdo = new PDO($dsn, $this->user, $this->pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erro na conexão com o banco de dados: " . $e->getMessage());
        }
    }

    // Retorna a conexão PDO
    public function getConnection() {
        return $this->pdo;
    }
}
?>