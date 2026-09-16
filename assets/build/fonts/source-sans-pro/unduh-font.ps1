# Unduh font Source Sans Pro dari Google Fonts ke folder ini. Cukup dijalankan
# SEKALI, di komputer / server yang bisa internet:
#
#   klik kanan file ini > Run with PowerShell
#   atau: powershell -ExecutionPolicy Bypass -File unduh-font.ps1
#
# Setelah 4 file .woff2 ada di folder ini, halaman otomatis memakainya
# (header.php mengecek sendiri). Tidak perlu ubah kode apa pun.

$ErrorActionPreference = 'Stop'
$dir = $PSScriptRoot
$ua  = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'

$faces = @(
  @{ nama = 'source-sans-pro-300';       css = 'https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300' },
  @{ nama = 'source-sans-pro-400';       css = 'https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400' },
  @{ nama = 'source-sans-pro-400italic'; css = 'https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@1,400' },
  @{ nama = 'source-sans-pro-700';       css = 'https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@700' }
)

foreach ($f in $faces) {
  try {
    $css = (Invoke-WebRequest -Uri $f.css -UserAgent $ua -UseBasicParsing).Content
    # Blok subset "latin" ada paling bawah di CSS Google Fonts.
    $urls = [regex]::Matches($css, 'url\((https://[^)]+\.woff2)\)') | ForEach-Object { $_.Groups[1].Value }
    if ($urls.Count -eq 0) { throw 'URL font tidak ketemu di CSS Google Fonts.' }
    $tujuan = Join-Path $dir ($f.nama + '.woff2')
    Invoke-WebRequest -Uri $urls[$urls.Count - 1] -UserAgent $ua -UseBasicParsing -OutFile $tujuan
    Write-Host ("OK    " + $f.nama + ".woff2  (" + [math]::Round((Get-Item $tujuan).Length / 1KB) + " KB)")
  } catch {
    Write-Host ("GAGAL " + $f.nama + " : " + $_.Exception.Message) -ForegroundColor Red
  }
}

Write-Host ''
Write-Host 'Selesai. Isi folder:'
Get-ChildItem $dir -Filter *.woff2 | Format-Table Name, Length -AutoSize
