<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* =====================================================================
   KEMBALI KE HALAMAN TERAKHIR SESUDAH SESI HABIS (seperti ap_dev)

   Dulu: sesi habis -> redirect('auth') -> login -> selalu ke Dashboard.
   Sekarang redirect('auth') dari halaman biasa membawa alamat halaman itu
   (?next=arnag/xxx), dan Auth mengembalikan pemakai ke sana sesudah login.

   Dipasang di SATU tempat ini (CodeIgniter memuat MY_url_helper lebih dulu
   dari url_helper bawaan), jadi +-125 pemanggilan redirect('auth') di
   controller tidak perlu diubah satu per satu.
   ===================================================================== */

/**
 * Bersihkan nilai next: hanya alamat DI DALAM aplikasi ini (mis. "arnag/create_invoice"
 * atau "report/x?a=1"). Alamat luar, "//", "..", dan halaman login/logout ditolak -> ''.
 */
function auth_next_aman($next)
{
    $next = trim((string) $next);
    if (preg_match('#^[/\\\\]{2}#', $next)) {   // "//situs-lain" = alamat luar -> tolak
        return '';
    }
    $next = ltrim($next, '/');
    if ($next === '' || strlen($next) > 500) {
        return '';
    }
    if (!preg_match('#^[A-Za-z0-9_\-/.]+(\?[A-Za-z0-9_\-=&%.+/]*)?$#', $next)) {
        return '';
    }
    if (strpos($next, '//') !== false || strpos($next, '..') !== false) {
        return '';
    }
    if (preg_match('#^auth(/|\?|$)#i', $next)) {
        return '';
    }
    return $next;
}

if (!function_exists('redirect')) {
    /**
     * Sama dengan redirect() bawaan CodeIgniter (system/helpers/url_helper.php),
     * ditambah: redirect('auth') saat membuka halaman biasa -> bawa ?next=.
     * Tidak untuk AJAX atau kiriman form (POST), karena itu bukan "halaman" yang bisa dibuka ulang.
     */
    function redirect($uri = '', $method = 'auto', $code = NULL)
    {
        if ($uri === 'auth'
            && isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'GET'
            && strtolower(isset($_SERVER['HTTP_X_REQUESTED_WITH']) ? $_SERVER['HTTP_X_REQUESTED_WITH'] : '') !== 'xmlhttprequest')
        {
            $CI =& get_instance();
            $sekarang = $CI->uri->uri_string();
            if (!empty($_SERVER['QUERY_STRING'])) {
                $sekarang .= '?' . $_SERVER['QUERY_STRING'];
            }
            $sekarang = auth_next_aman($sekarang);
            if ($sekarang !== '') {
                $uri = 'auth?next=' . rawurlencode($sekarang);
            }
        }

        // --- di bawah ini SALINAN redirect() bawaan CodeIgniter 3 ---
        if ( ! preg_match('#^(\w+:)?//#i', $uri))
        {
            $uri = site_url($uri);
        }

        // IIS environment likely? Use 'refresh' for better compatibility
        if ($method === 'auto' && isset($_SERVER['SERVER_SOFTWARE']) && strpos($_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS') !== FALSE)
        {
            $method = 'refresh';
        }
        elseif ($method !== 'refresh' && (empty($code) OR ! is_numeric($code)))
        {
            if (isset($_SERVER['SERVER_PROTOCOL'], $_SERVER['REQUEST_METHOD']) && $_SERVER['SERVER_PROTOCOL'] === 'HTTP/1.1')
            {
                $code = ($_SERVER['REQUEST_METHOD'] !== 'GET')
                    ? 303	// reference: http://en.wikipedia.org/wiki/Post/Redirect/Get
                    : 307;
            }
            else
            {
                $code = 302;
            }
        }

        switch ($method)
        {
            case 'refresh':
                header('Refresh:0;url='.$uri);
                break;
            default:
                header('Location: '.$uri, TRUE, $code);
                break;
        }
        exit;
    }
}
