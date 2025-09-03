# Esquema do Banco de Dados - Sistema de Instituição

## Visão Geral
Este documento descreve o esquema completo do banco de dados do Sistema de Instituição, incluindo tabelas, relacionamentos, índices e regras de negócio implementadas.

## Diagrama Entidade-Relacionamento

```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   instituições  │    │    endereços    │    │  departamentos  │    │    registros    │
├─────────────────┤    ├─────────────────┤    ├─────────────────┤    ├─────────────────┤
│ id (PK)         │1  N│ id (PK)         │1  N│ id (PK)         │1  N│ id (PK)         │
│ nome_longo      │────│ titulo          │────│ nome            │────│ nome            │
│ nome_curto      │    │ cidade          │    │ instituicao_id  │    │ instituicao_id  │
│ created_at      │    │ estado          │    │ endereco_id     │    │ endereco_id     │
│ updated_at      │    │ instituicao_id  │    │ created_at      │    │ departamento_id │
│                 │    │ created_at      │    │ updated_at      │    │ created_at      │
│                 │    │ updated_at      │    │                 │    │ updated_at      │
└─────────────────┘    └─────────────────┘    └─────────────────┘    └─────────────────┘
```

## Tabelas e Estrutura

### 1. Tabela `instituicoes`
**Descrição**: Armazena informações sobre instituições

| Coluna        | Tipo          | Restrições                      | Descrição                          |
|---------------|---------------|----------------------------------|------------------------------------|
| id            | BIGINT        | PRIMARY KEY, AUTO_INCREMENT     | Identificador único               |
| nome_longo    | VARCHAR(255)  | UNIQUE, NOT NULL                | Nome completo da instituição      |
| nome_curto    | VARCHAR(255)  | UNIQUE, NOT NULL                | Nome abreviado da instituição       |
| created_at    | TIMESTAMP     | DEFAULT CURRENT_TIMESTAMP       | Data de criação                   |
| updated_at    | TIMESTAMP     | DEFAULT CURRENT_TIMESTAMP       | Data da última atualização        |

**Índices**:
- PRIMARY KEY (`id`)
- UNIQUE KEY `instituicoes_nome_longo_unique` (`nome_longo`)
- UNIQUE KEY `instituicoes_nome_curto_unique` (`nome_curto`)

### 2. Tabela `enderecos`
**Descrição**: Armazena endereços vinculados às instituições

| Coluna         | Tipo          | Restrições                      | Descrição                          |
|----------------|---------------|----------------------------------|------------------------------------|
| id             | BIGINT        | PRIMARY KEY, AUTO_INCREMENT     | Identificador único               |
| titulo         | VARCHAR(255)  | NOT NULL                        | Título do endereço                |
| cidade         | VARCHAR(255)  | NOT NULL                        | Cidade do endereço                |
| estado         | VARCHAR(255)  | NOT NULL                        | Estado do endereço                |
| instituicao_id | BIGINT        | FOREIGN KEY, NOT NULL           | Referência para instituições      |
| created_at     | TIMESTAMP     | DEFAULT CURRENT_TIMESTAMP       | Data de criação                   |
| updated_at     | TIMESTAMP     | DEFAULT CURRENT_TIMESTAMP       | Data da última atualização        |

**Índices**:
- PRIMARY KEY (`id`)
- FOREIGN KEY (`instituicao_id`) REFERENCES `instituicoes` (`id`) ON DELETE CASCADE
- UNIQUE KEY `enderecos_titulo_instituicao_id_unique` (`titulo`, `instituicao_id`)

### 3. Tabela `departamentos`
**Descrição**: Armazena departamentos vinculados aos endereços

| Coluna         | Tipo          | Restrições                      | Descrição                          |
|----------------|---------------|----------------------------------|------------------------------------|
| id             | BIGINT        | PRIMARY KEY, AUTO_INCREMENT     | Identificador único               |
| nome           | VARCHAR(255)  | NOT NULL                        | Nome do departamento              |
| instituicao_id | BIGINT        | FOREIGN KEY, NOT NULL           | Referência para instituições      |
| endereco_id    | BIGINT        | FOREIGN KEY, NOT NULL           | Referência para endereços         |
| created_at     | TIMESTAMP     | DEFAULT CURRENT_TIMESTAMP       | Data de criação                   |
| updated_at     | TIMESTAMP     | DEFAULT CURRENT_TIMESTAMP       | Data da última atualização        |

**Índices**:
- PRIMARY KEY (`id`)
- FOREIGN KEY (`instituicao_id`) REFERENCES `instituicoes` (`id`) ON DELETE CASCADE
- FOREIGN KEY (`endereco_id`) REFERENCES `enderecos` (`id`) ON DELETE CASCADE
- UNIQUE KEY `departamentos_nome_endereco_id_unique` (`nome`, `endereco_id`)

### 4. Tabela `registros`
**Descrição**: Armazena registros de funcionários com vínculos institucionais

| Coluna          | Tipo          | Restrições                      | Descrição                          |
|-----------------|---------------|----------------------------------|------------------------------------|
| id              | BIGINT        | PRIMARY KEY, AUTO_INCREMENT     | Identificador único               |
| nome            | VARCHAR(255)  | NOT NULL                        | Nome do funcionário               |
| instituicao_id  | BIGINT        | FOREIGN KEY, NULL               | Referência opcional para instituições |
| endereco_id     | BIGINT        | FOREIGN KEY, NULL               | Referência opcional para endereços |
| departamento_id | BIGINT        | FOREIGN KEY, NULL               | Referência opcional para departamentos |
| created_at      | TIMESTAMP     | DEFAULT CURRENT_TIMESTAMP       | Data de criação                   |
| updated_at      | TIMESTAMP     | DEFAULT CURRENT_TIMESTAMP       | Data da última atualização        |

