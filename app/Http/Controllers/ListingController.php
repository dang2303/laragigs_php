<?php

namespace App\Http\Controllers;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use League\CommonMark\Block\Element\ListItem;

class ListingController extends Controller
{
    //show all listings
    public function index(){
        return view('listings.index', [
            //'heading' => 'Latest listing',
            'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(4)
            ]);
    }

    //show single listing
    public function show(Listing $listing){
        return view('listings.show', [
            'listing' => $listing
        ]);
    }

    //Show create Form
    public function create(){
        return view('listings.create');
    }

    //Store listings data
    public function store(Request $request){
        $formFeilds = $request -> validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if($request->hasFile('logo')){
            $formFeilds['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $formFeilds['user_id'] = auth()->id();

        Listing::create($formFeilds);

        return redirect('/Listings')->with('message', 'Listing created successfully!');
    }

    //Show edit listing
    public function edit(Listing $listing){
        //make sure logged in user is owner
        if($listing -> user_id != auth()->id()){
            abort(403, 'Unauthorized action');
        }
        return view('listings.edit', ['listing' => $listing]);
    }

    public function update(Request $request,Listing $listing){
        //make sure logged in user is owner
        if($listing -> user_id != auth()->id()){
            abort(403, 'Unauthorized action');
        }
        $formFeilds = $request -> validate([
            'title' => 'required',
            'company' => ['required'],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if($request->hasFile('logo')){
            $formFeilds['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $listing->update($formFeilds);

        return back()->with('message', 'Listing updated successfully!');
    }

    //delete listing
    public function delete(Listing $listing){
        //make sure logged in user is owner
        if($listing -> user_id != auth()->id()){
            abort(403, 'Unauthorized action');
        }
        $listing->delete();
        return redirect('/Listings')->with('message', 'Listing deleted successfully!');
    }

    //manage listings
    public function manage(){
        return view('listings.manage', ['listings' => auth()->user()->listings()->get()]);
        //khong phai loi
    }
}
