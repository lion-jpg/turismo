<?php

namespace App\Services;

use TCPDF;

class PdfService
{
    public function generateUserPdf($userData, $userId)
    {   
        // Create new PDF document
        $pdf = new TCPDF('P', 'mm', array(215, 355), true, 'UTF-8', false);
        
        // Set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Your Company');
        $pdf->SetTitle('Credencial');
        $pdf->SetSubject('User PDF');
       
        // Add a page
        $pdf->AddPage();

        // Set font tipo, fuente, 
        $pdf->SetFont('helvetica', '', 8);
        
        // Add background image
        $backgroundImagePath = public_path('storage/creden.jpg'); // Path to your background image file
        $pdf->Image($backgroundImagePath, 30, 60, 160, 52, 'JPG', '', '', true, 300, '', false, false, 0, false, false, false);

        // Agregar texto sobre la imagen de fondo
        $pdf->SetXY(57, 75); // Posición inicial del texto
        $pdf->Cell(0, 10, 'Nombre: ' . htmlspecialchars($userData['nombre']) . ' ' . htmlspecialchars($userData['apellidos']));

        $pdf->SetXY(57, 80); // Nueva posición para el siguiente elemento
        $pdf->Cell(0, 10, 'Teléfono: ' . htmlspecialchars($userData['telefono']));

        $pdf->SetXY(57, 85); // Nueva posición para el siguiente elemento
        $pdf->Cell(0, 10, 'Categoría: ' . htmlspecialchars($userData['descripcion']));

        $pdf->SetXY(57, 90); // Nueva posición para el siguiente elemento
        $pdf->Cell(0, 10, 'Género: ' . htmlspecialchars($userData['genero']));
        

         // Add the user's image to PDF
         if (isset($userData['foto_guia']['data'][0]['attributes']['url'])) {
            $imageUrl = 'https://backend-culturas.elalto.gob.bo' . $userData['foto_guia']['data'][0]['attributes']['url'];

            // Download the image using cURL
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $imageUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disabling SSL verification for development

            $imageData = curl_exec($ch);
            curl_close($ch);

            if ($imageData) {
                $pdf->Image('@' . $imageData, '34', '77',22, 27, 'JPG', '', 'T', true, 300, '', false, false, 0, false, false, false);
            }
        }

        // Add QR code with user ID
        // $userId = htmlspecialchars($id['id']?? 'ID no disponible');
        $url = 'http://localhost:8080/guia2/'. $userId;
        $pdf->write2DBarcode($url, 'QRCODE,H', 90, 70, 15, 15, array(), 'N');

        // Close and output PDF document
        return $pdf->Output('credencial.pdf', 'S'); // 'S' means return the document as a string
    }
}
