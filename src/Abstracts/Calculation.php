<?php

namespace GGG\Html\Builders\Abstracts;

use \GGG\Html\Builders\Interfaces\CalculationInterface as CalculationInterface;

abstract class Calculation implements CalculationInterface
{

  public function __construct()
  {
    $this->columns = [];
    return $this;
  }

  protected function setColumn( $colI, $colV )
  {
    if( (! isset( $this->columns[ $colI ] ) ) || (! is_array( $this->columns[ $colI ] ) ) )
    {
      $this->columns[ $colI ] = [];
    }
    array_push( $this->columns[ $colI ], $colV );
  }

}
