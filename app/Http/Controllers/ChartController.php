<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Khill\Lavacharts\Lavacharts;


class ChartController extends Controller
{
    public function testChart(){

        $lava = new Lavacharts; // See note below for Laravel

        $votes  = $lava->DataTable();


        $votes->addStringColumn('Year')
            ->addNumberColumn('Mortalidade')
//            ->addNumberColumn('Expenses')
//            ->setDateTimeFormat('Y')
            ->addRow(['2004', 1000])
            ->addRow(['2005', 1170])
            ->addRow(['2006', 660])
            ->addRow(['2007', 1030]);

        $lava->ColumnChart('Finances', $votes, [
            'title' => 'Crohn Desease - Mortalidade',
            'titleTextStyle' => [
                'color'    => '#eb6b2c',
                'fontSize' => 16
            ]
        ]);



        return view('charts.area',['lava'=> $lava]);
    }
}
