# Sistema de Instituição - Documentação Completa

## Visão Geral
Sistema completo de gerenciamento de instituições, endereços, departamentos e funcionários, desenvolvido com Laravel (backend), Vue.js (frontend) e MariaDB. Ambiente totalmente dockerizado com configuração otimizada para desenvolvimento e produção.

## Tecnologias Utilizadas
- **Backend**: Laravel 11 com API RESTful
- **Frontend**: Vue.js 3 + TypeScript + Composition API
- **Banco de Dados**: MariaDB 10.6
- **Containerização**: Docker & Docker Compose
- **Estilização**: CSS puro com layout responsivo unificado
- **Gerenciamento de Estado**: Pinia (Vue.js)
- **Roteamento**: Vue Router 4
- **Validação**: Laravel Form Requests + Frontend Validation
- **Notificações**: Toast system integrado

## Funcionalidades Implementadas

### 1. Cadastro de Instituições
- **Campos**: Nome longo (único), Nome curto (único)
- **Validações**: Unicidade de nomes, sem duplicatas
- **Interface**: Formulário simples com feedback visual
- **Ações**: Criar, editar, deletar com confirmação

### 2. Cadastro de Endereços
- **Campos**: Título (único por instituição), Cidade, Estado
- **Validações**: Título único por instituição, relacionamento obrigatório
- **Interface**: Seleção de instituição via dropdown dinâmico
- **Relacionamento**: Múltiplos endereços por instituição

### 3. Cadastro de Departamentos
- **Campos**: Nome (único por endereço), Instituição, Endereço
- **Validações**: Nome único por endereço, cascata de seleções
- **Interface**: Seleção dinâmica em cascata (instituição → endereço)
- **Relacionamento**: Departamento pertence a uma instituição e endereço

### 4. Registro de Funcionários
- **Campos obrigatórios**: Nome
- **Campos opcionais**: Instituição, Endereço, Departamento
- **Interface**: Seleção em cascata inteligente (instituição → endereço → departamento)
- **Filtros**: Carregamento dinâmico baseado em seleções anteriores

## Regras de Negócio Implementadas

### Unicidade de Dados
- **Instituição**: Nomes únicos no sistema
- **Endereço**: Título único por instituição (instituições diferentes podem ter endereços com mesmo nome)
- **Departamento**: Nome único por endereço (endereços diferentes podem ter departamentos com mesmo nome)

### Contagem de Registros
- **Instituição**: Contador azul mostrando quantas vezes é usada em registros
- **Endereço**: Contador azul mostrando quantas vezes é usado em registros  
- **Departamento**: Contador azul mostrando quantas vezes é usado em registros

### Sistema de Notificações
- **Sucesso**: Toast verde com mensagem apropriada
- **Erro**: Toast vermelho com mensagem detalhada
- **Validação**: Toast laranja para erros de validação
- **Confirmação**: Modais de confirmação para ações destrutivas

## Layout e Interface

### Estrutura de Páginas
1. **Home**: Dashboard inicial com navegação
2. **Cadastro**: CRUD completo de instituições, endereços e departamentos em interface unificada
3. **Registro**: CRUD completo de funcionários com seleção em cascata

### Barra Lateral Retrátil
- **Posição**: Esquerda fixa
- **Itens**: Home 🏠, Cadastro 📄, Registro 👤
- **Comportamento**: Retrátil suave com hover
- **Estilo**: Consistente em todas as resoluções
- **Ativo**: Indicador visual de página atual

### Cards de Exibição Hierárquicos

#### Estrutura Visual
```
Instituição Card
├── Cabeçalho: [Nome Instituição] [Editar] [Deletar] [Contador Registros]
├── Endereços
│   ├── Endereço Card
│   │   ├── Cabeçalho: [Nome Endereço] [Editar] [Deletar] [Contador Registros]
│   │   └── Departamentos
│   │       ├── Departamento Card
│   │       └── Cabeçalho: [Nome Departamento] [Editar] [Deletar] [Contador Registros]
```

### Responsividade Unificada
- **Remoção**: Todas as regras @media complexas
- **Padrão**: Layout flexível que se adapta naturalmente
- **Consistência**: Mesma experiência em 320px a 4K
- **Elementos**: Proporções fixas que escalam proporcionalmente

