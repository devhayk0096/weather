<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchResult extends Model
{
    use HasFactory;

    protected $table = 'search_results';

    protected $fillable = [
        'city',
        'country_code',
        'latitude',
        'longitude',
        'temperature',
        'temp_max',
        'temp_min',
        'description',
        'icon',
        'condition_name',
        'formatted_date',
        'formatted_day',
        'timestamp',
    ];




}
