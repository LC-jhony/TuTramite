@props(['color'])
<div class="flex items-center gap-2">
    <span class="h-4 w-4 rounded-full" style="background-color: {{ $color->getColor() }};"></span>
    <span>{{ $color->getLabel() }}</span>
</div>
