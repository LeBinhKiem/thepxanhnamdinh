
<h2>Bình luận</h2>
@if (auth()->check())
    
<form action="{{route('post.comment.comment',$item->id)}}" method="post" role="form">
  @csrf
  <div class="form-group {{ has_error($errors,"comment") }}">
      <textarea class="form-control form-control-sm"  name="comment" placeholder="Nhập bình luận"
      ></textarea>
      {!! get_error($errors,"comment") !!}
  </div>
    <button type="submit" class="btn btn-primary">Gửi</button>
</form>

@else
    <a href="{{route('get.auth_user.login')}}" style="color: red">Đăng nhập để có thể bình luận bài viết</a>
@endif

<h3 class="mt-5">Tất cả bình luận</h3>
<hr>
@forelse ($comment as $comm)
<div class="d-flex justify-content-between align-items-center">
  <div class="d-flex">
      <img onerror="this.onerror=null;this.src='{{ asset("images/avatar-default.png") }}';"
      src="{{ render_url_upload($comm->user->logo) }}" width="45" height="45" class="rounded-circle border" alt="">
      <div class="ms-3">
          <h4 style="margin-bottom: 0;">{{$comm->user->full_name}}<small class="ms-2">{{$comm->created_at->format('d/m/Y')}}</small></h4> 
          <p style="margin-bottom: 0;">{{$comm->comment}}</p>
      </div>
  </div>
  @can('my-comment', $comm)
  <div class="d-flex align-items-center">
      <form action="{{ route('delete.comments.destroy', $comm->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bình luận này?');">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
      </form>
  </div>
  @endcan
</div>
  <hr>
  @empty
  <p>Chưa có bình luận nào về bài đăng này.</p>
@endforelse

@if ($comment->count() > 0)
  <div class="d-flex justify-content-center mt-3">
    {{ $comment->appends($query)->links() }}
  </div>
@endif

