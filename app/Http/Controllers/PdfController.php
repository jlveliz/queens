<?php

namespace App\Http\Controllers;

use App\RepositoryInterface\EventRepositoryInterface;
use Illuminate\Http\Request;
use App\Score;
use  PDF;

class PdfController extends Controller
{
    protected $event;

    function __construct(EventRepositoryInterface $event)
    {
    	$this->event = $event;
    }

    public function print($type)
    {
    	$viewName = "";
    	$data = null;
    	$streamName = "";
    	$orientation = "portrait";
    	$events = $this->event->getActives();
    	switch ($type) {
    		case 'full':
    			$viewName = "admin.pdf.fullscore";
    			$data = Score::getFullScore();
    			$streamName = "Resultado General";
    			$orientation = "landscape";
    			break;
    		case 'finalist':
    			$viewName = "admin.pdf.finalist";
    			$data = Score::getScore(null,'finalist');
    			$streamName = "3 Finalistas";
    			$orientation = "landscape";
    			break;
    		case 'semifinalist':
    			$viewName = "admin.pdf.semifinalist";
    			$data = Score::getScore(null,'semifinalist');
    			$streamName = "5 Semifinalistas";
    			$orientation = "landscape";
    			break;
    		default:
    			break;
    	}
    	// dd($streamName);
    	$view = view()->make($viewName,compact('data','events','streamName'))->render();
    	$pdf = app()->make('dompdf.wrapper');
        $pdf->loadHtml($view)->setPaper('a4', $orientation);
        return $pdf->stream($streamName);
    }
}
