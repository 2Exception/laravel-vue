<?php
namespace App\Repositories\Frontend;

use App\Models\Video;

class VideoRepository extends CommonRepository
{

    public function __construct(Video $video)
    {
        parent::__construct($video);
    }

    /**
     * 视频列表页面
     * @param  Array $input [search]
     * @return Array
     */
    public function lists($input)
    {
        $dicts          = $this->getRedisDictLists(['audit' => ['pass'], 'video_status' => ['show']]);
        $default_search = [
            'filter' => ['id', 'title', 'content', 'auther'],
            'search' => [
                'status'   => $dicts['video_status']['show'],
                'is_audit' => $dicts['audit']['pass'],
            ],
            'sort'   => [
                'created_at' => 'desc',
            ],
        ];
        $search = $this->parseParams($default_search, $input);
        return $this->model->parseWheres($search)->with('comment', 'read', 'interact')->paginate();
    }
}
