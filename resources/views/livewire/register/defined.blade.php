<x-form wire:submit="save">
    @if(blank($this->modelRegister))
        <x-select
            :label="__('Caixa registradora')"
            icon="o-user"
            option-value="code"
            option-label="name"
            :options="$this->registers"
            wire:model="register"
            :placeholder="__('Selecione o caixa')"
        >
            <x-slot:append>
                <x-button :label="__('Salvar')" icon="o-check" class="btn-primary rounded-s-none" type="submit" spinner="save" />
            </x-slot:append>
        </x-select>
    @endif

    @if(filled($this->modelRegister))
        <p>
            @lang('Está configurado o caixa <strong>:name</strong> nessa máquina', ['name' => $this->modelRegister->name])
            @if(filled($this->modelRegister->opened_by))
                <span class="badge badge-success">@lang('Aberto')</span>
            @endif
        </p>
    @endif
</x-form>
