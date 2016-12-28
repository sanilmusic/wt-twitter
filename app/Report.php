<?php

namespace App;

use App\Models\Poruka;
use App\Models\Korisnik;

require PATH . '/vendor/fpdf181/fpdf.php';

class Report extends \FPDF
{
    const DPI = 96;
    const LOGO_WIDTH = 173;
    const FONT_FACE = 'Helvetica';
    const TABLE_COLUMNS = [145, 40];
    const CELL_HEIGHT = 7;
    const DT_FORMAT = 'j/n/Y H:i:s';

    /**
     * Fills in the available data.
     *
     * @return void
     */
    public function Generate()
    {
        // Create our initial page
        $this->AddPage();

        $this->Desc();
        $this->Stats();
        $this->Users();

        return $this;
    }

    /**
     * Generates the header of the document.
     *
     * @return void
     */
    protected function Desc()
    {
        $leftPos = ($this->getPageWidth() - $this->Px2mm(self::LOGO_WIDTH)) / 2;
        $this->image(PATH . '/images/logo.png', $leftPos, $this->GetIncreaseY(70));

        $this->Hr();

        $this->SetFont(self::FONT_FACE, null, 10);
        $this->Text(2, $this->GetIncreaseY(20), 'Generisano ' . date(self::DT_FORMAT));
    }

    /**
     * Include statistics in the document.
     *
     * @return void
     */
    protected function Stats()
    {
        $this->SetFont(self::FONT_FACE, 'B', 10);
        $this->Text(2, $this->GetIncreaseY(20), 'Broj korisnika: ' . Korisnik::broj());
        $this->Text(2, $this->GetIncreaseY(12), 'Broj poruka: ' . Poruka::broj());
        $this->Hr();
    }

    /**
     * Includes all users and messages they left in the document.
     *
     * @return void
     */
    protected function Users()
    {
        $users = Korisnik::sve();
        $count = count($users);

        for ($i = 0; $i < $count; $i++) {
            $this->User($users[$i]);

            if ($i < $count - 1) {
                $this->AddPage();
            }
        }
    }

    /**
     * Includes a single user and their messages in the document.
     * 
     * @param \App\Korisnik $user
     */
    protected function User(Korisnik $user)
    {
        $this->SetFont(self::FONT_FACE, 'B', 14);
        $this->Text(2, $this->GetIncreaseY(10), $user->dajPunoIme() . ' (' . $user->email . ')');

        // Table header
        $this->SetX(2);
        $this->SetY($this->GetIncreaseY(50));
        $this->SetFont(self::FONT_FACE, 'B', 10);
        $this->Row('Tekst', 'Datum');
        $this->SetFont(self::FONT_FACE, null, 10);

        $messages = $user->dajPoruke();
        foreach ($messages as $message) {
            $this->Row($message->tekst, date(self::DT_FORMAT, $message->kad));
        }
    }

    /**
     * Generate a table row, where first column is of MultiCell type and
     * second is a Cell.
     * 
     * @param string $first
     * @param string $second
     */
    protected function Row($first, $second)
    {
        $oldX = $this->GetX();
        $oldY = $this->GetY();

        $this->MultiCell(self::TABLE_COLUMNS[0], self::CELL_HEIGHT, $first, 1);

        $newY = $this->GetY();

        $this->SetXY($oldX + self::TABLE_COLUMNS[0], $oldY);
        $this->Cell(self::TABLE_COLUMNS[1], ($newY - $oldY), $second, 1, 1);

        $this->SetY($newY);
    }

    /**
     * Convert pixels to millimeters.
     * 
     * @param  int $pixels
     * @return float
     */
    protected function Px2mm($pixels)
    {
        return ($pixels * 25.4) / self::DPI;
    }

    /**
     * Increase current value of ordinate by defined value.
     * @param float $increaseBy
     * @param bool $convertFromPixels
     */
    protected function IncreaseY($increaseBy, $convertFromPixels = true)
    {
        if ($convertFromPixels) {
            $increaseBy = $this->Px2mm($increaseBy);
        }

        $this->SetY($this->GetY() + $increaseBy);
    }

    /**
     * Get the current value of Y while increasing it by defined value.
     * 
     * @param  float $increaseBy
     * @param  bool $convertFromPixels
     * @return float
     */
    protected function GetIncreaseY($increaseBy, $convertFromPixels = true)
    {
        $currentY = $this->GetY();

        $this->IncreaseY($increaseBy, $convertFromPixels);

        return $currentY;
    }

    /**
     * Draw a horizontal line at the current ordinate.
     * 
     * @return void
     */
    protected function Hr()
    {
        $lineY = $this->GetIncreaseY(20);
        $endPos = $this->getPageWidth() - 1;

        $this->Line(1, $lineY, $endPos, $lineY);
    }
}