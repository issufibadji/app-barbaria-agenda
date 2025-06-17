<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AgendaAiEstablishment;
use App\Models\AgendaAiMessageSetting;
use Illuminate\Support\Str;

class MessageSettingsSeeder extends Seeder
{
    public function run(): void
    {
        // Verifica se existe ao menos um estabelecimento
        $establishment = AgendaAiEstablishment::first();

        // Se não existir, cria um fake
        if (!$establishment) {
            $this->command->warn('Nenhum estabelecimento encontrado. Criando estabelecimento de teste...');

            $establishment = AgendaAiEstablishment::create([
                'uuid' => Str::uuid(),
                'name' => 'Estabelecimento Teste',
                'link' => 'estabelecimento-teste',
                'manual_chat_link' => null,
                'descrition' => 'Estabelecimento fictício para testes',
                'image' => null,
                'user_id' => 1,
            ]);

            $this->command->info('Estabelecimento de teste criado.');
        }

        // Mensagens padrão
        $mensagens = [
            [
                'type' => 'confirmacao_agendamento',
                'message' => 'Olá {nome_cliente}, seu horário {data_agendamento} às {hora_agendamento} está confirmado!',
            ],
            [
                'type' => 'lembrete_agendamento',
                'message' => 'Lembrete: você tem um horário em {data_agendamento} às {hora_agendamento}. Em caso de dúvidas, responda a essa mensagem!',
            ],
            [
                'type' => 'cancelamento_agendamento',
                'message' => 'Seu horário do dia {data_agendamento} às {hora_agendamento} foi cancelado. Em caso de dúvidas, responda a essa mensagem!',
            ],
            [
                'type' => 'agradecimento',
                'message' => 'Olá, {nome_cliente}! Sentimos sua falta. Que tal uma nova experiência conosco? Confira nossos serviços atualizados e agende sua visita: {link} Esperamos você!',
            ],
            [
                'type' => 'remarketing',
                'message' => 'Olá, tudo bem? Se deseja *agendar algum de nossos serviços* use nosso novo assistente pessoal abaixo, é rápido e fácil. ✅ {link} Aguardo você aqui na(o) {nome_estabelecimento} 👊👊',
            ],
        ];

        foreach ($mensagens as $data) {
            AgendaAiMessageSetting::firstOrCreate(
                ['type' => $data['type'], 'establishment_id' => $establishment->id],
                ['message' => $data['message']]
            );
        }

        $this->command->info('Mensagens manuais padrão cadastradas com sucesso.');
    }
}
