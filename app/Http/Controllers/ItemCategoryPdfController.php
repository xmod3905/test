<?php

namespace App\Http\Controllers;

use App\Models\ItemCategory;
use Barryvdh\DomPDF\Facade\Pdf;

class ItemCategoryPdfController extends Controller
{
    public function print($id)
    {
        $category = ItemCategory::with('masterItems')
            ->findOrFail($id);

        $pdf = Pdf::loadView('item_categories.pdf', [
            'category' => $category,
        ]);

        return $pdf->stream(
            'items-' . $category->nama . '.pdf'
        );
    }
}