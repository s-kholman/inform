<?php

namespace App\Rules;

use App\Actions\harvest\HarvestAction;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CreateOneToHarvestProductMonitoring implements ValidationRule
{
    public HarvestAction $harvestAction;

    public function __construct()
    {
        $this->harvestAction = new HarvestAction();
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->harvestAction->HarvestYear($value, 8) <> $this->harvestAction->HarvestYear(now(), 8)){
            $fail ('Запрещенно вносить указанной датой');
        }
    }
}
