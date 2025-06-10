<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use OwenIt\Auditing\Contracts\Auditable;
use App\Models\ReportModel;

class ReportLayout extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'report_model_id',
        'sql_query',
        'blade_template',
    ];

    public function report()
    {
        return $this->belongsTo(ReportModel::class);
    }
}