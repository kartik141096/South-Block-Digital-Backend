<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Category_Slave;
use App\Models\News;
use App\Models\News_Slave;

class WebAPI extends Controller
{
    public function get_weather()
    {   
        if($_SERVER['REMOTE_ADDR'] == "127.0.0.1")
            $q = "New Delhi";
        else{
            $q = $_SERVER['REMOTE_ADDR'];
        }

        $response = Http::get('http://api.weatherapi.com/v1/current.json', [

            'key' => '497bbe3effae4d6799050929241804',
            'q' => $q,
        ]);
        
        if ($response->successful()) 
        {
            $weatherData = $response->json();
            $weatherData['location']['date'] = date("D, j M Y");
            $weatherData['current']['condition']['icon'] = str_replace("//","",$weatherData['current']['condition']['icon']);

            return json_encode($weatherData);
        }else {
            $error = $response->status();
        }
    }
    
    public function get_category(){

        $categories = Category::with('slaves')->get();
        // $category_list['category_master'] = array();
        // $category_list['category_slave'] = array();
        
        foreach ($categories as $category) {
            $categoryData = [
                'category_name' => $category->name,
                'slaves' => []
            ];
        
            foreach ($category->slaves as $slave) {
                $categoryData['slaves'][] = [$slave->name];
            }
        
            $categoriesData[] = $categoryData;
        }
        return json_encode($categoriesData);
    }

    public function get_news_list(){

        $i=0;

        $dbNews = News::with('slaves')->get();

        foreach ($dbNews as $news) {
            $newsData[] = [
                'id' => $news->id,
                'category_id' => $news->category_id,
                'heading' => $news->heading,
                'paragraph' => $news->paragraph,
                'img' => $news->img,
                'tag' => $news->tag,
                'created_by' => $news->created_by,
                'is_active' => $news->is_active,
                'is_deleted' => $news->is_deleted,
                'created_at' => $news->created_at,
                'updated_at' => $news->updated_at,
                'slaves' => []
            ];
        
            foreach ($news->slaves as $slave) {
                $newsData[$i]['slaves'][] = [

                    'sub_heading' => $slave->sub_heading,
                    'paragraph' => $slave->paragraph,
                    'img' => $slave->img,
                ];
            }
            $i++;
        }
            // dd($newsData);
        return json_encode($newsData);
    }
}
