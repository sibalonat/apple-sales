<?php

namespace App\Http\Controllers;

use App\Http\Resources\LinkResource;
use App\Models\Link;
use App\Models\LinkProduct;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $links = Link::with('orders')->whereUserId($id)->get();
        return LinkResource::collection($links);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $link = Link::create([
            'user_id' => $request->user()->id,
            'code' => Str::random(6)
        ]);

        foreach ($request->input('products') as $product_id) {
            LinkProduct::create([
                'link_id' => $link->id,
                'product_id' => $product_id
            ]);
        }

        return $link;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Link  $link
     * @return \Illuminate\Http\Response
     */
    // public function show(Link $link)
    public function show($code)
    {
        return Link::with('user', 'products')->whereCode($code)->first();
    }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  \App\Models\Link  $link
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, Link $link)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  \App\Models\Link  $link
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy(Link $link)
    // {
    //     //
    // }
}