## API Endpoints Corrigidos

### Instituições
- `GET /api/instituicoes` - Listar todas
- `POST /api/instituicoes` - Criar nova
- `PUT /api/instituicoes/{id}` - Atualizar
- `DELETE /api/instituicoes/{id}` - Deletar

### Endereços
- `GET /api/enderecos` - Listar todos
- `GET /api/enderecos/instituicao/{id}` - Por instituição
- `POST /api/enderecos` - Criar novo
- `PUT /api/enderecos/{id}` - Atualizar
- `DELETE /api/enderecos/{id}` - Deletar

### Departamentos
- `GET /api/departamentos` - Listar todos
- `GET /api/departamentos/instituicao/{id}` - Por instituição
- `GET /api/departamentos/endereco/{id}` - Por endereço
- `POST /api/departamentos` - Criar novo
- `PUT /api/departamentos/{id}` - Atualizar
- `DELETE /api/departamentos/{id}` - Deletar

### Registros (Funcionários)
- `GET /api/registros` - Listar todos
- `POST /api/registros` - Criar novo
- `PUT /api/registros/{id}` - Atualizar
- `DELETE /api/registros/{id}` - Deletar

## Melhorias Recentes Implementadas

### 1. Correções de API
- ✅ Padronização de endpoints para consistência
- ✅ Correção de padrões de URL (removido "by-" desnecessário)
- ✅ Validação de unicidade no backend e frontend

### 2. Interface de Registro
- ✅ Título alterado de "Cadastro de Funcionários" para "Registrar"
- ✅ Botão "+ Novo Funcionário" movido para nova linha
- ✅ Botão renomeado de "+ Novo Funcionário" para "Adicionar"
- ✅ Layout responsivo mantido em todas as resoluções

### 3. Sistema de Notificações
- ✅ Toast system completamente integrado
- ✅ Mensagens personalizadas para cada ação
- ✅ Feedback visual imediato para usuários

### 4. Validações
- ✅ Frontend: Validação em tempo real
- ✅ Backend: Validação robusta com mensagens claras
- ✅ Tratamento de erros com feedback apropriado

## Comandos Docker

### Desenvolvimento
```bash
# Inicializar sistema completo
docker-compose down && docker-compose up --build -d

# Ver logs
docker-compose logs -f

# Acessar containers
docker-compose exec backend bash
docker-compose exec frontend bash
```

### Acesso aos Serviços
- **Frontend**: http://localhost:5173
- **Backend API**: http://localhost:8000
- **Banco de Dados**: localhost:3306

### Comandos Úteis
```bash
# Limpar e reconstruir
docker-compose down -v && docker-compose up --build -d

# Resetar banco de dados
docker-compose exec backend php artisan migrate:fresh --seed
```

## Estrutura de Diretórios
```
sistema_instituição/
├── backend/                    # Laravel 11 Backend
│   ├── app/Models/            # Eloquent Models
│   ├── app/Http/Controllers/ # API Controllers
│   ├── routes/api.php         # Rotas da API
│   ├── database/migrations/   # Migrations do banco
│   └── .env.example          # Configuração de ambiente
├── frontend/                   # Vue.js 3 Frontend
│   ├── src/views/            # Páginas principais
│   ├── src/components/       # Componentes Vue
│   ├── src/stores/          # Pinia stores
│   ├── src/services/        # Serviços de API
│   └── vite.config.ts       # Configuração Vite
├── docker-compose.yml        # Orquestração Docker
└── .trae/rules/             # Regras do projeto
    └── project_rules.md    # Este arquivo
```

## Status Final do Projeto
✅ **100% Funcional**
- Todas funcionalidades CRUD implementadas
- Validações de unicidade completas
- Sistema de notificações integrado
- Layout responsivo universal
- API endpoints padronizados
- Docker Compose operacional
- Documentação atualizada
- Testado e validado em ambiente Docker

✅ **Pronto para Produção**
- Configuração otimizada para containers
- Variáveis de ambiente configuradas
- Logs e monitoramento implementados
- Tratamento de erros robusto
- Interface intuitiva e amigável
