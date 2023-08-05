```sh
API LARAVEL
```

Está Application Programming Interface possuem 3 entidades, e para cada entidade suporta operações de criar, ler, atualizar e excluir.

A Aplicação contém Autenticação JWT, a onde somente usuario que estão no DB conseguem acessar.

Existem também relações de entidades, e abordei o eagle loading para estes relacionamentos.

Optei por utilizar no back-end as recursividades de paginação, ordenação, search de registros.

Tem tratativas de mensagens, e também acaso algum campo na hora do index da entidade esteja vazio.

```sh
Agora vamos rodar o projeto, certifique-se de ter o composer instalado.
```

Se quiser clonar via terminal pode abrir o seu *terminal*, e caminhar até a pasta do seu *Ambiente de desenvolvimento* e utilizar o comando ou colar a pasta.

```sh
*git clone https://github.com/GuilhermeAlamino/backend_laravel.git* 
```

Agora abre seu editor, vá até a pasta do seu projeto, e atualize as variáveis de ambiente do arquivo (*.env*)


*Não esqueça de criar o seu Banco de dados com o nome que vai ficar na variavel de ambiente DB_DATABASE, optei por somente alterar ela.*


```dosini

DB_DATABASE=company_management
DB_USERNAME=root
DB_PASSWORD=
```

Certifique se que tenha composer instalado, se não tiver baixe, pode executar no terminal o comando para verificar -> *composer -v*.
```sh
https://getcomposer.org/Composer-Setup.exe
```

Agora vai precisar usar comandos em seu *terminal* que ele pode ser de sua preferencia, caminhe até dentro da pasta *do seu projeto*, após isso rode o comando no *terminal*.
```sh
*Composer install* ou *Composer update*
```

Rode o comando para Gerar a Key do JWT no *terminal*.
```sh
php artisan jwt:secret
```

Rode o comando para Gerar a key do projeto Laravel ainda no *terminal*.
```sh
php artisan key:generate
```

Execute o comando para executar as migrações do Banco de dados.
```sh
php artisan migrate
```

Execute o seed para gerar o usuário de acesso *todos usuários da tabela user tem acesso ao sistema*, e popular o banco com os dados.
```sh
php artisan db:seed
```

Execute o projeto com o seguinte comando, optei por rodar na porta 8001.
```sh
php artisan serve --port=8001
```
