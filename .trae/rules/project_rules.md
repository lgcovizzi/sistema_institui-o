# Sistema de Instituição - Documentação Atualizada

## Visão Geral
Sistema completo de gerenciamento de instituições, endereços, departamentos e funcionários, desenvolvido com Laravel (backend), Vue.js (frontend) e MariaDB.

## Tecnologias Utilizadas
- **Backend**: Laravel 11
- **Frontend**: Vue.js 3 + TypeScript
- **Banco de Dados**: MariaDB
- **Containerização**: Docker & Docker Compose
- **Estilização**: CSS puro com layout responsivo unificado

## Funcionalidades Implementadas

### 1. Cadastro de Instituições
- **Campos**: Nome longo (único), Nome curto (único)
- **Exclusões**: Sem CNPJ, telefone ou email
- **Interface**: Formulário simples com validação de unicidade

### 2. Cadastro de Endereços
- **Campos**: Título (único por instituição), Cidade, Estado
- **Relacionamento**: Múltiplos endereços por instituição
- **Interface**: Seleção de instituição via dropdown

### 3. Cadastro de Departamentos
- **Campos**: Nome (único por endereço), Instituição, Endereço
- **Relacionamento**: Departamento pertence a uma instituição e endereço específico
- **Interface**: Seleção dinâmica de instituição e endereço

### 4. Cadastro de Funcionários
- **Campos obrigatórios**: Nome, Instituição, Endereço, Departamento
- **Campos opcionais**: Cargo, Horário de trabalho
- **Interface**: Seleção em cascata (instituição → endereço → departamento)

## Layout e Interface

### Estrutura de Páginas
1. **Home**: Dashboard inicial
2. **Cadastro Instituições**: CRUD completo de instituições
3. **Cadastro Funcionários**: CRUD completo de funcionários

### Barra Lateral Retrátil
- **Posição**: Esquerda da tela
- **Ícones**: Home 🏠, Cadastro Instituições 📄, Cadastro Funcionários 👤
- **Comportamento**: Retrátil com animação suave
- **Estilo**: Consistente em todas as resoluções

### Cards de Exibição

#### Instituições Cadastradas
- Nome da instituição
- Lista de endereços (interior)
- Lista de departamentos (interior dos endereços)
- Botões: Editar ✏️, Deletar ✖️

#### Endereços Cadastrados
- Título do endereço
- Cidade e estado
- Instituição vinculada
- Botões: Editar ✏️, Deletar ✖️

#### Departamentos Cadastrados
- Nome do departamento
- Instituição vinculada
- Endereço vinculado
- Botões: Editar ✏️, Deletar ✖️

#### Funcionários Cadastrados
- Nome do funcionário
- Instituição
- Endereço
- Departamento
- Cargo (quando preenchido)
- Horário de trabalho (quando preenchido)
- Botões: Editar ✏️, Deletar ✖️

## Melhorias de Layout Implementadas

### CSS Unificado
- **Remoção**: Todas as regras @media para tamanhos específicos
- **Padronização**: Mesmo layout para 1023px e qualquer tamanho
- **Consistência**: Elementos mantêm proporções independente da resolução

### Responsividade Simplificada
- Layout flexível que se adapta naturalmente
- Sem breakpoints complexos
- Experiência consistente em desktop, tablet e mobile

## Regras de Negócio

### Unicidade de Dados
- Nome curto da instituição: único no sistema
- Nome longo da instituição: único no sistema
- Título do endereço: único por instituição
- Nome do departamento: único por endereço

### Relacionamentos
- **Instituição** → **Endereços** (1:N)
- **Instituição** → **Departamentos** (1:N)
- **Endereço** → **Departamentos** (1:N)
- **Instituição** → **Funcionários** (1:N)
- **Endereço** → **Funcionários** (1:N)
- **Departamento** → **Funcionários** (1:N)

## Comandos Docker

### Inicialização do Sistema
```bash
docker-compose down && docker-compose up --build -d
```

### Acesso aos Serviços
- **Frontend**: http://localhost:5173
- **Backend**: http://localhost:8000
- **Banco de Dados**: localhost:3306

## Estrutura de Diretórios
```
sistema_instituição/
├── backend/          # Laravel backend
├── frontend/         # Vue.js frontend
├── docker-compose.yml
└── .trae/rules/
    └── project_rules.md
```

## Status do Projeto
✅ Sistema completamente funcional
✅ Todas as funcionalidades implementadas
✅ Layout padronizado para qualquer resolução
✅ Docker Compose configurado e operacional
✅ Banco de dados reinicializado
✅ Validações de unicidade implementadas
