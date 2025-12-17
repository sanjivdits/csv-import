<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function index()
    {
        if(Auth::check()){

            $contacts = Contact::where('user_id', Auth::id())->latest()->paginate(10);

            return view('contacts.index', compact('contacts'));
        }
  
        return redirect("/")->with('error', 'Opps! You do not have access');
        
    }
}