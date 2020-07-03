<?php
/**
 * Excel service
 * It is a class that containes all functions of excel treatment
 *
 * PHP version 7.2
 *
 * @category service
 * @package  App\Services
 * @author   MHA <moham.hassen@gmail.com>
 * @license  http://localhost/ test
 * @link     http://localhost/
 */

namespace App\Services;

use App\Entity\FinancialMovements;
use App\Entity\Wallet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\PHPExcel_Style_Border;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class ExcelService
 *
 * @category Service
 * @package  App\Services
 * @author   MHA <moham.hassen@gmail.com>
 * @license  http://localhost/ test
 * @link     http://localhost/
 */
class ExcelService
{
    const FIRST_COL = 3;
    const FIRST_ROW = 4;
    private $row = 4;
    private $col = 3;
    /**
     * @var Translator
     */
    private $trans;

    /**
     * ExcelService constructor.
     *
     * @param TranslatorInterface $trans
     */
    public function __construct(TranslatorInterface $trans)
    {
        $this->trans = $trans;
    }

    /**
     * getRow : return the current row position
     *
     * @return int
     */
    public function getRow()
    {
        return $this->row;
    }

    /**
     * getColl : return the current coll position
     *
     * @return int
     */
    public function getColl(): int
    {
        return $this->col;
    }

    /**
     * __incPos : increment col and row
     *
     * @param int $col
     * @param int $row
     */
    private function __incPos(int $row = 1, int $col = 1): void
    {
        $this->col += $col;
        $this->row += $row;
    }

    /**
     * buildSheetHeader : generate excel header sheet
     *
     * @param \Worksheet $sheet
     */
    public function buildSheetHeader(Worksheet $sheet)
    {
        // set header title cell
        $sheet->setCellValueByColumnAndRow($this->col, $this->row, $this->trans->trans('Wallet Id'));
        $this->__incPos(0, 1);
        $sheet->setCellValueByColumnAndRow($this->col, $this->row, $this->trans->trans('Tag'));
        $this->__incPos(0, 1);
        $sheet->setCellValueByColumnAndRow($this->col, $this->row, $this->trans->trans('Date Last Financial Movement'));
        $this->__incPos(0, 1);
        $sheet->setCellValueByColumnAndRow($this->col, $this->row, $this->trans->trans('Currency'));
        $this->__incPos(0, 1);
        $sheet->setCellValueByColumnAndRow($this->col, $this->row, $this->trans->trans('Booking Amount'));
        $sheet->mergeCellsByColumnAndRow($this->col, $this->row, $this->col + 1, $this->row);
        $this->__incPos(0, 2);
        $sheet->setCellValueByColumnAndRow($this->col, $this->row, $this->trans->trans('Value Amount'));
        $sheet->mergeCellsByColumnAndRow($this->col, $this->row, $this->col + 1, $this->row);
        $this->__incPos(0, 2);
        $sheet->setCellValueByColumnAndRow($this->col, $this->row, $this->trans->trans('Nb Of Financial Mouvmemnts'));
        $sheet->mergeCellsByColumnAndRow($this->col, $this->row, $this->col + 4, $this->row);
        $this->col = self::FIRST_COL;
        $sheet->mergeCellsByColumnAndRow($this->col, $this->row, $this->col, $this->row + 1);
        $this->__incPos(0, 1);
        $sheet->mergeCellsByColumnAndRow($this->col, $this->row, $this->col, $this->row + 1);
        $this->__incPos(0, 1);
        $sheet->mergeCellsByColumnAndRow($this->col, $this->row, $this->col, $this->row + 1);
        $this->__incPos(0, 1);
        $sheet->mergeCellsByColumnAndRow($this->col, $this->row, $this->col, $this->row + 1);
        $this->__incPos(0, 1);
        $sheet->setCellValueByColumnAndRow($this->col, $this->row + 1, $this->trans->trans('Real Value'));
        $this->__incPos(0, 1);
        $sheet->setCellValueByColumnAndRow($this->col, $this->row + 1, $this->trans->trans('Converted Value'));
        $this->__incPos(0, 1);
        $sheet->setCellValueByColumnAndRow($this->col, $this->row + 1, $this->trans->trans('Real Value'));
        $this->__incPos(0, 1);
        $sheet->setCellValueByColumnAndRow($this->col, $this->row + 1, $this->trans->trans('Converted Value'));
        $this->__incPos(0, 1);
        $sheet->setCellValueByColumnAndRow($this->col, $this->row + 1, $this->trans->trans('Id'));
        $this->__incPos(0, 1);
        $sheet->setCellValueByColumnAndRow($this->col, $this->row + 1, $this->trans->trans('Booking Date'));
        $this->__incPos(0, 1);
        $sheet->setCellValueByColumnAndRow($this->col, $this->row + 1, $this->trans->trans('Value date'));
        $this->__incPos(0, 1);
        $sheet->setCellValueByColumnAndRow($this->col, $this->row + 1, $this->trans->trans('Amount'));
        $this->__incPos(0, 1);
        $sheet->setCellValueByColumnAndRow($this->col, $this->row + 1, $this->trans->trans('Description'));
        // increment the row possition
        $this->__incPos(2, 0);
        // initialise the col position
        $this->col = self::FIRST_COL;
    }

