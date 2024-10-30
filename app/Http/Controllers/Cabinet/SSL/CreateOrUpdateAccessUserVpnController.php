<?php

namespace App\Http\Controllers\cabinet\ssl;

use App\Actions\Acronym\AcronymFullNameUser;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VpnInfo;
use Illuminate\Support\Str;
use PHPUnit\Util\Exception;

class CreateOrUpdateAccessUserVpnController extends Controller
{
    use TempDir;

    private MikrotikController $mikrotikController;
    private array $user;
    private string $path_temp;
    private string $ipConfigW7;

    public function __construct($userID, $settings)
    {

        $this->user['settings'] = json_decode($settings);

        $this->path_temp = storage_path() . '/app/temp/';

        if (!file_exists($this->path_temp)) {
            mkdir($this->path_temp, 0777, true);
        }

        $user = User::query()
            ->with(['Registration','FilialName'])
            ->where('id', $userID)
            ->limit(1)
            ->get();

        $vpn = VpnInfo::query()->where('registration_id', $user[0]->Registration->id)->first();

        $this->user['locality'] = Str::slug(Str::lower($user[0]->FilialName->name),'_','ru');
        $this->user['common_name'] = Str::slug(
            Str::lower(Str::limit($user[0]->Registration->first_name, 1)).' '.
            Str::lower($user[0]->Registration->last_name).' '.
            $user[0]->id,'_','ru');

        if(empty($vpn->revoke_friendly_name)){
            $this->user['revoke_friendly_name'] = '';
        } else {
            $this->user['revoke_friendly_name'] = $vpn->revoke_friendly_name;
        }

        if(empty($vpn->ip_domain)){
            $this->user['ip_domain'] = '';
        } else {
            $this->user['ip_domain'] = $vpn->ip_domain;
        }

        if(empty($vpn->mail_send)){
            $this->user['email'] = [$user[0]->email];
        } else {
            $this->user['email'] = [$user[0]->email, $vpn->mail_send];
        }

        if(empty($vpn->login_domain)){
            $this->user['login_domain'] = '';
        } else {
            $this->user['login_domain'] = $vpn->login_domain;
        }

        $this->user['phone'] = $user[0]->Registration->phone;
        $this->user['registration_id'] = $user[0]->Registration->id;
        $fullNameUser = new AcronymFullNameUser();
        $this->user['full_name'] = $fullNameUser->Acronym($user[0]->Registration);

        $this->mikrotikController = new MikrotikController($this->user);
    }

    public function __invoke()
    {
        $arhive = new ArhiveAccessUserVpnController($this->user);
        $toEmail = new SendEmailUserInfoController($this->user);

        if ($this->user['ip_domain'] == ''){
            return ['message' => 'Нет IP адреса пользователя'];
        }


        if ($this->user['settings']->W10 || $this->user['settings']->W7) {
            //Запрос / проверка / создание / подпись

           $this->mikrotikController->sslGetActive()->sslCheckInvalidAfter()->sslCreate()->sslSing();

           if ($this->mikrotikController->sing)
           {
               return ['message' => 'SSL sign'];
           }

            //Запрос / корректировка / создание
            $this->mikrotikController->getModeConfig()->checkIpModeConfig()->addModeConfig();

            //Запрос / корректировка / создание
            $this->mikrotikController->identityGet()->identitySet()->identityAdd();

            //экспорт SSL
            $this->mikrotikController->exportSSL();

            //создали скрипт
            CreateScriptController::create($this->user, $this->mikrotikController->sslActive[0]['name'], $this->mikrotikController->ipConfigW7, $this->pathTemp());

            DownloadMokrotikSslController::download($this->mikrotikController->sslActive[0]['name']);

            if ($this->user['settings']->W10){
                $arhive($this->mikrotikController->sslActive[0]['name'], '.ps1');
            } else {
                $arhive($this->mikrotikController->sslActive[0]['name'], '.cmd');
            }

            $toEmail($this->mikrotikController->sslActive[0]['name']);

            return ['message' => 'Выполнено'];

        }

        if ($this->user['settings']->scriptW10){
            $this->mikrotikController->sslGetActive()->getModeConfig();
            CreateScriptController::create($this->user, $this->mikrotikController->sslActive[0]['name'], $this->mikrotikController->ipConfigW7, $this->pathTemp());
            $arhive($this->mikrotikController->sslActive[0]['name'], '.ps1');
            $toEmail($this->mikrotikController->sslActive[0]['name']);
            return ['message' => 'Скрипт под W10 отправлен'];
        }

        if ($this->user['settings']->settingDelete){
            $this->mikrotikController->getModeConfig()->identityGet()->identityRemove()->modeConfigRemove();
            return ['message' => 'Настройки удалены'];
        }
        return ['message' => 'Действия не выполнены'];
    }
}
