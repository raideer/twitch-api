<?php
namespace Raideer\TwitchApi\Resources;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Raideer\TwitchApi\Wrapper;

abstract class Resource{

  protected $wrapper;

  public function __construct(Wrapper $wrapper){

    $this->wrapper = $wrapper;
    $this->wrapper->registerResource($this);

  }

  abstract function getName();

  public function resolveOptions($options, $defaults, $required = [], $allowedTypes = []){

    $resolver = new OptionsResolver();
    $resolver->setDefaults($defaults);

    if(!empty($required)){
      $resolver->setRequired($required);
    }

    if(!empty($allowedTypes)){
      foreach($allowedTypes as $type => $value){
        $resolver->setAllowedValues($type, $value);
      }
    }

    return $resolver->resolve($options);

  }


}
