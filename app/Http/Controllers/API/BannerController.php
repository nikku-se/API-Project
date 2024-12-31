<?php

namespace App\Http\Controllers\Api;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


/**
 * @OA\Info(
 *     title="API Documentation",
 *     version="1.0.0",
 *     description="This is the API documentation for the project.",
 *     @OA\Contact(
 *         email="contact@example.com"
 *     ),
 *     @OA\License(
 *         name="MIT",
 *         url="https://opensource.org/licenses/MIT"
 *     )
 * )
 */

 class BannerController extends Controller
 {
     /**
      * @OA\Get(
      *     path="/api/banners",
      *     summary="Get all banners",
      *     tags={"Banners"},
      *     @OA\Response(
      *         response=200,
      *         description="List of banners",
      *         @OA\JsonContent(
      *             type="array",
      *             @OA\Items(ref="#/components/schemas/Banner")
      *         )
      *     )
      * )
      */
     public function index()
     {
         return response()->json(Banner::all(), 200);
     }
 
     /**
      * @OA\Post(
      *     path="/api/banners",
      *     summary="Create a new banner",
      *     tags={"Banners"},
      *     @OA\RequestBody(
      *         required=true,
      *         @OA\MediaType(
      *             mediaType="multipart/form-data",
      *             @OA\Schema(
      *                 required={"name", "image", "description"},
      *                 @OA\Property(
      *                     property="name",
      *                     type="string",
      *                     description="Name of the banner",
      *                     example="Banner 1"
      *                 ),
      *                 @OA\Property(
      *                     property="image",
      *                     type="string",
      *                     format="binary",
      *                     description="Image file for the banner"
      *                 ),
      *                 @OA\Property(
      *                     property="description",
      *                     type="string",
      *                     description="Description of the banner",
      *                     example="This is a banner description."
      *                 )
      *             )
      *         )
      *     ),
      *     @OA\Response(
      *         response=201,
      *         description="Banner created successfully",
      *         @OA\JsonContent(ref="#/components/schemas/Banner")
      *     ),
      *     @OA\Response(response=422, description="Validation error")
      * )
      */
     public function store(Request $request)
     {
         $validated = $request->validate([
             'name' => 'required|string|max:255',
             'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
             'description' => 'required|string',
         ]);
 
         $imageName = time().'.'.$request->image->extension();
         $request->image->move(public_path('uploads'), $imageName);
 
         $banner = Banner::create([
             'name' => $validated['name'],
             'image' => $imageName,
             'description' => $validated['description'],
         ]);
 
         return response()->json($banner, 201);
     }
 
     /**
      * @OA\Get(
      *     path="/api/banners/{id}",
      *     summary="Get a specific banner by ID",
      *     tags={"Banners"},
      *     @OA\Parameter(
      *         name="id",
      *         in="path",
      *         required=true,
      *         @OA\Schema(type="integer"),
      *         description="Banner ID"
      *     ),
      *     @OA\Response(
      *         response=200,
      *         description="Banner details",
      *         @OA\JsonContent(ref="#/components/schemas/Banner")
      *     ),
      *     @OA\Response(response=404, description="Banner not found")
      * )
      */
     public function show($id)
     {
         $banner = Banner::find($id);
 
         if (!$banner) {
             return response()->json(['message' => 'Banner not found'], 404);
         }
 
         return response()->json($banner, 200);
     }
 
     /**
      * @OA\Put(
      *     path="/api/banners/{id}",
      *     summary="Update a specific banner by ID",
      *     tags={"Banners"},
      *     @OA\Parameter(
      *         name="id",
      *         in="path",
      *         required=true,
      *         @OA\Schema(type="integer"),
      *         description="Banner ID"
      *     ),
      *     @OA\RequestBody(
      *         required=true,
      *         @OA\JsonContent(
      *             @OA\Property(property="name", type="string", example="Updated Banner Name"),
      *             @OA\Property(property="image", type="string", example="updated_banner.jpg"),
      *             @OA\Property(property="description", type="string", example="Updated description.")
      *         )
      *     ),
      *     @OA\Response(
      *         response=200,
      *         description="Banner updated successfully",
      *         @OA\JsonContent(ref="#/components/schemas/Banner")
      *     ),
      *     @OA\Response(response=404, description="Banner not found"),
      *     @OA\Response(response=422, description="Validation error")
      * )
      */
     public function update(Request $request, $id)
     {
         $validated = $request->validate([
             'name' => 'string|max:255',
             'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
             'description' => 'string',
         ]);
 
         $banner = Banner::find($id);
 
         if (!$banner) {
             return response()->json(['message' => 'Banner not found'], 404);
         }
 
         // Update the image if it's provided
         if ($request->hasFile('image')) {
             $imageName = time().'.'.$request->image->extension();
             $request->image->move(public_path('uploads'), $imageName);
             $banner->image = $imageName;
         }
 
         $banner->update($validated);
 
         return response()->json($banner, 200);
     }
 
     /**
      * @OA\Delete(
      *     path="/api/banners/{id}",
      *     summary="Delete a specific banner by ID",
      *     tags={"Banners"},
      *     @OA\Parameter(
      *         name="id",
      *         in="path",
      *         required=true,
      *         @OA\Schema(type="integer"),
      *         description="Banner ID"
      *     ),
      *     @OA\Response(response=200, description="Banner deleted successfully"),
      *     @OA\Response(response=404, description="Banner not found")
      * )
      */
     public function destroy($id)
     {
         $banner = Banner::find($id);
 
         if (!$banner) {
             return response()->json(['message' => 'Banner not found'], 404);
         }
 
         $banner->delete();
 
         return response()->json(['message' => 'Banner deleted successfully'], 200);
     }
 }


















































































































































































































































