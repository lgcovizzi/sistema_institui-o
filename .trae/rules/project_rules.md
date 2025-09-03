reinicie o docker compose
docker contendo backend com laravel o frontend com vuejs e banco de dados mariadb
sempre rode em docker 
uma página web com um formulário para cadastrar uma instiuição, a instituição só tem um nome longo e um nome curto, a instuição não tem os campos de CNPJ,Telefone,Email

um formulário para cadastrar um endereço, precisa selecionar uma instituição já cadastrada, cada instituição pode ter multiplos endereços, 
um formulário para cadastrar o departamento, para cadastrar um departamento precisa selecionar uma instituição, e tb precisa selecionar um endereço


uma segunda página com um formulário para cadastrar um funcionário, 
para cadastrar um funcionário precisa selecionar uma instituição (selecionando o nome curto), e tb precisa selecionar um endereço, 
e tb precisa selecionar um departamento, e como opcional, adicionar manualmente o cargo e o horário de trabalho
O endereço é composto por um titulo, uma cidade, um estado não há Logradouro, Número, Bairro.
faça o backend com laravel, e o frontend com vuejs, e o banco de dados com mariadb

na página de cadastro, em Sistema de Instituição, é mostrado card com o nome da instituição, lista de endereços e departamentos e um botão de deletar e editar.
na página de cadastro, em Endereço, é mostrado card com o titulo do endereço, a cidade, o estado e um botão de deletar e editar.
na página de cadastro, em Departamento, é mostrado card com o nome do departamento, a instituição e um botão de deletar e editar.
na página de cadastro, em Funcionário, é mostrado card com o nome do funcionário, a instituição, o endereço, o departamento, o cargo e o horário de trabalho e um botão de deletar e editar.
coloque no padrão de uma barra lateral retratil, Sistema de Instituição, com as opções de Home Cadastro Instituições Cadastro Funcionários
O CARD Departamentos Cadastrados está no interior do card Endereços Cadastrados e o card Endereços Cadastrados está no interior do Instituições Cadastradas

a página tem o layout de um dasboard,
a barra lateral deve ter icones a esquerda e ser retrátil
o nome curto da instituição deve ser único
o nome longo da instituição deve ser único
o titulo do endereço na instituição deve ser único
o nome do departamento no endereço deve ser único

reinicie o banco de dados como se fosse a primeira vez
