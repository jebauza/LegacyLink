<?php

namespace App\Models;

use App\Models\Ceremony;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Video extends Model
{
    use HasFactory;

    protected $table = 'video';

    protected $fillable = [
        'ceremony_id',
        'vimeo_code',
        'vimeo_url',
        'vimeo_rmtp_url',
        'vimeo_rmtp_key'
    ];

    /**
     * Get the user that owns the Video
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ceremony()
    {
        return $this->belongsTo(Ceremony::class, 'ceremony_id', 'id');
    }

}
