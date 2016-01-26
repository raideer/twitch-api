## Resources
| Resource | Official documentation |
| -------- | ---------------------- |
| [Blocks](#blocks) | https://github.com/justintv/Twitch-API/blob/master/v3_resources/blocks.md |
| [Channels](#channels) | https://github.com/justintv/Twitch-API/blob/master/v3_resources/channels.md |
### Blocks

* ###### **getBlockedUsers($user, $params = [])** - Get user's block list
*AUTHENTICATED*  
Scope:  `user_blocks_read`  

##### Parameters

| Name | Required? | Type | Description |
| ---- | --------- | ---- | ----------- |
| limit | optional | integer | Maximum number of objects in array. Default is 25. Maximum is 100. |    
| offset | optional | integer | Object offset for pagination. Default is 0. |

* ###### **blockUser($user, $target)** - Add target to user's block list
*AUTHENTICATED*    
Scope: `user_blocks_edit`   

* ###### **unblockUser($user, $target)** - Delete target from user's block list
*AUTHENTICATED*    
Scope: `user_blocks_edit`

### Channels

* ###### **getChannel($user)** - Get channel object

* ###### **getChannel()** - Get authenticated user's channel
*AUTHENTICATED*  
Scope: `channel_read`

* ###### **getVideos($channel, $params = [])**

##### Parameters

| Name | Required? | Type | Description |
| ---- | --------- | ---- | ----------- |
| limit | optional | integer | Maximum number of objects in array. Default is 10. Maximum is 100. |
| offset | optional | integer | Object offset for pagination. Default is 0. |
| broadcasts | optional | bool | Returns only broadcasts when *true*. Otherwise only highlights are returned. Default is *false*. |
| hls | optional | bool | Returns only HLS VoDs when *true*. Otherwise only non-HLS VoDs are returned. Default is *false*. |
