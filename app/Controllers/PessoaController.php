<?php

class PessoaController
{
    private PDO $pdo;

    public function __construct()
    {
        require __DIR__ . '/../../config/database.php';
        $this->pdo = $pdo;
    }

    public function listar(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        $sql = 'SELECT
                    id,
                    nome,
                    cpf,
                    telefone,
                    email,
                    data_nascimento,
                    criado_em
                FROM pessoas
                ORDER BY id DESC';

        $stmt = $this->pdo->query($sql);
        $pessoas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(
            $pessoas,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );
    }

    public function incluir(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        $nome            = trim($_POST['nome'] ?? '');
        $cpf             = trim($_POST['cpf'] ?? '');
        $telefone        = trim($_POST['telefone'] ?? '');
        $email           = trim($_POST['email'] ?? '');
        $dataNascimento  = trim($_POST['data_nascimento'] ?? '');

        if ($nome === '') {
            http_response_code(400);

            echo json_encode([
                'erro' => 'Nome é obrigatório.'
            ]);

            return;
        }

        if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);

            echo json_encode([
                'erro' => 'E-mail inválido.'
            ]);

            return;
        }

        try {
            $sql = 'INSERT INTO pessoas (
                        nome,
                        cpf,
                        telefone,
                        email,
                        data_nascimento
                    ) VALUES (
                        :nome,
                        :cpf,
                        :telefone,
                        :email,
                        :data_nascimento
                    )';

            $stmt = $this->pdo->prepare($sql);

            $stmt->bindValue(':nome', $nome);
            $stmt->bindValue(':cpf', $cpf ?: null);
            $stmt->bindValue(':telefone', $telefone ?: null);
            $stmt->bindValue(':email', $email ?: null);
            $stmt->bindValue(
                ':data_nascimento',
                $dataNascimento ?: null
            );

            $stmt->execute();

            http_response_code(201);

            echo json_encode([
                'mensagem' => 'Pessoa cadastrada com sucesso.',
                'id'       => $this->pdo->lastInsertId()
            ], JSON_UNESCAPED_UNICODE);
        } catch (PDOException $e) {
            http_response_code(500);

            echo json_encode([
                'erro' => 'Erro ao cadastrar pessoa.'
            ]);
        }
    }
}
```