// /**
//  * @OA\Info(
//  *     title="API Documentation",
//  *     version="1.0.0",
//  *     description="This is the API documentation for the project.",
//  *     @OA\Contact(
//  *         email="contact@example.com"
//  *     ),
//  *     @OA\License(
//  *         name="MIT",
//  *         url="https://opensource.org/licenses/MIT"
//  *     )
//  * )
//  */

// class BannerController extends Controller
// {
//     /**
//      * @OA\Get(
//      *     path="/api/banners",
//      *     summary="Get all banners",
//      *     tags={"Banners"},
//      *     @OA\Response(
//      *         response=200,
//      *         description="List of banners",
//      *         @OA\JsonContent(
//      *             type="array",
//      *             @OA\Items(ref="#/components/schemas/Banner")
//      *         )
//      *     )
//      * )
//      */
//     public function index()
//     {
//         return response()->json(Banner::all(), 200);
//     }

//     /**
//  * @OA\Post(
//  *     path="/api/banners",
//  *     summary="Create a new banner",
//  *     tags={"Banners"},
//  *     @OA\RequestBody(
//  *         required=true,
//  *         @OA\MediaType(
//  *             mediaType="multipart/form-data",
//  *             @OA\Schema(
//  *                 required={"name", "image", "description"},
//  *                 @OA\Property(
//  *                     property="name",
//  *                     type="string",
//  *                     description="Name of the banner",
//  *                     example="Banner 1"
//  *                 ),
//  *                 @OA\Property(
//  *                     property="image",
//  *                     type="string",
//  *                     format="binary",
//  *                     description="Image file for the banner"
//  *                 ),
//  *                 @OA\Property(
//  *                     property="description",
//  *                     type="string",
//  *                     description="Description of the banner",
//  *                     example="This is a banner description."
//  *                 )
//  *             )
//  *         )
//  *     ),
//  *     @OA\Response(
//  *         response=201,
//  *         description="Banner created successfully",
//  *         @OA\JsonContent(ref="#/components/schemas/Banner")
//  *     ),
//  *     @OA\Response(response=422, description="Validation error")
//  * )
//  */
//     public function store(Request $request)
//     {
//         $validated = $request->validate([
//             'name' => 'required|string|max:255',
//             'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
//             'description' => 'required|string',
//         ]);

//         $imageName = time().'.'.$request->image->extension();
//         $request->image->move(public_path('uploads'), $imageName);

//         $banner = Banner::create([
//             'name' => $validated['name'],
//             'image' => $imageName,
//             'description' => $validated['description'],
//         ]);

//         return response()->json($banner, 201);
//     }

//     /**
//      * @OA\Get(
//      *     path="/api/banners/{id}",
//      *     summary="Get a specific banner by ID",
//      *     tags={"Banners"},
//      *     @OA\Parameter(
//      *         name="id",
//      *         in="path",
//      *         required=true,
//      *         @OA\Schema(type="integer"),
//      *         description="Banner ID"
//      *     ),
//      *     @OA\Response(
//      *         response=200,
//      *         description="Banner details",
//      *         @OA\JsonContent(ref="#/components/schemas/Banner")
//      *     ),
//      *     @OA\Response(response=404, description="Banner not found")
//      * )
//      */
//     public function show($id)
//     {
//         $banner = Banner::find($id);

