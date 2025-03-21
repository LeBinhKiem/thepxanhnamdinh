<?php

namespace Modules\Base\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Base\Http\Requests\VoteRequest;
use Modules\Base\Models\Votes;

class VoteController extends Controller
{

    protected static $instance = null;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new VoteController();
        }

        return self::$instance;
    }

    private function __getVoteDefault()
    {
        return [
            5 => [
                "percent"   => 0,
                "count"     => 0
            ],
            4 => [
                "percent"   => 0,
                "count"     => 0
            ],
            3 => [
                "percent"   => 0,
                "count"     => 0
            ],
            2 => [
                "percent"   => 0,
                "count"     => 0
            ],
            1 => [
                "percent"   => 0,
                "count"     => 0
            ],
        ];
    }

    public function vote(VoteRequest $request)
    {
        $data = $request->except("_token");
        $data["user_id"]    = get_user_id();
        $data["created_at"]  = now()->toDateTimeString();
        $data["updated_at"] = now()->toDateTimeString();

        $checkVote = DB::table("votes")
            ->where("model", $data["model"])
            ->where("model_id", $data["model_id"])
            ->where("user_id", $data["user_id"])
            ->first();

        if ($checkVote) {
            toastr()->warning("Bạn đã bình luận vào trang này!", "Thất bại");
            return redirect()->back();
        }

        $reponse = DB::table("votes")->insert($data);

        if ($reponse) {
            $this->__updateVoteForModel($data["model"], $data["model_id"]);
            toastr()->success("Đánh giá thành công", "Thành công");
        } else {
            toastr()->success("Đánh giá thất bại", "Thất bại");
        }

        return redirect()->back();
    }

    public function getDataVote($model, $modelID, $pageCurrent = 1)
    {
        $userID = get_user_id();

        $voteCurrentUser = Votes::with("user")
            ->where("model", $model)
            ->where("model_id", $modelID)
            ->where("user_id", $userID)
            ->first();

        $voteList = Votes::with("user")
            ->where("model", $model)
            ->where("model_id", $modelID)
            ->paginate(5, ["*"], "page", $pageCurrent);

        $voteAll = DB::table("votes")
            ->selectRaw("star, count(id) as count")
            ->where("model", $model)
            ->where("model_id", $modelID)
            ->groupBy("star")
            ->get();

        $voteOverview = $this->__getVoteDefault();

        $total = $voteList->total();

        foreach ($voteAll as $vote) {
            $voteOverview[$vote->star] = [
                "percent" => ($vote->count / $total) * 100,
                "count" => $vote->count
            ];
        }

        $data = [
            "current"   => $voteCurrentUser,
            "list"      => $voteList,
            "overview"  => $voteOverview,
            "model"     => class_basename($model),
            "model_id"  => $modelID,
        ];

        return $data;
    }

    public function delete(Request $request)
    {
        $userId = get_user_id();
        $model = $request->model;
        $modelID = $request->model_id;

        $reponse = DB::table("votes")
            ->where("model", $model)
            ->where("model_id", $modelID)
            ->where("user_id", $userId)
            ->delete();

        if ($reponse) {
            $this->__updateVoteForModel($model, $modelID);
            toastr()->success("Xóa đánh giá thành công", "Thành công");
        } else {
            toastr()->success("Xóa đánh giá thất bại", "Thất bại");
        }

        return redirect()->back();
    }

    private function __updateVoteForModel($model, $modelID)
    {
        $avgStar = DB::table("votes")
            ->where("model", $model)
            ->where("model_id", $modelID)
            ->avg("star");

        $reponse = DB::table(strtolower($model))
            ->where("id", $modelID)
            ->update(["vote" => floor($avgStar)]);

        return $reponse;
    }
}
