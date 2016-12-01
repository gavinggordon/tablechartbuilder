<?php

namespace GGG\Html\Builders;

class Table
{

  const CALCULATIONS_NS = '\\GGG\\Html\\Builders\\Calculations\\';

  protected $id;           // ''
  protected $data;         // [[#,…]|#,…]
  protected $html;         // ''
  protected $title;        // ''
  protected $headers;      // ['',…]
  protected $calc_data;    // [[#,…]|#,…]
  protected $calc_type;    // ''

  private $data_set;       // +|-
  private $title_set;      // +|-
  private $data_sizes;     // ['',…]
  private $headers_set;    // +|-
  private $calc_data_set;  // +|-
  private $is_responsive;  // +|-
  private $use_bootstrap;  // +|-
  
  public function __construct( $use_bootstrap = 0, $is_responsive = 0 )
  {
    $this->id = '';
    $this->data = [];
    $this->html = '';
    $this->title = '';
    $this->headers = [];
    $this->calc_data = [];
    $this->calc_type = [];
    $this->data_set = false;
    $this->title_set = false;
    $this->headers_set = false;
    $this->calc_data_set = false;
    /**
    if( 0 === intval( $use_bootstrap ) )
    {
      $this->use_bootstrap = false;
    }
    if( 1 === intval( $use_bootstrap ) )
    {
      $this->use_bootstrap = true;
    }
    if( 0 === intval( $is_responsive ) )
    {
      $this->is_responsive = false;
    }
    if( 1 === intval( $is_responsive ) )
    {
      $this->is_responsive = true;
    }
    **/
    $this->use_bootstrap = (boolean) intval( $use_bootstrap );
    $this->is_responsive = (boolean) intval( $is_responsive );
    return $this;
  }

  protected function setTitle( $title )
  {
    if( $this->title_set === false )
    {
      $this->title = ucwords( trim( $title ) );
      if( preg_match( '/^(.*\s.*)+$/i', $this->title ) )
      {
        $words = preg_split( '/\s+?/', lcfirst( $this->title ) );
        foreach( $words as $index => $word )
        {
          $this->id .= $word;
        }
      }
      else // true !== preg_match( '/^(.*\s.*)+$/i', $this->title )
      {
        $this->id .= lcfirst( $this->title );
      }
      $this->id .= 'Table';
      $this->title_set = true;
    }
    return $this;
  }

  protected function setHeaders( $headers )
  {
    if( $this->headers_set === false )
    {
      array_push( $this->headers, $headers );
      $this->headers_set = true;
    }
    return $this;
  }

  protected function setRowData( $data )
  {
    array_push( $this->data, $data );
    $this->data_set = true;
    return $this;
  }

  protected function total()
  {
    $calc_type = 'Total';
    $calc_type_class = static::CALCULATIONS_NS . $calc_type;
    $total = new $calc_type_class;
    array_push( $this->calc_type, $calc_type );
    array_push( $this->calc_data, $total->calc( $this->data ) );
    $this->calc_data_set = true;
    return $this;
  }

  protected function average()
  {
    $calc_type = 'Average';
    $calc_type_class = static::CALCULATIONS_NS . $calc_type;
    $average = new $calc_type_class;
    array_push( $this->calc_type, $calc_type );
    array_push( $this->calc_data, $average->calc( $this->data ) );
    $this->calc_data_set = true;
    return $this;
  }

  protected function difference()
  {
    $calc_type = 'Difference';
    $calc_type_class = static::CALCULATIONS_NS . $calc_type;
    $difference = new $calc_type_class;
    array_push( $this->calc_type, $calc_type );
    array_push( $this->calc_data, $difference->calc( $this->data ) );
    $this->calc_data_set = true;
    return $this;
  }

  protected function highest()
  {
    $calc_type = 'Highest';
    $calc_type_class = static::CALCULATIONS_NS . $calc_type;
    $highest = new $calc_type_class;
    array_push( $this->calc_type, $calc_type );
    array_push( $this->calc_data, $highest->calc( $this->data ) );
    $this->calc_data_set = true;
    return $this;
  }

  protected function lowest()
  {
    $calc_type = 'Lowest';
    $calc_type_class = static::CALCULATIONS_NS . $calc_type;
    $lowest = new $calc_type_class;
    array_push( $this->calc_type, $calc_type );
    array_push( $this->calc_data, $lowest->calc( $this->data ) );
    $this->calc_data_set = true;
    return $this;
  }

