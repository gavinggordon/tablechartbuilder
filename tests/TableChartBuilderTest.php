<?php

use GGG\Html\Builders\TableChartBuilder;

class TableChartBuilderTest extends \PHPUnit_Framework_TestCase
{
  
    public function __construct()
    {
        return $this;
    }

    public function testRenderBootstrapTableChart()
    {
        $bsconfigs = [
          'title' => 'Bootstrap Table Chart',
          'headers' => [
            'download','upload','other','test'
          ],
          'data' => [
            [3.4,1.4,2.5,5.6],
            [4.9,1.2,2.1,4.2],
            [3.6,1.5,2.8,4.5],
            [10.5,15.9,5.8,30.6],
            [-1.1,1.1,-2.5,2.5]
          ],
          'equation' => ['highest','lowest','average','total']
        ];
        $bschart = new TableChartBuilder( 1, 1 );
        $bschart->configure( $bsconfigs );
        $actual = $bschart->render();
        $expected =<<<EOE
    <div class="container">
      <h2 class="text-center">Bootstrap Table Chart</h2>
    </div>
    <div class="table-responsive">
      <table id="bootstrapTableChartTable" class="table table-hover table-bordered">
        <thead>
          <tr>
            <th class="text-center">
              <b>#</b> <span class="text-muted">/</span> <b>=</b>
            </th>
            <th class="text-center">
              <b>Download</b>
            </th>
            <th class="text-center">
              <b>Upload</b>
            </th>
            <th class="text-center">
              <b>Other</b>
            </th>
            <th class="text-center">
              <b>Test</b>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="text-center">
              0
            </td>
            <td class="info text-center">
              3.4
            </td>
            <td class="success text-center">
              1.4
            </td>
            <td class="warning text-center">
              2.5
            </td>
            <td class="danger text-center">
              5.6
            </td>
          </tr>
          <tr>
            <td class="text-center">
              1
            </td>
            <td class="info text-center">
              4.9
            </td>
            <td class="success text-center">
              1.2
            </td>
            <td class="warning text-center">
              2.1
            </td>
            <td class="danger text-center">
              4.2
            </td>
          </tr>
          <tr>
            <td class="text-center">
              2
            </td>
            <td class="info text-center">
              3.6
            </td>
            <td class="success text-center">
              1.5
            </td>
            <td class="warning text-center">
              2.8
            </td>
            <td class="danger text-center">
              4.5
            </td>
          </tr>
          <tr>
            <td class="text-center">
              3
            </td>
            <td class="info text-center">
              10.5
            </td>
            <td class="success text-center">
              15.9
            </td>
            <td class="warning text-center">
              5.8
            </td>
            <td class="danger text-center">
              30.6
            </td>
          </tr>
          <tr>
            <td class="text-center">
              4
            </td>
            <td class="info text-center">
              -1.1
            </td>
            <td class="success text-center">
              1.1
            </td>
            <td class="warning text-center">
              -2.5
            </td>
            <td class="danger text-center">
              2.5
            </td>
          </tr>
        </tbody>
        <tfoot>
          <tr class="active" style="border-top:3px double #888888;">
            <th class="text-center">
              Highest
            </th>
            <th class="text-info text-center">
              10.5
            </th>
            <th class="text-success text-center">
              15.9
            </th>
            <th class="text-warning text-center">
              5.8
            </th>
            <th class="text-danger text-center">
              30.6
            </th>
          </tr>
          <tr class="active" style="border-top:3px double #888888;">
            <th class="text-center">
              Lowest
            </th>
            <th class="text-info text-center">
              -1.1
            </th>
            <th class="text-success text-center">
              1.1
            </th>
            <th class="text-warning text-center">
              -2.5
            </th>
            <th class="text-danger text-center">
              2.5
            </th>
          </tr>
          <tr class="active" style="border-top:3px double #888888;">
            <th class="text-center">
              Average
            </th>
            <th class="text-info text-center">
              4.26
            </th>
            <th class="text-success text-center">
              4.22
            </th>
            <th class="text-warning text-center">
              2.14
            </th>
            <th class="text-danger text-center">
              9.48
            </th>
          </tr>
          <tr class="active" style="border-top:3px double #888888;">
            <th class="text-center">
              Total
            </th>
            <th class="text-info text-center">
              21.3
            </th>
            <th class="text-success text-center">
              21.1
            </th>
            <th class="text-warning text-center">
              10.7
            </th>
            <th class="text-danger text-center">
              47.4
            </th>
          </tr>
        </tfoot>
      </table>
    </div>
EOE;
        $this->assertSame( $expected, $actual );
    }

