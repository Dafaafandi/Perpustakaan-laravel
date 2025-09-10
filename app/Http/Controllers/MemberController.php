<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;

class MemberController extends Controller
{
    /**
     * Display a listing of the members.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $members = User::whereHas('roles', function ($query) {
                $query->where('name', 'member');
            })->select(['id', 'name', 'email', 'created_at', 'image']);

            return DataTables::of($members)
                ->addIndexColumn()
                ->addColumn('avatar', function ($member) {
                    if ($member->image) {
                        return '<img src="' . asset('storage/' . $member->image) . '" alt="Avatar" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">';
                    } else {
                        return '<div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 40px; height: 40px; font-size: 16px;">'
                            . strtoupper(substr($member->name, 0, 1)) . '</div>';
                    }
                })
                ->addColumn('name_email', function ($member) {
                    return '<div>
                                <div class="fw-bold text-primary">' . $member->name . '</div>
                                <div class="text-muted small">' . $member->email . '</div>
                            </div>';
                })
                ->addColumn('registered_date', function ($member) {
                    return '<div>
                                <div class="fw-bold">' . $member->created_at->format('d M Y') . '</div>
                                <div class="text-muted small">' . $member->created_at->diffForHumans() . '</div>
                            </div>';
                })
                ->addColumn('action', function ($member) {
                    return '
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-outline-info" onclick="viewMember(' . $member->id . ')" title="View Details">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteMember(' . $member->id . ')" title="Delete Member">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    ';
                })
                ->filterColumn('name_email', function ($query, $keyword) {
                    $query->where(function ($q) use ($keyword) {
                        $q->where('name', 'like', "%{$keyword}%")
                            ->orWhere('email', 'like', "%{$keyword}%");
                    });
                })
                ->rawColumns(['avatar', 'name_email', 'registered_date', 'action'])
                ->make(true);
        }

        return view('admin.members.index', [
            'title' => 'Members Management'
        ]);
    }

    /**
     * Display the specified member.
     */
    public function show(string $id): View
    {
        $member = User::findOrFail($id);

        return view('admin.members.show', [
            'title' => 'Member Detail',
            'member' => $member
        ]);
    }

    /**
     * Remove the specified member from storage.
     */
    public function destroy(Request $request, string $id)
    {
        try {
            $member = User::findOrFail($id);

            // Prevent deletion of admin users
            if ($member->hasRole('admin')) {
                if ($request->ajax()) {
                    return response()->json(['error' => 'Cannot delete admin users.'], 400);
                }
                return redirect()->route('admin.members.index')
                    ->with('error', 'Cannot delete admin users.');
            }

            $member->delete();

            if ($request->ajax()) {
                return response()->json(['success' => 'Member deleted successfully.']);
            }

            return redirect()->route('admin.members.index')
                ->with('success', 'Member deleted successfully.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Failed to delete member.'], 500);
            }
            return redirect()->route('admin.members.index')
                ->with('error', 'Failed to delete member.');
        }
    }
}
