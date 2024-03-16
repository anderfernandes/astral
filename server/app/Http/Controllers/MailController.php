<?php

namespace App\Http\Controllers;

use App\Mail\Sales\Receipt;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Process;

class MailController extends Controller
{
    public function index(string $item, string $id, string $doc): Response
    {
        $sale = (new \App\Models\Sale())->findOrFail($id);

        if ($sale == null) {
            return response()->noContent(404);
        }

        // Create PDF
        $file = storage_path("/app/{$doc}_{$id}.pdf");

        // Send mail
        Mail::to("handerson171@gmail.com")->send(new Receipt($sale));

        // Delete PDF
        Process::run("rm $file");

        return response()->noContent(200);
    }
}
