<?php

namespace App\Mail;
use App\Models\Company;
use App\Models\Permission;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvitationEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $email;
    public $phone;
    public $company;
    public $permission;
    public $url;
    public $url2;
    /**
     * Create a new message instance.
     */
    public function __construct($name,$email,$phone,$company,$permission,$url,$url2)
    {
        //
       // dd($permission);
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->company = $company;
        $this->permission = $permission;

        $this->url = $url;
        $this->url2 = $url2;
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invitation Email',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $company_name = Company::where('id',$this->company)->value('company_name');
      
        $permissions = Permission::whereIn('id', $this->permission)->pluck('name');
         
        return new Content(
            view: 'email.invitation',
            with:['company_name'=> $company_name,'permissions' => $permissions],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
