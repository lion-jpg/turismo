<x-filament-panels::page class="fi-dashboard-page">

    @if (method_exists($this, 'filtersForm'))
        {{ $this->filtersForm }}
    </x-filament-panels::page>
    @endif

    <x-filament-widgets::widgets
        :columns="$this->getColumns()"
        :data="
            [
                ...(property_exists($this, 'filters') ? ['filters' => $this->filters] : []),
                ...$this->getWidgetData(),
            ]
        "
        :widgets="$this->getVisibleWidgets()"
    />
  