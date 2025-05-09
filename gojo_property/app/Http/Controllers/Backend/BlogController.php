<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogCategory; 
use Carbon\Carbon;
use App\Models\BlogPost; 
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function AllBlogCategory(){
        $category = BlogCategory::latest()->get();
        return view('backend.category.blog_category',compact('category'));
    }


    public function StoreBlogCategory(Request $request){ 
        BlogCategory::insert([ 
            'category_name' => $request->category_name,
            'category_slug' => strtolower(str_replace(' ','-',$request->category_name)),  
        ]);
          $notification = array(
            'message' => 'BlogCategory Created Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.blog.category')->with($notification);
    } 


    public function EditBlogCategory($id){
        $categories = BlogCategory::findOrFail($id);
        return response()->json($categories);
    }


    public function UpdateBlogCategory(Request $request){ 
        $cat_id = $request->cat_id;

        BlogCategory::findOrFail($cat_id)->update([ 
            'category_name' => $request->category_name,
            'category_slug' => strtolower(str_replace(' ','-',$request->category_name)),  
        ]);
          $notification = array(
            'message' => 'BlogCategory Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.blog.category')->with($notification);
    } 


    public function DeleteBlogCategory($id){
        BlogCategory::findOrFail($id)->delete();
        $notification = array(
            'message' => 'BlogCategory Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function AllPost(){
        $post = BlogPost::latest()->get();
        return view('backend.post.all_post',compact('post')); 
    }

    public function AddPost(){
        $blogcat = BlogCategory::latest()->get();
        return view('backend.post.add_post',compact('blogcat')); 
    }


    public function StorePost(Request $request){ 
        $image = $request->file('post_image');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        $manager = new ImageManager(new Driver()); 
        $img = $manager->read($image)->resize(370,250);
        $img->save(public_path('upload/post/' . $name_gen));
        $save_url = 'upload/post/'.$name_gen;
    
        BlogPost::insert([
            'blogcat_id' => $request->blogcat_id,
            'user_id' => Auth::user()->id,
            'post_title' => $request->post_title,
            'post_slug' => strtolower(str_replace(' ','-',$request->post_title)), 
            'short_descp' => $request->short_descp,
            'long_descp' => $request->long_descp,
            'post_tags' => $request->post_tags,
            'post_image' => $save_url, 
            'created_at' => Carbon::now(),
        ]);
    
        $notification = array(
            'message' => 'BlogPost Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.post')->with($notification);
    }

    public function EditPost($id){      
        $blogcat = BlogCategory::latest()->get();
        $post = BlogPost::findOrFail($id);
        return view('backend.post.edit_post',compact('post','blogcat'));
    }

    public function UpdatePost(Request $request){
        $post_id = $request->id;
        if ($request->file('post_image')) {
            $image = $request->file('post_image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $manager = new ImageManager(new Driver()); 
            $img = $manager->read($image)->resize(370,250);
            $img->save(public_path('upload/post/' . $name_gen));
            $save_url = 'upload/post/'.$name_gen;
            
            BlogPost::findOrFail($post_id)->update([
                'blogcat_id' => $request->blogcat_id,
                'user_id' => Auth::user()->id,
                'post_title' => $request->post_title,
                'post_slug' => strtolower(str_replace(' ','-',$request->post_title)), 
                'short_descp' => $request->short_descp,
                'long_descp' => $request->long_descp,
                'post_tags' => $request->post_tags,
                'post_image' => $save_url, 
                'created_at' => Carbon::now(),
            ]);
        } else {
            BlogPost::findOrFail($post_id)->update([
                'blogcat_id' => $request->blogcat_id,
                'user_id' => Auth::user()->id,
                'post_title' => $request->post_title,
                'post_slug' => strtolower(str_replace(' ','-',$request->post_title)), 
                'short_descp' => $request->short_descp,
                'long_descp' => $request->long_descp,
                'post_tags' => $request->post_tags, 
                'created_at' => Carbon::now(),
            ]);
        }
    
        $notification = array(
            'message' => 'BlogPost Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.post')->with($notification);
    }
      
    public function BlogDetails($slug){
        $blog = BlogPost::where('post_slug',$slug)->first();
        
        $tags = $blog->post_tags;
        $tags_all = explode(',',$tags);
        $bcategory = BlogCategory::latest()->get();
        $dpost = BlogPost::latest()->limit(3)->get();
        return view('frontend.blog.blog_details',compact('blog','tags_all','bcategory','dpost'));    
    }
      
    public function DeletePost($id){
        $post = BlogPost::findOrFail($id);
        $img = $post->post_image;
        unlink($img);
        BlogPost::findOrFail($id)->delete();

        $notification = array(
            'message' => 'BlogPost Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification); 
    }       

    public function BlogCatList($id){
        $blog = BlogPost::where('blogcat_id',$id)->get();
        $breadcat = BlogCategory::where('id',$id)->first();
        $bcategory = BlogCategory::latest()->get();
        $dpost = BlogPost::latest()->limit(3)->get();
        return view('frontend.blog.blog_cat_list', compact('blog','breadcat','bcategory','dpost'));
    }

    public function BlogList(){
        $blog = BlogPost::latest()->get(); 
        $bcategory = BlogCategory::latest()->get();
        $dpost = BlogPost::latest()->limit(3)->get();
        return view('frontend.blog.blog_list', compact('blog','bcategory','dpost'));
    }
}