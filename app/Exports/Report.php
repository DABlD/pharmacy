<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\{FromView, ShouldAutoSize};
use DOMDocument;

class Report implements FromView, ShouldAutoSize
{
    public function __construct($headers, $title, $data){
        $this->headers = $headers;
        $this->title = $title;
        $this->data = $data;
    }

    public function view(): View
    {
        return view('reports.exports.report', [
            'headers' => $this->headers,
            'title' => $this->title,
            'datas' => $this->data,
        ]);
    }
}