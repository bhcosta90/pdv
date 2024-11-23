<?php

declare(strict_types = 1);

namespace App\Livewire\Register;

use App\Actions\Register\{BrowserRegister, ShowRegister};
use App\Models\Register;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Defined extends Component
{
    public ?string $register = null;

    public ?Register $modelRegister = null;

    public function mount(BrowserRegister $browserRegister): void
    {
        $this->modelRegister = $browserRegister->handle();
    }

    public function render(): View
    {
        return view('livewire.register.defined');
    }

    #[Computed]
    public function registers(): Collection
    {
        return store()->registers;
    }

    public function save(ShowRegister $showRegister): void
    {
        $register = $showRegister->handle($this->register);

        $cookie = \Cookie::forever('register', $register->code);

        \Cookie::queue($cookie);

        $this->modelRegister = $register;
    }
}
