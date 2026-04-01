<?php

namespace App\Livewire;

use App\Models\Contact;
use App\Mail\ContactFormMail;
use App\Settings\GeneralSettings;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class ContactForm extends Component
{
    public $name;
    public $email;
    public $message;
    public $success = false; // Status untuk menampilkan pesan sukses

    // Aturan validasi
    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email',
        'message' => 'required|min:10',
    ];

    public function submit(GeneralSettings $settings)
    {
        // Jalankan validasi
        $this->validate();

        // 1. Simpan ke Database
        $contact = Contact::create([
            'name' => $this->name,
            'email' => $this->email,
            'message' => $this->message,
        ]);

        // 2. Kirim Notifikasi Email (Hanya jika email admin diisi di Settings)
        if ($settings->email) {
            try {
                Mail::to($settings->email)->send(new ContactFormMail($contact));
            } catch (\Exception $e) {
                // Log error jika gagal kirim email
                Log::error('Gagal kirim email contact form: ' . $e->getMessage());
            }
        }

        // Reset form & tampilkan notifikasi sukses
        $this->reset(['name', 'email', 'message']);
        $this->success = true;
    }

    // METHOD BARU: Untuk tombol "SEND_NEW_MESSAGE"
    public function resetForm()
    {
        $this->success = false;
        $this->reset(['name', 'email', 'message']);
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}