<x-layout>
    <x-slot:header>
        Jogadores
    </x-slot:header>

    <ul role="list" class="divide-y divide-gray-100">
        @foreach ($players as $player)
            <li class="flex justify-between gap-x-6 py-5" onclick="{{ route('players.view', $player->id) }}">
                <div class="flex min-w-0 gap-x-4">
                    <img class="h-12 w-12 flex-none rounded-full bg-gray-50"
                        src="{{ URL::to('assets/images/soccer-player.png') }}" alt="icone jogador">
                    <div class="min-w-0 flex-auto">
                        <p class="mt-1 truncate text-xs leading-5 text-gray-500">{{ $player->user->nickname }}</p>
                        <p class="text-sm leading-6 text-gray-900">Level: {{ $player->level }}</p>
                    </div>
                </div>


                <div class="shrink-0 sm:flex sm:flex-col sm:items-end">
                    <a href="{{ route('players.view', $player->id) }}"
                        class="bg-gray-900 text-white hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium"><i
                            class="fa-solid fa-eye"></i> Visualizar </a>
                </div>

            </li>
        @endforeach
    </ul>
    {{ $players->links() }}
</x-layout>
