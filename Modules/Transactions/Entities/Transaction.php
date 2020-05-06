<?php

namespace Modules\Transactions\Entities;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded = [];

    public function setMetadataAttribute($value)
    {
        $this->attributes['metadata'] = serialize($value);
    }

    public function getMetadataAttribute($value)
    {
        return unserialize($value);
    }

    public function setDetailAttribute($value)
    {
        $this->attributes['detail'] = serialize($value);
    }

    public function getDetailAttribute($value)
    {
        return unserialize($value);
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }
}