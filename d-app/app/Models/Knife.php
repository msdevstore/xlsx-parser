<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Knife extends Model
{
    protected $fillable = ['Service IDs', 'Pitch', 'Type', 'Gear', 'Shape', 'Blade Type', 'Cut Type', 'Cut Position', 'Corner Radius', 'Size Across', 'Size Around', 'No Across', 'No Around', 'Gap Across', 'Gap Around', 'Center-to-Center Across', 'Center-to-Center Around', 'Liner', 'Perforation', 'Location', 'Supplier ID', 'Notes', 'Size Width', 'Repeat Length', 'No of Knife', 'Status'];

    use HasFactory;
}
