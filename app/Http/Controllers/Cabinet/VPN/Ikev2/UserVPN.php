<?php

namespace App\Http\Controllers\Cabinet\VPN\Ikev2;

use App\Actions\Acronym\AcronymFullNameUser;
use App\Models\User;
use App\Models\VpnInfo;
use Exception;
use Illuminate\Support\Str;

class UserVPN
{
    private $user;
    private $vpn;

    /**
     * @throws Exception
     */
    public function __construct($User)
    {
        try {
            $this->user = User::query()
                ->with(['Registration','FilialName'])
                ->where('id', $User)
                ->limit(1)
                ->first();
        } catch (Exception $exception) {

        }

        if (!empty($this->user)){
            $this->vpn = VpnInfo::query()->where('registration_id', $this->user->Registration->id)->first();
        } else {
            throw new Exception('Пользователь не найден');
        }


    }

    public function full_name(): string
    {
        $fullNameUser = new AcronymFullNameUser();
        return $fullNameUser->Acronym($this->user->Registration);
    }

    public function registration_id()
    {
        return $this->user->Registration->id;
    }

    public function phone()
    {
        return $this->user->Registration->phone;
    }

    public function login_domain()
    {
       return $this->vpn->login_domain ?? '';
    }

    public function email() : array
    {
        return empty($vpn->mail_send) ?  [$this->user->email] : [$this->user->email, $this->vpn->mail_send];
    }

    public function ip_domain()
    {
        return  $this->user['ip_domain'] =  $this->vpn->ip_domain ?? '';
    }

    public function revoke_friendly_name()
    {
        if(empty($vpn->revoke_friendly_name)){
            return '';
        } else {
            return $this->vpn->revoke_friendly_name;
        }
    }

    public function locality(): string
    {
        return Str::slug(Str::lower($this->user->FilialName->name),'_','ru');
    }

    public function common_name(): string
    {
        return Str::slug(
            Str::lower(Str::limit($this->user->Registration->first_name, 1)).' '.
            Str::lower($this->user->Registration->last_name).' '.$this->user->id,'_','ru');
    }

}
