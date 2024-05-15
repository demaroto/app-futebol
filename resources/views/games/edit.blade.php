<x-layouts>
    <x-slot:header>
        Editar Partida
    </x-slot:header>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
        <form class="space-y-6" action="{{ route('games.update', $game->id) }}" method="POST">
          @csrf
          @method('put')
          <input type="hidden" name="game_id" value="{{ $game->id }}">
          <div>
            <label for="date" class="block text-sm font-medium leading-6 text-gray-900">Data</label>
            <div class="mt-2">
                <input id="date" value="{{ date('Y-m-d', strtotime($game->date))}}" name="date" type="date"  required class="block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
            </div>
            @error('date')
            <p class="text-red-500">{{ $message }}</p>
            @enderror
        </div>
        
        <div>
            <label for="limit_players" class="block text-sm font-medium leading-6 text-gray-900">Limite de Jogadores no time</label>
            <div class="flex items-center">
                <input id="limit_players" value="{{ $game->limit_players }}" name="limit_players" type="number" min="1" max="11" required class="block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
            </div>
            @error('limit_players')
              <p class="text-red-300">{{ $message }}</p>
            @enderror
          </div>
  
          <div>
            <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Editar Partida</button>
          </div>
        </form>
  
      </div>

    

</x-layouts>