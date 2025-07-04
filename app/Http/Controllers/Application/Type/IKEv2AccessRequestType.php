<?php

namespace App\Http\Controllers\Application\Type;

use App\Mail\RequestSSLMail;
use Illuminate\Support\Facades\Mail;

class IKEv2AccessRequestType  extends ApplicationTypeRender implements ApplicationTypeInterface
{

    function run(): ApplicationTypeInterface
    {
        return $this;
    }

    public function createApplication(): void
    {
        $userInfo = $this->getAuthorApplication();

        $text['textBody'] = 'Вы будите получать уведомления об этапах выполнения';
        $text['textCaption'] = "Ваша заявка № " . $this->modelApplication->identification ." зарегистрирована";
        $text['topic'] = 'Запрос сертификата';

        Mail::to($userInfo['email'], $userInfo['name'])->queue(new RequestSSLMail($userInfo['name'], $text));

        $text['textBody'] = 'Необходимо отклонить или выполнить заявку';
        $text['textCaption'] = "зарегистрирована заявка № " . $this->modelApplication->identification ." от " . $userInfo['name'];
        $text['topic'] = 'Запрос сертификата пользователем';

        Mail::to('sergey@krimm.ru', 'Холманских С.Н.')->queue(new RequestSSLMail('Холманских С.Н.', $text));
    }

    public function acceptedForWorkApplication(): void
    {
        $userInfo = $this->getAuthorApplication();

        $text['textBody'] = 'О результате выполнения сообщим дополнительно';
        $text['textCaption'] = "Ваша заявка № " . $this->modelApplication->identification ." взята в работу";
        $text['topic'] = 'Запрос сертификата';

        Mail::to($userInfo['email'], $userInfo['name'])->queue(new RequestSSLMail($userInfo['name'], $text));
    }

    public function rejectionApplication(): void
    {
        $userInfo = $this->getAuthorApplication();

        $text['textBody'] = 'На данный момент Ваша заявка отклонена.';
        $text['textCaption'] = "Ваша заявка № " . $this->modelApplication->identification ." отклонена";
        $text['topic'] = 'Запрос сертификата';

        Mail::to($userInfo['email'], $userInfo['name'])->queue(new RequestSSLMail($userInfo['name'], $text));
    }

    public function completedApplication(): void
    {
        $userInfo = $this->getAuthorApplication();

        $text['textBody'] = 'Данные для подключения будут направленны на email';
        $text['textCaption'] = "Ваша заявка № " . $this->modelApplication->identification ." выполнена";
        $text['topic'] = 'Запрос сертификата';

        Mail::to($userInfo['email'], $userInfo['name'])->queue(new RequestSSLMail($userInfo['name'], $text));
    }

    public function closedApplication(): void
    {
        $userInfo = $this->getAuthorApplication();

        $text['textBody'] = 'Ваша заявка закрыта со статусом ' . $this->getStatusClose();
        $text['textCaption'] = "Ваша заявка № " . $this->modelApplication->identification ." закрыта";
        $text['topic'] = 'Запрос сертификата';

        Mail::to($userInfo['email'], $userInfo['name'])->queue(new RequestSSLMail($userInfo['name'], $text));
    }
}
