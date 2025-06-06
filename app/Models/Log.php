<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;

class Log extends Model implements AuditableContract
{
    use Auditable;

    // Coloque aqui seus atributos e métodos normalmente
}
