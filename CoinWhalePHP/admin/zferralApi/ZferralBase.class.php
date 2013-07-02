<?php

/**
 * Base class for zferral Data Objects.
 *
 */
class ZferralBase
{
  public function toArray()
  {
    $array = get_object_vars($this);

    foreach($array as $key => $value)
    {
      if($value === null)
      {
        unset($array[$key]);
      }
    }

    return array($this->getName() => $array);
  }
}
