<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use OwenIt\Auditing\Contracts\Auditable;
use App\Models\ReportRelationship;
use App\Models\ReportField;
use App\Models\ReportLayout;

class ReportModel extends Model implements Auditable
{
    use HasFactory;
    use Uuid;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'name',
        'open_mode',
        'acl',
        'has_filter',
        'user_id',
    ];

    public function relationships()
    {
        return $this->hasMany(ReportRelationship::class);
    }

    public function fields()
    {
        return $this->hasMany(ReportField::class);
    }

    public function layout()
    {
        return $this->hasOne(ReportLayout::class);
    }
}