    /**
     * buildSheetData : generate sheet data
     *
     * @param \Worksheet $sheet
     */
    public function buildSheetData(Worksheet $sheet, array $data): void
    {

        /** @var Wallet $wallet */
        foreach ($data as $wallet) {
            $nb_mouvment = count($wallet->getFinancialMouvements()) - 1;
            if ($nb_mouvment < 0) {
                $nb_mouvment = 0;
            }
            $sheet->setCellValueByColumnAndRow($this->col, $this->row, $wallet->getId())
                ->mergeCellsByColumnAndRow($this->col, $this->row, $this->col, $this->row + $nb_mouvment);
            $this->__incPos(0, 1);
            $sheet->setCellValueByColumnAndRow($this->col, $this->row, $wallet->getTag())
                ->mergeCellsByColumnAndRow($this->col, $this->row, $this->col, $this->row + $nb_mouvment);
            $this->__incPos(0, 1);
            $sheet->setCellValueByColumnAndRow($this->col, $this->row, $wallet->getDateLastFinancialMovement()->format('Y-m-d'))
                ->mergeCellsByColumnAndRow($this->col, $this->row, $this->col, $this->row + $nb_mouvment);
            $this->__incPos(0, 1);
            $sheet->setCellValueByColumnAndRow($this->col, $this->row, $wallet->getCurrency())
                ->mergeCellsByColumnAndRow($this->col, $this->row, $this->col, $this->row + $nb_mouvment);
            $this->__incPos(0, 1);
            $sheet->setCellValueByColumnAndRow($this->col, $this->row, $wallet->getBookingAmount()->getValue())
                ->mergeCellsByColumnAndRow($this->col, $this->row, $this->col, $this->row + $nb_mouvment);
            $this->__incPos(0, 1);
            $sheet->setCellValueByColumnAndRow($this->col, $this->row, $wallet->getBookingAmount()->getUniqValue())
                ->mergeCellsByColumnAndRow($this->col, $this->row, $this->col, $this->row + $nb_mouvment);
            $this->__incPos(0, 1);
            $sheet->setCellValueByColumnAndRow($this->col, $this->row, $wallet->getValueAmount()->getValue())
                ->mergeCellsByColumnAndRow($this->col, $this->row, $this->col, $this->row + $nb_mouvment);
            $this->__incPos(0, 1);
            $sheet->setCellValueByColumnAndRow($this->col, $this->row, $wallet->getValueAmount()->getUniqValue())
                ->mergeCellsByColumnAndRow($this->col, $this->row, $this->col, $this->row + $nb_mouvment);
            $this->__incPos(0, 1);
            $pos = $this->col;
            /**
             * @var FinancialMovements $mouvment
             */
            foreach ($wallet->getFinancialMouvements() as $mouvment) {
                $sheet->setCellValueByColumnAndRow($this->col, $this->row, $mouvment->getId());
                $this->__incPos(0, 1);
                $sheet->setCellValueByColumnAndRow($this->col, $this->row, $mouvment->getBookingDate()->format('Y-m-d'));
                $this->__incPos(0, 1);
                $sheet->setCellValueByColumnAndRow($this->col, $this->row, $mouvment->getValueDate()->format('Y-m-d'));
                $this->__incPos(0, 1);
                $sheet->setCellValueByColumnAndRow(
                    $this->col, $this->row, $mouvment->getAmount()->getValue() .
                    "(" . $mouvment->getAmount()->getCurrency() . ") [" . $mouvment->getAmount()->getUniqValue() . " " . $mouvment->getAmount()->getUniqCurrecy() . "]"
                );
                $this->__incPos(0, 1);
                $sheet->setCellValueByColumnAndRow($this->col, $this->row, $mouvment->getDescription());
                $this->__incPos(0, 1);
                $this->__incPos(1, 0);
                $this->col = $pos;
            }
            if (!count($wallet->getFinancialMouvements())) {
                $this->__incPos(1, 0);
            }
            // initialise the column pos
            $this->col = self::FIRST_COL;
        }

        $last_col = $sheet->getHighestColumn();
        $last_row = $sheet->getHighestDataRow();
        $start = $sheet->getCellByColumnAndRow(self::FIRST_COL, self::FIRST_ROW)->getCoordinate();
        $end = $last_col . $last_row;
        $this->setSheetBorder($sheet, $start, $end);
        $sheet->getStyle($start . ':' . $end)->getAlignment()->applyFromArray(
            array('horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, 'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
        );

        $sheet->setShowGridlines(false);
        $cellIterator = $sheet->getRowIterator()->current()->getCellIterator();
        //$cellIterator->setIterateOnlyExistingCells(true);
        foreach ($cellIterator as $cell) {
            $sheet->getColumnDimension($cell->getColumn())->setAutoSize(true);
            $sheet->getDefaultRowDimension()->setRowHeight(-1);
        }
    }

    /**
     * Apply border style
     *
     * @param Worksheet $sheet excel sheet
     * @param string $startCell the cells coord
     * @param string $endcell end cells coord
     *
     * @return void
     */
    public function setSheetBorder($sheet, $startCell, $endcell)
    {
        // border style
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    'color' => ['argb' => '000000'],
                    'size' => '1px'
                ],
            ],
        ];
        $sheet->getStyle($startCell . ':' . $endcell)->applyFromArray($styleArray);
    }
}
