<?php

namespace App\Http\Controllers\Cards;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoadCounterpartyInformationRequest;
use Carbon\Carbon;
use Illuminate\Support\Str;

class CreateExportInformationUPPController extends Controller
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

        xmlwriter_start_attribute($this->xw, 'xmlns:v8');
        xmlwriter_text($this->xw, 'http://v8.1c.ru/data');
        xmlwriter_end_attribute($this->xw);

        xmlwriter_start_attribute($this->xw, 'xmlns:xsi');
        xmlwriter_text($this->xw, 'http://www.w3.org/2001/XMLSchema-instance');
        xmlwriter_end_attribute($this->xw);

        xmlwriter_start_element($this->xw, 'V8Exch:Data');

        xmlwriter_start_element($this->xw, 'DocumentObject.ПоступлениеТоваровУслуг');
        $this->tag('Ref', Str::uuid());
        $this->tag('DeletionMark', 'false');
        $this->tag('Date',Carbon::parse($request['documentDate'])->format('Y-m-d') . 'T06:00:00');
        $this->tag('Number');
        $this->tag('Posted', 'false');
        $this->tag('ВалютаДокумента', 'a3d28f02-599a-11e4-80ca-6eae8b538cc9');
        $this->tag('ВидОперации', 'ПокупкаКомиссия');
        $this->tag('ВидПоступления', 'НаСклад');
        $this->tag('ДатаВходящегоДокумента', Carbon::parse($request['counterpartyDate'])->format('Y-m-d') . 'T00:00:00');
        $this->tag('ДоговорКонтрагента', '2d61a427-088a-11f0-812e-6eae8b538cc9');
        $this->tag('БанковскийСчетКонтрагента', '00000000-0000-0000-0000-000000000000');
        $this->tagClose('Комментарий');
        $this->tag('Контрагент','2d61a426-088a-11f0-812e-6eae8b538cc9');
        $this->tag('КратностьВзаиморасчетов', '1');
        $this->tag('КурсВзаиморасчетов', '1');
        $this->tag('НДСВключенВСтоимость', 'false');
        $this->tag('НомерВходящегоДокумента', $request['counterpartyNumber']);
        $this->tag('Организация', '524c907a-4f4c-4cba-a61d-6bb28e730c9d');
        $this->tag('Ответственный', '8d1d6cb4-7881-11ea-811f-6eae8b538cc9');
        $this->tag('ОтражатьВБухгалтерскомУчете', 'true');
        $this->tag('ОтражатьВНалоговомУчете', 'true');
        $this->tag('ОтражатьВУправленческомУчете', 'true');
        $this->tag('ПодразделениеОрганизации', '00000000-0000-0000-0000-000000000000');
        $this->tag('Подразделение', '00000000-0000-0000-0000-000000000000');
        $this->tag('РегистрироватьЦеныПоставщика', 'false');
        $this->tag('СуммаВключаетНДС', 'true');
        $this->tagAtr('СкладОрдер', '00000000-0000-0000-0000-000000000000', 'xsi:type', 'CatalogRef.Склады'); //?
        $this->tag('СуммаДокумента', '1000');//??
        $this->tag('СчетУчетаРасчетовПоАвансам','821358d4-6d13-40c0-aa96-a1a619a1f966');
        $this->tag('СчетУчетаРасчетовПоТаре', 'e9dfed15-3ce9-431f-bedb-de4df55dd07a');
        $this->tag('СчетУчетаРасчетовСКонтрагентом', 'a2912351-d8b0-4471-8bb7-faa192adf582');
        $this->tag('ТипЦен', '00000000-0000-0000-0000-000000000000');
        $this->tag('УчитыватьНДС', 'true');
        $this->tagAtr('Сделка', '00000000-0000-0000-0000-000000000000', 'xsi:type', 'DocumentRef.ЗаказПоставщику');
        $this->tag('УсловиеПродаж', '00000000-0000-0000-0000-000000000000');
        $this->tagAtr('Проект', '', 'xsi:nil', 'true');//?
        $this->tag('Грузоотправитель', '00000000-0000-0000-0000-000000000000');
        $this->tag('Грузополучатель', '00000000-0000-0000-0000-000000000000');
        $this->tagClose('НомерВходящегоДокументаЭлектронногоОбмена');
        $this->tag('ДатаВходящегоДокументаЭлектронногоОбмена', '0001-01-01T00:00:00');
        $this->tagAtr('ИнтекоДокументОснование', '', 'xsi:nil', 'true'); //?
        $this->tag('ЕстьАлкогольнаяПродукция', 'false');
        $this->tag('УдалитьДокЕГАИС', '00000000-0000-0000-0000-000000000000');
        $this->tag('УдалитьПолученИзЕГАИС', 'false');
        $this->tag('УдалитьАктПереданВЕГАИС', 'false');
        $this->tag('УдалитьПереданВЕГАИССРасхождениями', 'false');
        $this->tag('ДатаПриема', '0001-01-01T00:00:00');
        $this->tag('ЭтоУниверсальныйДокумент', 'false');
        $this->tag('ПлатаЗаПравоПользованияПредметамиАренды', 'false');
        $this->tag('СчетУчетаНДСПоАренднымОбязательствам', 'edd0035b-cf47-4b3a-9408-5e99d5971c70');
        $this->tag('СчетУчетаПроцентовПоАренде', '16b6b70d-e803-4fa3-ace5-e4130dbca14f');
        $this->tag('СтавкаДисконтирования', '0');
        $this->tag('ДатаОкончанияАренды', '0001-01-01T00:00:00');
        $this->tag('СтоимостьОбязательства', '0');
        $this->tag('АвансовыеПлатежи', '0');
        $this->tagClose('СпособОценкиАрендыБУ');//?

        xmlwriter_start_element($this->xw, 'Товары');
        foreach ($counterpartyInformation as $toDay){

            foreach ($toDay as $value){
                xmlwriter_start_element($this->xw, 'Row');
                $this->tag('Номенклатура', $this->typeId($value['type']));
                $this->tag('КоличествоМест', '0');
                $this->tag('ЕдиницаИзмерения', 'd4c2d0de-9c8a-11e4-80d0-6eae8b538cc9');
                $this->tag('ЕдиницаИзмеренияМест', '00000000-0000-0000-0000-000000000000');
                $this->tag('Коэффициент', '1');
                $this->tag('Количество', $value['value']);
                $this->tag('Цена', $value['price']);
                $this->tag('Сумма', $value['summa']);
                $this->tag('СтавкаНДС', $value['ndsText']);
                $this->tag('СуммаНДС', $value['nds']);
                $this->tag('СчетУчетаБУ', '325d3cff-22ce-4f34-b28d-e13b750ceacb');
                $this->tag('СерияНоменклатуры', '00000000-0000-0000-0000-000000000000');
                $this->tag('ХарактеристикаНоменклатуры', '00000000-0000-0000-0000-000000000000');
                $this->tagAtr('Заказ', '', 'xsi:nil', 'true');
                $this->tag('СчетУчетаНДС', '924f0af0-5e54-41af-af07-628265e965ed');
                $this->tag('СчетУчетаНУ', '1ad29b8d-3c82-44ae-b5c1-917017199635');
                $this->tag('ОтражениеВУСН', 'Принимаются');
                $this->tag('Склад', $value['sklad_id']);
                $this->tag('ПриходныйОрдер', '00000000-0000-0000-0000-000000000000');
                $this->tag('ЗаказПоставщику', '00000000-0000-0000-0000-000000000000');
                $this->tag('КлючСвязи', '0');
                $this->tag('ИнтекоЧислоГолов', '0');
                $this->tag('АлкогольнаяПродукция', '00000000-0000-0000-0000-000000000000');
                $this->tagClose('ИдентификаторСтроки');
                $this->tagClose('ИдентификаторУпаковки');
                $this->tag('ПрослеживаемыйТовар', 'false');
                $this->tag('СтранаПроисхождения', '982d33e2-bee6-453a-992e-11d13fa66fa7');
                $this->tag('СпособОтраженияРасходов', '00000000-0000-0000-0000-000000000000');
                $this->tag('СчетПередачиБУ', '00000000-0000-0000-0000-000000000000');
                $this->tag('ПрослеживаемыйКомплект', 'false');

                xmlwriter_end_element($this->xw);
            }

        }


        xmlwriter_end_element($this->xw);
        $this->tagClose('ВозвратнаяТара');
        $this->tagClose('Услуги');
        $this->tagClose('Оборудование');
        $this->tagClose('ОбъектыСтроительства');
        $this->tagClose('СерийныеНомера');
        $this->tagClose('ДокументыРасчетовСКонтрагентом');
        $this->tagClose('ШтрихкодыУпаковок');
        $this->tagClose('СведенияПрослеживаемости');
        $this->tagClose('ГрафикПлатежей');
        xmlwriter_end_element($this->xw);

        xmlwriter_end_element($this->xw);

        xmlwriter_end_element($this->xw);

        xmlwriter_end_document($this->xw);

        file_put_contents(storage_path() .'/app/public/card/export.xml', xmlwriter_output_memory($this->xw));
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
