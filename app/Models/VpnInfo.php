<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class VpnInfo extends Model
{
    use HasFactory;

    protected $fillable =
        ['ip_domain', 'login_domain', 'revoke_friendly_name', 'registration_id', 'mail_send', 'time_send', 'sms_access'];

    public function Registration(): HasOne
    {
        return $this->hasOne(Registration::class);
    }

}
