<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\ReportModel;

class ReportRelationship extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_model_id',
        'table_origin',
        'column_origin',
        'relationship_type',
        'table_target',
        'column_target',
    ];

    public function report()
    {
        return $this->belongsTo(ReportModel::class);
    }
}