<?php

namespace Modules\Sell\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class MatchController extends Controller
{

    public function schedule(Request $request)
{
    $matches = [];
    $leagues = [
        "Vietnam-V-League"   => ["text" => "V-League 1", "id" => "3374-48"],
        "Vietnam-V-League-2" => ["text" => "V-League 2", "id" => "3374-411"],
        "Vietnam-Cup"        => ["text" => "Cúp Quốc gia", "id" => "3374-1344"],
        "Vietnam-Super-Cup"  => ["text" => "Siêu cúp Quốc gia", "id" => "3374-14202"],
        "AFC-Cup"            => ["text" => "AFC Champions League 2", "id" => "3374-1019"],
        "Club-Friendly-List" => ["text" => "Giao hữu", "id" => "3374-13926"],
        "Vietnam Play-Offs"  => ["text" => "Playoff", "id" => "3374-6301"],
    ];

    $client = new Client([
        'headers' => [
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3',
            'Referer'    => 'https://betsapi.com',
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Accept-Language' => 'en-US,en;q=0.5',
            'Cookie' => 'your_cookie_here',
        ],
    ]);

    foreach ($leagues as $league => $details) {
        $id = $details["id"];
        $index = 1;

        while (true) {
            $link = "https://betsapi.com/tl/$id/Nam-Dinh-in-$league/p.$index";
            try {
                $response = $client->get($link)->getBody()->getContents();
            } catch (\GuzzleHttp\Exception\ClientException $e) {
                // Nếu gặp lỗi 403 hoặc các lỗi khác, tiếp tục vòng lặp hoặc xử lý lỗi
                break;
            }

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
    // dd($matches);
    return view("sell::pages.schedule", [
        "position" => "schedule",
        "items"    => $matches,
        "leagues"  => $leagues,
        "query"    => $request->query(),
    ]);
}

    
    
    
    public function rank()
    {
        $years = range(2025,2019);
        $ranksByYear = [];
    
        foreach ($years as $year) {
            $client = new Client();
            $response = $client->request("get", "https://cms.hanoifc.net/api/rank/get-lists?tournamentId=1&year={$year}");
            $data = json_decode($response->getBody()->getContents());
            
            $ranksByYear[$year] = $data->data;
        }

        // dd($ranksByYear);
        $viewData = [
            "position" => "rank",
            "ranksByYear" => $ranksByYear,
            "years" => $years,
        ];
    
        return view("sell::pages.rank")->with($viewData);
    }
    
    public function result(Request $request)
    {
        $index       = 1;
        $statusCrawl = true;
        $matches     = [];
        $league      = $request->league ?? "Vietnam-V-League";
        $leagues     = [
            "Vietnam-V-League"   => [
                "text" => "Giải Bóng đá Vô địch Quốc gia V-League 1",
                "id"   => "3374-48"
            ],
            "Vietnam-V-League-2" => [
                "text" => "Giải Bóng đá hạng Nhất Quốc gia V-League 2",
                "id"   => "3374-411"
            ],
            "Vietnam-Cup"        => [
                "text" => "Giải Bóng đá Cúp Quốc gia",
                "id"   => "3374-1344"
            ],
            "Vietnam-Super-Cup"        => [
                "text" => "Chung kết siêu Cúp Quốc gia",
                "id"   => "3374-14202"
            ],
            "AFC-Cup"        => [
                "text" => "Giải Bóng đá Cúp C2 châu Á",
                "id"   => "3374-38266"
            ],
            "Club-Friendly-List"        => [
                "text" => "Giải Bóng đá giao hữu",
                "id"   => "3374-13926"
            ],
            "Vietnam Play-Offs"        => [
                "text" => "Playoff V-League",
                "id"   => "3374-6301"
            ],
        ];

        $id = $leagues[$league]["id"];

        $client = new Client([
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3',
                'Referer'    => 'https://betsapi.com',
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                'Accept-Language' => 'en-US,en;q=0.5',
                'Cookie' => 'your_cookie_here',
            ],
        ]);

        while ($statusCrawl) {
            $link = "https://betsapi.com/tl/$id/Nam-Dinh-in-$league/p.$index";
            if (!$link) {
                abort(404);
            }

            try {
                $response = $client->get($link)->getBody()->getContents();
            } catch (\GuzzleHttp\Exception\ClientException $e) {
                // Nếu gặp lỗi 403 hoặc các lỗi khác, tiếp tục vòng lặp hoặc xử lý lỗi
                break;
            }
            
            $dom      = new \DOMDocument();
            @$dom->loadHTML($response);;

            $xpath = new \DOMXPath($dom);

            $rows = $xpath->query('//table[@class="table table-sm"]/tbody/tr');

            if ($rows->length == 0) {
                $statusCrawl = false;
                break;
            }

            foreach ($rows as $row) {
                /** @var \DOMElement $row */
                $cells = $row->getElementsByTagName('td');
                if ($cells->length >= 5) {
                    $teams  = $this->__handleFormat($cells->item(2)->nodeValue); // Home v Away (trim to remove whitespace)
                    $result = $this->__handleFormat($cells->item(4)->nodeValue); // Result (trim to remove whitespace)
                    $date   = $this->__handleFormat($cells->item(0)->getAttribute('data-dt')); // Date (trim to remove whitespace)

                    if (!preg_match('/\d+[-:]\d+/', $result)) {
                        continue; // Skip this row if result doesn't match the pattern
                    }

                    $date = str_replace("T", " ",$date);
                    $date = str_replace("Z", "",$date);
                    $date   = Carbon::createFromFormat('Y-m-d H:i:s', $date, 'Asia/Ho_Chi_Minh');
                    $date->addHours(7);
                    $date           = $date->format('Y-m-d H:i');


                    $teams_info     = explode('v', $teams);
                    $home_team_name = ($teams_info[0]);
                    $away_team_name = ($teams_info[1]);
                    $home_team_name = preg_replace('/\[\d+\]/', '', $home_team_name);
                    $away_team_name = preg_replace('/\[\d+\]/', '', $away_team_name);

                    $home_team_name = $this->__handleFormat($home_team_name);
                    $away_team_name = $this->__handleFormat($away_team_name);

                    $images          = $row->getElementsByTagName('img');
                    $home_team_image = $images->item(0)->getAttribute('src');
                    $away_team_image = $images->item(1)->getAttribute('src');

                    // Build match array
                    $match = [
                        'date'      => $date,
                        'home_team' => [
                            'name'  => $home_team_name,
                            'image' => $home_team_image,
                        ],
                        'away_team' => [
                            'name'  => $away_team_name,
                            'image' => $away_team_image,
                        ],
                        'result'    => $result,
                    ];

                    // Add match to matches array
                    $matches[] = $match;
                }
            }
            $index++;
        }

        // dd($matches);
        $viewData = [
            "position" => "result",
            "items"    => $matches,
            "leagues"  => $leagues,
            "query"    => $request->query(),
        ];

        return view("sell::pages.result")->with($viewData);
    }

    private function __handleFormat($text)
    {
        
        $text = str_replace("\n", "", $text);
        $text = trim($text);

        return $text;
    }

}