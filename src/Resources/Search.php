<?php

namespace Raideer\TwitchApi\Resources;

/**
 * Search for channels, streams or games with queries.
 */
class Search extends Resource
{
    /**
   * Returns the resource name.
   *
   * @return string
   */
  public function getName()
  {
      return 'search';
  }

  /**
   * Returns a list of channel objects matching the search query.
   *
   * Learn more:
   * https://github.com/justintv/Twitch-API/blob/master/v3_resources/search.md#get-searchchannels
   *
   * @param  string $query   Search query
   * @param  array $params  Optional parameters
   *
   * @return array
   */
  public function searchChannels($query, $params = [])
  {
      $defaults = [
          'query'  => urlencode($query),
          'limit'  => 25,
          'offset' => 0,
      ];

      return $this->wrapper->request('GET', 'search/channels', ['query' => $this->resolveOptions($params, $defaults)]);
  }

  /**
   * Returns a list of stream objects matching the search query.
   *
   * Learn more:
   * https://github.com/justintv/Twitch-API/blob/master/v3_resources/search.md#get-searchstreams
   *
   * @param  string $query   Search query
   * @param  array $params Optional params
   *
   * @return array
   */
  public function searchStreams($query, $params = [])
  {
      $defaults = [
      'query'  => urlencode($query),
      'limit'  => 25,
      'offset' => 0,
      'hls'    => null,
    ];

      return $this->wrapper->request('GET', 'search/streams', ['query' => $this->resolveOptions($params, $defaults)]);
  }

  /**
   * Returns a list of game objects matching the search query.
   *
   * Learn more:
   * https://github.com/justintv/Twitch-API/blob/master/v3_resources/search.md#get-searchgames
   *
   * @param  string $query   Search query
   * @param  array $params  Optional params
   *
   * @return array
   */
  public function searchGames($query, $params = [])
  {
      $defaults = [
          'query' => urlencode($query),
          'limit' => 25,
          'type'  => 'suggest',
          'live'  => false,
      ];

      return $this->wrapper->request('GET', 'search/games', ['query' => $this->resolveOptions($params, $defaults)]);
  }
}
