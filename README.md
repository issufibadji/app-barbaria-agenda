# Agenda para Barbearias

Aplicação web feita com Laravel, Vue 3 e Inertia para gerenciar horários em barbearias. O projeto inclui recursos de pagamento via Mercado Pago e envio de notificações por web push.

## Requisitos

- PHP >= 8.2
- Composer
- Node.js e npm

## Instalação

```bash
composer install
cp .env.example .env
php artisan key:generate
npm install
php artisan migrate
```

## Execução

Execute a compilação dos assets e inicie o servidor Laravel em terminais separados:

```bash
npm run dev
php artisan serve
```

Após iniciar, acesse `http://localhost:8000`.

---

Integrado com Mercado Pago para processar pagamentos e suporte a notificações web push para engajar usuários.
