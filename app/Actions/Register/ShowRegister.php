<?php

declare(strict_types = 1);

namespace App\Actions\Register;

use App\Interfaces\UserInterface;
use App\Models\Register;
use Lorisleiva\Actions\Concerns\{AsAction, WithAttributes};

class ShowRegister
{
    use AsAction;
    use WithAttributes;

    protected Register $register;

    public function __construct(protected UserInterface $user)
    {
        //
    }

    public function handle(string $code): Register
    {
        $this->set('register_id', ($this->register = Register::whereCode($code)->first())->id);
        $this->validateAttributes();

        return $this->register;
    }

    public function authorize(): bool
    {
        return $this->user->user()->can('show', [$this->register, $this->user->store()]);
    }

    public function rules(): array
    {
        return [
            'register_id' => ['required', 'exists:registers,id'],
        ];
    }
}
