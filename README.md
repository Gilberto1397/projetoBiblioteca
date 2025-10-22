# Sistema de Gerenciamento de Biblioteca

Projeto básico envolvendo rotinas presentes em uma biblioteca, como cadastro de livros, autores e editoras, além de permitir o empréstimo e devolução de livros.

API feita em Laravel para aperfeiçoar conhecimentos sobre Laravel, VueJs, MVC, CRUD, autenticação, autorização, testes automatizados e qualidade de código.

## 🚀 Como Rodar a Aplicação Utilizando Docker e Docker Compose

### Pré-requisitos
- Docker e Docker Compose instalados

### Passo a Passo

1. **Suba os containers com Docker Compose**
```bash
  docker compose up -d
```

Isso irá iniciar:
- Container PHP com Laravel (Backend)
- Container PostgreSQL (Banco de dados)
- Container Vue.js (Frontend)

4. **Acesse a aplicação**
- **Frontend**: http://localhost:5173
- **Backend API**: http://localhost:80

### Comandos Úteis

**Parar os containers:**
```bash
  docker compose down
```
**Executar testes:**
```bash
  docker compose exec container-php php artisan test
```

**Executar PHP-Stan:**
```bash
  docker compose exec container-php composer stan
```

## 🛠️ Tecnologias Utilizadas

### Backend
- Laravel (PHP)
- PostgreSQL
- Laravel Sanctum (Autenticação)
- PHPUnit (Testes)
- Larastan (Análise estática)

### Frontend
- Vue.js 3
- Vite
- Axios
- Vue Router
- Pinia (State Management)

### DevOps
- Docker
- Docker Compose

## 📝 Estrutura do Projeto

```
├── client/          # Aplicação Vue.js (Frontend)
├── server/          # Aplicação Laravel (Backend/API)
├── dadosPostgres/   # Dados persistidos do PostgreSQL
├── docker-compose.yml
├── Dockerfile-php
├── Dockerfile-postgres
└── Dockerfile-vue
```

## 🧪 Testes

O projeto conta com testes automatizados. Para executá-los:

```bash
# Testes do backend
docker compose exec container-php php artisan test

# Análise estática com Larastan
docker compose exec container-php ./vendor/bin/phpstan analyse
```
