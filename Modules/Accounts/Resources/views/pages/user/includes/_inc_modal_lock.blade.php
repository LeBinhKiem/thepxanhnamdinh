<div class="modal fade" id="lock-{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route("post.user.lock") }}" method="post">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Khóa tài khoản</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-1">Tài khoản: <b>{{ $item->name }}</b></div>
                    <input type="hidden" name="id" value="{{ $item->id }}">
                    <div>Lý do khóa:</div>
                    <div class="form-group mt-2">
                        <textarea required name="reason" class="form-control" rows="10"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Khóa</button>
                </div>
            </div>
        </form>
    </div>
</div>