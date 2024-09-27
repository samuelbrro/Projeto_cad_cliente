<?php
$host = 'localhost';
$dbname = 'cadastro_db';
$user = 'root';
$password = '';

// Verifica se o método de requisição é POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Conexão com o banco de dados
    try {
        // Cria uma nova conexão PDO para MySQL
        $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Sanitiza e valida os dados do formulário
        $name = htmlspecialchars(trim($_POST['name'])); // Sanitiza o nome
        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL); // Sanitiza o email

        // Verifica se o email é válido
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Email inválido.');
        }

        // Verificação se o email já existe
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo "Email já cadastrado!";
            exit();
        }

        // Valida a senha
        $password = $_POST['password']; // Recebe a senha sem alteração
        if (strlen($password) < 8) {
            throw new Exception('A senha deve conter pelo menos 8 caracteres.');
        }

        // Insere o novo usuário no banco de dados
        $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (:name, :email, :password)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bindParam(':password', $passwordHash);

        if ($stmt->execute()) {
            echo "Usuário cadastrado com sucesso!";
        } else {
            echo "Erro ao cadastrar usuário.";
        }
    } catch(PDOException $e) {
        echo 'Erro: ' . $e->getMessage();
    } catch(Exception $e) {
        echo 'Erro: ' . $e->getMessage();
    }
} else {
    echo 'Método de requisição não permitido.';
}
?>
