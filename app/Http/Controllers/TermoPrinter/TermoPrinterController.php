<?php

namespace App\Http\Controllers\TermoPrinter;

use App\Actions\Acronym\AcronymFullNameUser;
use App\Http\Controllers\Controller;
use App\Models\PassFilial;
use App\Models\TermPrinterSettings;
use App\Models\User;
use Illuminate\Support\Carbon;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\Printer;

class TermoPrinterController extends Controller
{
    public function print(PassFilial $passFilial)
    {

        $setting = TermPrinterSettings::query()->where('filial_id', $passFilial->filial_id)->first();

        $name = new AcronymFullNameUser();

        try {
            $connector = new NetworkPrintConnector($setting->ip_address, 9100);
            $printer = new Printer($connector);
            $printer->setPrintLeftMargin(80);
            $printer->setPrintWidth(400);
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setLineSpacing(100);
            $printer -> setTextSize(2, 2);
            $printer -> text("Пропуск.\n");
            $printer -> setTextSize(1, 1);
            $printer->feed();
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer -> text("Гос. номер: ");
            $printer->setDoubleStrike(true);
            $printer -> text("$passFilial->number_car\n");
            $printer->setDoubleStrike(false);
            $printer -> text("ФИО: $passFilial->last_name\n");
            $printer -> text("Дата: " . Carbon::parse($passFilial->date)->format('d-m-Y') . "\n");
            $printer -> text("Разрешил: " . $name->Acronym(User::query()->find($passFilial->user_id)->Registration). "\n");
            $printer ->text("Комментарий: ");
            $printer->setLineSpacing();
            $printer ->text("\n");
            $printer ->text("$passFilial->comments\n");
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->qrCode('https://develop.krimm.ru/pass/check?key='. $passFilial->id, 0, 4);
            //$printer->qrCode('https://inform.krimm.ru/pass/check?key='. $passFilial->id, 0, 4);
            $printer -> cut();
            $printer ->  close();
            return ['messages' => 'Отправлено на печать'];
        } catch (\Exception $e) {
            return ['messages' => 'Пропуск сохранен в БД, но печать не удалась'];
        }

    }
}
