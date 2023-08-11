<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class contactForm extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $name;
    protected $email;
    protected $mobile_number;
    protected $company_number;
    protected $address;
    protected $requirments;
    protected $guarded = [];
    
    
    public function __construct($name, $email,$mobile_number, $company_number, $address, $requirments)
    {
        $this->name = $name;
        $this->email = $email;
        $this->mobile_number = $mobile_number;
        $this->company_number = $company_number;
        $this->address = $address;
        $this->requirements = $requirments;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Contact Form Details',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'contactForm',
            with: [
                'name'=>$this->name,
                'email'=>$this->email,
                'mobile_number'=>$this->mobile_number,
                'company_number'=>$this->company_number,
                'address'=>$this->address,
                'requirements'=>$this->requirements,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}