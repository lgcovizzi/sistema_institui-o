# Sistema de Instituição - Documentação Atualizada
vc está em um ambiente dockerizado, faça tudo dentro do container.
nginx use o padrão do laravel
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

uma instituição pode ter multiplos endereços e cada endereço pode ter multiplos departamentos
o endereço pertence a uma instituição eo endereço deve ser único na instituição

porém quando houver outra instituição com nome diferente essa instiuição pode ter o mesmo nome de endereço. 
não pode haver dois endereços com o mesmo nome na mesma instituição.
cada endereço pode ter apenas um departamento com o mesmo nome.
cada departamento pode ter apenas um endereço com o mesmo nome.



### 4. Registro
- **Campos obrigatórios**: Nome, 
- **Campos opcionais**: Instituição, Endereço, Departamento
- **Interface**: Seleção em cascata (instituição → endereço → departamento)

## Layout e Interface

### Estrutura de Páginas
1. **Home**: Dashboard inicial
2. **Cadastro Cadastro**: CRUD completo de instituições, endereços e departamentos
3. **Cadastro Registro**: CRUD completo com campos nome, instituição, endereço, departamento

### Barra Lateral Retrátil
- **Posição**: Esquerda da tela
- **Ícones**: Home 🏠, Cadastro Instituições 📄, Cadastro Funcionários 👤
- **Comportamento**: Retrátil com animação suave
- **Estilo**: Consistente em todas as resoluções

### Cards de Exibição

#### Instituições Cadastradas

mostra um card para cada instituição este card contem um cabeçalho com o nome da istituição, um botão de editar e um botão de deletar.
dentro do card mostra um cabeçalho com o nome do endereço, um botão de editar e um botão de deletar.
dentro do cabeçalho do endereço mostra um cabeçalho com o nome do departamento, um botão de editar e um botão de deletar.
dentro do cabeçalho do departamento mostra um cabeçalho com o nome do departamento, um botão de editar e um botão de deletar.

do lado direito do cabeçalho do instituição mostra botão em uma caixa azul que conta quantas vezes a instituição foi utilizda no registro
do lado direito do cabeçalho do endereço mostra botão em uma caixa azul que conta quantas vezes o endereço foi utilizdo no registro
do lado direito do cabeçalho do departamento mostra botão em uma caixa azul que conta quantas vezes o departamento foi utilizdo no registro

a pagina de 

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
em uma instituição não pode haver dois endereços com o mesmo nome.
em um endereço não pode haver dois departamentos com o mesmo nome.

contagem de registros
 é feito uma contagem no card de instituição de quantas vezes a instituição aparece no registo
 é feito uma contagem no card de endereço de quantas vezes o endereço aparece no registo
 é feito uma contagem no card de departamento de quantas vezes o departamento aparece no registo

toast
quando houver um erro de validação um toast deve aparecer na tela mostrando o erro.
quando houver um sucesso um toast deve aparecer na tela mostrando o sucesso.
quando houver um erro de validação no registro um toast deve aparecer na tela mostrando o erro.
quando houver um sucesso no registro um toast deve aparecer na tela mostrando o sucesso.
quando houver um erro de validação no cadastro um toast deve aparecer na tela mostrando o erro.
quando houver um sucesso no cadastro um toast deve aparecer na tela mostrando o sucesso.
quando houver um erro de validação no registro um toast deve aparecer na tela mostrando o erro.
quando houver um sucesso no registro um toast deve aparecer na tela mostrando o sucesso.

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
