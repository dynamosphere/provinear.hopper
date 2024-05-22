<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserContactResource;
use App\Models\Enums\ContactType;
use App\Models\User;
use App\Models\UserContact;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rules\Enum;

class UserContactController extends Controller
{
    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Store a new contact for the authenticated user
     * 
     * Future:
     * - Add verification for newly added contact
     * - Allow user to change primary contact
     */
    public function store(Request $request, User $user)
    {
        Gate::authorize('user', $user);

        $validated = $request->validate([
            'type' => ['required', 'string', new Enum(ContactType::class)],
            'contact' => 'string|max:255|min:11|required',
            'provider' => 'nullable|string|max:12',
        ]);

        $validated['user_id'] = $user->user_id;
        $contact = $this->userService->newUserContact($validated);

        return new UserContactResource($contact);
    }

    /**
     * Get a contact using it's ID
     * 
     * The contact ID must be of the current authenticated user
     */
    public function show(Request $request, UserContact $contact)
    {
        Gate::authorize('view', $contact);

        return new UserContactResource($contact);
    }

    /**
     * Update a user contact
     * 
     * The contact ID must be of the current authenticated user
     */
    public function update(Request $request, UserContact $contact)
    {
        Gate::authorize('update', $contact);

        $validated = $request->validate([
            'type' => ['required', 'string', new Enum(ContactType::class)],
            'contact' => 'string|max:255|min:11|required',
            'provider' => 'nullable|string|max:12',
        ]);
        $contact = $this->userService->updateUserContact($contact, $validated);

        return new UserContactResource($contact);
    }

    /**
     * Get all contacts of the current authenticated user
     */
    public function index(Request $request, User $user)
    {
        Gate::authorize('user', $user);

        return UserContactResource::collection($user->contacts);
    }

    /**
     * Delete a user contact
     * 
     * The contact ID must be of the current authenticated user
     */
    public function destroy(Request $request, UserContact $contact)
    {
        Gate::authorize('delete', $contact);

        if ($this->userService->deleteUserContact($contact))
        {
            return response()->json([
                'message' => 'Contact deleted successfully'
            ], 402);
        }
    }
}
