<h1 align="center">Sell2Brazil</h1>

> Iniciando

## Instalação

# Backend
``` bash
# Instalar as depedências do projeto
composer install

# Atualizar lista de classes se necessário
composer dump-autoload

# Configurar variáveis de ambiente
cp .env.example .env
php artisan key:generate

# Rodar os testes
php artisan test
```

### Configuração - Backend (Ambiente Docker)

``` bash
# Rode o Docker compose
docker-compose up -d

# Instalar dependências do projeto
docker-compose exec app composer install

# Atualizar lista de classes
docker-compose exec app composer dump-autoload

# Configurar variáveis de ambiente
cp .env.example .env
docker-compose exec --user=ambientum app php artisan key:generate

# Rodar os testes
docker-compose exec --user=ambientum app php artisan test
```

# Gerar migrações do banco de dados
php artisan migrate



# Frontend

## Project setup
```
yarn install
```

### Compiles and hot-reloads for development
```
yarn serve
```
