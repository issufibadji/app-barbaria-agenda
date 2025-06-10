<?php

namespace Modules\Report\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Report\Database\factories\ReportFieldFactory;

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