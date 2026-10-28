# Calculadora Estequiométrica (EstequioLab) ⚗️🧪

Projeto completo de **Calculadora Estequiométrica e Tabela Periódica Interativa**, desenvolvido estritamente conforme as especificações e regras de negócio contidas no arquivo [`requisitos.md`](requisitos.md).

---

## 🎯 Objetivos do Projeto Atendidos

1. **Calculadora Estequiométrica Completa**:
   - Caixa de texto para adicionar a fórmula ou reação química com cálculo imediato ao lado.
   - **Balanceamento automático de equações químicas** com coeficientes estequiométricos inteiros mínimos.
   - Cálculo de todas as grandezas derivadas:
     - **Número de mols** ($n = m / M$)
     - **Massa estequiométrica** ($m = n \times M$)
     - **Volume molar nas CNTP** ($V = n \times 22,414\text{ L/mol}$)
     - **Número de partículas / moléculas** ($N = n \times 6,022 \times 10^{23}$)
     - **Titulação Ácido-Base** ($C_A \times V_A / a = C_B \times V_B / b$)
     - **Concentração molar e comum** ($M = n / V$ e $C = m / V$)
     - **Número de Oxidação (Nox)** detalhado para cada átomo na substância.

2. **Tabela Periódica Interativa IUPAC**:
   - Consulta integrada e acessível no topo do site.
   - Todos os 118 elementos químicos cadastrados com símbolos, massas atômicas, número atômico (Z), famílias, eletronegatividade, estados físicos, configurações eletrônicas e Nox.
   - Ao clicar em qualquer elemento, abre um **MODAL** rico com suas propriedades e a opção **"Adicionar à Fórmula"** ou **"Copiar Símbolo"**.
   - Filtros dinâmicos por famílias (Metais Alcalinos, Alcalinoterrosos, Transição, Halogênios, Gases Nobres, Lantanídeos, Actinídeos, etc.) e busca em tempo real.

3. **Duplo Sistema de Explicações Didáticas**:
   - **Explicação Objetiva / Técnica**: Passo a passo com rigor acadêmico, proporções estequiométricas molares, regras de três detalhadas e unidades (g, mol, L, partículas).
   - **Explicação para Crianças de até 11 anos**: Linguagem lúdica, afetuosa e visual (analogias divertidas com peças de LEGO, receitas de bolo e personagens mágicos onde nenhuma pecinha se perde).

4. **Fontes e Referências Confiáveis da Internet**:
   - Rodapé com links diretos para as referências oficiais: IUPAC Gold Book, Sociedade Brasileira de Química (SBQ), Brasil Escola, Khan Academy e Toda Matéria.

---

## 💻 Stack Tecnológica & Regras Globais

- **Backend**: PHP estruturado com sessões nativas (`session_start()`, `$_SESSION`).
- **Banco de Dados**: MySQL com **PDO** e *Prepared Statements* em todas as operações para garantia total contra *SQL Injections*.
- **Criptografia & Segurança**: Senhas tratadas exclusivamente com hash **Bcrypt** (`password_hash($senha, PASSWORD_BCRYPT)` e `password_verify`).
- **Regra de E-mail Único**: Verificação em tempo de execução e restrição `UNIQUE` no banco de dados.
- **Frontend**: HTML5, PHP, CSS3 e **Tailwind CSS** priorizando o conceito **Mobile-First**.
- **Mensagens & Modais**:
  - Mensagens de sucesso e erro apresentadas em notificações **TOAST** customizadas.
  - Alertas e confirmações nativas do navegador (`alert`, `confirm`) substituídas pelo componente **MODAL** do sistema.
- **Logs e Auditoria**:
  - Tabela `logs_auditoria` mantendo registros cronológicos de todas as operações (cadastro, logins bem-sucedidos, tentativas inválidas, logout, cálculos executados e exclusões de histórico).
- **Acesso Aberto com Histórico Restrito**:
  - Qualquer visitante pode utilizar todas as ferramentas e cálculos livremente sem cadastro.
  - O histórico permanente no banco de dados é ativado para usuários cadastrados e autenticados.

---

## 📁 Estrutura de Arquivos Modular

```
Calculadora-de-Estequiometrica/
├── config/
│   ├── bd.php                # Conexão PDO segura com MySQL + auto-criação de schema
│   └── config.php            # Constantes da aplicação, sessão nativa e logs de auditoria
├── database/
│   └── schema.sql            # Script SQL de criação das tabelas (usuarios, historico, logs)
├── backend/
│   ├── auth/
│   │   ├── login.php         # Autenticação segura, validação Bcrypt e log de auditoria
│   │   ├── register.php      # Cadastro com e-mail único, hash Bcrypt e log de auditoria
│   │   └── logout.php        # Destruição segura de sessão e log de saída
│   ├── calcular.php          # Gravação de cálculos e auditoria via PDO
│   └── historico_actions.php # Exclusão individual ou total com confirmação em modal
├── includes/
│   ├── header.php            # Navbar responsiva Mobile-First com dark mode e menu
│   ├── footer.php            # Rodapé completo com links e referências científicas da internet
│   ├── toast.php             # Container e template do sistema de TOASTS
│   └── modal.php             # Modais de confirmação, avisos e detalhes de elementos
├── assets/
│   ├── css/
│   │   └── style.css         # Estilizações complementares da tabela periódica e animações
│   └── js/
│       ├── periodic-table.js # Banco de dados dos 118 elementos químicos IUPAC e interações
│       ├── stoichiometry.js  # Motor químico (parser de fórmulas, balanceamento, massas, Nox)
│       └── app.js            # Controle dos toats, modais, tema escuro e requisições
├── views/
│   ├── index.php             # Página principal com calculadora e explicações duplas
│   ├── tabela-periodica.php  # Página dedicada da Tabela Periódica interativa
│   ├── historico.php         # Página de histórico permanente com proteção de login
│   ├── auditoria.php         # Visualizador de logs de auditoria do sistema
│   ├── login.php             # Interface de login responsiva
│   └── registro.php          # Interface de cadastro com e-mail único
├── demo.html                 # Versão Standalone 100% autônoma (abra direto no navegador)
├── index.php                 # Redirecionador para views/index.php
├── requisitos.md             # Especificação e requisitos originais do projeto
└── README.md                 # Documentação técnica do projeto
```

---

## 🚀 Como Executar

### Opção 1: Visualização Imediata (Sem Servidor / Standalone)
Basta dar dois cliques no arquivo:
👉 **`demo.html`**
Ele abrirá diretamente em seu navegador (Google Chrome, Microsoft Edge, Firefox, etc.) com todos os cálculos, tabela periódica, balanceamento, modos de explicação e histórico local funcionando em 1 clique!

### Opção 2: Servidor PHP & MySQL (XAMPP / WAMP / Laragon)
1. Certifique-se de que o **Apache** e o **MySQL** estejam ativos no XAMPP ou servidor local.
2. No painel do phpMyAdmin ou terminal MySQL, importe o arquivo:
   `database/schema.sql`
   *(O script cria o banco `calculadora_estequiometrica` e todas as tabelas com integridade referencial).*
3. Coloque a pasta do projeto em seu diretório web (`htdocs` ou `www`).
4. Acesse pelo navegador:
   `http://localhost/Calculadora-de-Estequiometrica/`

### Opção 3: Servidor Embutido do PHP CLI
No prompt de comando ou PowerShell dentro da pasta do projeto:
```bash
php -S localhost:8000
```
Em seguida, abra: `http://localhost:8000/views/index.php`
