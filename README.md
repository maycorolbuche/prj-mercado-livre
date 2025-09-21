# Sistema de Gestão de Produtos Mercado Livre

Sistema em Laravel para cadastrar produtos, atualizar estoque e preços, e receber pedidos em tempo real via Webhooks da API do Mercado Livre.

---

## 📦 Requisitos

- PHP >= 8.1
- Composer
- MySQL ou outro banco compatível
- Laravel 12.30+
- Node.js + npm (para assets)
- Servidor web (Apache/Nginx) ou `php artisan serve`

---

## 🚀 Instalação

1. **Clone o projeto:**

    ```bash
    git clone https://github.com/maycorolbuche/prj-mercado-livre
    cd prj-mercado-livre
    ```

2. **Instale dependências PHP:**

    ```bash
    composer install
    ```

3. **Instale dependências frontend:**

    ```bash
    npm install
    npm run build
    ```

4. **Crie arquivo de variáveis de ambiente:**

    ```bash
    cp .env.example .env
    ```

5. **Configure banco de dados no `.env`:**

    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nome_do_banco
    DB_USERNAME=usuario
    DB_PASSWORD=senha
    ```

6. **Gere a chave do aplicativo:**

    ```bash
    php artisan key:generate
    ```

7. **Rode migrations e seeds:**

    ```bash
    php artisan migrate
    ```