  protected function setup()
  {
    if( true === $this->checkForDataUniformity() )
    {
      $this->initializeSetup();
      if( $this->headers_set === true )
      {
        foreach( $this->headers as $data )
        {
          $this->insertHeadersRow( $data );
        }
      }
      if( $this->data_set === true )
      {
        foreach( $this->data as $row => $data )
        {
          $this->insertDataRow( $row, $data );
        }
        $this->closeDataRow();
      }
      if( $this->calc_data_set === true )
      {
        foreach( $this->calc_data as $row => $data )
        {
          $this->insertCalcDataRow( $row, $data );
        }
        $this->closeCalcDataRow();
      }
      return $this->finishSetup();
    }
  }

  private function checkForDataUniformity()
  {
    $headers_sizes = [
      'rows' => 0,
      'data' => []
    ];
    foreach( $this->headers as $rowI => $row )
    {
      $headers_sizes['rows'] = $rowI + 1;
      if( is_array( $row ) )
      {
        foreach( $row as $dataI => $data )
        {
array_push( $headers_sizes['data'], $data );
        }
      }
      else // false == is_array( $row )
      {
        array_push( $headers_sizes['data'], $row );
      }
    }

    $data_sizes = [
      'rows' => 0,
      'data' => []
    ];
    foreach( $this->data as $rowI => $row )
    {
      $data_sizes['rows'] = $rowI + 1;
      foreach( $row as $dataI => $data )
      {
        array_push( $data_sizes['data'], count( $data ) );
      }
    }

    $calc_data_sizes = [
      'rows' => 0,
      'data' => []
    ];
    foreach( $this->calc_data as $rowI => $row )
    {
      $calc_data_sizes['rows'] = $rowI + 1;
      foreach( $row as $dataI => $data )
      {
        array_push( $calc_data_sizes['data'], count( $data ) );
      }
    }

    $headers_size = count( $headers_sizes['data'] ) / $headers_sizes['rows'];
    $data_size = count( $data_sizes['data'] ) / $data_sizes['rows'];
    $calc_data_size = count( $calc_data_sizes['data'] ) / $calc_data_sizes['rows'];

    if( $headers_size != 0 && $data_size != 0 && $calc_data_size != 0 )
    {
      if( $headers_size === $data_size && $data_size === $calc_data_size && $calc_data_size === $headers_size )
      {
        $this->data_sizes = [
          'headers' => [
            'rows' => $headers_sizes['rows'],
            'cols' => $headers_size
          ],
          'data' => [
            'rows' => $data_sizes['rows'],
            'cols' => $data_size
          ],
          'calc_data' => [
            'rows' => $calc_data_sizes['rows'],
            'cols' => $calc_data_size
          ]
        ];
        return true;
      }
      else // $headers_size !== $data_size && $data_size !== $calc_data_size && $calc_data_size !== $headers_size
      {
        if( $headers_size !== $data_size )
        {
          echo 'The "$headers" [' . $headers_size . '] and "$data" [' . $data_size . '] data array sizes do not match one and other.';
        }
        if( $data_size !== $calc_data_size )
        {
          echo 'The "$data" [' . $data_size . '] and "$calc_data" [' . $calc_data_size . '] data array sizes do not match one and other.';
        }
        if( $calc_data_size !== $headers_size )
        {
          echo 'The "$calc_data" [' . $calc_data_size . '] and "$headers" [' . $headers_size . '] data array sizes do not match one and other.';
        }
      }
    }
    else // $headers_size == 0 && $data_size == 0 && $calc_data_size == 0
    {
      echo 'One or more data array sizes either (i) do not match the size of one or more of the others, or (ii) do not contain any data at all.';
    }
    return false;
  }

  private function initializeSetup()
  {
    if( $this->use_bootstrap === true )
    {
      $this->setupBootstrapTable();
    }
    else // $this->use_bootstrap !== true
    {
      $this->setupBasicTable();
    }
  }

  private function insertHeadersRow( $d )
  {
    if( $this->headers_set === true )
    {
      $row_index_header = '#';
      $ctx = ' style="border-top:1px solid #DDDDDD;border-right:1px solid #DDDDDD;border-bottom:2px solid #DDDDDD;border-left:1px solid #DDDDDD;"';
      $ctx2 = ' style="border:1px solid #DDDDDD;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;"';
      if( $this->calc_data_set === true )
      {
        if( $this->use_bootstrap === true )
        {
          $row_index_header = '#</b> <span class="text-muted">/</span> <b>=';
        }
        else
        {
          $row_index_header = '#</b> <span style="color:rgba(0,0,0,0.33);">/</span> <b>=';
        }
      }
      if( $this->use_bootstrap === true )
      {
        $ctx = NULL;
        $ctx2 = ' class="text-center"';
      }
      $this->html .=<<<EOH
        <thead>
          <tr{$ctx}>
            <th{$ctx2}>
              <b>{$row_index_header}</b>
            </th>

EOH;

      foreach( $d as $index => $header )
      {
        $header = ucwords( $header );
        $this->html .=<<<EOH
            <th{$ctx2}>
              <b>{$header}</b>
            </th>

EOH;

      }
      $this->html .=<<<EOH
          </tr>
        </thead>

EOH;

    }
  }

