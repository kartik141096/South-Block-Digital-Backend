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
    
    public function get_category()
    {

        $categories = Category::with('slaves')->get();
        foreach ($categories as $category) {
            if($category->is_deleted == 0){

                $categoryData = [
                    'category_id' => $category->id,
                    'category_name' => $category->name,
                    'is_active' => $category->is_active,
                    'slaves' => []
                ];
                $v=0;
                foreach ($category->slaves as $slave) {

                    if($slave ->is_deleted == 0){

                        $categoryData['slaves'][$v]['subcategory_id'] = $slave->id;
                        $categoryData['slaves'][$v]['subcategory_name'] = $slave->name;
                        $categoryData['slaves'][$v]['is_active'] = $slave->is_active;
                    }
                    $v++;
                }
                
                $categoriesData[][] = $categoryData;
            }
        }
        // return $categoriesData;
        return json_encode($categoriesData);
    }

    public function get_news_list()
    {

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

    public function update_category(Request $request)
    {
        $data = $request->only('id','name','is_parent','is_active','is_deleted');
        $status = FALSE;
        $updateData = [];
        
        if (isset($data['id']) && $data['id']!= NULL){

            if (isset($data['name']) && $data['name']!= NULL) {
                $updateData['name'] = $data['name'];
            }
            if (isset($data['is_parent']) && $data['is_parent']!= NULL) {
                $updateData['is_parent'] = $data['is_parent'];
            }
            if (isset($data['is_active']) && $data['is_active']!= NULL) {
                $updateData['is_active'] = $data['is_active'];
            }
            if (isset($data['is_deleted']) && $data['is_deleted']!= NULL) {
                $updateData['is_deleted'] = $data['is_deleted'];
            }

            if (!empty($updateData)) {
    
                $rowsAffected = Category::where('id', $data['id'])->update($updateData);
    
                if ($rowsAffected > 0) {

                    $status = TRUE;
                } else {

                    $status = FALSE;
                }
            }
        }
        return $status;

    }
}
