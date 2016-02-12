## Resources
| Resource | Official documentation |
| -------- | ---------------------- |
| [Blocks](#blocks) | https://github.com/justintv/Twitch-API/blob/master/v3_resources/blocks.md |
| [Channels](#channels) | https://github.com/justintv/Twitch-API/blob/master/v3_resources/channels.md |
| [Chat](#chat) | https://github.com/justintv/Twitch-API/blob/master/v3_resources/chat.md |
| [Follows](#follows) | https://github.com/justintv/Twitch-API/blob/master/v3_resources/follows.md |
### Blocks

* **getBlockedUsers($user, $params = [])** - Get user's block list   
*AUTHENTICATED*  
Scope:  `user_blocks_read`  

* **blockUser($user, $target)** - Add target to user's block list   
*AUTHENTICATED*    
Scope: `user_blocks_edit`   

* **unblockUser($user, $target)** - Delete target from user's block list   
*AUTHENTICATED*    
Scope: `user_blocks_edit`

### Channels

* **getChannel($user)** - Get channel object for $user

* **getChannel()** - Get authenticated user's channel    
*AUTHENTICATED*  
Scope: `channel_read`

* **getEditors($channel)** - Get a list of $channel editors    
*AUTHENTICATED*  
Scope: `channel_read`

* **getVideos($channel, $params = [])** - Get a list of $channel videos

* **updateChannel($channel, $params = [])** - Update $channel's status    
*AUTHENTICATED*  
Scope: `channel_editor`

* **resetStreamKey($channel)** - Resets $channel's stream key    
*AUTHENTICATED*  
Scope: `channel_stream`

* **startCommercial($channel, $length = 30)** - Starts a (30,60,90,120,150,180s) commercial    
*AUTHENTICATED*  
Scope: `channel_commercial`

* **getTeams($channel)** - Get a list of team objects for $channel
 
* **getFollows($channel, $params = [])** - Get a list of follow objects for $channel

### Chat

* **getChat($channel)** - Get a links object to all other chat enpoints

* **getEmoticons()** - Get a list of all emoticon objects for Twitch

* **getEmoticonImages($params = [])** - Get a list of emoticons

* **getBadges($channel)** - Get a list of chat badges that can be used in $channel's chat

### Follows

* **getFollowers($channel, $params = [])** - Get a list of follow objects for $channel

* **getFollows($user, $params = [])** - Get a list of follows objects for $user

* **getRelationship($user, $channel)** - Get relationship between $user and $channel

* **followChannel($user, $target, $notifications = false)** - Adds $user to $target's followers    
*AUTHENTICATED*  
Scope: `user_follows_edit`

* **unfollowChannel($user, $target, $notifications = false)** - Removes $user from $target's followers    
*AUTHENTICATED*  
Scope: `user_follows_edit`

### Games

* **getTopGames($params = [])** - Returns a list of games objects sorted by number of current viewers on Twitch, most popular first

### Ingests

* **getIngests()** - Returns a list of ingest objects

### Search

* **searchChannels($query, $params = [])** - Returns a list of channel objects matching the search query

* **searchStreams($query, $params = [])** - Returns a list of stream objects matching the search query

* **searchGames($query, $params = [])** - Returns a list of game objects matching the search query

### Streams

* **getStreams($params = [])** - Returns a list of stream objects that are queried by a number

* **getFeatured($params = [])** - Returns a list of featured (promoted) stream objects

* **getSummary($params = [])** - Returns a summary of current streams

* **getFollowed($params = [])** - Returns a list of stream objects that the authenticated user is following    
*AUTHENTICATED*  
Scope: `user_read`

### Subscribtions

* **getSubscribtions($channel, $params = [])** - Returns a list of subscribtion objects sorted by subscribtion relationship creation    
*AUTHENTICATED*  
Scope: `channel_subscriptions`

* **getSubscribtion($channel, $user)** - Returns a subscribtion object for $channel witch includes the $user
*AUTHENTICATED*  
Scope: `channel_check_subscription`

* **getSubscribtion($user, $channel)** - Returns a $channel object that $user subscribes to    
*AUTHENTICATED*  
Scope: `user_subscriptions`

### Teams

* **getTeams($params = [])** - Returns a list of active teams

* **getTeam($team)** - Returns a team object for $team

### Users

* **getUser()** - Returns a user object    
*AUTHENTICATED*  
Scope: `user_read`

* **getUser($name)** - Returns a user object    

* **getFollowed($params = [])** - Returns a list of stream objects that the authenticated user is following    
*AUTHENTICATED*  
Scope: `user_read`

* **getFollowedVideos($params = [])** - Returns a list of video objects from channels that the authenticated user is following    
*AUTHENTICATED*  
Scope: `user_read`

### Videos

* **getVideo($id)** - Returns a video object

* **getTopVideos($params = [])** - Returns a list of videos created in a given time period sorted by

* **getChannelVideos($channel, $params = [])** - Returns a list of videos ordered by time of creation

* **getFollowedVideos($params = [])** - Returns a list of video objects from channels that the authenticated user is following    
*AUTHENTICATED*  
Scope: `user_read`