  private function insertDataRow( $r, $d )
  {
    $ctx = ' style="border:1px solid #DDDDDD;"';
    $ctx2 = ' style="border:1px solid #DDDDDD;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;"';
    if( $this->use_bootstrap === true )
    {
      $ctx = NULL;
      $ctx2 = ' class="text-center"';
    }
    if( $r === 0 )
    {
      if( $this->headers_set === true )
      {
        $this->html .=<<<EOH
        <tbody>

EOH;

      }
      else // $this->headers_set !== true
      {
        $this->html .=<<<EOH
      <tbody>

EOH;

      }
    }
    if( $this->headers_set === true )
    {
      $this->html .=<<<EOH
          <tr{$ctx}>
            <td{$ctx2}>
              {$r}
            </td>

EOH;

    }
    else // $this->headers_set !== true
    {
      $this->html .=<<<EOH
        <tr{$ctx}>
          <td{$ctx2}>
            {$r}
          </td>

EOH;

    }
    foreach( $d as $index => $data )
    {
      $ctx = NULL;
      $ctx2 = NULL;
      if( $this->use_bootstrap === true )
      {
        switch( $index )
        {
          case 0:
            $ctx2 = ' class="info text-center"';
            break;
          case 1:
            $ctx2 = ' class="success text-center"';
            break;
          case 2:
            $ctx2 = ' class="warning text-center"';
            break;
          case 3:
            $ctx2 = ' class="danger text-center"';
            break;
        }
      }
      else // $this->use_bootstrap !== true
      {
        switch( $index )
        {
          case 0:
            $ctx2 = ' style="background:rgb(217,237,247);border:1px solid #DDDDDD;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;"';
            break;
          case 1:
            $ctx2 = ' style="background:rgb(223,240,216);border:1px solid #DDDDDD;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;"';
            break;
          case 2:
            $ctx2 = ' style="background:rgb(252,248,227);border:1px solid #DDDDDD;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;"';
            break;
          case 3:
            $ctx2 = ' style="background:rgb(242,222,222);border:1px solid #DDDDDD;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;"';
            break;
        }
      }
      if( $this->headers_set === true )
      {
        $this->html .=<<<EOH
            <td{$ctx2}>
              {$data}
            </td>

EOH;

      }
      else // $this->headers_set !== true
      {
        $this->html .=<<<EOH
          <td{$ctx2}>
            {$data}
          </td>

EOH;

      }
    }
    if( $this->headers_set === true )
    {
      $this->html .=<<<EOH
          </tr>

EOH;

    }
    else // $this->headers_set !== true
    {
      $this->html .=<<<EOH
        </tr>

EOH;

    }
  }

  private function closeDataRow()
  {
    if( $this->headers_set === true )
    {
      if( $this->calc_data_set === true )
      {
        $this->html .=<<<EOH
        </tbody>

EOH;

      }
    }
    else // $this->headers_set !== true
    {
      if( $this->calc_data_set === false )
      {
        $this->html .=<<<EOH
      </tbody>

EOH;

      }
    }
  }

