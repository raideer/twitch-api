<?php
namespace Raideer\TwitchApi\Resources;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Raideer\TwitchApi\Wrapper;

/**
 * This is the parent class of all Resources
 */
abstract class Resource{

  protected $wrapper;

  /**
   * Takes Wrapper instance as its only parameter
   * Automatically self-registers the resource
   *
   * @param Wrapper $wrapper
   */
  public function __construct(Wrapper $wrapper){

    $this->wrapper = $wrapper;
    $this->wrapper->registerResource($this);

  }

  /**
   * Required by all resources
   * Used when registering the resource
   *
   * @return string
   */
  abstract function getName();

  /**
   * Helper function for resolving parameters
   *
   * @param  array $options      Passed params
   * @param  array $defaults     Default values
   * @param  array $required     Required fields
   * @param  array $allowedTypes Allowed field values
   * @return array
   */
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
