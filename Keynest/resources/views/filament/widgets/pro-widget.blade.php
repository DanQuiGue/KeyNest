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
    <x-filament::card class="bg-gradient-to-r from-blue-500 to-purple-600 text-white">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold">¡Mejora al plan TEAM!</h2>
                <p class="mt-1 text-white/90">
                    Hasta 20 juegos, 1000 claves al mes envíos masivos y mas funciones

                </p>
                <a href="" class="mt-3 inline-block bg-white text-blue-600 font-semibold px-4 py-2 rounded-md shadow hover:bg-gray-100 transition">
                    Suscribirse al plan TEAM
                </a>
            </div>
            <img src="https://cdn-icons-png.flaticon.com/512/1055/1055687.png" alt="Upgrade" class="w-24 h-24">
        </div>
    </x-filament::card>
</x-filament::widget>
