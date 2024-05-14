<?php

namespace App\Services;

use App\Dto\Game\GameInputDto;
use App\Dto\Game\GameOutputDto;
use App\Dto\GamePlayer\GamePlayerInputDto;
use App\Dto\Team\TeamOutputDto;
use App\Repositories\GameRepository;
use Faker\Factory;

class GameService
{

    public function createGame(string $date, int $limit_players): GameOutputDto
    {
        $inputDto = new GameInputDto($date, $limit_players);
        $gameRepository = GameRepository::create($inputDto->toArray());
        $outputDto = new GameOutputDto($gameRepository->id, $inputDto->date, $inputDto->limit_players);
        return $outputDto;
    }

    public function next()
    {
        $gameRepository = GameRepository::getNextGame();
        return $gameRepository;
    }

    public function checkPlayer($idGame)
    {
        $gameRepository = GameRepository::playerConfirmed($idGame);
        //Jogadores com time
        $playersWithTeam = $gameRepository->gamePlayers->filter(fn ($qr) => $qr['team_id'] != null)->count();
        //Todos os players
        $playerAll = $gameRepository->players;
        
        //Ajustando goleiros que confirmaram presença
        foreach ($playerAll->toArray() as $v) {
            foreach ($gameRepository->gamePlayers->toArray() as $j) {
                if ($v['id'] == $j['player_id']) {
                    $players[$v['id']] = [
                        'id' => $v['id'],
                        'level' => $v['level'],
                        'goalkeeper' => $v['goalkeeper'],
                        'gamePlayer_id' => $j['id'],
                        'team_id' => $j['team_id'],
                        'game_id' => $j['game_id'],
                        'confirmed' => $j['confirmed']
                    ];
                }
            }
        }
        
        $countPlayers = array_count_values(array_column($players, 'goalkeeper'));
        $goalkeepers = in_array(1, array_keys($countPlayers)) ? $countPlayers[1] : 0;
        $playersLine = in_array(0, array_keys($countPlayers)) ? $countPlayers[0] : 0;
       
        //Quantidade confirmados
        $qtdConfirmed = $gameRepository->gamePlayers->count() - $playersWithTeam;

        //Jogadores totais confirmados para formar os times
        $teamsTotal = $qtdConfirmed > 0 ? intval(($goalkeepers+$playersLine) / $gameRepository->limit_players) : 0;
        //dd(['teams' => $teamsTotal, 'goalkeepers' => $goalkeepers]);
        //Se a quantidade de jogadores e goleiros estiverem corretas
        if ($qtdConfirmed > 0 &&  $teamsTotal >= 2 && $goalkeepers == $teamsTotal) {
            
            $this->cleanGameById($idGame);
            //Criar os teams
            for ($x = 0; $x < $teamsTotal; $x++) {
                $teamService = new TeamService();
                $team_name = 'Time ' . ($x + 1);
                $teams[$x] = $teamService->createTeam($team_name, $idGame);
            
            }

            $this->addPlayerToGame($idGame, $teams, $players);

        }else{

            if (intval($playersWithTeam / $gameRepository->limit_players) < 2){
                //Limpa todos os times dessa partida
                $this->cleanGameById($idGame);
            }
            
        }
    }

    public function addPlayerToGame($id, $teams, $players)
    {
        $gameRepository = GameRepository::find($id);
        $qtyPlayers = $gameRepository->limit_players - 1;
        //Ordenar por vele
        $columns = array_column($players, 'level');
        array_multisort($columns, SORT_DESC, $players);
        $newTeams = [];
        $playersOnly = array_values(array_filter($players, fn ($p) => $p['goalkeeper'] == 0));
        $playersGoalKeeper = array_values(array_filter($players, fn ($p) => $p['goalkeeper'] == 1));
        $key = 0;

        //Aplicar jogadores aos times distribuindo por level
        foreach ($teams as $v) {
            for ($i = 0; $i < $qtyPlayers; $i++) {
                $newTeams[$key][] = $playersOnly[0];
                $key = $this->nextKey($key, $teams);
                unset($playersOnly[0]);
                $playersOnly = array_values($playersOnly);
            }
        }
        //Adicionando um goleiro
        foreach ($teams as $k => $v) {
            $newTeams[$k][] = $playersGoalKeeper[0];
            unset($playersGoalKeeper[0]);
            $playersGoalKeeper = array_values($playersGoalKeeper);
        }

        //Enviar para GamePlayerService
        foreach($newTeams as $k => $news) {
            foreach($news as $new) {
                $dto = new GamePlayerInputDto($new['id'], $id, true, 0, $teams[$k]->id);
                $gamePlayerService = new GamePlayerService();
                $gamePlayerService->updateGamePlayer($new['gamePlayer_id'], $dto);
            }
        }
        
    }

    private function cleanGameById($id)
    {
        $gamePlayerService = new GamePlayerService();
        $teamService = new TeamService();
        $gamePlayerService->cleanTeamByGameId($id);
        $teamService->deleteByGameId($id);
        
    }

    private function nextKey(int $key, array $array)
    {
        if ($key < count($array) && $key + 1 < count($array)) {
            return $key + 1;
        } else {
            return 0;
        }
    }
}