//         if (!$banner) {
//             return response()->json(['message' => 'Banner not found'], 404);
//         }

//         return response()->json($banner, 200);
//     }

//     /**
//      * @OA\Put(
//      *     path="/api/banners/{id}",
//      *     summary="Update a specific banner by ID",
//      *     tags={"Banners"},
//      *     @OA\Parameter(
//      *         name="id",
//      *         in="path",
//      *         required=true,
//      *         @OA\Schema(type="integer"),
//      *         description="Banner ID"
//      *     ),
//      *     @OA\RequestBody(
//      *         required=true,
//      *         @OA\JsonContent(
//      *             @OA\Property(property="name", type="string", example="Updated Banner Name"),
//      *             @OA\Property(property="image", type="string", example="updated_banner.jpg"),
//      *             @OA\Property(property="description", type="string", example="Updated description.")
//      *         )
//      *     ),
//      *     @OA\Response(
//      *         response=200,
//      *         description="Banner updated successfully",
//      *         @OA\JsonContent(ref="#/components/schemas/Banner")
//      *     ),
//      *     @OA\Response(response=404, description="Banner not found"),
//      *     @OA\Response(response=422, description="Validation error")
//      * )
//      */
//     public function update(Request $request, $id)
//     {
//         $validated = $request->validate([
//             'name' => 'string|max:255',
//             'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
//             'description' => 'string',
//         ]);

//         $banner = Banner::find($id);

//         if (!$banner) {
//             return response()->json(['message' => 'Banner not found'], 404);
//         }

//         // Update the image if it's provided
//         if ($request->hasFile('image')) {
//             $imageName = time().'.'.$request->image->extension();
//             $request->image->move(public_path('uploads'), $imageName);
//             $banner->image = $imageName;
//         }

//         $banner->update($validated);

//         return response()->json($banner, 200);
//     }

//     /**
//      * @OA\Delete(
//      *     path="/api/banners/{id}",
//      *     summary="Delete a specific banner by ID",
//      *     tags={"Banners"},
//      *     @OA\Parameter(
//      *         name="id",
//      *         in="path",
//      *         required=true,
//      *         @OA\Schema(type="integer"),
//      *         description="Banner ID"
//      *     ),
//      *     @OA\Response(response=200, description="Banner deleted successfully"),
//      *     @OA\Response(response=404, description="Banner not found")
//      * )
//      */
//     public function destroy($id)
//     {
//         $banner = Banner::find($id);

//         if (!$banner) {
//             return response()->json(['message' => 'Banner not found'], 404);
//         }

//         $banner->delete();

//         return response()->json(['message' => 'Banner deleted successfully'], 200);
//     }
// } -->

































































// public function getAll(){
//     $data['banners'] = Banner::all();
//     return response()->json([
//         'status'=>'true',
//         'message'=>'All Banner data',
//         'data'=>$data,
//     ]);
// }
// public function createBanner(Request $request){
//     $validateUser = validator::make($request->all(),[
//         'name'=>'required',
//         'image'=>'required|mimes:png,jpg,jpeg,gif',
//         'description'=>'required'
//     ]);
//     if($validateUser->fails()){
//         return response()->json([
//             'status'=>false,
//             'message'=>'Validation Error',
//             'errors'=> $validation->errors()->all(),
//         ],401);
//     }
//     $img = $request->image;
//     $ext = $img->getClientOriginalEXtension();
//     $imageName = time().'.'.$ext;
//     $img->move(public_path('uploads'),$imageName);

//     $banner = $Banner::create([
//         'name'=> $request->name,
//         'image'=>$request->imageName,
//         'description'=>$request->description,
//     ]);
//     return response()->json([
//         'status'=>true,
//         'message'=>'Banner Created Successfully',
//         'banner'=>$banner,
//     ]);
//  }
//  public function showBanner(string $id){
//     data['banner'] = Banner::select([
//         'id',
//         'name',
//         'image',
//         'description'
//     ])->where(['id',$id])->get();
//  }
//  Public function updateBanner(Request $request, string $id){
//     $validateUser = validator::make($request->all(),[
//         'name' => 'required',
//         'image'=>'required|mimes:jpg,jpeg,png,gif',
//         'description'=>'required'
//     ]);
//     if(validator->fails()){
//         return response()->json([
//             'status'=>false,
//             'message'=>'Validation Error',
//             'errors'=>$validation->errors()->all()
//         ]);
//     }

//  }