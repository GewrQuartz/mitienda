<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SupportAttachment;
use App\SupportMessage;
use App\SupportTicket;
use Auth;
use Carbon\Carbon;

class TicketController extends Controller
{

    public function __construct()
    {
        $this->activeTemplate = activeTemplate();
    }


    // Support Ticket
    public function supportTicket()
    {
        if (Auth::id() == null) {
            abort(404);
        }
        $page_title = "Support Tickets";
        $supports = SupportTicket::where('user_id', Auth::id())->latest()->paginate(15);
        return view($this->activeTemplate . 'user.support.index', compact('supports', 'page_title'));
    }


    public function openSupportTicket()
    {
        if (!Auth::user()) {
            abort(404);
        }
        $page_title = "New Ticket";
        $user = Auth::user();
        return view($this->activeTemplate . 'user.support.create', compact('page_title', 'user'));
    }

    public function storeSupportTicket(Request $request)
    {
        $ticket = new SupportTicket();
        $message = new SupportMessage();
        $files = $request->file('attachments');
        $allowedExts = array('jpg', 'png', 'jpeg', 'pdf','doc','docx');
        $this->validate($request, [
            'attachments' => [
                'max:4096',
                function ($attribute, $value, $fail) use ($files, $allowedExts) {
                    foreach ($files as $file) {
                        $ext = strtolower($file->getClientOriginalExtension());
                        if (($file->getSize() / 1000000) > 2) {
                            return $fail("Imágenes ¡MÁXIMO 2 MB PERMITIDO!");
                        }
                        if (!in_array($ext, $allowedExts)) {
                            return $fail("Solo se permiten archivos png, jpg, jpeg, pdf, doc, docx");
                        }
                    }
                    if (count($files) > 5) {
                        return $fail("Se pueden cargar un máximo de 5 archivos");
                    }
                },
            ],
            'name' => 'required|max:191',
            'email' => 'required|email|max:191',
            'subject' => 'required|max:100',
            'message' => 'required',
        ]);
        $ticket->user_id = Auth::id();
        $random = rand(100000, 999999);
        $ticket->ticket = $random;
        $ticket->name = $request->name;
        $ticket->email = $request->email;
        $ticket->subject = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status = 0;
        $ticket->save();
        $message->supportticket_id = $ticket->id;
        $message->message = $request->message;
        $message->save();
        $path = imagePath()['ticket']['path'];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as  $file) {
                try {
                    $attachment = new SupportAttachment();
                    $attachment->support_message_id = $message->id;
                    $attachment->attachment = uploadFile($file, $path);
                    $attachment->save();
                } catch (\Exception $exp) {
                    $notify[] = ['error', 'No se pudo cargar su ' . $file];
                    return back()->withNotify($notify)->withInput();
                }
            }
        }
        $notify[] = ['success', '¡Ticket creado con éxito!'];
        return redirect()->route('ticket')->withNotify($notify);
    }

    public function viewTicket($ticket)
    {
        $page_title = "View Ticket";
        $my_ticket = SupportTicket::where('ticket', $ticket)->latest()->first();
        $messages = SupportMessage::where('supportticket_id', $my_ticket->id)->latest()->get();
        $user = auth()->user();
        return view($this->activeTemplate. 'user.support.view', compact('my_ticket', 'messages', 'page_title', 'user'));

    }

    public function replyTicket(Request $request, $id)
    {
        $ticket = SupportTicket::findOrFail($id);
        $message = new SupportMessage();
        $files = $request->file('attachments');
        if ($request->replayTicket == 1) {

            $allowedExts = array('jpg', 'png', 'jpeg', 'pdf','doc','docx');
            $this->validate($request, [
                'attachments' => [
                    'max:4096',
                    function ($attribute, $value, $fail) use ($files, $allowedExts) {
                        foreach ($files as $file) {
                            $ext = strtolower($file->getClientOriginalExtension());
                            if (($file->getSize() / 1000000) > 2) {
                                return $fail("Imagen MAX  2MB ALLOW!");
                            }
                            if (!in_array($ext, $allowedExts)) {
                                return $fail("Only png, jpg, jpeg, pdf, doc, docx files are allowed");
                            }
                        }
                        if (count($files) > 5) {
                            return $fail("Se pueden cargar un máximo de 5 archivos");
                        }
                    },
                ],
                'message' => 'required',
            ]);

            $ticket->status = 2;
            $ticket->last_reply = Carbon::now();
            $ticket->save();



            $message->supportticket_id = $ticket->id;
            $message->message = $request->message;
            $message->save();

            $path = imagePath()['ticket']['path'];


            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as  $file) {
                    try {
                        $attachment = new SupportAttachment();
                        $attachment->support_message_id = $message->id;
                        $attachment->attachment = uploadFile($file, $path);
                        $attachment->save();
                    } catch (\Exception $exp) {
                        $notify[] = ['error', 'No se pudo cargar su ' . $file];
                        return back()->withNotify($notify)->withInput();
                    }
                }
            }

            $notify[] = ['success', '¡Ticket de soporte respondió con éxito!'];
        } elseif ($request->replayTicket == 2) {
            $ticket->status = 3;
            $ticket->last_reply = Carbon::now();
            $ticket->save();
            $notify[] = ['success', '¡Ticket de soporte cerrado correctamente!'];
        }
        return back()->withNotify($notify);

    }





    public function ticketDownload($ticket_id)
    {
        $attachment = SupportAttachment::findOrFail(decrypt($ticket_id));
        $file = $attachment->attachment;

        $path = imagePath()['ticket']['path'];
        $full_path = $path.'/'. $file;

        $title = str_slug($attachment->supportMessage->ticket->subject);
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        $mimetype = mime_content_type($full_path);


        header('Content-Disposition: attachment; filename="' . $title . '.' . $ext . '";');
        header("Content-Type: " . $mimetype);
        return readfile($full_path);
    }

}
