<?php

namespace App\Services;

use App\Entity\Ticket;
use BaconQrCode\Writer;
use Endroid\QrCode\Builder\BuilderInterface;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\LabelAlignment;
use Endroid\QrCode\Label\Font\OpenSans;
use Endroid\QrCode\RoundBlockSizeMode;
use function Symfony\Component\Clock\now;

class QrCodeGenerator {

/** 
    *@var BuilderInterface 
 */
    private $builder;

    public function __construct(BuilderInterface $builder) {
        $this->builder = $builder;
    }

    public function generate(Ticket $ticket): string {

        $path = 'C:/Users/Oumayma/ELFIRMA-1/public/assets/img/logoelfirma.png';
        $date = new \DateTime('now');
        $datestring = $date->format('d-m-Y ');

        $builder = new Builder(
            writer: new PngWriter(),
            writerOptions: [],
            validateResult: false,
            data: $path.$ticket->getId(),
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::High,
            size: 300,
            margin: 10,
            roundBlockSizeMode: RoundBlockSizeMode::Margin,
            logoPath: $path,
            logoResizeToWidth: 50,
            logoPunchoutBackground: true,
            labelText: 'Voici  votre ticket crée avec succés. \n'.$datestring,
            labelFont: new OpenSans(20),
            labelAlignment: LabelAlignment::Center
        );

        $namePng = $ticket->getId().'.png';
        $result = $builder->build();
        $qrcodePath = 'C:/Users/Oumayma/ELFIRMA-1/public/assets/QrCode/'.$namePng;
        $result->saveToFile($qrcodePath);

        return $qrcodePath;
      

        
    }




}

