<?php

namespace App\Http\Controllers;

use App\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::latest()->get();
        return response([
            'success' => true,
            'message' => 'List Semua Blogs',
            'data' => $blogs
        ], 200);
    }
    public function store(Request $request)
    {
        // validate data
        $validator = Validator::make(
            $request->all(),
            [
                'title' => 'required',
                'content' => 'required',
            ],
            [
                'title.required' => 'masukan title blog!',
                'content.required' => 'masukan content blog'
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'silahkan isi bidang yang kosong',
                'data' => $validator->errors()
            ], 400);
        } else {
            $blog = Blog::create([
                'title' => $request->input('title'),
                'content' => $request->input('content')
            ]);
            if ($blog) {
                return response()->json([
                    'success' => true,
                    'message' => 'blog berhasil disimpan',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'blog gagal disimpan',
                ], 400);
            }
        }
    }
    public function show($id)
    {
        $blog = Blog::whereId($id)->first();
        if ($blog) {
            return response()->json([
                'success' => true,
                'message' => 'detail blog',
                'data' => $blog
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'blog tidak ditemukan',
                'data' => ''
            ], 400);
        }
    }
    public function update(Request $request, $id)
    {
        // validate data
        $validator = validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
        ], [
            'title.required' => 'masukan title blog...',
            'content.required' => 'masukan content blog...',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'silahkan isi bidang yang kosong',
                'data' => $validator->errors()
            ], 400);
        } else {

            // $blog =   Blog::whereId($request->input('id'))->update([
            $blog =   Blog::whereId($id)->update([

                'title' => $request->input('title'),
                'content' => $request->input('content'),
            ]);
            if ($blog) {
                return response()->json([
                    'success' => true,
                    'message' => 'blog anda berhasil diupdate',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'blog anda gagal diupdate',
                ], 500);
            }
        }
    }
    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();
        if($blog){
            return response()->json([
                'success'=>true,
                'message'=>'blog berhasil dihapus',
            ],200);
        }else{
            return response()->json([
                'success'=>false,
                'message'=>'blog gagal dihapus',
            ],500);
        }
    }
}
