<?php

namespace Sinarajabpour1998\Notifier\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifierSmsTemplate extends Model
{
    use HasFactory;
    protected $fillable = ['template_text'];
}
