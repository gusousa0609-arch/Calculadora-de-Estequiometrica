-- Schema SQL para o Banco de Dados: calculadora_estequiometrica
-- Criado para MySQL com suporte a UTF8MB4 e integridade referencial

CREATE DATABASE IF NOT EXISTS `calculadora_estequiometrica` 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE `calculadora_estequiometrica`;

-- Tabela de Usuários
CREATE TABLE IF NOT EXISTS `usuarios` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nome` VARCHAR(120) NOT NULL,
    `email` VARCHAR(180) NOT NULL UNIQUE,
    `senha` VARCHAR(255) NOT NULL,
    `criado_em` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `atualizado_em` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_usuario_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela de Histórico de Cálculos Estequiométricos
-- Usuários não cadastrados podem calcular livremente, mas registros vinculados exigem usuário
CREATE TABLE IF NOT EXISTS `historico_calculos` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `usuario_id` INT NOT NULL,
    `tipo_calculo` VARCHAR(60) NOT NULL, -- Ex: 'estequiometria', 'massa_molar', 'titulacao', 'concentracao', 'nox', 'gases'
    `entrada_formula` TEXT NOT NULL,
    `parametros_entrada` JSON NULL,
    `resultado_resumo` TEXT NOT NULL,
    `resultado_completo` JSON NULL,
    `criado_em` DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_historico_usuario` FOREIGN KEY (`usuario_id`) 
        REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
    INDEX `idx_historico_usuario_data` (`usuario_id`, `criado_em`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela de Logs de Auditoria do Sistema
-- Registra todas as ações importantes (Login, Cadastro, Logout, Cálculos, Alterações de Perfil, etc.)
CREATE TABLE IF NOT EXISTS `logs_auditoria` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `usuario_id` INT NULL, -- NULL quando a ação for anônima ou tentativa de login inválida
    `acao` VARCHAR(80) NOT NULL, -- Ex: 'LOGIN_SUCESSO', 'LOGIN_FALHA', 'CADASTRO', 'CALCULO_REALIZADO', 'LOGOUT'
    `detalhes` TEXT NULL,
    `ip_address` VARCHAR(45) NULL,
    `user_agent` VARCHAR(255) NULL,
    `criado_em` DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_logs_usuario` FOREIGN KEY (`usuario_id`) 
        REFERENCES `usuarios` (`id`) ON DELETE SET NULL,
    INDEX `idx_logs_acao_data` (`acao`, `criado_em`),
    INDEX `idx_logs_usuario` (`usuario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
