<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\LostItem;
use App\Models\FoundItem;
use App\Models\Claim;
use App\Models\Student;

class AdminController extends Controller
{
    public function loginPage()
    {
        return view('admin-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'password' => 'required'
        ]);

        $adminPassword = config('admin.password');

        if (! is_string($adminPassword) || trim($adminPassword) === '') {
            return back()->with('error', 'Admin password is not configured.');
        }

        if (hash_equals($adminPassword, (string) $request->password)) {
            session([
                'is_admin' => true,
                'admin_name' => config('admin.name', 'System Admin')
            ]);

            session()->forget([
                'student_id',
                'student_name',
                'student_matric',
                'student_phone',
                'student_profile_picture',
                'student_registration_id',
                'student_password_reset_id',
                'student_profile_update',
            ]);

            return redirect('/admin/dashboard');
        }

        return back()->with('error', 'Invalid admin password.');
    }

    public function dashboard()
    {
        if (!session('is_admin')) {
            return redirect('/admin/login');
        }

        $lostItemsCount = LostItem::count();
        $foundItemsCount = FoundItem::count();
        $studentsCount = Student::count();

        $pendingClaimsCount = Claim::where('status', 'pending')->count();

        $recentLostItems = LostItem::latest()->take(5)->get();
        $recentFoundItems = FoundItem::latest()->take(5)->get();

        $pendingClaims = Claim::with('foundItem')
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

            $dashboardClaims = Claim::with('foundItem')->latest()->get();

        return view('admin-dashboard', compact(
            'lostItemsCount',
            'foundItemsCount',
            'studentsCount',
            'pendingClaimsCount',
            'recentLostItems',
            'recentFoundItems',
            'pendingClaims',
            'dashboardClaims'
        ));
    }

    public function claims()
{
    if (!session('is_admin')) {
        return redirect('/admin/login');
    }

    $status = request('status', 'all');

    $query = Claim::with('foundItem')->latest();

    if ($status !== 'all') {
        $query->where('status', $status);
    }

    $claims = $query->get();

    $pendingClaimsCount = Claim::where('status', 'pending')->count();

    return view('admin-claims', compact(
        'claims',
        'pendingClaimsCount'
    ));
    }

    public function approveClaim($id)
    {
        if (session('is_admin') !== true) {
    return redirect('/admin/login')->with('error', 'Only admin can approve claims.');
}

        $claim = Claim::with('foundItem')->findOrFail($id);

        $claim->status = 'approved';
        $claim->save();

        if ($claim->foundItem) {
            $claim->foundItem->status = 'claimed';
            $claim->foundItem->save();
        }

        return redirect('/admin/claims')->with('success', 'Claim approved successfully.');
    }

    public function rejectClaim($id)
    {
        if (session('is_admin') !== true) {
    return redirect('/admin/login')->with('error', 'Only admin can reject claims.');
}

        $claim = Claim::findOrFail($id);

        $claim->status = 'rejected';
        $claim->save();

        return redirect('/admin/claims')->with('success', 'Claim rejected successfully.');
    }

    public function users()
{
    if (!session('is_admin')) {
        return redirect('/admin/login');
    }

    $students = Student::latest()->get();

    $studentsCount = Student::count();
    $lostItemsCount = LostItem::count();
    $foundItemsCount = FoundItem::count();
    $pendingClaimsCount = Claim::where('status', 'pending')->count();

    return view('admin-users', compact(
        'students',
        'studentsCount',
        'lostItemsCount',
        'foundItemsCount',
        'pendingClaimsCount'
    ));
}

    public function reports()
{
    if (!session('is_admin')) {
        return redirect('/admin/login');
    }

    $lostItemsCount = LostItem::count();
    $foundItemsCount = FoundItem::count();
    $studentsCount = Student::count();

    $totalClaimsCount = Claim::count();
    $pendingClaimsCount = Claim::where('status', 'pending')->count();
    $approvedClaimsCount = Claim::where('status', 'approved')->count();
    $rejectedClaimsCount = Claim::where('status', 'rejected')->count();

    $claimedItemsCount = FoundItem::where('status', 'claimed')->count();
    $lostItems = LostItem::latest()->take(5)->get();
    $foundItems = FoundItem::latest()->take(5)->get();
    $claims = Claim::with('foundItem')->latest()->take(5)->get();

    return view('admin-reports', compact(
        'lostItemsCount',
        'foundItemsCount',
        'studentsCount',
        'totalClaimsCount',
        'pendingClaimsCount',
        'approvedClaimsCount',
        'rejectedClaimsCount',
        'claimedItemsCount',
        'lostItems',
        'foundItems',
        'claims'
    ));
}

   public function messages()
{
    if (!session('is_admin')) {
        return redirect('/admin/login');
    }

    $messages = DB::table('contact_messages')
        ->orderByDesc('created_at')
        ->get();

    $totalMessages = $messages->count();
    $unreadMessagesCount = $messages->where('status', 'unread')->count();

    $pendingClaimsCount = Claim::where('status', 'pending')->count();

    return view('admin-messages', compact(
        'messages',
        'totalMessages',
        'unreadMessagesCount',
        'pendingClaimsCount'
    ));
}


  public function logout()
{
    session()->forget('is_admin');
    session()->forget('admin_name');

    return redirect('/admin/login')->with('success', 'Admin logged out successfully.');
}
    public function showClaim($id)
    {
        if (!session('is_admin')) {
            return redirect('/admin/login');
        }

        $claim = Claim::with('foundItem')->findOrFail($id);

         $pendingClaimsCount = Claim::where('status', 'pending')->count();

        return view('admin-claim-details', compact('claim', 'pendingClaimsCount'));
    }

    public function studentDetails($id)
{
    if (!session('is_admin')) {
        return redirect('/admin/login');
    }

    $student = Student::findOrFail($id);

    $lostItems = LostItem::where('matric_number', $student->matric_number)
        ->latest()
        ->get();

    $foundItems = FoundItem::where('matric_number', $student->matric_number)
        ->latest()
        ->get();

    $claims = Claim::where('matric_number', $student->matric_number)
        ->with('foundItem')
        ->latest()
        ->get();

    $pendingClaimsCount = Claim::where('status', 'pending')->count();

    return view('admin-student-details', compact(
        'student',
        'lostItems',
        'foundItems',
        'claims',
        'pendingClaimsCount'
    ));
}

public function deleteStudent($id)
{
    if (!session('is_admin')) {
        return redirect('/admin/login');
    }

    $student = Student::findOrFail($id);
    $student->delete();

    return redirect('/admin/users')->with('success', 'Student account deleted successfully. Existing reports remain in the system.');
}

public function markMessageRead($id)
{
    if (!session('is_admin')) {
        return redirect('/admin/login');
    }

    DB::table('contact_messages')
        ->where('id', $id)
        ->update([
            'status' => 'read',
            'updated_at' => now(),
        ]);

    return redirect('/admin/messages')->with('success', 'Message marked as read.');
}

public function deleteMessage($id)
{
    if (!session('is_admin')) {
        return redirect('/admin/login');
    }

    DB::table('contact_messages')
        ->where('id', $id)
        ->delete();

    return redirect('/admin/messages')->with('success', 'Message deleted successfully.');
}

}
