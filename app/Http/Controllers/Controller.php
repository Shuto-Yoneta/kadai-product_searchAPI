<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    
    // Web APIを実行する
    function execute_api($keyword) {
        
        $url = 'https://app.rakuten.co.jp/services/api/IchibaItem/Search/20170706';

        // applicationIdの 'xxxxx....' は取得したアプリIDに書き換える
        $params = [
            'format' => 'json',
            'applicationId' => '1084521773457364307',
            'hits' => 15,
            'imageFlag' => 1
        ];
        
        
        
        $query = http_build_query($params, "", "&");
        $search_url = $url . '?' . $query . '&keyword=' . $keyword;

        return file_get_contents($search_url);
    }
    
}
