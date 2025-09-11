<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccountInvitationLink;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class CompanyAccountInvitationController extends Controller
{
    /**
     * Show the create account link page
     */
    public function index()
    {
        $invitations = AccountInvitationLink::where('company_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('company.account-invitations.index', compact('invitations'));
    }

    /**
     * Show the form to create a new account invitation
     */
    public function create()
    {
        return view('company.account-invitations.create');
    }

    /**
     * Store a new account invitation
     */
    public function store(Request $request)
    {
        $request->validate([
            'expiration_hours' => 'required|integer|min:1|max:24',
        ]);

        // Calculate expiration time
        $expiresAt = Carbon::now()->addHours((int) $request->expiration_hours);

        // Create the invitation (role is automatically patient, email will be set during registration)
        $invitation = AccountInvitationLink::createInvitation([
            'email' => '', // Will be filled during registration
            'role' => 'patient', // Always patient
            'company_id' => auth()->id(),
            'expires_at' => $expiresAt,
            'created_by' => auth()->id(),
        ]);

        // Generate the invitation URL
        $invitationUrl = route('invitation.accept', ['token' => $invitation->token]);

        return redirect()->route('company.account-invitations.index')
            ->with('success', 'Account invitation link created successfully!')
            ->with('invitation_url', $invitationUrl);
    }

    /**
     * Delete an invitation
     */
    public function destroy(AccountInvitationLink $invitation)
    {
        // Ensure the invitation belongs to the current company
        if ($invitation->company_id !== auth()->id()) {
            abort(403);
        }

        $invitation->delete();

        return redirect()->route('company.account-invitations.index')
            ->with('success', 'Invitation deleted successfully!');
    }

    /**
     * Accept an invitation (public route)
     */
    public function accept($token)
    {
        $invitation = AccountInvitationLink::where('token', $token)->first();

        if (!$invitation) {
            return redirect()->route('login')->with('error', 'Invalid invitation link.');
        }

        if (!$invitation->isValid()) {
            if ($invitation->is_used) {
                return redirect()->route('login')->with('error', 'This invitation link has already been used.');
            }
            if ($invitation->isExpired()) {
                return redirect()->route('login')->with('error', 'This invitation link has expired.');
            }
        }

        return view('auth.accept-invitation', compact('invitation'));
    }

    /**
     * Process the invitation acceptance
     */
    public function processInvitation(Request $request, $token)
    {
        $invitation = AccountInvitationLink::where('token', $token)->first();

        if (!$invitation || !$invitation->isValid()) {
            return redirect()->route('login')->with('error', 'Invalid or expired invitation link.');
        }

        $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'mname' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'birthday' => 'required|date',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Calculate age
        $age = Carbon::parse($request->birthday)->age;

        // Update invitation with email
        $invitation->update(['email' => $request->email]);

        // Create the user
        $user = \App\Models\User::create([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'mname' => $request->mname,
            'email' => $request->email,
            'phone' => $request->phone,
            'birthday' => $request->birthday,
            'age' => $age,
            'company' => $invitation->company->company ?? $invitation->company->full_name,
            'role' => 'patient', // Always patient
            'password' => bcrypt($request->password),
            'created_by' => $invitation->created_by,
        ]);

        // Mark invitation as used
        $invitation->markAsUsed();

        // Log the user in
        auth()->login($user);

        return redirect()->route('patient.dashboard')
            ->with('success', 'Account created successfully! Welcome to ' . config('app.name'));
    }
}
