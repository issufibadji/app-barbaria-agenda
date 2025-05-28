
# 🚀 Laravel + Vue + InertiaJS (JS puro, com autenticação)

Starter kit moderno com **Laravel**, **Vue 3**, **Inertia.js** e **JavaScript puro** — sem TypeScript. Inclui login, registro, dashboard e estrutura inicial pronta para começar seu projeto.

---

## ✅ Requisitos

- PHP >= 8.2  
- Composer  
- Node.js + npm  
- Banco de dados configurado (.env)  
- Laravel CLI (`composer global require laravel/installer`)

---

## 📦 Etapas de Instalação

### 1. Criar novo projeto Laravel

```bash
composer create-project laravel/laravel projeto-auth-js
cd projeto-auth-js
```

---

### 2. Instalar Breeze com Vue + Inertia + JS

```bash
composer require laravel/breeze --dev
php artisan breeze:install vue
```

Esse comando instala:

- Vue 3  
- Inertia.js  
- Autenticação completa  
- **JavaScript puro (sem TypeScript)**

---

### 3. Instalar dependências e compilar assets

```bash
npm install
npm run dev
```

---

### 4. Rodar migrações

```bash
php artisan migrate
```

---

### 5. Subir o servidor

```bash
php artisan serve
```

---

## 🟢 Tudo Pronto!

Você agora tem:

- 🔐 Login, registro, logout e proteção com middleware
- 🧑‍💻 Código 100% JavaScript (sem arquivos `.ts`)
- 📁 Templates prontos para:
  - Dashboard
  - Perfil de usuário
  - Layout com navbar e sidebar

---

## 🛠️ Próximos passos

- Criar novos componentes Vue
- Adicionar permissões e papéis (roles)
- Criar sistema de notificações
- Ativar 2FA (dupla autenticação)
- Gerenciar logs e auditoria
