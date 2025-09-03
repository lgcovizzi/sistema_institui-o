# Sistema de Instituição - Gestão Completa

Sistema completo de gerenciamento de instituições, endereços, departamentos e funcionários desenvolvido com tecnologias modernas e arquitetura escalável.

## 🚀 Visão Geral

Sistema robusto para gestão hierárquica de instituições com relacionamentos complexos entre instituições, endereços, departamentos e funcionários. Desenvolvido com foco em usabilidade, performance e manutenibilidade.

## 🛠️ Tecnologias Utilizadas

### Backend
- **Laravel 11** - Framework PHP moderno e robusto
- **MariaDB 10.6** - Banco de dados relacional de alta performance
- **API RESTful** - Arquitetura de serviços web
- **Eloquent ORM** - Mapeamento objeto-relacional avançado

### Frontend
- **Vue.js 3** - Framework JavaScript reativo
- **TypeScript** - Superset tipado do JavaScript
- **Composition API** - API moderna do Vue 3
- **Pinia** - Gerenciamento de estado moderno
- **Vue Router 4** - Sistema de roteamento
- **Vite** - Build tool ultrarrápida

### Infraestrutura
- **Docker & Docker Compose** - Containerização completa
- **PHP 8.3** - Versão mais recente do PHP
- **Node.js 20** - Ambiente JavaScript moderno

## 📋 Funcionalidades Implementadas

### 1. Cadastro de Instituições ✅
- **Campos**: Nome longo (único), Nome curto (único)
- **Validações**: Unicidade garantida, prevenção de duplicatas
- **Interface**: Formulário intuitivo com feedback visual
- **Ações**: CRUD completo com confirmações de segurança

### 2. Cadastro de Endereços ✅
- **Campos**: Título (único por instituição), Cidade, Estado
- **Validações**: Título único por instituição, relacionamento obrigatório
- **Interface**: Seleção dinâmica de instituições via dropdown
- **Relacionamento**: Múltiplos endereços por instituição

### 3. Cadastro de Departamentos ✅
- **Campos**: Nome (único por endereço), Instituição, Endereço
- **Validações**: Nome único por endereço, validação em cascata
- **Interface**: Seleção em cascata inteligente
- **Relacionamento**: Departamento pertence a instituição e endereço

### 4. Registro de Funcionários ✅
- **Campos obrigatórios**: Nome
- **Campos opcionais**: Instituição, Endereço, Departamento
- **Interface**: Seleção em cascata inteligente
- **Filtros**: Carregamento dinâmico baseado em seleções

## 🔐 Regras de Negócio

### Unicidade de Dados
- **Instituição**: Nomes únicos no sistema inteiro
- **Endereço**: Título único por instituição
- **Departamento**: Nome único por endereço

### Contadores Inteligentes
- Contadores azuis mostrando uso em registros
- Feedback visual sobre relacionamentos ativos
- Prevenção de exclusão acidental

### Sistema de Notificações
- **Sucesso**: Toast verde com mensagens claras
- **Erro**: Toast vermelho com detalhes do problema
- **Validação**: Toast laranja para erros de formulário
- **Confirmação**: Modais de segurança para exclusões

## 🎨 Interface e Experiência

### Layout Responsivo Universal
- **Remoção**: Todas as regras @media complexas
- **Padrão**: Layout flexível que se adapta naturalmente
- **Consistência**: Mesma experiência de 320px a 4K
- **Elementos**: Proporções fixas que escalam proporcionalmente

### Barra Lateral Retrátil
- **Posição**: Fixa na esquerda
- **Itens**: Home 🏠, Cadastro 📄, Registro 👤
- **Comportamento**: Suave com hover
- **Ativo**: Indicador visual de página atual

### Cards Hierárquicos
```
Instituição
├── Endereço 1
│   ├── Departamento 1
│   └── Departamento 2
├── Endereço 2
│   └── Departamento 3
└── ...
```

## 🚀 Instalação e Execução

### Pré-requisitos
- Docker e Docker Compose instalados
- Portas 5173, 8000 e 3306 disponíveis

### Comandos de Instalação

```bash
# Clonar repositório
git clone [repositorio-url]
cd sistema_instituição

# Inicializar sistema completo
docker-compose down && docker-compose up --build -d

# Verificar status
docker-compose ps

# Ver logs
docker-compose logs -f
```

### Acesso aos Serviços
- **Frontend**: http://localhost:5173
- **Backend API**: http://localhost:8000
- **Banco de Dados**: localhost:3306

### Comandos Úteis

```bash
# Resetar banco de dados
docker-compose exec backend php artisan migrate:fresh --seed

# Acessar containers
docker-compose exec backend bash
docker-compose exec frontend bash

# Limpar e reconstruir tudo
docker-compose down -v && docker-compose up --build -d
```

## 📊 API Endpoints

### Instituições
```
GET    /api/instituicoes
POST   /api/instituicoes
PUT    /api/instituicoes/{id}
DELETE /api/instituicoes/{id}
```

### Endereços
```
GET    /api/enderecos
GET    /api/enderecos/instituicao/{id}
POST   /api/enderecos
PUT    /api/enderecos/{id}
DELETE /api/enderecos/{id}
```

### Departamentos
```
GET    /api/departamentos
GET    /api/departamentos/instituicao/{id}
GET    /api/departamentos/endereco/{id}
POST   /api/departamentos
PUT    /api/departamentos/{id}
DELETE /api/departamentos/{id}
```

### Registros (Funcionários)
```
GET    /api/registros
POST   /api/registros
PUT    /api/registros/{id}
DELETE /api/registros/{id}
```

## 🏗️ Estrutura de Diretórios

```
sistema_instituição/
├── backend/                    # Laravel 11 Backend
│   ├── app/Models/            # Eloquent Models
│   ├── app/Http/Controllers/ # API Controllers
│   ├── routes/api.php         # Rotas da API
│   ├── database/migrations/   # Migrations
│   └── .env.example          # Configuração
├── frontend/                   # Vue.js 3 Frontend
│   ├── src/views/            # Páginas principais
│   ├── src/components/       # Componentes Vue
│   ├── src/stores/          # Pinia stores
│   ├── src/services/        # Serviços de API
│   └── vite.config.ts       # Configuração Vite
├── docker-compose.yml        # Orquestração Docker
└── README.md               # Este arquivo
```

## 🎯 Status do Projeto

### ✅ Funcionalidades Completas
- [x] CRUD completo de instituições
- [x] CRUD completo de endereços
- [x] CRUD completo de departamentos
- [x] CRUD completo de funcionários
- [x] Validações de unicidade
- [x] Sistema de notificações
- [x] Layout responsivo universal
- [x] API RESTful padronizada
- [x] Docker Compose completo
- [x] Documentação técnica

### ✅ Pronto para Produção
- [x] Configuração otimizada para containers
- [x] Variáveis de ambiente configuradas
- [x] Logs e monitoramento
- [x] Tratamento de erros robusto
- [x] Interface intuitiva
- [x] Performance otimizada

## 📞 Suporte e Contribuição

Para reportar problemas ou sugerir melhorias:
1. Abra uma issue no repositório
2. Descreva detalhadamente o problema
3. Inclua logs e passos para reprodução

## 📄 Licença

Este projeto está sob a licença MIT. Veja o arquivo LICENSE para mais detalhes.

---

Desenvolvido com ❤️ para gestão eficiente de instituições educacionais e corporativas.