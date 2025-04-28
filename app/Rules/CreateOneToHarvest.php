<?php

namespace App\Rules;

use App\Actions\harvest\HarvestAction;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CreateOneToHarvest implements ValidationRule
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
        if ($this->harvestAction->HarvestYear($value) <> $this->harvestAction->HarvestYear(now())){
            $fail ('Запрещено вносить указанной датой');
        }
    }
}
