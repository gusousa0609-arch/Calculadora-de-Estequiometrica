<?php
/**
 * Arquivo de Conexão com o Banco de Dados MySQL via PDO
 * Segue boas práticas de segurança, prepared statements e prevenção a SQL Injection.
 */

require_once __DIR__ . '/config.php';

function getDbConnection(): ?PDO {
    static $pdo = null;

    if ($pdo !== null) {
        return $pdo;
    }

    $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false, // Garante que a emulação de prepared statements esteja desativada
    ];

    try {
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        return $pdo;
    } catch (PDOException $e) {
        // Tenta criar o banco de dados caso não exista (útil para primeiro setup no XAMPP/WAMP)
        if ($e->getCode() === 1049) {
            try {
                $rootDsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";charset=utf8mb4";
                $tempPdo = new PDO($rootDsn, DB_USER, DB_PASS, $options);
                $tempPdo->exec("CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                
                // Conecta novamente com o banco recém-criado
                $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
                
                // Executa a criação inicial das tabelas
                $schemaFile = __DIR__ . '/../database/schema.sql';
                if (file_exists($schemaFile)) {
                    $sql = file_get_contents($schemaFile);
                    $pdo->exec($sql);
                }
                return $pdo;
            } catch (Exception $initEx) {
                error_log("Falha na auto-inicialização do banco: " . $initEx->getMessage());
            }
        }
        
        error_log("Erro de conexão PDO: " . $e->getMessage());
        return null;
    }
}
