## Resources
| Resource | Official documentation |
| -------- | ---------------------- |
| [Blocks](#blocks) | https://github.com/justintv/Twitch-API/blob/master/v3_resources/blocks.md |
| [Channels](#channels) | https://github.com/justintv/Twitch-API/blob/master/v3_resources/channels.md |
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

* **getChannel($user)** - Get channel object

* **getChannel()** - Get authenticated user's channel    
*AUTHENTICATED*  
Scope: `channel_read`

* **getVideos($channel, $params = [])**
