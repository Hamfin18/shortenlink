<?php

namespace App\Http\Controllers;

use App\Models\LinkList;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index($pLink = null)
    {
        if ($pLink) {
            $link = LinkList::where('p_link', $pLink)->first();
            $rLink = (strpos($link->r_link, 'http') === 0) ? $link->r_link : 'https://' . $link->r_link;
            return redirect()->away($rLink);
        }

        return view('dashboard.index');
    }

    public function getUrl(Request $request)
    {
        $requestLink = $request->url;
        $exist = LinkList::where('r_link', $requestLink)->first();

        if ($exist) {
            return $exist->p_link;
        } else {
            $newData = new LinkList();
            $newData->r_link = str_replace(['https://', 'http://'], '', $requestLink);
            $newData->p_link = Str::random(6);
            $newData->save();
            return $newData->p_link;
        }
    }
}
