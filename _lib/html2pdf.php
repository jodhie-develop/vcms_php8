<?php
/*
 * Pengganti pustaka lama html2pdf/ (HTML2PDF 4.01 + TCPDF lama, tidak bisa di-load di PHP 8) dengan
 * spipu/html2pdf 5.x yang dipasang lewat Composer (lihat composer.json & DEPLOY.md bagian 8).
 *
 * Halaman lama cukup mengganti baris require-nya:
 *   require_once VCMS_ROOT . '/_lib/html2pdf.php';
 *   $html2pdf = new HTML2PDF('P', 'A4', 'en');        // urutan argumen sama dengan versi 4
 *   $html2pdf->setTestTdInOnePage(false);
 *   $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
 *   $html2pdf->Output($namafile);
 *   ... catch (HTML2PDF_exception $e) { html2pdf_fail($e); }
 *
 * Lokasi autoload Composer: lihat _lib/vendor.php.
 */
defined('VCMS') or exit;

require_once __DIR__ . '/vendor.php';

/** Hentikan halaman dengan pesan umum; detail hanya ke log. */
function html2pdf_fail(Throwable $e): never
{
    vendor_fail($e, 'V-CMS PDF gagal', 'PDF gagal dibuat. Silakan coba lagi atau hubungi administrator.');
}

/** Nama file PDF untuk header: tanpa path & karakter berbahaya, wajib berakhiran .pdf. */
function html2pdf_safe_name(string $name): string
{
    $name = basename(str_replace('\\', '/', $name));
    $name = trim(preg_replace('/[\x00-\x1F\x7F"<>:\/\\\\|?*]+/', '', $name) ?? '');
    if ($name === '' || $name === '.pdf') {
        $name = 'document.pdf';
    }
    return strtolower(substr($name, -4)) === '.pdf' ? $name : $name . '.pdf';
}

vendor_require(\Spipu\Html2Pdf\Html2Pdf::class, 'PDF', 'html2pdf');

/** API HTML2PDF 4.01 di atas spipu/html2pdf 5.x. */
class HTML2PDF extends \Spipu\Html2Pdf\Html2Pdf
{
    /** $vue = true (parameter ?vuehtml lama): tampilkan HTML sumber PDF, seperti versi 4. */
    public function writeHTML($html, $vue = false)
    {
        if ($vue) {
            while (ob_get_level() > 0) {
                ob_end_clean();
            }
            header('Content-Type: text/html; charset=UTF-8');
            echo "<!DOCTYPE html>\n<html><head><meta charset=\"UTF-8\"><title>HTML</title></head>"
                . '<body style="padding: 10px; font-size: 10pt; font-family: Verdana;">' . "\n"
                . $html . "\n</body></html>";
            exit;
        }
        return parent::writeHTML($html);
    }

    /** Versi 4: $dest false = 'I' (tampil di browser), true = 'S' (string). */
    public function Output($name = '', $dest = false)
    {
        $dest = $dest === false || $dest === '' ? 'I' : ($dest === true ? 'S' : $dest);
        return parent::output(html2pdf_safe_name((string) $name), $dest);
    }
}

if (!class_exists('HTML2PDF_exception', false)) {
    class_alias(\Spipu\Html2Pdf\Exception\Html2PdfException::class, 'HTML2PDF_exception');
}