  private function insertCalcDataRow( $r, $d )
  {
    $ctx = ' style="background:#F5F5F5;border-top:3px double #888888;border-right:1px solid #CCCCCC;border-bottom:1px solid #CCCCCC;border-left:1px solid #DDDDDD;"';
    $ctx2 = ' style="border:1px solid #DDDDDD;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;"';
    $cell_tag = 'td';
    if( $this->use_bootstrap === true )
    {
      $ctx = ' class="active" style="border-top:3px double #888888;"';
      $ctx2 = ' class="text-center"';
    }
    if( $r === 0 )
    {
      if( $this->headers_set === true )
      {
        $this->html .=<<<EOH
        <tfoot>

EOH;

      }
    }
    if( $this->data_set === true )
    {
      $cell_tag = 'th';
    }
    if( $this->headers_set === true )
    {
      $this->html .=<<<EOH
          <tr{$ctx}>
            <{$cell_tag}{$ctx2}>
              {$this->calc_type[ $r ]}
            </{$cell_tag}>

EOH;

    }
    else // $this->headers_set !== true
    {
      $this->html .=<<<EOH
        <tr{$ctx}>
          <{$cell_tag}{$ctx2}>
            {$this->calc_type[ $r ]}
          </{$cell_tag}>

EOH;

    }
    foreach( $d as $index => $calc_data )
    {
      $ctx = NULL;
      $ctx2 = NULL;
      if( $this->use_bootstrap === true )
      {
        switch( $index )
        {
          case 0:
            $ctx2 = ' class="text-info text-center"';
            break;
          case 1:
            $ctx2 = ' class="text-success text-center"';
            break;
          case 2:
            $ctx2 = ' class="text-warning text-center"';
            break;
          case 3:
            $ctx2 = ' class="text-danger text-center"';
            break;
        }
      }
      else // $this->use_bootstrap !== true
      {
        switch( $index )
        {
          case 0:
            // #5BC0DE
            $ctx2 = ' style="color:rgb(49,99,139);border:1px solid #DDDDDD;font-weight:bold!important;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;"';
            break;
          case 1:
            // #5CB86C
            $ctx2 = ' style="color:rgb(60,118,61);border:1px solid #DDDDDD;font-weight:bold!important;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;"';
            break;
          case 2:
            // #F0AD4E
            $ctx2 = ' style="color:rgb(138,109,59);border:1px solid #DDDDDD;font-weight:bold!important;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;"';
            break;
          case 3:
            // #D9534F
            $ctx2 = ' style="color:rgb(169,68,66);border:1px solid #DDDDDD;font-weight:bold!important;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;"';
            break;
        }
      }
      if( $this->headers_set === true )
      {
        $this->html .=<<<EOH
            <{$cell_tag}{$ctx2}>
              {$calc_data}
            </{$cell_tag}>

EOH;

      }
      else // $this->headers_set !== true
      {
        $this->html .=<<<EOH
          <{$cell_tag}{$ctx2}>
            {$calc_data}
          </{$cell_tag}>

EOH;

      }
    }
    if( $this->headers_set === true )
    {
      $this->html .=<<<EOH
          </tr>

EOH;

    }
    else // $this->headers_set !== true
    {
      $this->html .=<<<EOH
        </tr>

EOH;

    }
  }

  private function closeCalcDataRow()
  {
    if( $this->headers_set === true )
    {
      if( $this->data_set === true )
      {
        $this->html .=<<<EOH
        </tfoot>

EOH;

      }
    }
    else // $this->headers_set !== true
    {
      if( $this->data_set === true )
      {
        $this->html .=<<<EOH
      </tbody>

EOH;

      }
    }
  }

  private function setupBootstrapTable()
  {
    $props = ' class="table table-hover table-bordered"';
    if( $this->title_set === true )
    {
      $props = ' id="' . $this->id . '"' . $props;
      $this->html .=<<<EOH
    <div class="container">
      <h2 class="text-center">{$this->title}</h2>
    </div>

EOH;

    }
    if( $this->is_responsive === true )
    {
      $this->html .=<<<EOH
    <div class="table-responsive">
      <table{$props}>

EOH;

    }
    else // $this->is_responsive !== true
    {
      $this->html .=<<<EOH
    <table{$props}>

EOH;

    }
  }

  private function setupBasicTable()
  {
    $props = ' style="width:100%;margin:0 auto;font-family:\'Helvetica Neue\',Helvetica,Arial,sans-serif;font-size:14px;border:1px solid #DDDDDD;empty-cells:show;border-collapse:collapse;line-height:1.428571429;"';
    if( $this->title_set === true )
    {
      $props = ' id="' . $this->id . '"' . $props;
      $this->html .=<<<EOH
    <div style="width:100%;">
      <h2 style="font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;font-size:30px;text-align:center;">{$this->title}</h2>
    </div>

EOH;

    }
    if( $this->is_responsive === true )
    {
      $this->html .=<<<EOH
    <div style="width:100%;margin:0 auto;">
      <table{$props}>

EOH;

    }
    else // $this->is_responsive !== true
    {
      $this->html .=<<<EOH
    <table{$props}>

EOH;

    }
  }

  private function finishSetup()
  {
    if( $this->is_responsive === true )
    {
      $this->html .=<<<EOH
      </table>
    </div>

EOH;

    }
    else // $this->is_responsive !== true
    {
      $this->html .=<<<EOH
    </table>

EOH;

    }
    return $this->html;
  }

}
