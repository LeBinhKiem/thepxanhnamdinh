<?php

namespace Modules\Base\Helpers\Classics;

class PaginateHelper
{
    public static function show($items)
    {
        return ' <div>Hiển thị ' . ($items->firstItem() ?? 0) . ' - ' . ($items->lastItem() ?? 0) . ' / ' . $items->total() . ' bản ghi</div>';
    }

    public static function paginate($items, $quering = '')
    {
        return '<div class="d-flex justify-content-between align-items-center mt-2">
                            <nav aria-label="Page navigation">
                                <ul class="pagination">
                                    ' . $items->appends($quering)->render() . '
                                </ul>
                            </nav>
                            <div>Hiển thị ' . ($items->firstItem() ?? 0) . ' - ' . ($items->lastItem() ?? 0) . ' / ' . $items->total() . ' bản ghi</div>
                 </div>';
    }
}