<?php

namespace Raideer\TwitchApi\Resources;

/**
 * Users can subscribe to channels.
 */
class Subscriptions extends Resource
{
    /**
   * Return the resource name.
   *
   * @return string
   */
  public function getName()
  {
      return 'subscribtions';
  }

  /**
   * Returns a list of subscribtion objects sorted by subscribtion relationship creation
   * date which contain users subscribed to $channel.
   *
   * Learn more:
   * https://github.com/justintv/Twitch-API/blob/master/v3_resources/subscriptions.md#get-channelschannelsubscriptions
   *
   * @param  string $channel Target channel
   * @param  array $params  Optional params
   *
   * @return array
   */
  public function getSubscribtions($channel, $params = [])
  {
      $this->wrapper->checkScope('channel_subscriptions');

      $defaults = [
      'limit'     => 25,
      'offset'    => 0,
      'direction' => 'asc',
    ];

      $values = [
      'direction' => ['asc', 'desc'],
    ];

      return $this->wrapper->request('GET', "channels/$channel/subscriptions", ['query' => $this->resolveOptions($params, $defaults, [], $values)], true);
  }

  /**
   * Returns a subscribtion object which includes the user is subscribed
   * Requires authentication for $channel.
   *
   * Learn more:
   * https://github.com/justintv/Twitch-API/blob/master/v3_resources/subscriptions.md#get-channelschannelsubscriptionsuser
   *
   * @param  string $channel Target channel
   * @param  string $user    Target user
   *
   * @return array
   */
  public function getSubscribtion($channel, $user)
  {
      $this->wrapper->checkScope('channel_check_subscription');

      return $this->wrapper->request('GET', "channels/$channel/subscriptions/$user", [], true);
  }

  /**
   * Returns a channel object that user subscribes to
   * Requires authentication for $user.
   *
   * Learn more:
   * https://github.com/justintv/Twitch-API/blob/master/v3_resources/subscriptions.md#get-usersusersubscriptionschannel
   *
   * @param  string $user    Target user
   * @param  string $channel Target channel
   *
   * @return array
   */
  public function getUserSubscribtion($user, $channel)
  {
      $this->wrapper->checkScope('user_subscriptions');

      return $this->wrapper->request('GET', "users/$user/subscriptions/$channel", [], true);
  }
}
