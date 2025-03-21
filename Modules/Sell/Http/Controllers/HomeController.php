<?php

namespace Modules\Sell\Http\Controllers;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Modules\Products\Enums\ProductEnum;
use Modules\Products\Models\BLogs;
use Modules\Products\Models\Products;
use Carbon\Carbon;
class HomeController extends Controller
{
    public function index()
    {
        $items = Products::with("category")
            ->where("status", ProductEnum::STATUS_ACTIVE)
            ->orderBy("created_at", "desc")
            ->limit(3)
            ->get();

        $blogs = BLogs::where("status", 1)
            ->orderBy("created_at", "desc")
            ->limit(4)
            ->get();

            $matches = [];
            $leagues = [
                "Vietnam-V-League"   => ["text" => "V-League 1", "id" => "3374-48"],
                "Vietnam-V-League-2" => ["text" => "V-League 2", "id" => "3374-411"],
                "Vietnam-Cup"        => ["text" => "Cúp Quốc Gia", "id" => "3374-1344"],
                "Vietnam-Super-Cup"  => ["text" => "Siêu cúp Quốc Gia", "id" => "3374-14202"],
                "AFC-Cup"            => ["text" => "AFC Champions League 2", "id" => "3374-1019"],
                "Club-Friendly-List" => ["text" => "Giao hữu", "id" => "3374-13926"],
                "Vietnam Play-Offs"  => ["text" => "Playoff", "id" => "3374-6301"],
            ];
        
            $client = new Client([
                'headers' => [
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
                    'Referer'    => 'https://betsapi.com',
                    'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                    'Accept-Language' => 'en-US,en;q=0.5',
                    'Cookie' => 'your_cookie_here',
                ]
            ]);
            
            foreach ($leagues as $league => $details) {
                $id = $details["id"];
                $index = 1;
            
                while (true) {
                    $link = "https://betsapi.com/tl/$id/Nam-Dinh-in-$league/p.$index";
                    
                    try {
                        $response = $client->get($link)->getBody()->getContents();
                    } catch (\GuzzleHttp\Exception\ClientException $e) {
                        break;
                    }
            
                    // Xử lý dữ liệu response ở đây
                    $dom = new \DOMDocument();
                    @$dom->loadHTML($response);
                    $xpath = new \DOMXPath($dom);
            
                    $rows = $xpath->query('//table[@class="table table-sm"]/tbody/tr');
                    if ($rows->length == 0) break;
            
                    foreach ($rows as $row) {
                        /** @var \DOMElement $row */
                        $cells = $row->getElementsByTagName('td');
                        if ($cells->length < 5) continue;
            
                        $teams = $this->__handleFormat($cells->item(2)->nodeValue);
                        $result = $this->__handleFormat($cells->item(4)->nodeValue);
                        $date = $this->__handleFormat($cells->item(0)->getAttribute('data-dt'));
            
                        if (stripos($result, 'Cancelled') !== false || preg_match('/\d+[-:]\d+/', $result)) {
                            continue;
                        }
            
                        $date = Carbon::parse(str_replace(["T", "Z"], [" ", ""], $date))->addHours(7)->format('Y-m-d H:i');
                        list($home_team_name, $away_team_name) = array_map([$this, '__handleFormat'], explode('v', $teams));
            
                        $home_team_image = $row->getElementsByTagName('img')->item(0)->getAttribute('src');
                        $away_team_image = $row->getElementsByTagName('img')->item(1)->getAttribute('src');
            
                        $matches[] = [
                            'date'      => $date,
                            'home_team' => ['name' => $home_team_name, 'image' => $home_team_image],
                            'away_team' => ['name' => $away_team_name, 'image' => $away_team_image],
                            'result'    => 'View',
                            'league'    => $details['text']
                        ];
                    }
                    $index++;
                }
            }
            usort($matches, fn($a, $b) => strtotime($a['date']) - strtotime($b['date']));
            $nextMatch = !empty($matches) ? $matches[0] : null;

        $medias = DB::table("medias")
            ->orderBy("created_at", "desc")
            ->limit(4)
            ->get();

        $ranks = new Client();
        $ranks = $ranks->request("get", "https://cms.hanoifc.net/api/rank/get-lists?tournamentId=1&year=2025")->getBody()->getContents();
        $ranks = json_decode($ranks);

        $viewData = [
            "items"    => $items,
            "blogs"    => $blogs,
            "nextMatch" => $nextMatch,
            "ranks"    => $ranks->data,
            "medias"   => $medias,
        ];

        return view("sell::pages.home")->with($viewData);
    }

    private function __handleFormat($text)
    {
        
        $text = str_replace("\n", "", $text);
        $text = trim($text);

        return $text;
    }

}