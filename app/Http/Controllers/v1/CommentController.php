<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Services\v1\CommentService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
{
    protected $Comments;

    /**
     * ProductController constructor.
     * @param CommentService $service
     */
    public function __construct(CommentService $service)
    {
        require(app_path() . '/Common/jdf.php');
        $this->Comments = $service;
    }

    public function store(Request $request)
    {
        try {
            $result = $this->Comments->createComment($request);
            if ($result)
                return response()->json([
                    'error' => false
                ], 201);
            else
                return response()->json([
                    'error' => true
                ], 201);

        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'error_msg' => $e->getMessage()
            ], 500);
        }
    }
}
