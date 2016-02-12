<?php

namespace Raideer\TwitchApi\Resources;

/**
 * Users can subscribe to channels.
 */
<<<<<<< HEAD
class Subscriptions extends Resource{

  /**
   * Return the resource name
   * @return string
   */
  public function getName(){
    return 'subscriptions';
  }

  /**
   * Returns a list of subscription objects sorted by subscription relationship creation
   * date which contain users subscribed to $channel
=======
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
>>>>>>> c923f5963333108945d5d87da593b694aa1bab2f
   *
   * Learn more:
   * https://github.com/justintv/Twitch-API/blob/master/v3_resources/subscriptions.md#get-channelschannelsubscriptions
   *
   * @param  string $channel Target channel
   * @param  array $params  Optional params
   *
   * @return array
   */
<<<<<<< HEAD
  public function getSubscriptions($channel, $params = []){
    $this->wrapper->checkScope("channel_subscriptions");
=======
  public function getSubscribtions($channel, $params = [])
  {
      $this->wrapper->checkScope('channel_subscriptions');
>>>>>>> c923f5963333108945d5d87da593b694aa1bab2f

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
<<<<<<< HEAD
   * Returns a subscription object which includes the user is subscribed
   * Requires authentication for $channel
=======
   * Returns a subscribtion object which includes the user is subscribed
   * Requires authentication for $channel.
>>>>>>> c923f5963333108945d5d87da593b694aa1bab2f
   *
   * Learn more:
   * https://github.com/justintv/Twitch-API/blob/master/v3_resources/subscriptions.md#get-channelschannelsubscriptionsuser
   *
   * @param  string $channel Target channel
   * @param  string $user    Target user
   *
   * @return array
   */
<<<<<<< HEAD
  public function getSubscription($channel, $user){
    $this->wrapper->checkScope("channel_check_subscription");
=======
  public function getSubscribtion($channel, $user)
  {
      $this->wrapper->checkScope('channel_check_subscription');
>>>>>>> c923f5963333108945d5d87da593b694aa1bab2f

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
<<<<<<< HEAD
  public function getUserSubscription($user, $channel){
    $this->wrapper->checkScope("user_subscriptions");
=======
  public function getUserSubscribtion($user, $channel)
  {
      $this->wrapper->checkScope('user_subscriptions');
>>>>>>> c923f5963333108945d5d87da593b694aa1bab2f

      return $this->wrapper->request('GET', "users/$user/subscriptions/$channel", [], true);
  }
}
