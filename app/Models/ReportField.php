<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\ReportModel;

class ReportField extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_model_id',
        'field',
        'alias',
        'is_filter',
        'orderby',
        'groupby',
        'filter_operator',
        'default_value',
        'logic',
        'visible_filter',
        'field_type',
    ];

    public function report()
    {
        return $this->belongsTo(ReportModel::class);
    }
}