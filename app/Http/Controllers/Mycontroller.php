<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\a_user;
use App\Models\category;
use App\Models\product;

use Illuminate\Support\Facades\Redis;
use PHPUnit\Event\Telemetry\GarbageCollectorStatus;

class Mycontroller extends Controller
{
    public function index()
    {
        $category = category::all();
        $product = product::all();

        return view('front')->with('category',$category)->with('product',$product);
    }
    public function login(){
        return view('login');
    }
    //Login Check------

    public function login_check(Request $request)
    {
        $request->validate([
            'uname'=>'required',
            'password'=>'required'
        ],[
            'uname.required'=>'Username Field Is Required',
            'password.required'=>'Password Field Is Required'
        ]);
        $data = a_user::where('uname',$request['uname'])->where('password',$request['password'])->first();

        if($data)
        {
            session()->put('uname',$data['uname']);
            return redirect()->route('dashboard');
        }
        else
        {
            session()->flash('error','Please Enter Valid UserName And Password');
            return redirect()->route('login');
        }
    }

    public function product()
    {
        $data = category::all();
        return view('product_add')->with('data',$data);
    }

    public function add_product(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'price'=>'required|numeric',
            'image'=>'required'
        ],[
            'name.required'=>'Product Name Is Required',
            'image.reuired'=>'Product Image Is Required',
            'price.reuired'=>'Product Price Is Required',
            'price.numeric'=>'Please Enter Number Only In Product Price'
        ]);

        if($request->hasFile('image'))
        {
            $name = time().".". $request['image']->extension();
            if($request['image']->move(public_path('p_image'),$name))
            {
                $data = new product;

                $data->name = $request['name'];
                $data->price = $request['price'];
                $data->catagory = $request['cat'];
                $data->image = $name;
                $data->color = $request['color'];

                if($data->save())
                {
                    return redirect()->route('product.add');
                }
                else
                {
                    session()->flash('error','Sorry Record Was Not Inserted');
                    return redirect()->route('product.add');
                }
            }
            else
            {
                session()->flash('error','Sorry Image Was Not Not Uploaded');
                return redirect()->route('product.add');
            }
        }
        else
        {
            session()->flash('error','Please Upload Image');
            return redirect()->route('cat.add');
        }
    }

    //Category Add--------

    public function add_cat(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'image'=>'required'
        ],[
            'name.required'=>'Category Name Is Required',
            'image.reuired'=>'Category Image Is Required'
        ]);


        if($request->hasFile('image'))
        {
            $name = time().".". $request['image']->extension();
            if($request['image']->move(public_path('image'),$name))
            {
                $data = new category;

                $data->name = $request['name'];
                $data->image = $name;

                if($data->save())
                {
                    return redirect()->route('cat.add');
                }
                else
                {
                    session()->flash('error','Sorry Record Was Not Inserted');
                    return redirect()->route('cat.add');
                }
            }
            else
            {
                session()->flash('error','Sorry Image Was Not Not Uploaded');
                return redirect()->route('cat.add');
            }
        }
        else
        {
            session()->flash('error','Please Upload Image');
            return redirect()->route('cat.add');
        }

    }

    //category show----

    public function show_category()
    {
        $data = category::all();

        return view('show_category')->with('data',$data);
    }

    public function edit_cat(Request $request)
    {
        $data = category::where('id',$request['id'])->first();

        return response()->json([$data]);
    }

    public function delete_cat(Request $request)
    {
        $data = category::where('id',$request['id'])->delete();

        $pr = product::where('catagory',$request['id'])->delete();
        if($data && $pr)
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

    public function category_edit(Request $request)
    {
        $data = category::where('id',$request['id'])->first();

        if($request->hasFile('image'))
        {
            $name = time().".".$request['image']->extension();

            if($request['image']->move(public_path('image'),$name))
            {
                $data->name = $request['name'];
                $data->image = $name;
                if($data->save())
                {
                    return redirect()->route('show.cat');
                }
                else
                {
                    session()->flash('error','Record Not Updated');
                    return redirect()->route('show.cat');
                }
            }
            else{
                session()->flash('error','Image Not Uploaded');
                return redirect()->route('show.cat');
            }
        }
        else
        {
            $data->name = $request['name'];
            if($data->save())
            {
                return redirect()->route('show.cat');
            }
            else
            {
                session()->flash('error','Record Not Updated');
                return redirect()->route('show.cat');
            }
        }
    }

    public function show_product()
    {
        $data = product::all();

        return view('show_product')->with('data',$data);
    }

    public function edit_pro(Request $request)
    {
        $data = product::where('id',$request['id'])->first();

        return response()->json([$data]);
    }

    public function product_edit(Request $request)
    {
        $data = product::where('id',$request['id'])->first();

        if($request->hasFile('image'))
        {
            $name = time().".".$request['image']->extension();

            if($request['image']->move(public_path('p_image'),$name))
            {
                $data->name = $request['name'];
                $data->price = $request['price'];
                $data->color = $request['color'];
                $data->image = $name;
                if($data->save())
                {
                    return redirect()->route('show.product');
                }
                else
                {
                    session()->flash('error','Record Not Updated');
                    return redirect()->route('show.product');
                }
            }
            else{
                session()->flash('error','Image Not Uploaded');
                return redirect()->route('show.product');
            }
        }
        else
        {
            $data->name = $request['name'];
            $data->price = $request['price'];
            $data->color = $request['color'];
            if($data->save())
            {
                return redirect()->route('show.product');
            }
            else
            {
                session()->flash('error','Record Not Updated');
                return redirect()->route('show.product');
            }
        }
    }

    public function delete_product(Request $request)
    {
        $data = product::where('id',$request['id'])->delete();

        if($data)
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

    public function cat_filter(Request $request)
    {
        $data = product::where('catagory',$request['id'])->get();
        if($data)
        {
            return response()->json([$data]);
        }
        else
        {
            return 0;
        }

    }

    public function sort_filter(Request $request)
    {
        if($request['val'] == "a to z")
        {
            $data = product::orderBy('name')->get();
            return response()->json([$data]);
        }
        elseif($request['val'] == "z to a")
        {
            $data = product::orderBy('name' ,'DESC')->get();
            return response()->json([$data]);
        }
        elseif($request['val'] == "h to l")
        {
            $data = product::orderBy('price' ,'DESC')->get();
            return response()->json([$data]);
        }
        elseif($request['val'] == "l to h")
        {
            $data = product::orderBy('price')->get();
            return response()->json([$data]);
        }
    }

    public function filter_set(Request $request)
    {
        if($request['color'] != "")
        {
            if($request['price'] != "")
            {
                $data = product::where('color',$request['color'])->where('price','>=',$request['p_start'])->where('price','<=',$request['p_end'])->get();
                return response()->json([$data]);
            }
            else
            {
                $data = product::where('color',$request['color'])->get();
                return response()->json([$data]);
            }
        }
        elseif($request['price'] != "")
        {
            $data = product::where('price','>=',$request['p_start'])->where('price','<=',$request['p_end'])->get();
            return response()->json([$data]);
        }
        else
        {
            $data = product::all();
            return response()->json([$data]);
        }
       // return response()->json([$request->all()]);
    }
}