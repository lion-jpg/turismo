<div class="content">
    <div class="custom-background">
        <x-filament-panels::page.simple>

            @if (filament()->hasRegistration())
            <x-slot name="subheading">
                {{ __('filament-panels::pages/auth/login.actions.register.before') }}

                {{ $this->registerAction }}
            </x-slot>
            @endif

            {{ \Filament\Support\Facades\FilamentView::renderHook('panels::auth.login.form.before') }}
            <div class="filament-login-page">
                <x-filament-panels::form wire:submit="authenticate">
                    {{ $this->form }}

                    <x-filament-panels::form.actions :actions="$this->getCachedFormActions()"
                        :full-width="$this->hasFullWidthFormActions()" />
                </x-filament-panels::form>
            </div>


            {{ \Filament\Support\Facades\FilamentView::renderHook('panels::auth.login.form.after') }}
        </x-filament-panels::page.simple>
    </div>



<style>
.content {
    position: relative;
    background-image: var(--bg-image);
    background-size: cover;
    background-position: center;
    height: 65vh;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 15px;
    border: 5px solid var(--border-color);
    box-shadow: var(--glow-shadow);
}

.content::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    border-radius: 15px;
    background-color: var(--overlay-color);
    z-index: 0;
}

.filament-login-page {
    position: relative;
    z-index: 1;
    background-color: var(--form-bg);
    padding: 2rem;
    border-radius: 10px;
    box-shadow: var(--form-shadow);
}
 
.custom-background {
    position: relative;
    z-index: 1;
}

:root {
    --bg-image: url('{{ asset('storage/boot.jpg') }}');
    --border-color: rgba(255, 255, 255, 0.8);
    --glow-shadow: 0 0 20px rgba(255, 255, 255, 0.4);
    --overlay-color: rgba(0, 0, 0, 0.4);
    --form-bg: rgba(255, 255, 255, 0.1);
    --form-shadow: 0 8px 32px rgba(31, 38, 135, 0.37);
}

.dark {
    --border-color: rgba(8, 8, 8, 0.2);
    --glow-shadow: 0 0 20px rgba(0, 0, 0, 0.6);
    --overlay-color: rgba(0, 0, 0, 0.6);
    --form-bg: rgba(0, 0, 0, 0.2);
    --form-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
}

.filament-login-page form {
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
}

.filament-login-page label {
    color: var(--text-color, white);
    font-weight: 500;
}

.filament-login-page input {
    background-color: var(--input-bg, rgba(233, 222, 222, 0.1));
    border: 1px solid var(--input-border, rgba(255, 255, 255, 0.2));
    color: var(--input-text, black);
}

.filament-login-page input:focus {
    border-color: var(--input-focus-border, rgba(255, 255, 255, 0.5));
    box-shadow: 0 0 0 2px var(--input-focus-shadow, rgba(19, 18, 18, 0.1));
}
</style>
</div>