<?php

namespace App\Http\Controllers;
use Goutte;
use Illuminate\Http\Request;
use Log;
use Illuminate\Support\Str;

class Prueba extends Controller
{
    public function index(){
        try {
            $array_cuntries = array();
            $crawler = Goutte::request('GET', 'https://www.futbol24.com/Live/');
            dump($crawler);
            /*$array_cuntries = $crawler->filter('ul.countries')->each(function ($node,$i) {
                //Log::info($node);
                //dump($node->text());
                $arr = $node->children()->each(function ($node,$j) use ($i) {
                    $data = $node->children()->extract(['_name', '_text', 'href']);*/

                    /*$crawler2 = Goutte::request('GET', 'https://www.futbol24.com'.$data[0][2]);

                    $array_competiciones = $crawler2->filter('ul.leagues')->each(function ($node,$i) {
                        $arr2 = $node->children()->each(function ($node,$j) use ($i) {
                            $data2 = $node->children()->extract(['_name', '_text', 'href']);
                            //dump($data2);
                            return ['name'=>$data2[0][1],'uri'=>$data2[0][2]];
                        });
                        return $arr2;
                    });*/
                   /* return ['name'=>$data[0][1],'uri'=>$data[0][2]];
                });
                return $arr;
            });*/
            dump($array_cuntries);

        } catch (Exception $exception) {
            Log::error($exception);
        }
        
        //return view('prueba',['data'=>'']);
    }

    public function betfair(){
        try {
            $partidos = array();
            $competencias = $this->getUrlPartidosLive();
            foreach ($competencias as $i => $competencia) {
                foreach ($competencia as $j => $value) {
                    $crawler = Goutte::request('GET', $value);
                    $partidos[$i][$j] = $bloque_gen = $crawler->filter('div#mod-matchheader-1001-container')->each(function ($node,$i) {
                        return [
                            'nombre_competencia' => $node->children()->children()->eq(0)->text(),
                            'nombre_local' => $node->children()->children()->eq(1)->children()->children()->children()->children()->children()->eq(0)->text(),
                            'gol_local' => $node->children()->children()->eq(1)->children()->children()->children()->children()->children()->eq(1)->text(),
                            'tiempo_partido' => $node->children()->children()->eq(1)->children()->children()->children()->children()->children()->eq(2)->text(),
                            'nombre_visitante' => $node->children()->children()->eq(1)->children()->children()->children()->children()->eq(1)->children()->eq(0)->text(),
                            'gol_visitante' => $node->children()->children()->eq(1)->children()->children()->children()->children()->eq(1)->children()->eq(1)->text()
                        ];
                    })[0];
                }
            }
            // * hola mundo 
            // ! hola mundo
            // todo: hola mundo
            // ? prueba
            return response()->json($partidos);
        } catch (Exception $exception) {
            Log::error($exception);
        }
    }

    public function getUrlPartidosLive(){
        try {
            $crawler = Goutte::request('GET', 'https://www.betfair.com/sport/inplay');
            $partidos = $crawler->filter('div.list-multipickavb')->each(function ($node,$i) {
                $bloques_competencias = $node->children()->children()->eq(1)->children()->children();
                $part = $bloques_competencias->each(function ($node,$i) {
                    $list_parts = $node->children()->eq(1)->children();
                    $parts = $list_parts->each(function ($node,$i) {
                        return $node->children()->children()->eq(1)->children()->eq(1)->children()->extract(['href'])[0];
                    });
                    return $parts;
                });
                return ['url_partidos' => $part];
            });
            return $partidos[0]['url_partidos'];
        } catch (Exception $exception) {
            Log::error($exception);
        }
    }
}
