<?php

namespace Modules\Base\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Base\Models\Comment;
use Modules\Base\Http\Requests\CommentRequest;

class CommentController extends Controller
{

    public function comment(CommentRequest $request, $blogId){
        $data = $request->all('comment');
        $data['blog_id'] = $blogId;
        $data['user_id'] = auth()->id();

        if(Comment::create($data)){
            toastr()->success("Bình luận thành công", "Thành công");
            return redirect()->back();
        }

        return redirect()->back();
    }
    public function destroy($id){
        $comment = Comment::findOrFail($id);
        $comment->delete();
        toastr()->success("Xóa bình luận thành công", "Thành công");
        return redirect()->back();
    }
}
