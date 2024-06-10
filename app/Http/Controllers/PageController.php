<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function aboutUs()
    {
        return view('pages.about');
    }

    public function contactUs()
    {
        return view('pages.contact');
    }

    public function pricing()
    {
        return view('pages.pricing');
    }

    public function privacyPolicy()
    {
        return view('pages.privacy');
    }

    public function termsConditions()
    {
        return view('pages.terms');
    }

    public function cancellationRefundPolicy()
    {
        return view('pages.cancellation');
    }
}
