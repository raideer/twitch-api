<?php

namespace Raideer\TwitchApi\Resources;

/**
 * Teams are an organisation of channels.
 */
class Teams extends Resource
{
    /**
   * Return the Resource name.
   *
   * @return string
   */
  public function getName()
  {
      return 'teams';
  }

  /**
   * Returns a list of active teams.
   *
   * Learn more:
   * https://github.com/justintv/Twitch-API/blob/master/v3_resources/teams.md#get-teams
   *
   * @param  array $params  Optiona params
   *
   * @return array
   */
  public function getTeams($params = [])
  {
      $defaults = [
      'limit'  => 25,
      'offset' => 0,
    ];

      return $this->wrapper->request('GET', 'teams', ['query' => $this->resolveOptions($params, $defaults)]);
  }

  /**
   * Returns a team object for $team.
   *
   * Learn more:
   * https://github.com/justintv/Twitch-API/blob/master/v3_resources/teams.md#get-teamsteam
   *
   * @param  string $team Target team
   *
   * @return array
   */
  public function getTeam($team)
  {
      return $this->wrapper->request('GET', "teams/$team");
  }
}
