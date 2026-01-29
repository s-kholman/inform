<?php

namespace App\Http\Controllers\Cards;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoadCounterpartyInformationRequest;
use Carbon\Carbon;
use Illuminate\Support\Str;

class CreateExportInformationERPController extends Controller
{
    private \XMLWriter $xw;

    public function __invoke(LoadCounterpartyInformationRequest $request, CardMessagesController $messages)
    {

        $parseInformationCounterparty = new ParseInformationContragentController();

        $counterpartyInformation = $parseInformationCounterparty($request->file('loadInformation'), $messages);
        $this->xw = xmlwriter_open_memory();

        xmlwriter_set_indent($this->xw, 1);
        $res = xmlwriter_set_indent_string($this->xw, ' ');

        xmlwriter_start_document($this->xw, '1.0', 'UTF-8');

        xmlwriter_start_element($this->xw, 'V8Exch:_1CV8DtUD');

        xmlwriter_start_attribute($this->xw, 'xmlns:V8Exch');
        xmlwriter_text($this->xw, 'http://www.1c.ru/V8/1CV8DtUD/');
        xmlwriter_end_attribute($this->xw);

        xmlwriter_start_attribute($this->xw, 'xmlns:core');
        xmlwriter_text($this->xw, 'http://v8.1c.ru/data');
        xmlwriter_end_attribute($this->xw);

        xmlwriter_start_attribute($this->xw, 'xmlns:v8');
        xmlwriter_text($this->xw, 'http://v8.1c.ru/8.1/data/enterprise/current-config');
        xmlwriter_end_attribute($this->xw);

        xmlwriter_start_attribute($this->xw, 'xmlns:xs');
        xmlwriter_text($this->xw, 'http://www.w3.org/2001/XMLSchema');
        xmlwriter_end_attribute($this->xw);

        xmlwriter_start_attribute($this->xw, 'xmlns:xsi');
        xmlwriter_text($this->xw, 'http://www.w3.org/2001/XMLSchema-instance');
        xmlwriter_end_attribute($this->xw);

        xmlwriter_start_element($this->xw, 'V8Exch:Data');

        xmlwriter_start_element($this->xw, 'v8:DocumentObject.ПриобретениеТоваровУслуг');
        $this->tag('v8:Ref', Str::uuid());
        $this->tag('v8:DeletionMark', 'false');
        $this->tag('v8:Date',Carbon::parse($request['documentDate'])->format('Y-m-d') . 'T06:00:00');
        $this->tag('v8:Number');
        $this->tag('v8:Posted', 'false');
        $this->tagAtr('v8:Валюта', '98e04e57-6d04-11f0-902c-005056bd6494','xsi:type','v8:CatalogRef.Валюты');
        $this->tagAtr('v8:Партнер', 'dd8ac8d8-c213-41df-85e1-72f5ac9741cb','xsi:type','v8:CatalogRef.Партнеры');
        $this->tag('v8:ХозяйственнаяОперация', 'ЗакупкаУПоставщика');
        $this->tagAtr('v8:Подразделение', '00000000-0000-0000-0000-000000000000', 'xsi:type', 'v8:CatalogRef.СтруктураПредприятия');
        $this->tagAtr('v8:Склад', '13d00eac-c415-11e5-80e5-6eae8b538cc9', 'xsi:type', 'v8:CatalogRef.Склады');
        $this->tagAtr('v8:Контрагент', 'dd8ac8d8-c213-41df-85e1-72f5ac9741cb', 'xsi:type', 'v8:CatalogRef.Контрагенты');
        $this->tag('v8:СуммаДокумента', '1000');
        $this->tag('v8:СуммаВзаиморасчетовПоЗаказу', '0');
        $this->tagAtr('v8:Менеджер', '8d1d6cb4-7881-11ea-811f-6eae8b538cc9', 'xsi:type', 'v8:CatalogRef.Пользователи');
        $this->tag('v8:ЗаказПоставщику', '00000000-0000-0000-0000-000000000000');
        $this->tagAtr('v8:ПодотчетноеЛицо', '00000000-0000-0000-0000-000000000000', 'xsi:type', 'v8:CatalogRef.ФизическиеЛица');
        $this->tag('v8:ЦенаВключаетНДС', 'true');
        $this->tagAtr('v8:ВалютаВзаиморасчетов', '98e04e57-6d04-11f0-902c-005056bd6494', 'xsi:type', 'v8:CatalogRef.Валюты');
        $this->tagClose('v8:Комментарий');
        $this->tag('v8:ЗакупкаПодДеятельность', 'ПродажаОблагаетсяНДС');
        $this->tagClose('v8:ФормаОплаты');
        $this->tag('v8:Согласован', 'true');
        $this->tag('v8:НалогообложениеНДС', 'ПродажаОблагаетсяНДС');
        $this->tag('v8:СуммаВзаиморасчетов', '0'); //??
        $this->tagAtr('v8:БанковскийСчетОрганизации', '00000000-0000-0000-0000-000000000000', 'xsi:type', 'v8:CatalogRef.БанковскиеСчетаОрганизаций');
        $this->tag('v8:НомерВходящегоДокумента', $request['counterpartyNumber']);
        $this->tag('v8:ДатаВходящегоДокумента', Carbon::parse($request['counterpartyDate'])->format('Y-m-d') . 'T00:00:00');
        $this->tagAtr('v8:Грузоотправитель', '00000000-0000-0000-0000-000000000000', 'xsi:type', 'v8:CatalogRef.Контрагенты');
        $this->tagAtr('v8:БанковскийСчетКонтрагента', '00000000-0000-0000-0000-000000000000', 'xsi:type', 'v8:CatalogRef.БанковскиеСчетаКонтрагентов');
        $this->tagAtr('v8:БанковскийСчетГрузоотправителя', '00000000-0000-0000-0000-000000000000', 'xsi:type', 'v8:CatalogRef.БанковскиеСчетаКонтрагентов');
        $this->tagAtr('v8:Сделка', '00000000-0000-0000-0000-000000000000', 'xsi:type', 'v8:CatalogRef.СделкиСКлиентами');
        $this->tagAtr('v8:Принял', '00000000-0000-0000-0000-000000000000', 'xsi:type', 'v8:CatalogRef.ФизическиеЛица');
        $this->tagClose('v8:ПринялДолжность');
        $this->tag('v8:ПоступлениеПоЗаказам', 'false');
        $this->tagAtr('v8:ГруппаФинансовогоУчета', '00000000-0000-0000-0000-000000000000', 'xsi:type', 'v8:CatalogRef.ГруппыФинансовогоУчетаРасчетов');
        $this->tag('v8:РегистрироватьЦеныПоставщика', 'false');
        $this->tagAtr('v8:Договор', '4961ffc4-f4b9-11f0-9f62-0024ecf4e982', 'xsi:type', 'v8:CatalogRef.ДоговорыКонтрагентов');
        $this->tagAtr('v8:Автор', '8d1d6cb4-7881-11ea-811f-6eae8b538cc9', 'xsi:type', 'v8:CatalogRef.Пользователи');
        $this->tagAtr('v8:Руководитель', 'a7b1f485-d429-11f0-9f62-0024ecf4e982', 'xsi:type', 'v8:CatalogRef.ОтветственныеЛицаОрганизаций');
        $this->tag('v8:ПорядокРасчетов', 'ПоДоговорамКонтрагентов');
        $this->tag('v8:ВернутьМногооборотнуюТару', 'false');
        $this->tag('v8:ДатаВозвратаМногооборотнойТары', '0001-01-01T00:00:00');
        $this->tagClose('v8:СостояниеЗаполненияМногооборотнойТары');
        $this->tag('v8:ТребуетсяЗалогЗаТару', 'false');
        $this->tagAtr('v8:ДопоступлениеПоДокументу', '', 'xsi:nil', 'true');
        $this->tagClose('v8:НазначениеАванса');
        $this->tagClose('v8:КоличествоДокументов');
        $this->tagClose('v8:АпкИсточникФормирования');
        $this->tagClose('v8:КоличествоЛистов');
        $this->tagAtr('v8:ГлавныйБухгалтер', '437e0978-d42b-11f0-9f62-0024ecf4e982', 'xsi:type', 'v8:CatalogRef.ОтветственныеЛицаОрганизаций');
        $this->tagAtr('v8:СтатьяДвиженияДенежныхСредств', '00000000-0000-0000-0000-000000000000', 'xsi:type', 'v8:CatalogRef.СтатьиДвиженияДенежныхСредств');
        $this->tag('v8:СпособДоставки', 'СиламиПоставщикаДоНашегоСклада');
        $this->tagAtr('v8:ПеревозчикПартнер', '00000000-0000-0000-0000-000000000000', 'xsi:type', 'v8:CatalogRef.Партнеры');
        $this->tagAtr('v8:ЗонаДоставки', '00000000-0000-0000-0000-000000000000', 'xsi:type', 'v8:CatalogRef.ЗоныДоставки');
        $this->tag('v8:ВремяДоставкиС', '0001-01-01T00:00:00');
        $this->tag('v8:ВремяДоставкиПо', '0001-01-01T00:00:00');
        $this->tagClose('v8:АдресДоставки');
        $this->tagClose('v8:АдресДоставкиЗначенияПолей');
        $this->tagClose('v8:ДополнительнаяИнформацияПоДоставке');
        $this->tagClose('v8:АдресДоставкиПеревозчика');
        $this->tagClose('v8:АдресДоставкиПеревозчикаЗначенияПолей');
        $this->tag('v8:ОсобыеУсловияПеревозки', 'false');
        $this->tagClose('v8:ОсобыеУсловияПеревозкиОписание');
        $this->tagAtr('v8:НаправлениеДеятельности', '00000000-0000-0000-0000-000000000000', 'xsi:type', 'v8:CatalogRef.НаправленияДеятельности');
        $this->tag('v8:ЕстьАлкогольнаяПродукция', 'false');
        $this->tagAtr('v8:Соглашение', '00000000-0000-0000-0000-000000000000', 'xsi:type', 'v8:CatalogRef.СоглашенияСПоставщиками');
        $this->tagAtr('v8:Организация', '524c907a-4f4c-4cba-a61d-6bb28e730c9d', 'xsi:type', 'v8:CatalogRef.Организации');
        $this->tag('v8:КурсЧислитель', '1');
        $this->tag('v8:КурсЗнаменатель', '1');
        $this->tagAtr('v8:АпкСтатьяРасходовЕСХН', '00000000-0000-0000-0000-000000000000', 'xsi:type', 'v8:CatalogRef.АпкСтатьиРасходовЕСХН');
        $this->tag('v8:ЕстьМаркируемаяПродукцияГИСМ', 'false');
        $this->tag('v8:ЕстьКиЗГИСМ', 'false');
        $this->tag('v8:ВариантПриемкиТоваров', 'РазделенаТолькоПоНакладным');
        $this->tag('v8:СуммаВзаиморасчетовПоТаре', '0');
        $this->tag('v8:АвансовыйОтчет', '00000000-0000-0000-0000-000000000000');
        $this->tagClose('v8:НаименованиеВходящегоДокумента');
        $this->tag('v8:ОплатаВВалюте', 'false');
        $this->tagClose('v8:АдресДоставкиЗначение');
        $this->tagClose('v8:АдресДоставкиПеревозчикаЗначение');
        $this->tag('v8:КорректировкаОстатковРНПТ', 'false');
        $this->tag('v8:ДатаПоступления', '0001-01-01T00:00:00');
        $this->tag('v8:ДатаКурсаВалютыДокумента', '0001-01-01T00:00:00');
        $this->tag('v8:НоваяМеханикаСозданияЗаявленийОВвозе', 'true');
        $this->tagAtr('v8:ОбъектРасчетовУпр', '00000000-0000-0000-0000-000000000000', 'xsi:type', 'v8:CatalogRef.ОбъектыРасчетов');
        $this->tag('v8:ОперацияССамозанятым', 'false');
        $this->tagClose('v8:ИдентификаторПлатежа');

        foreach ($counterpartyInformation as $toDay){

            foreach ($toDay as $value){
                xmlwriter_start_element($this->xw, 'v8:Товары');
                $this->tagAtr('v8:Номенклатура', $this->typeId($value['type']), 'xsi:type', 'v8:CatalogRef.Номенклатура');
                $this->tagAtr('v8:НоменклатураПартнера', '00000000-0000-0000-0000-000000000000', 'xsi:type', 'v8:CatalogRef.НоменклатураКонтрагентов');
                $this->tagAtr('v8:Характеристика', '00000000-0000-0000-0000-000000000000', 'xsi:type', 'v8:CatalogRef.ХарактеристикиНоменклатуры');
                $this->tagAtr('v8:Упаковка', '00000000-0000-0000-0000-000000000000', 'xsi:type', 'v8:CatalogRef.УпаковкиЕдиницыИзмерения');
                $this->tag('v8:КоличествоУпаковок', $value['value']);
                $this->tag('v8:Количество', $value['value']);
                $this->tag('v8:КоличествоПоРНПТ', '0');
                $this->tag('v8:Цена', $value['price']);
                $this->tagAtr('v8:ВидЦеныПоставщика', '00000000-0000-0000-0000-000000000000', 'xsi:type', 'v8:CatalogRef.ВидыЦенПоставщиков');
                $this->tag('v8:ПроцентРучнойСкидки', '0');
                $this->tag('v8:СуммаРучнойСкидки', '0');
                $this->tag('v8:Сумма', $value['summa']);
                $this->tagAtr('v8:СтавкаНДС', $value['ndsText'], 'xsi:type', 'v8:CatalogRef.СтавкиНДС');
                $this->tag('v8:СуммаНДС', $value['nds']);
                $this->tag('v8:СуммаСНДС', $value['summa']);
                $this->tagAtr('v8:СтатьяРасходов', '00000000-0000-0000-0000-000000000000', 'xsi:type', 'v8:ChartOfCharacteristicTypesRef.СтатьиРасходов');
                $this->tagAtr('v8:АналитикаРасходов', '', 'xsi:nil', 'true');
                $this->tag('v8:КодСтроки', '0');
                $this->tagAtr('v8:НомерГТД', '00000000-0000-0000-0000-000000000000', 'xsi:type', 'v8:CatalogRef.НомераГТД');
                $this->tagAtr('v8:Склад', $value['sklad_id'], 'xsi:type', 'v8:CatalogRef.Склады');
                $this->tag('v8:ЗаказПоставщику', '00000000-0000-0000-0000-000000000000');
                $this->tagClose('v8:Сертификат');
                $this->tagClose('v8:НомерПаспорта');
                $this->tag('v8:СтатусУказанияСерий', '0');
                $this->tagAtr('v8:Сделка', '00000000-0000-0000-0000-000000000000', 'xsi:type', 'v8:CatalogRef.СделкиСКлиентами');
                $this->tag('v8:СуммаВзаиморасчетов', '0');
                $this->tag('v8:СуммаНДСВзаиморасчетов', '0');
                $this->tagAtr('v8:ВидЗапасов', '6318edea-e865-11f0-9f62-0024ecf4e982', 'xsi:type', 'v8:CatalogRef.ВидыЗапасов');
                $this->tag('v8:ИдентификаторСтроки', Str::uuid());
                $this->tagAtr('v8:Назначение', '00000000-0000-0000-0000-000000000000', 'xsi:type', 'v8:CatalogRef.Назначения');
                $this->tag('v8:АпкЧислоГолов', '0');
                $this->tagAtr('v8:Серия', '00000000-0000-0000-0000-000000000000', 'xsi:type', 'v8:CatalogRef.СерииНоменклатуры');
                $this->tagAtr('v8:АналитикаУчетаНоменклатуры', 'de500a22-fbf6-11f0-9f62-0024ecf4e982', 'xsi:type', 'v8:CatalogRef.КлючиАналитикиУчетаНоменклатуры');
                $this->tagAtr('v8:Подразделение', '00000000-0000-0000-0000-000000000000', 'xsi:type', 'v8:CatalogRef.СтруктураПредприятия');
                $this->tag('v8:СписатьНаРасходы', 'false');
                $this->tagClose('v8:НомерВходящегоДокумента');
                $this->tag('v8:ДатаВходящегоДокумента', '0001-01-01T00:00:00');
                $this->tagAtr('v8:ОбъектРасчетов', 'd55cd6d7-fbf6-11f0-9f62-0024ecf4e982', 'xsi:type', 'v8:CatalogRef.ОбъектыРасчетов');
                $this->tagClose('v8:НаименованиеВходящегоДокумента');
                $this->tag('v8:СуммаИтог', '1000');
                $this->tag('v8:зрнКарточкаАнализа', '00000000-0000-0000-0000-000000000000');

                xmlwriter_end_element($this->xw);
            }

        }

        xmlwriter_start_element($this->xw, 'v8:ЭтапыГрафикаОплаты');
        $this->tag('v8:Заказ', '00000000-0000-0000-0000-000000000000');
        $this->tag('v8:СверхЗаказа', 'false');
        $this->tag('v8:ВариантОплаты', 'КредитПослеПоступления');
        $this->tag('v8:ДатаПлатежа', '2026-01-28T00:00:00');
        $this->tag('v8:Сдвиг', '0');
        $this->tag('v8:ПроцентПлатежа', '100');
        $this->tag('v8:СуммаПлатежа', '100');
        $this->tag('v8:ПроцентЗалогаЗаТару', '0');
        $this->tag('v8:СуммаЗалогаЗаТару', '0');
        $this->tag('v8:СуммаВзаиморасчетов', '100');
        $this->tag('v8:СуммаВзаиморасчетовПоТаре', '0');
        $this->tagAtr('v8:ОбъектРасчетов', 'd55cd6d7-fbf6-11f0-9f62-0024ecf4e982', 'xsi:type', 'v8:CatalogRef.ОбъектыРасчетов');
        $this->tag('v8:ВариантОтсчета', 'ОтДатыОтгрузки');

        xmlwriter_end_element($this->xw);
        xmlwriter_end_element($this->xw);
        xmlwriter_end_element($this->xw);
        $this->tagClose('PredefinedData');
        xmlwriter_end_element($this->xw);
        xmlwriter_end_document($this->xw);
        file_put_contents(storage_path() .'/app/public/card/export.xml', "\xEF\xBB\xBF" . xmlwriter_output_memory($this->xw));
    }

