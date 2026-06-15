<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about_us(){
        return view('page.about_us');
    }

    public function contact_us(){
        return view('page.contact_us');
    }

    public function privacy_policy(){
        return view('page.privacy_policy');
    }

    public function term_condition(){
        return view('page.term_condition');
    }

    public function refund_policy(){
        return view('page.refund_policy');
    }
}
