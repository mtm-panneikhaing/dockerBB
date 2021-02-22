<?php

namespace App\Http\Controllers;

use App\Contracts\Services\Post\PostServiceInterface;
use App\Exports\PostsExport;
use App\Imports\PostsImport;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Input;

class PostController extends Controller
{
    
    /** $postInterface */
    private $postInterface;

    /**
     * constructor
     * @param postInterface
     * */
    public function __construct(PostServiceInterface $postInterface)
    {
        $this->postInterface = $postInterface;
    }

    
    /**
     * post detail
     */
    public function detail(Request $request)
    {
        $postList = $this->postInterface->getPostList($request);
        return view('posts.post_list', [
            'posts' => $postList
        ]);
    }

    /**
     * Go to view post add
     */
    public function add()
    {
        return view('posts.post_add');
    }

    /**
     * create post to view
     */
    public function create()
    {
        return view('posts.create-post');
    }

    /**
     * confirmPost
     * @param $request
     * @return $posts
     */
    public function confirmPost(Request $request)
    {
        $validator = validator(request()->all(), [
            'title' =>'required|unique:posts',
            'description' => 'required',
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        return view('posts.post_add_confirm', [
            'post' => $request
        ]);
    }

    /**
     * insert post into database
     * @param request
     * @return info
     */
    public function insert(Request $request)
    {
        $this->postInterface->insertPost($request);

        return redirect('/posts')
            ->with('info', 'Add Post Successful');
    }
    /**
    * search updated data in database
    * @param update $id
    * @return old data
    */
    public function update($id)
    {
        $updatePost = $this->postInterface->searchPost($id);
        return view('posts.post_update', [
            'post' => $updatePost
        ]);
    }

    /**
     * update confirmation
     * @return posts
     */
    public function updateConfirm(Request $request)
    {
        $validator = validator($request->all(), [
            'title' =>'required',
            'description' => 'required',
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        return view('posts.post_update_confirm', [
            'post' => $request
        ]);
    }

    /**
     * update post into database
     * @param request
     */
    public function updatePost(Request $request)
    {
        $this->postInterface->updatePost($request);
        return redirect('/posts')
            ->with('info', 'Update Post Successfully');
    }
    /**
     * delete post
     * @param delete id
     * @return info
     */
    public function delete(Request $request)
    {
        $id = $request->id;

        $this->postInterface->deletePost($id);
        return redirect('/posts')
            ->with('info', 'Post  Deleted');
    }
}
