{{-- modal delete --}}
<div class="hard-delete">
    <input type="checkbox" id="show-modal-delete" class="modal-toggle" />
    <div class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg">{{ __('Cảnh báo!') }}</h3>
            <p class="py-4">
                {!! nl2br(
                    __(
                        "Mày sẽ xoá hết tất cả những gì mày đang chọn đấy. \nNghĩ kỹ vào không lại khôi phục được như cho vào trash đâu đấy.\nLúc đấy lại bảo tao không nhắc. OK",
                    ),
                ) !!}
            </p>
            <div class="modal-action">
                <label for="show-modal-delete" class="btn btn-error btn-active text-white js-delete-handle"
                    data-path="{{ route('admin.posts.delete') }}" data-method="delete">{{ __('Delete Post') }}</label>
                <label for="show-modal-delete" class="btn js-delete-close">Cancel</label>
            </div>
        </div>
    </div>
</div>

{{-- modal soft delete --}}
<div class="soft-delete">
    <input type="checkbox" id="show-modal-soft-delete" class="modal-toggle" />
    <div class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg">{{ __('Nhắc nhở') }}</h3>
            <p class="py-4">
                @if ($isTrash)
                    {!! nl2br(__("Khôi phục bài viết mày đã xoá.\nXem kỹ vào không lại phải vào lần nữa🙄")) !!}
                @else
                    {!! nl2br(
                        __("Mày sẽ xoá hết tất cả những gì mày đang chọn đấy. \nNghĩ kỹ vào không lại mất phải mất công khôi phục."),
                    ) !!}
                @endif
            </p>
            <div class="modal-action">
                @if ($isTrash)
                    <label for="show-modal-soft-delete" class="btn btn-info btn-active text-white js-soft-delete-handle"
                        data-path="{{ route('admin.posts.restore') }}" data-method="post">{{ __('Restore') }}</label>
                @else
                    <label for="show-modal-soft-delete"
                        class="btn btn-error btn-active text-white js-soft-delete-handle"
                        data-path="{{ route('admin.posts.soft.delete') }}"
                        data-method="delete">{{ __('Remove trash') }}</label>
                @endif
                <label for="show-modal-soft-delete" class="btn js-delete-close">Cancel</label>
            </div>
        </div>
    </div>
</div>
