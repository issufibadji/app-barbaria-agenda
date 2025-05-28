# Laravel + Vue + InertiaJS (JavaScript) Starter Kit

Este projeto é um boilerplate completo com Laravel + Vue 3 + Inertia.js + Breeze usando **apenas JavaScript** (sem TypeScript). Inclui autenticação, dashboard inicial, layouts com navegação, e estrutura para desenvolvimento de aplicações modernas.

---

## 🚀 Instalação Rápida (Passo a Passo)

### 1. Clone o repositório (ou crie do zero)
```bash
git clone https://github.com/seu-usuario/seu-repositorio.git projeto-auth-js
cd projeto-auth-js
```

---

### 2. Instale dependências de backend
```bash
composer require laravel/breeze --dev
php artisan breeze:install vue
```
 #### Ou 

```bash
composer install

```

### 3. Instale dependências frontend e compile
```bash
npm install
npm run dev
```

---

### 4. Configure o arquivo `.env` e gere a chave
```bash
cp .env.example .env
php artisan key:generate
```

Edite suas configurações de banco de dados:
```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nome_da_base
DB_USERNAME=root
DB_PASSWORD=
```

---

### 5. Rode as migrações
```bash
php artisan migrate
```

---

### 6. Inicie o servidor
```bash
php artisan serve
```

---

## ✅ O que você já tem pronto

- [x] Laravel com autenticação
- [x] Vue 3 + Inertia.js (sem TypeScript)
- [x] Login, Registro, Logout
- [x] Middleware de proteção de rotas
- [x] Dashboard e layout com Navbar e Sidebar
- [x] Padrão visual com Tailwind CSS

---

## 📁 Estrutura de Pastas

```
resources/
├── js/
│   ├── Pages/
│   ├── Layouts/
│   ├── Components/
│   └── App.vue
routes/
├── web.php
```

---

## 🧠 Sugestão de Continuação

- ✅ Criar layouts personalizados
- ✅ Implementar gestão de usuários
- ✅ Integrar com APIs
- ✅ Adicionar permissões e papéis (roles)
- ✅ Usar Tailwind plugins como forms, typography, etc.

---

Feito com ❤️ por [Seu Nome ou Equipe]
