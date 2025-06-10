<?php

namespace Modules\Report\Entities;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Report\Database\factories\ReportModelFactory;

use OwenIt\Auditing\Contracts\Auditable;

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
