<x-layouts>
    <x-slot:header>
        <div class="flex justify-between">
            <div>Partidas de Futebol</div>
            <div>
                <a href="{{ route('games.create') }}" class="bg-gray-900 text-white rounded-md px-3 py-2 text-sm font-medium"><i class="fa-solid fa-plus"></i> Criar Partida </a>
            </div>
        </div>

    </x-slot:header>

    @if ($game)
    <div class="rounded overflow-hidden shadow-lg">
        <div class="px-6 py-4">
            <div class="font-bold text-xl mb-2">Próxima Partida</div>
            <p class="text-gray-900 text-base">
                Próxima partida será no dia {{ date('d/m/Y', strtotime($game->date)) }}
            </p>
            <p class="text-gray-900 text-base">
                Time com {{ $game->limit_players - 1 }} Jogadores e 1 Goleiro.
            </p>
            <div class="mt-3 flex justify-start">
                <a href="{{ route('games.edit', $game->id) }}" class="bg-gray-900 text-white rounded-md px-3 py-2 text-sm font-medium"><i class="fa-solid fa-pencil"></i> Editar Partida </a>
                <form method="post" action="{{ route('games.delete', $game->id) }}">
                    @csrf
                    @method('delete')
                    <button type="submit" class="bg-red-900 text-white rounded-md px-3 py-2 ml-1 text-sm font-medium" ><i class="fa-solid fa-trash"></i> Deletar Partida</button>
                </form>
               
            </div>
        </div>
        <div class="px-6 pt-4 pb-2">
            <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#futdagalera</span>
            <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#futebol</span>
            <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">#partiufut</span>
        </div>
        <div class="px-6 py-4 ">
            <div class="font-bold text-xl mb-2 text-center">Times ({{ $game->teams->count() }})</div>
            @if ($game->teams->count() > 0)
            <div class="flex justify-around">
                @foreach ($game->teams as $team)
                <div class="px-4 sm:px-0">
                    <h3 class="text-center font-semibold leading-7 text-blue-500">{{ $team->name }}</h3>
                    @if ($gamePlayer->count() > 0)
                    @foreach ($gamePlayer as $p)
                    @if ($p->team_id == $team->id)
                    <div>
                        <dt class="text-sm font-medium leading-6 text-gray-900 mt-1">
                            <span class="bg-gray-900 text-white rounded px-1 py-1">Level # {{ $p->player->level }} </span> {{ ucfirst($p->user->nickname) }} - {{ $p->player->goalkeeper == 1 ?  'Goleiro' : 'Jogador'}}
                        </dt>

                    </div>
                    @endif
                    @endforeach
                    @endif
                </div>
                @endforeach
            </div>





            @endif
        </div>
        <div class="px-6 py-4">
            <div class="font-bold text-xl mb-2">Jogadores ({{ $players->count() }}) - Confirmados: ({{ $gamePlayer->where('confirmed', 1)->count() }})</div>
            @if ($errors->any())
            @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
            @endforeach
            @endif
        </div>
        <div class="px-6 pt-4 pb-2">
            @if ($players->count() ?? 0 > 0)

            <div class="bg-white py-2">
                <div class="mx-auto">
                    <ul role="list" class="grid grid-cols-3 gap-4">
                        @foreach ($players as $player)
                        <li>
                            <div class="flex items-center gap-x-6">
                                <img class="h-16 w-16 rounded-full" src="{{ URL::to('/assets/images/soccer-player.png') }}" alt="Avatar de {{ $player->user->nickname }}">
                                <div>
                                    <h3 class="text-base font-semibold leading-7 tracking-tight text-gray-900">
                                        {{ $player->user->nickname }} - {{ $player->goalkeeper ? 'Goleiro' : 'Jogador' }}
                                    </h3>
                                    <p class="text-sm font-semibold leading-6 text-indigo-600">Level:
                                        {{ $player->level }}
                                    </p>
                                    <div class="flex justify-start items-center">
                                        @if ($game->gamePlayers->count() > 0)
                                        @foreach ($game->gamePlayers as $gamePlayer)
                                        @if ($gamePlayer->player_id == $player->id && $gamePlayer->confirmed == 1)
                                        <div class="bg-green-300 text-black rounded-md px-1 py-1 me-1 text-sm font-medium">
                                            <i class="fa-solid fa-check"></i> Confirmado
                                        </div>
                                        @endif
                                        @endforeach
                                        @endif
                                        <div class="">
                                            <a href="{{ route('players.edit', $player->id) }}" class="bg-gray-900 text-white rounded-md px-1 py-1 text-sm font-medium"><i class="fa-solid fa-pencil"></i> Editar </a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
        </div>
    </div>
    @endif


</x-layouts>