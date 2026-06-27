<?php
namespace App\Http\Controllers;
use App\Models\Member;
class MemberController extends Controller {
    public function index() {
        $type = request('type', 'executive');
        $members = Member::where('is_published', true)->where('type', $type)->orderBy('sort_order')->get();
        return view('members.index', compact('members'));
    }
}