     public function testRenderNonBootstrapTableChart()
    {
        $bsconfigs = [
          'title' => 'Non-Bootstrap Table Chart',
          'headers' => [
            'download','upload','other','test'
          ],
          'data' => [
            [3.4,1.4,2.5,5.6],
            [4.9,1.2,2.1,4.2],
            [3.6,1.5,2.8,4.5],
            [10.5,15.9,5.8,30.6],
            [-1.1,1.1,-2.5,2.5]
          ],
          'equation' => ['highest','lowest','average','total']
        ];
        $bschart = new TableChartBuilder( 0, 1 );
        $bschart->configure( $bsconfigs );
        $actual = $bschart->render();
        $expected =<<<EOE
    <div style="width:100%;">
      <h2 style="font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;font-size:30px;text-align:center;">Non-Bootstrap Table Chart</h2>
    </div>
    <div style="width:100%;margin:0 auto;">
      <table id="non-BootstrapTableChartTable" style="width:100%;margin:0 auto;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;font-size:14px;border:1px solid #DDDDDD;empty-cells:show;border-collapse:collapse;line-height:1.428571429;">
        <thead>
          <tr style="border-top:1px solid #DDDDDD;border-right:1px solid #DDDDDD;border-bottom:2px solid #DDDDDD;border-left:1px solid #DDDDDD;">
            <th style="border:1px solid #DDDDDD;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;">
              <b>#</b> <span style="color:rgba(0,0,0,0.33);">/</span> <b>=</b>
            </th>
            <th style="border:1px solid #DDDDDD;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;">
              <b>Download</b>
            </th>
            <th style="border:1px solid #DDDDDD;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;">
              <b>Upload</b>
            </th>
            <th style="border:1px solid #DDDDDD;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;">
              <b>Other</b>
            </th>
            <th style="border:1px solid #DDDDDD;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;">
              <b>Test</b>
            </th>
          </tr>
        </thead>
        <tbody>
          <tr style="border:1px solid #DDDDDD;">
            <td style="border:1px solid #DDDDDD;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;">
              0
            </td>
            <td style="background:rgb(217,237,247);border:1px solid #DDDDDD;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;">
              3.4
            </td>
            <td style="background:rgb(223,240,216);border:1px solid #DDDDDD;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;">
              1.4
            </td>
            <td style="background:rgb(252,248,227);border:1px solid #DDDDDD;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;">
              2.5
            </td>
            <td style="background:rgb(242,222,222);border:1px solid #DDDDDD;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;">
              5.6
            </td>
          </tr>
          <tr style="border:1px solid #DDDDDD;">
            <td style="border:1px solid #DDDDDD;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;">
              1
            </td>
            <td style="background:rgb(217,237,247);border:1px solid #DDDDDD;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;">
              4.9
            </td>
            <td style="background:rgb(223,240,216);border:1px solid #DDDDDD;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;">
              1.2
            </td>
            <td style="background:rgb(252,248,227);border:1px solid #DDDDDD;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;">
              2.1
            </td>
            <td style="background:rgb(242,222,222);border:1px solid #DDDDDD;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;">
              4.2
            </td>
          </tr>
          <tr style="border:1px solid #DDDDDD;">
            <td style="border:1px solid #DDDDDD;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;">
              2
            </td>
            <td style="background:rgb(217,237,247);border:1px solid #DDDDDD;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;">
              3.6
            </td>
            <td style="background:rgb(223,240,216);border:1px solid #DDDDDD;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;">
              1.5
            </td>
            <td style="background:rgb(252,248,227);border:1px solid #DDDDDD;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;">
              2.8
            </td>
            <td style="background:rgb(242,222,222);border:1px solid #DDDDDD;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;">
              4.5
            </td>
          </tr>
          <tr style="border:1px solid #DDDDDD;">
            <td style="border:1px solid #DDDDDD;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;">
              3
            </td>
            <td style="background:rgb(217,237,247);border:1px solid #DDDDDD;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;">
              10.5
            </td>
            <td style="background:rgb(223,240,216);border:1px solid #DDDDDD;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;">
              15.9
            </td>
            <td style="background:rgb(252,248,227);border:1px solid #DDDDDD;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;">
              5.8
            </td>
            <td style="background:rgb(242,222,222);border:1px solid #DDDDDD;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;">
              30.6
            </td>
          </tr>
          <tr style="border:1px solid #DDDDDD;">
            <td style="border:1px solid #DDDDDD;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;">
              4
            </td>
            <td style="background:rgb(217,237,247);border:1px solid #DDDDDD;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;">
              -1.1
            </td>
            <td style="background:rgb(223,240,216);border:1px solid #DDDDDD;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;">
              1.1
            </td>
            <td style="background:rgb(252,248,227);border:1px solid #DDDDDD;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;">
              -2.5
            </td>
            <td style="background:rgb(242,222,222);border:1px solid #DDDDDD;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;">
              2.5
            </td>
          </tr>
        </tbody>
        <tfoot>
          <tr style="background:#F5F5F5;border-top:3px double #888888;border-right:1px solid #CCCCCC;border-bottom:1px solid #CCCCCC;border-left:1px solid #DDDDDD;">
            <th style="border:1px solid #DDDDDD;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;">
              Highest
            </th>
            <th style="color:rgb(49,99,139);border:1px solid #DDDDDD;font-weight:bold!important;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;">
              10.5
            </th>
            <th style="color:rgb(60,118,61);border:1px solid #DDDDDD;font-weight:bold!important;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;">
              15.9
            </th>
            <th style="color:rgb(138,109,59);border:1px solid #DDDDDD;font-weight:bold!important;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;">
              5.8
            </th>
            <th style="color:rgb(169,68,66);border:1px solid #DDDDDD;font-weight:bold!important;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;">
              30.6
            </th>
          </tr>
          <tr style="background:#F5F5F5;border-top:3px double #888888;border-right:1px solid #CCCCCC;border-bottom:1px solid #CCCCCC;border-left:1px solid #DDDDDD;">
            <th style="border:1px solid #DDDDDD;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;">
              Lowest
            </th>
            <th style="color:rgb(49,99,139);border:1px solid #DDDDDD;font-weight:bold!important;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;">
              -1.1
            </th>
            <th style="color:rgb(60,118,61);border:1px solid #DDDDDD;font-weight:bold!important;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;">
              1.1
            </th>
            <th style="color:rgb(138,109,59);border:1px solid #DDDDDD;font-weight:bold!important;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;">
              -2.5
            </th>
            <th style="color:rgb(169,68,66);border:1px solid #DDDDDD;font-weight:bold!important;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;">
              2.5
            </th>
          </tr>
          <tr style="background:#F5F5F5;border-top:3px double #888888;border-right:1px solid #CCCCCC;border-bottom:1px solid #CCCCCC;border-left:1px solid #DDDDDD;">
            <th style="border:1px solid #DDDDDD;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;">
              Average
            </th>
            <th style="color:rgb(49,99,139);border:1px solid #DDDDDD;font-weight:bold!important;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;">
              4.26
            </th>
            <th style="color:rgb(60,118,61);border:1px solid #DDDDDD;font-weight:bold!important;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;">
              4.22
            </th>
            <th style="color:rgb(138,109,59);border:1px solid #DDDDDD;font-weight:bold!important;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;">
              2.14
            </th>
            <th style="color:rgb(169,68,66);border:1px solid #DDDDDD;font-weight:bold!important;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;">
              9.48
            </th>
          </tr>
          <tr style="background:#F5F5F5;border-top:3px double #888888;border-right:1px solid #CCCCCC;border-bottom:1px solid #CCCCCC;border-left:1px solid #DDDDDD;">
            <th style="border:1px solid #DDDDDD;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;">
              Total
            </th>
            <th style="color:rgb(49,99,139);border:1px solid #DDDDDD;font-weight:bold!important;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;">
              21.3
            </th>
            <th style="color:rgb(60,118,61);border:1px solid #DDDDDD;font-weight:bold!important;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;">
              21.1
            </th>
            <th style="color:rgb(138,109,59);border:1px solid #DDDDDD;font-weight:bold!important;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;">
              10.7
            </th>
            <th style="color:rgb(169,68,66);border:1px solid #DDDDDD;font-weight:bold!important;text-align:center;padding:8px;vertical-align:top;line-height:1.428571429;">
              47.4
            </th>
          </tr>
        </tfoot>
      </table>
    </div>
EOE;

        $this->assertSame( $expected, $actual );
    }

    
}
