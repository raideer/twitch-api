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
