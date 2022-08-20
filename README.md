# Processo Seletivo - eGET

## Requisitos Funcionais

-   [x] Deverá ser possível que o usuário faça login na aplicação e, caso não possua conta, realize um novo cadastro.
-   [x] Após cadastrar uma nova conta, enviar um e-mail de boas vindas.
-   [ ] Após realizar login, o usuário deve ter acesso à uma listagem de clientes, contendo paginação e algum filtro ou modo de pesquisa.
-   [x] Deverá ser possível cadastrar um novo cliente, contendo os seguintes campos:
-   -   Nome (Obrigatório);
-   -   CPF (Obrigatório);
-   -   Categoria;
-   -   CEP (Obrigatório);
-   -   Rua;
-   -   Bairro;
-   -   Cidade;
-   -   UF;
-   -   Complemento;
-   -   Telefone.

-   [ ] No cadastro, quando o usuário preencher o campo de CEP, o sistema deve consultar na API ViaCEP (http://viacep.com.br) e preencher os demais campos automaticamente (rua, bairro, cidade e uf).
-   [ ] O campo de telefone deverá ter uma máscara para padronização do telefone(Exemplo: '(99) 9 9999-9999').
-   [x] Deverá ser possível alterar e excluir clientes.

## Requisitos Não Funcionais

-   [x] No backend, utilizar PHP e Laravel (versão 7 ou superior).
-   [x] Usar Postgres como banco de dados.
-   [x] Usar o Eloquent para acesso a banco de dados.
-   [x] Usar migrations para criação e alteração do banco de dados;
-   [x] No frontend, usar tecnologia ou framework de sua preferência.
-   [ ] As validações devem ocorrer tanto no backend como no frontend.
-   [ ] Cobrir a aplicação com testes automatizados.
-   [ ] A aplicação (backend e frontend) deverá ser hospedada na nuvem (opcional)

## Regras de Negócio

-   [x] O sistema não deve permitir o cadastro de um CPF inválido.
-   [x] O sistema não deve permitir o cadastro de um CPF duplicado.
-   [x] Um usuário não pode visualizar ou ter acesso aos clientes de outro usuário.

## Entrega

Se algum requisito não for atendido, entregar o que foi feito mesmo assim.
Disponibilizar os fontes do projeto no GitHub.
Deverá ser agendado uma reunião por videoconferência para apresentação da aplicação rodando localmente no seu próprio ambiente, ou em hospedagem de sua preferência. Nesta reunião a aplicação deverá ser demonstrada e explicada, bem como o código e lógica.