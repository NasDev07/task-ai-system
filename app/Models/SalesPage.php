<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SalesPage extends Model
{
    protected $fillable = [
        'user_id',
        'product_name',
        'description',
        'features',
        'target_audience',
        'price',
        'unique_selling_point',
        'headline',
        'subheadline',
        'benefits',
        'features_breakdown',
        'social_proof',
        'pricing_display',
        'call_to_action',
        'template',
        'template_settings',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'template_settings' => 'json',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