**Índices**:
- PRIMARY KEY (`id`)
- FOREIGN KEY (`instituicao_id`) REFERENCES `instituicoes` (`id`) ON DELETE SET NULL
- FOREIGN KEY (`endereco_id`) REFERENCES `enderecos` (`id`) ON DELETE SET NULL
- FOREIGN KEY (`departamento_id`) REFERENCES `departamentos` (`id`) ON DELETE SET NULL

## Relacionamentos

### 1. Instituições → Endereços
- **Tipo**: Um-para-muitos (1:N)
- **Descrição**: Uma instituição pode ter múltiplos endereços
- **On Delete**: CASCADE (quando uma instituição é deletada, seus endereços são deletados)

### 2. Instituições → Departamentos
- **Tipo**: Um-para-muitos (1:N)
- **Descrição**: Uma instituição pode ter múltiplos departamentos
- **On Delete**: CASCADE (quando uma instituição é deletada, seus departamentos são deletados)

### 3. Endereços → Departamentos
- **Tipo**: Um-para-muitos (1:N)
- **Descrição**: Um endereço pode ter múltiplos departamentos
- **On Delete**: CASCADE (quando um endereço é deletado, seus departamentos são deletados)

### 4. Instituições → Registros
- **Tipo**: Um-para-muitos (1:N)
- **Descrição**: Uma instituição pode ter múltiplos registros de funcionários
- **On Delete**: SET NULL (quando uma instituição é deletada, os registros mantêm-se com instituição_id = NULL)

### 5. Endereços → Registros
- **Tipo**: Um-para-muitos (1:N)
- **Descrição**: Um endereço pode ter múltiplos registros de funcionários
- **On Delete**: SET NULL (quando um endereço é deletado, os registros mantêm-se com endereco_id = NULL)

### 6. Departamentos → Registros
- **Tipo**: Um-para-muitos (1:N)
- **Descrição**: Um departamento pode ter múltiplos registros de funcionários
- **On Delete**: SET NULL (quando um departamento é deletado, os registros mantêm-se com departamento_id = NULL)

## Regras de Negócio Implementadas

### 1. Unicidade de Dados
- **instituicoes.nome_longo**: Deve ser único no sistema
- **instituicoes.nome_curto**: Deve ser único no sistema
- **enderecos.titulo**: Deve ser único por instituição (pode haver repetição entre instituições diferentes)
- **departamentos.nome**: Deve ser único por endereço (pode haver repetição entre endereços diferentes)

### 2. Integridade Referencial
- Todas as chaves estrangeiras possuem restrições de integridade
- Deleções em cascata para manter consistência dos dados
- Uso de SET NULL para preservar registros de funcionários quando estruturas são removidas

### 3. Campos Opcionais
- **registros.instituicao_id**: Permite NULL (funcionário sem vínculo institucional)
- **registros.endereco_id**: Permite NULL (funcionário sem endereço específico)
- **registros.departamento_id**: Permite NULL (funcionário sem departamento específico)

## Queries Úteis

### Contagem de Registros por Entidade
```sql
-- Contar quantos registros cada instituição possui
SELECT i.nome_longo, COUNT(r.id) as total_registros
FROM instituicoes i
LEFT JOIN registros r ON i.id = r.instituicao_id
GROUP BY i.id, i.nome_longo;

-- Contar quantos registros cada endereço possui
SELECT e.titulo, COUNT(r.id) as total_registros
FROM enderecos e
LEFT JOIN registros r ON e.id = r.endereco_id
GROUP BY e.id, e.titulo;

-- Contar quantos registros cada departamento possui
SELECT d.nome, COUNT(r.id) as total_registros
FROM departamentos d
LEFT JOIN registros r ON d.id = r.departamento_id
GROUP BY d.id, d.nome;
```

### Hierarquia Completa
```sql
-- Buscar todos os registros com hierarquia completa
SELECT 
    r.nome as funcionario,
    i.nome_longo as instituicao,
    e.titulo as endereco,
    d.nome as departamento
FROM registros r
LEFT JOIN instituicoes i ON r.instituicao_id = i.id
LEFT JOIN enderecos e ON r.endereco_id = e.id
LEFT JOIN departamentos d ON r.departamento_id = d.id
ORDER BY i.nome_longo, e.titulo, d.nome;
```

## Migrações Laravel

As tabelas são criadas através das seguintes migrações:
- `2024_01_01_000001_create_instituicoes_table.php`
- `2024_01_01_000002_create_enderecos_table.php`
- `2024_01_01_000003_create_departamentos_table.php`
- `2024_01_01_000004_create_registros_table.php`

## Considerações de Performance

### Índices
- Índices únicos garantem integridade dos dados
- Índices de chave estrangeira otimizam JOINs
- Índices compostos para regras de unicidade

### Integridade
- Uso de transações para operações complexas
- Validações em nível de banco de dados
- Constraints para garantir consistência

## Backup e Restore

### Exportar Dados
```bash
# Exportar todas as tabelas
mysqldump -u root -p sistema_instituicao > backup.sql

# Exportar apenas estrutura
mysqldump -u root -p --no-data sistema_instituicao > estrutura.sql
```

### Importar Dados
```bash
# Importar backup
mysql -u root -p sistema_instituicao < backup.sql
```