<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use App\Models\HubungiKami;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class HubungiKamiController extends Controller
{
    /**
     * Display a listing of the messages.
     */
    public function index()
    {
        return view('pages.editor.hubungikami.hubungikami.index');
    }

    /**
     * Get data for DataTables
     */
    public function getData(Request $request)
    {
        $query = HubungiKami::orderBy('created_at', 'desc');

        // Filter pencarian
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                // Karena data terenkripsi, kita perlu menggunakan raw query atau melakukan pencarian berbeda
                // Untuk sementara, kita bisa mencari berdasarkan message saja atau ID
                $q->where('message', 'LIKE', "%{$search}%")
                  ->orWhere('id', 'LIKE', "%{$search}%");
            });
        }

        return DataTables::of($query)
            ->addColumn('full_name_display', function ($row) {
                return $row->full_name;
            })
            ->addColumn('email_display', function ($row) {
                return $row->email;
            })
            ->addColumn('phone_display', function ($row) {
                return $row->phone;
            })
            ->addColumn('message_display', function ($row) {
                return strlen($row->message) > 50 ? substr($row->message, 0, 50) . '...' : $row->message;
            })
            ->addColumn('status_display', function ($row) {
                if ($row->is_read) {
                    return '<span class="badge badge-success">Sudah Dibaca</span>';
                } else {
                    return '<span class="badge badge-warning">Belum Dibaca</span>';
                }
            })
            ->addColumn('created_at_display', function ($row) {
                return $row->created_at->format('d/m/Y H:i');
            })
            ->addColumn('action', function ($row) {
                $readText = $row->is_read ? 'Mark Unread' : 'Mark Read';
                $readClass = $row->is_read ? 'btn-secondary' : 'btn-info';
                
                return '<div class="btn-group" role="group">
                    <button type="button" class="btn btn-sm ' . $readClass . ' btnRead" data-id="' . $row->id . '" data-read="' . ($row->is_read ? '1' : '0') . '">' . $readText . '</button>
                    <button type="button" class="btn btn-sm btn-primary btnDetail" data-id="' . $row->id . '">Detail</button>
                    <button type="button" class="btn btn-sm btn-danger btnDelete" data-id="' . $row->id . '">Delete</button>
                </div>';
            })
            ->rawColumns(['status_display', 'action'])
            ->make(true);
    }

    /**
     * Get detail of a specific message
     */
    public function detail(Request $request): JsonResponse
    {
        try {
            $message = HubungiKami::findOrFail($request->id);
            
            return response()->json([
                'success' => 1,
                'data' => [
                    'id' => $message->id,
                    'full_name' => $message->full_name,
                    'email' => $message->email,
                    'phone' => $message->phone,
                    'message' => $message->message,
                    'is_read' => $message->is_read,
                    'created_at' => $message->created_at->format('d/m/Y H:i:s'),
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => 0,
                'messages' => 'Data tidak ditemukan'
            ]);
        }
    }

    /**
     * Toggle read status
     */
    public function toggleRead(Request $request): JsonResponse
    {
        try {
            $message = HubungiKami::findOrFail($request->id);
            
            // Toggle status read
            $message->is_read = !$message->is_read;
            $message->save();
            
            $status = $message->is_read ? 'dibaca' : 'belum dibaca';
            
            return response()->json([
                'success' => 1,
                'messages' => "Pesan berhasil ditandai sebagai {$status}"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => 0,
                'messages' => 'Gagal mengubah status pesan'
            ]);
        }
    }

    /**
     * Delete a message
     */
    public function deleteData(Request $request): JsonResponse
    {
        try {
            $message = HubungiKami::findOrFail($request->id);
            
            // Set deleted_by sebelum soft delete
            $message->deleted_by = Auth::id();
            $message->save();
            
            // Soft delete
            $message->delete();
            
            return response()->json([
                'success' => 1,
                'messages' => 'Pesan berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => 0,
                'messages' => 'Gagal menghapus pesan'
            ]);
        }
    }

    /**
     * Get dashboard statistics
     */
    public function getStats(): JsonResponse
    {
        try {
            $totalMessages = HubungiKami::count();
            $unreadMessages = HubungiKami::unread()->count();
            $readMessages = HubungiKami::read()->count();
            $todayMessages = HubungiKami::whereDate('created_at', today())->count();
            
            return response()->json([
                'success' => 1,
                'data' => [
                    'total' => $totalMessages,
                    'unread' => $unreadMessages,
                    'read' => $readMessages,
                    'today' => $todayMessages
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => 0,
                'messages' => 'Gagal mengambil statistik'
            ]);
        }
    }
}