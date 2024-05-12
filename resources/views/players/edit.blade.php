<x-layouts>
    <x-slot:header>
        Editar Jogador - {{ $player->user->nickname }}
    </x-slot:header>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
        <form class="space-y-6" action="{{ route('players.update', $player->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div>
                <label for="level" class="block text-sm font-medium leading-6 text-gray-900">Level</label>
                <div class="mt-2">
                    <input id="level" value="{{ $player->level }}" name="level" type="number" min="1"
                        max="5" required
                        class="block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                </div>
                @error('level')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <div class="flex items-center">
                    <input id="filter-mobile-color-0" name="goalkeeper" {{ $player->goalkeeper ? 'checked' : '' }}
                        type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    <label for="filter-mobile-color-0"
                        class="ml-3 min-w-0 flex-1 block text-sm font-medium leading-6 text-gray-900">Goleiro</label>
                </div>
                @error('goalkeeper')
                    <p class="text-red-300">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <button type="submit"
                    class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Salvar</button>
            </div>
        </form>
        @if ($game)
            <div class="px-6 pt-4 pb-2">
                <div class="font-bold text-xl mb-2">Confirmar Presença no Fut</div>
                <p>Próxima data: {{ date('d/m/Y', strtotime($game->date)) }}</p>
                <p>Jogadores: {{ $game->limit_players }}</p>
                @if (count($gamePlayer))
                    @if ($gamePlayer[0]['confirmed'] == 0)
                        <form method="post" action="{{ route('gamePlayer.update', $game->id) }}">
                            @csrf
                            @method('put')
                            <input type="hidden" name="id" value="{{ $gamePlayer[0]['id'] }}">
                            <input type="hidden" name="game_id" value="{{ $game->id }}">
                            <input type="hidden" name="player_id" value="{{ $player->id }}">
                            <input type="hidden" name="team_id" value="0">
                            <input type="hidden" name="confirmed" value="1">
                            
                            <button
                                class="bg-green-900 mt-3 text-white hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium"
                                type="submit">Confirmar</button>
                        </form>
                    @endif
                    @if ($errors->any())
                        @foreach ($errors as $error)
                            <p>{{ $error->message }}</p>
                        @endforeach
                    @endif
                    @if ($gamePlayer[0]['confirmed'] == 1)
                        <form method="post" action="{{ route('gamePlayer.update', $game->id) }}">
                            @csrf
                            @method('put')
                            <input type="hidden" name="id" value="{{ $gamePlayer[0]['id'] }}">
                            <input type="hidden" name="game_id" value="{{ $game->id }}">
                            <input type="hidden" name="player_id" value="{{ $player->id }}">
                            <input type="hidden" name="confirmed" value="0">
                            <input type="hidden" name="team_id" value="0">
                            <div
                                                            class="bg-green-300 text-black rounded-md px-3 py-2 me-1 text-sm font-medium"><i
                                                                class="fa-solid fa-check"></i> Presença Confirmada </div>
                            <button
                                class="bg-red-500 text-white hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 mt-3 text-sm font-medium"
                                type="submit">Deixar para próxima vez</button>
                        </form>
                    @endif
                @else
                    <form method="post" action="{{ route('gamePlayer.store') }}">
                        @csrf
                        <input type="hidden" name="game_id" value="{{ $game->id }}">
                        <input type="hidden" name="player_id" value="{{ $player->id }}">
                        <input type="hidden" name="confirmed" value="1">
                        <button
                            class="bg-green-900 mt-3 text-white hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium"
                            type="submit">Confirmar</button>
                    </form>
                @endif
            </div>
        @endif
    </div>
</x-layouts>
