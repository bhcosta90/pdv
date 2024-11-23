<?php

declare(strict_types = 1);

namespace App\Actions\Register;

use App\Models\{Register};
use App\Rules\StoreRule;
use App\Trait\StoreActionTrait;
use Lorisleiva\Actions\Concerns\{AsAction, WithAttributes};

class ShowRegister
{
    use AsAction;
    use WithAttributes;
    use StoreActionTrait;

    protected Register $register;

    public function handle(string $code): Register
    {
        $this->set('register_id', ($this->register = Register::whereCode($code)->first())->id);
        $this->validateAttributes();

        return $this->register;
    }

    public function authorize(): bool
    {
        return $this->user->can('show', [$this->register, $this->store]);
    }

    public function rules(): array
    {
        return [
            'register_id' => ['required', new StoreRule(new Register(), $this->store->id)],
        ];
    }
}
