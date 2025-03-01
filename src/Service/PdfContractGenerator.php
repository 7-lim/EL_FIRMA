<?php



namespace App\Service;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\Location;




class PdfContractGenerator
{
    public function generateContract(Location $location): string
    {
        $dompdf = new Dompdf(new Options(['isHtml5ParserEnabled' => true]));

        $html = $this->generateHtml($location);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $outputPath = 'contracts/contract_' . $location->getId() . '.pdf';
        file_put_contents($outputPath, $dompdf->output());

        return $outputPath;
    }

    private function generateHtml(Location $location): string
    {
        $terrain = $location->getTerrain();
        $owner = $terrain->getAgriculteur();
        $executive = $terrain->getAgriculteur();  // Assuming Utilisateur is assigned to Location

        return "
         <p>Le Preneur Exécutif s'engage à assurer la gestion, l'entretien et l'exploitation durable du terrain loué en conformité avec les lois en vigueur, les réglementations environnementales applicables et les meilleures pratiques agricoles reconnues par les autorités compétentes. Il devra mettre en œuvre des techniques de conservation des sols, maintenir leur fertilité, assurer un système d'irrigation et de drainage adéquat, et prévenir toute dégradation de la productivité du terrain. Le Preneur Exécutif devra également prendre toutes les mesures nécessaires pour éviter l’érosion des sols, la contamination des ressources naturelles et toute détérioration écologique du terrain.

En contrepartie de la jouissance du terrain, le Preneur Exécutif s’engage à verser au Bailleur la somme de [X] euros à titre de redevance de location, payable [modalités de paiement : mensuellement, annuellement, en une seule fois]. Toute violation des obligations susmentionnées, entraînant une détérioration du terrain ou une perte de productivité, pourra donner lieu à des pénalités financières, ainsi qu'à l’obligation pour le Preneur Exécutif de procéder à la remise en état du terrain à ses frais. En cas de manquement grave ou répété, le Bailleur se réserve le droit de résilier le contrat de plein droit et d’exiger une indemnisation proportionnelle aux préjudices subis.</p>

            <h1>Land Lease Agreement</h1>
            <p><strong>Owner:</strong> {$owner->getNom()} {$owner->getPrenom()}</p>
            <p><strong>Executive:</strong> {$executive->getNom()} {$executive->getPrenom()}</p>
            <p><strong>Location:</strong> {$terrain->getLocalisation()}</p>
            <p><strong>Start Date:</strong> {$location->getDateDebut()->format('Y-m-d')}</p>
            <p><strong>End Date:</strong> {$location->getDateFin()->format('Y-m-d')}</p>
            <p><strong>Price:</strong> {$location->getPrixLocation()} EUR</p>
            <h3>Terms and Conditions</h3>
           
            <p><strong>Signatures:</strong></p>
            <p>____________________ (Owner)</p>
            <p>____________________ (Executive)</p>
        ";
    }
}
