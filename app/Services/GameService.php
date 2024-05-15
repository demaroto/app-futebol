<?php

namespace App\Services;

use App\Dto\Game\GameEditInputDto;
use App\Dto\Game\GameInputDto;
use App\Dto\Game\GameOutputDto;
use App\Dto\GamePlayer\GamePlayerInputDto;
use App\Dto\Team\TeamOutputDto;
use App\Repositories\GameRepository;
use App\Repositories\TeamRepository;
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
        //Todos os players
        $playerAll = $gameRepository->players;

        //Ajustando goleiros que confirmaram presença
        foreach ($playerAll->toArray() as $v) {
            foreach ($gameRepository->gamePlayers->toArray() as $j) {
                if ($v['id'] == $j['player_id'] && $j['confirmed'] == 1) {
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

        //Jogadores com time
        $playersWithoutTeam = array_filter($players, fn ($qr) => $qr['goalkeeper'] == 0 && $qr['team_id'] == null);
        $playersWithTeam = array_filter($players, fn ($qr) => $qr['goalkeeper'] == 0 && $qr['team_id'] != null);
        $goalkeepersWithoutTeam = array_filter($players, fn ($qr) => $qr['goalkeeper'] == 1 && $qr['team_id'] == null);
        $goalkeepersWithTeam = array_filter($players, fn ($qr) => $qr['goalkeeper'] == 1 && $qr['team_id'] != null);
        $countPlayersWithTeams = count($playersWithTeam) + count($goalkeepersWithTeam);
        $countPlayersWithOutTeams = count($playersWithoutTeam) + count($goalkeepersWithoutTeam);

        //Quantidade confirmados
        $qtdConfirmedWithTeams = $countPlayersWithTeams + count($goalkeepersWithTeam);

        //Jogadores confirmados com time
        $teamsTotal = $qtdConfirmedWithTeams > 0 ? intval($qtdConfirmedWithTeams / $gameRepository->limit_players) : 0;
        $noTeamsTotal = $countPlayersWithOutTeams > 0 ? intval($countPlayersWithOutTeams / $gameRepository->limit_players) : 0;

        //Se a quantidade total de confirmados sem times
        if (count($players ?? []) > 0 &&  $noTeamsTotal >= 2 && $goalkeepersWithoutTeam >= 2) {

            $this->createTeams($idGame, $noTeamsTotal, array_merge($goalkeepersWithoutTeam, $playersWithoutTeam));
        } elseif (count($players ?? []) > 0 && $teamsTotal >= 2 && $noTeamsTotal == 1 &&  count($goalkeepersWithoutTeam) >= 1) {

            $this->cleanGameById($idGame);
            $this->createTeams($idGame, $noTeamsTotal + $teamsTotal, array_merge($goalkeepersWithoutTeam, $playersWithoutTeam, $playersWithTeam, $goalkeepersWithTeam));
        } else {

            if (intval($countPlayersWithTeams / $gameRepository->limit_players) < 2) {
                //Limpa todos os times dessa partida
                $this->cleanGameById($idGame);
            }

            if ($this->verifyTeams($idGame, $gameRepository->limit_players)) {
                $this->cleanGameById($idGame);
            }
        }

        $this->cleanTeamEmpty($idGame);
    }

    private function createTeams($idGame, $total, $players)
    {

        //Criar os teams
        for ($x = 0; $x < $total; $x++) {
            $teamService = new TeamService();
            $numberTotal = $teamService->countByGameId($idGame) + 1;
            $team_name = 'Time ' . $numberTotal;
            $teams[$x] = $teamService->createTeam($team_name, $idGame);
        }

        $this->addPlayerToGame($idGame, $teams, $players);
    }

    public function addPlayerToGame($id, $teams, $players)
    {
        $gameRepository = GameRepository::find($id);
        $qtyPlayers = $gameRepository->limit_players - 1;
        //Ordenar por vele
        $newTeams = [];
        $playersOnly = array_values(array_filter($players, fn ($p) => $p['goalkeeper'] == 0));
        $playersGoalKeeper = array_values(array_filter($players, fn ($p) => $p['goalkeeper'] == 1));
        $j = 0;
        $columns = array_column($playersOnly, 'level');
        array_multisort($columns, SORT_DESC,  $playersOnly);
        //Aplicar jogadores aos times distribuindo por level
        foreach ($teams as $k => $v) {
            for ($i = 0; $i < $qtyPlayers; $i++) {
                if (!in_array(0, array_keys($playersOnly))) continue;
                if ($j >= count($teams)) $j = 0;
                $newTeams[$j][] = $playersOnly[0];
                unset($playersOnly[0]);
                $playersOnly = array_values($playersOnly);
                $j++;
            }
            //Adicionando um goleiro
            if (!in_array(0, array_keys($playersGoalKeeper))) continue;
            $newTeams[$k][] = $playersGoalKeeper[0];
            unset($playersGoalKeeper[0]);
            $playersGoalKeeper = array_values($playersGoalKeeper);
        }

        //Remove qty incorretas
        $newTeams = array_filter($newTeams, function ($n) use ($qtyPlayers) {
            return count($n) == $qtyPlayers + 1;
        });

        //Enviar para GamePlayerService
        foreach ($newTeams as $kn => $news) {
            foreach ($news as $new) {
                //if (!isset($teams[$kn])) continue;
                $dto = new GamePlayerInputDto($new['id'], $id, true, 0, $teams[$kn]->id);
                $gamePlayerService = new GamePlayerService();
                $gamePlayerService->updateGamePlayer($new['gamePlayer_id'], $dto);
            }
        }
    }

    private function cleanGameById($id)
    {
        $gamePlayerService = new GamePlayerService();
        $gamePlayerService->cleanTeamByGameId($id);
    }


    public function findById($id)
    {
        $repository = GameRepository::find($id);
        return $repository;
    }

    public function update($id, GameEditInputDto $input)
    {
        $repository = GameRepository::find($id)->update(['date' => $input->date, 'limit_players' => $input->limit_players]);
        return $repository;
    }

    public function deleteGame($id)
    {
        $gamePlayerService = new GamePlayerService();
        $gamePlayerService->deleteByGameId($id);
        $teamService = new TeamService();
        $teamService->deleteByGameId($id);

        $repository = new GameRepository();
        $repository->delete($id);
    }

    private function cleanTeamEmpty($idGame)
    {
        $repository = TeamRepository::getTeamsEmpty($idGame);
        foreach ($repository as $team) {
            if ($team->gamePlayers->count() == 0) {
                TeamRepository::delete($team->id);
            }
        }
    }

    private function verifyTeams($idGame, $qty)
    {
        $repository = TeamRepository::getTeamsEmpty($idGame);
        foreach ($repository as $team) {
            //Se a quantidade de jogadores estiverem incorretas
            if ($team->gamePlayers->count() != $qty) {
                return true;
                break;
            }
        }

        return false;
    }
}
