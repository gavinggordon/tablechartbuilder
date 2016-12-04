<?php

namespace GGG\Html\Builders;

class TableChartBuilder extends Table
{

  public function __construct( $use_bootstrap = 0, $is_responsive = 0 )
  {
    parent::__construct( $use_bootstrap, $is_responsive );
    return $this;
  }

  public function configure( $assoc_array )
  {
    if( isset( $assoc_array['title'] ) )
    {
      $this->setTitle( $assoc_array['title'] );
    }
    if( isset( $assoc_array['headers'] ) )
    {
      $this->setHeaders( $assoc_array['headers'] );
    }
    if( isset( $assoc_array['data'] ) )
    {
      if( is_array( $assoc_array['data'] ) )
      {
        foreach( $assoc_array['data'] as $data )
        {
          if( is_array( $data ) )
          {
            $this->setRowData( $data );
          }
        }
      }
    }
    if( isset( $assoc_array['equation'] ) )
    {
      if( is_array( $assoc_array['equation'] ) )
      {
        foreach( $assoc_array['equation'] as $equation )
        {
          $equation_method = strtolower( $equation );
          $this->$equation_method();
        }
      }
      else // true !== is_array( $assoc_array['equation'] )
      {
        $equation_method = strtolower( $assoc_array['equation'] );
        $this->$equation_method();
      }
    }
    return $this;
  }

  public function setTableTitle( $title )
  {
    $this->setTitle( $title );
    return $this;
  }

  public function setColHeaders( $headers )
  {
    $this->setHeaders( $headers );
    return $this;
  }

  public function setData( $data )
  {
    $this->setRowData( $data );
    return $this;
  }

  public function getTotal()
  {
    $this->total();
    return $this;
  }

  public function getAverage()
  {
    $this->average();
    return $this;
  }

  public function getDifference()
  {
    $this->difference();
    return $this;
  }

  public function getHighest()
  {
    $this->highest();
    return $this;
  }

  public function getLowest()
  {
    $this->lowest();
    return $this;
  }

  public function render()
  {
    $html = $this->setup();
    return rtrim( $html );
  }

}
