# Introdução do projeto Back-end Application Programming Interface(API) Laravel

Está Application Programming Interface possuem 3 entidades, e para cada entidade suporta operações de criar, ler, atualizar e excluir.

A Aplicação contém Autenticação JWT, a onde somente usuario que estão no banco de dados na tabela users conseguem acessar.

Existem também relações de entidades, e abordei o eagle loading para estes relacionamentos.

Optei por utilizar no back-end as recursividades de paginação, ordenação, search de registros como também mencionado.

Tem tratativas de mensagens, e também acaso alguma coluna na hora de puxar o index de quaisquer entidade esteja vazio.

# Introdução para rodar a aplicação Back-end Laravel

Certifique-se de ter o composer instalado.

# Faça o clone do projeto

Coloque a pasta no seu Ambiente de Desenvolvimento, obs: utilize terminal para colar o comando git clone (entre outros) ou baixe a pasta.

### `*git clone https://github.com/GuilhermeAlamino/backend_laravel.git*`

## Faça a atualização da variavel de ambiente `*(.env)*` laravel, vai existir o `*.env.example*` crie um arquivo `*(.env)*` portanto não esqueça de criar o nome do banco de dados e deixar o mesmo dessa variável `*DB_DATABASE*`

```dosini
DB_DATABASE=company_management
DB_USERNAME=root
DB_PASSWORD=
```
## Execute o comando

No Diretorio do projeto, você execute o comando abaixo

### `*Composer install* ou *Composer update*`

Agora ainda no diretorio, você pode gerar a Key do JWT com o comando abaixo

### `php artisan jwt:secret`

Você pode gerar a Key do Laravel com o comando abaixo

### `*php artisan key:generate*`

Você pode rodar as migrações do banco de dados com o comando abaixo

### `*php artisan migrate*`

Execute o seed para gerar o usuário de acesso obs:*todos usuários da tabela user tem acesso ao sistema*, e para popular o banco com os dados.

### `*php artisan db:seed*`

Execute a API Laravel com o seguinte comando, optei por rodar na porta 8001.

### `*php artisan serve --port=8001*`

O Projeto ira rodar na porta [http://localhost:8001](http://localhost:8001).
