<x-filament::widget>
    <x-filament::card class="mt-6">
        <h3 class="text-lg font-semibold mb-2">Estadísticas actuales</h3>
        <ul class="list-disc ml-5 text-gray-700">
            <li>Claves subidas este mes: <strong>{{$thisMonth}} / {{$maxKeys}}</strong></li>
            <li>Juegos activos; <strong>{{$activeGames}} / {{$totalGamesAllowed}}</strong></li>
            <li>Claves canjeadas: <strong>{{$redeemedKeys}} </strong></li>
            <li>Porcentaje de Claves canjeadas: <strong>{{$conversionRate}} </strong></li>
        </ul>
    </x-filament::card>
</x-filament::widget>
