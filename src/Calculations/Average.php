<?php

namespace GGG\Html\Builders\Calculations;

use \GGG\Html\Builders\Abstracts\Calculation as Calculation;

class Average extends Calculation
{

  protected $columns;

/**

  public function __construct()
  {
    $this->columns = [];
    return $this;
  }

**/
  
  public function calc( $data )
  {
    $calculatedData = [];
    foreach( $data as $rowIndex => $rowData )
    {
      foreach( $rowData as $index => $value )
      {
        $this->setColumn( $index, $value );
      }
    }
    foreach( $this->columns as $colIndex => $colData )
    {
      array_push( $calculatedData, round( array_sum( $colData ) / count( $colData ), 2 ) );
    }
    return $calculatedData;
  }

/**
  private function setColumn( $colI, $colV )
  {
    if( (! isset( $this->columns[ $colI ] ) ) || (! is_array( $this->columns[ $colI ] ) ) )
    {
      $this->columns[ $colI ] = [];
    }
    array_push( $this->columns[ $colI ], $colV );
  }
**/
  
}
