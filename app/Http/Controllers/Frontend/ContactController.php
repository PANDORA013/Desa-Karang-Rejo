<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function index()
    {
        // Get office information
        $officeInfo = [
            'address' => 'Jl. Raya Karangrejo No. 123, Kecamatan Sukodadi, Kabupaten Lamongan, Jawa Timur 62253',
            'phone' => '(0322) 123456',
            'email' => 'info@desakarangrejo.id',
            'office_hours' => [
                'monday_friday' => 'Senin - Jumat: 08:00 - 16:00 WIB',
                'saturday' => 'Sabtu: 08:00 - 12:00 WIB',
                'sunday' => 'Minggu: Tutup'
            ],
            'emergency_contacts' => [
                'kepala_desa' => '081234567890',
                'sekdes' => '081234567891',
                'babinsa' => '081234567892',
                'bhabinkamtibmas' => '081234567893'
            ]
        ];

        return view('frontend.contact', compact('officeInfo'));
    }

    public function store(Request $request)
    {
        // Rate limiting - max 3 messages per hour per IP
        $key = 'contact-message:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors([
                'rate_limit' => "Terlalu banyak pesan dikirim. Silakan coba lagi dalam {$seconds} detik."
            ])->withInput();
        }

        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20|regex:/^([0-9\s\-\+\(\)]*)$/',
            'subject' => 'required|string|min:5|max:255',
            'message' => 'required|string|min:10|max:2000'
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.min' => 'Nama minimal 2 karakter.',
            'name.max' => 'Nama maksimal 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'phone.regex' => 'Format nomor telepon tidak valid.',
            'subject.required' => 'Subjek wajib diisi.',
            'subject.min' => 'Subjek minimal 5 karakter.',
            'subject.max' => 'Subjek maksimal 255 karakter.',
            'message.required' => 'Pesan wajib diisi.',
            'message.min' => 'Pesan minimal 10 karakter.',
            'message.max' => 'Pesan maksimal 2000 karakter.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Create contact message
            $contactMessage = ContactMessage::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'subject' => $request->subject,
                'message' => $request->message,
                'status' => 'new'
            ]);

            // Hit rate limiter
            RateLimiter::hit($key, 3600); // 1 hour

            // Send notification email to admin (optional)
            try {
                // Mail::to('admin@desakarangrejo.id')->send(new ContactMessageNotification($contactMessage));
            } catch (\Exception $e) {
                // Log email error but don't fail the request
                Log::warning('Failed to send contact notification email: ' . $e->getMessage());
            }

            return redirect()->route('contact.index')
                ->with('success', 'Pesan Anda berhasil dikirim. Terima kasih! Kami akan merespon secepatnya.');

        } catch (\Exception $e) {
            Log::error('Contact message creation failed: ' . $e->getMessage());
            
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat mengirim pesan. Silakan coba lagi.');
        }
    }

    public function getOfficeHours()
    {
        return response()->json([
            'office_hours' => [
                'monday_friday' => 'Senin - Jumat: 08:00 - 16:00 WIB',
                'saturday' => 'Sabtu: 08:00 - 12:00 WIB',
                'sunday' => 'Minggu: Tutup'
            ],
            'current_status' => $this->getCurrentOfficeStatus()
        ]);
    }

    private function getCurrentOfficeStatus()
    {
        $now = now();
        $dayOfWeek = $now->dayOfWeek; // 0 = Sunday, 1 = Monday, etc.
        $hour = $now->hour;

        if ($dayOfWeek == 0) { // Sunday
            return 'Tutup';
        } elseif ($dayOfWeek == 6) { // Saturday
            return ($hour >= 8 && $hour < 12) ? 'Buka' : 'Tutup';
        } else { // Monday - Friday
            return ($hour >= 8 && $hour < 16) ? 'Buka' : 'Tutup';
        }
    }
}