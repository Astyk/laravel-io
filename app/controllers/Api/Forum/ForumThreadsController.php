<?php namespace Api;

use Lio\Forum\Threads\ThreadRepository;
use Lio\Tags\TagRepository;
use BaseController;
use Input;

class ForumThreadsController extends BaseController
{
    protected $threadsPerPage = 50;
    protected $threads;
    protected $tags;

    public function __construct(ThreadRepository $threads, TagRepository $tags)
    {
        $this->threads = $threads;
        $this->tags    = $tags;
    }

    public function getIndex($status = '')
    {
        $threadCount = Input::get('take', $this->threadsPerPage);
        $tags        = $this->tags->getAllTagsBySlug(Input::get('tags'));
        $threads     = $this->threads->getByTagsAndStatusPaginated($tags, $status, $threadCount);

        // We want the newest threads to come out in chronological order
        return $threads->getCollection()->reverse();
    }
}