    private function typeId($typeName): string
    {
        if (str_contains($typeName, '92')){
            return '6ab76806-ba58-4302-a637-77cc34fa455b';
        } elseif (str_contains($typeName, '95')){
            return '032af63b-3816-4596-a3f7-e2d881be960c';
        }
        elseif (str_contains($typeName, '96')){
            return '032af63b-3816-4596-a3f7-e2d881be960c';
        }
        elseif (str_contains($typeName, '98')){
            return '032af63b-3816-4596-a3f7-e2d881be960c';
        }
        elseif (str_contains($typeName, '100')){
            return '032af63b-3816-4596-a3f7-e2d881be960c';
        }
        else{
            return '2e2e60c9-759f-440d-b50a-d0789e4b9cd2';
        }

    }

    private function tag($tag, $value = ''):void
    {
        xmlwriter_start_element($this->xw, $tag);
        xmlwriter_text($this->xw, $value);
        xmlwriter_end_element($this->xw);
    }

    private function tagClose($tag):void
    {
        xmlwriter_write_element($this->xw, $tag);
    }

    private function tagAtr($tag, $value, $atrName, $atrValue):void
    {
        xmlwriter_start_element($this->xw, $tag);
        xmlwriter_start_attribute($this->xw, $atrName);
        xmlwriter_text($this->xw, $atrValue);
        xmlwriter_end_attribute($this->xw);
        xmlwriter_text($this->xw, $value);
        xmlwriter_end_element($this->xw);
    }
}
