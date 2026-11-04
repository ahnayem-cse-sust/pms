<?php

namespace App\Support;

/**
 * PDFs that contain Bangla text. DomPDF cannot join Bangla letters (conjuncts, vowel signs), so these are made with mPDF
 * (composer require mpdf/mpdf) and the Kalpurush font in resources/fonts.
 */
class BanglaPdf
{
    public static function available(): bool
    {
        return class_exists(\Mpdf\Mpdf::class);
    }

    /** @return string the PDF file contents */
    public static function render(string $html, string $footerHtml = '', array $config = []): string
    {
        $tmp = storage_path('app/mpdf');
        if (! is_dir($tmp)) @mkdir($tmp, 0775, true);

        // mPDF's font reader raises PHP notices / warnings (e.g. "Undefined array key" on glyphs without a Unicode value) that
        // Laravel turns into exceptions. They are harmless to the output, so inside mPDF's own files they are ignored here.
        $previous = null;
        $previous = set_error_handler(function ($no, $str, $file, $line) use (&$previous) {
            if (str_contains(str_replace('\\', '/', (string) $file), '/mpdf/mpdf/')) return true;

            return $previous ? $previous($no, $str, $file, $line) : false;
        });
        try {
            $fonts = (new \Mpdf\Config\FontVariables())->getDefaults()['fontdata'];
            $mpdf = new \Mpdf\Mpdf($config + [
                'mode' => 'utf-8', 'format' => 'A4', 'tempDir' => $tmp,
                'margin_left' => 12, 'margin_right' => 12, 'margin_top' => 8, 'margin_bottom' => 12, 'margin_footer' => 5,
                'fontDir' => array_merge((new \Mpdf\Config\ConfigVariables())->getDefaults()['fontDir'], [resource_path('fonts')]),
                'fontdata' => $fonts + ['kalpurush' => ['R' => 'kalpurush.ttf', 'useOTL' => 0xFF]],
                'default_font' => 'kalpurush',
                'useSubstitutions' => true, 'backupSubsFont' => ['dejavusans'],   // Latin names / symbols the Bangla font lacks
            ]);
            if ($footerHtml !== '') $mpdf->SetHTMLFooter($footerHtml);
            $mpdf->WriteHTML($html);

            return $mpdf->Output('', 'S');
        } finally {
            restore_error_handler();
        }
    }
}
