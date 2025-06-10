<?php

namespace Modules\MercadoPago\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class MercadoPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_mp',
        'valor',
        'valor_pago',
        'status',
        'status_detail',
        'qr_code',
        'id_user',
        'module',
        'id_module',
        'metodo_pagamento',
        'data_pagamento',
    ];

    public function getQRCodeBase64()
    {
        $writer = new PngWriter();

        // Crie uma nova instância do QrCode
        $qrCode = new QrCode($this->qr_code);

        // Renderize o QrCode como uma imagem
        $result = $writer->write($qrCode);

        // Obtenha a string da imagem PNG
        $pngString = $result->getString();

        // Converta a imagem em base64
        $base64 = 'data:image/png;base64,' . base64_encode($pngString);
        return $base64;
    }

    protected static function newFactory()
    {
        return \Modules\MercadoPago\Database\factories\MercadoPagoFactory::new();
    }
}
