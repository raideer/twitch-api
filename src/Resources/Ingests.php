<?php
namespace Raideer\TwitchApi\Resources;

/**
 * These are RTMP ingest points.
 * By directing an RTMP stream with your stream_key injected into the url_template,
 * you will broadcast your content live on Twitch.
 */
class Ingests extends Resource{

  /**
   * Returns the resource name
   * @return string
   */
  public function getName(){
    return "ingests";
  }

  /**
   * Returns a list of ingest objects
   *
   * Learn more:
   * https://github.com/justintv/Twitch-API/blob/master/v3_resources/ingests.md#get-ingests
   *
   * @return array
   */
  public function getIngests(){

    return $this->wrapper->request("GET", "ingests");
  }


}
