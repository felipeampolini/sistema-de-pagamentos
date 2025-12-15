# Sistema de Pagamentos

![PHP](https://img.shields.io/badge/PHP-8.2-blue)
![Laravel](https://img.shields.io/badge/Laravel-10-red)
![Docker](https://img.shields.io/badge/Docker-Compose-blue)
![MySQL](https://img.shields.io/badge/MySQL-8-orange)
![License](https://img.shields.io/badge/License-MIT-green)

## Tecnologias Utilizadas

Este projeto foi desenvolvido utilizando as seguintes tecnologias:

* PHP 8.2
* Laravel 10
* Docker e Docker Compose
* Nginx
* MySQL 8
* Composer

## Pré-requisitos

Antes de iniciar, certifique-se de ter o seguinte item instalado e em execução:

* Docker

---

## Rodar o Projeto (Primeiro Setup)

Siga os passos abaixo para configurar e executar o projeto localmente pela primeira vez.

### 1 - Clonar o repositório

```bash
git clone https://github.com/felipeampolini/sistema-de-pagamentos.git
cd sistema-de-pagamentos
```

### 2 - Criar o arquivo `.env`

Copie o arquivo de exemplo para criar o arquivo de configuração de ambiente:

```bash
cp src/.env.example src/.env
```

### 3 - Subir os containers

Execute o comando abaixo para construir e iniciar os containers:

```bash
docker compose up -d --build
```

### 4 - Instalar as dependências do Laravel

Instale as dependências do projeto dentro do container da aplicação:

```bash
docker compose exec app composer install
```

### 5 - Gerar a `APP_KEY`

A `APP_KEY` é necessária para o funcionamento correto do Laravel:

```bash
docker compose exec app php artisan key:generate
```

### 6 - Gerar a `JWT_KEY`

Gere a chave utilizada para autenticação via JWT:

```bash
docker compose exec app php artisan jwt:secret
```

### 7 - Ajustar permissões de pastas (se necessário)

Caso ocorra algum problema de permissão, execute o comando abaixo:

```bash
docker compose exec app chmod -R 777 storage bootstrap/cache
```

### 8 - Executar as migrations

Crie as tabelas no banco de dados:

```bash
docker compose exec app php artisan migrate
```

### 9 - Acessar o projeto

Após finalizar o setup, a aplicação estará disponível em:

[http://localhost:8080](http://localhost:8080)

---

## Testes e Uso da API

Para facilitar o teste manual de todos os endpoints disponíveis, o projeto inclui uma coleção do **Postman** e a documentação via **Swagger**.

### Importar Coleção do Postman

Siga os passos abaixo para começar a testar a API:

1. **Localizar o arquivo**
   A coleção está disponível no seguinte caminho do repositório:

   ```
   postman/collections/Sistema_Pagamentos.postman_collection.json
   ```

2. **Importar no Postman**

   * Abra o [Postman](www.postman.com).
   * Clique em **Import** no canto superior esquerdo.
   * Selecione a opção **File** e escolha o arquivo `.json` informado acima.

3. **Token JWT automático no login**
   Após realizar o login, o token JWT é automaticamente salvo em uma variável de ambiente da coleção, facilitando o uso das demais rotas protegidas.

### Acessar Swagger

A documentação interativa da API pode ser acessada em:

[http://localhost:8080/api/documentation](http://localhost:8080/api/documentation)

---

## Conectar no banco de dados com aplicativo externo

Para acessar o banco de dados utilizando ferramentas como **DBeaver**, **HeidiSQL** ou similares, utilize as seguintes informações:

* Host: `127.0.0.1`
* Demais credenciais conforme definidas no arquivo `.env`:

  * `DB_CONNECTION`
  * `DB_PORT`
  * `DB_DATABASE`
  * `DB_USERNAME`
  * `DB_PASSWORD`

---

## Comandos úteis

Reiniciar os containers Docker:

```bash
docker compose restart
```

Visualizar logs dos containers em execução:

```bash
docker compose logs -f
```

Acessar o terminal do container da aplicação:

```bash
docker compose exec app bash
```

Dropar todas as tabelas e recriar as migrations:

```bash
docker compose exec app php artisan migrate:fresh
```

---

# Informações Adicionais

## Logs

A aplicação possui logs separados por contexto:

* `user.log`: ações relacionadas a usuários
* `transfer.log`: ações relacionadas a transferências
* `laravel.log`: logs de erro gerais da aplicação

Todos os arquivos de log estão localizados em:

```
src/storage/logs
```

---

## Versionamento de Rotas

A API utiliza o padrão de **versionamento por URI**.

Exemplos:

* `GET /api/v1/users/my-balance`
* `POST /api/v1/transfer/send`

Esse modelo foi adotado para garantir **compatibilidade retroativa** e facilitar a manutenção da API ao longo do tempo:

* **Evolução da API:** permite a criação de novas versões (`v2`, `v3`, etc.) com mudanças significativas sem impactar clientes que utilizam versões anteriores.
* **Clareza e simplicidade:** a versão da API é facilmente identificável diretamente na URL.

---

## Licença

MIT License
