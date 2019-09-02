# AION-API

API do Aion usando o framework Laravel 5.5 e o SGBD PostgreSQL

SPA do projeto [aqui](http://github.com/ati-urcamp/aion)

> Algumas consultas utilizada no projeto utilizam funções específicas do PostgreSQL. Se preferir usar outro SGBD, modificar as mesmas.

Sequência para instalação

```
# Cria o .env (Edite os dados de conexão etc... aqui antes de prosseguir)
cp .env.example .env

# Instala as dependências
composer install

# Gera a key do Laravel e do JWT
php artisan key:generate
php artisan jwt:secret

# Cria as tabelas
php artisan migrate

# Cria um usuário e as informações básicas para uso
php artisan db:seed
```

Depois de instalado, use o usuário `aion` e a senha `102030` para fazer login

Se quiser pausar tarefas em andamento execute o comando `php artisan aion:pausar-timesheets`
