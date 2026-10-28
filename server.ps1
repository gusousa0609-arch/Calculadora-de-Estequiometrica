# Servidor HTTP Localhost Simulado para o EstequioLab
param(
    [int]$Port = 8080,
    [string]$Root = $PSScriptRoot
)

$listener = New-Object System.Net.HttpListener
$prefix = "http://localhost:$Port/"
$listener.Prefixes.Add($prefix)

try {
    $listener.Start()
} catch {
    # Se a porta 8080 estiver ocupada, tenta 8085
    $Port = 8085
    $listener = New-Object System.Net.HttpListener
    $prefix = "http://localhost:$Port/"
    $listener.Prefixes.Add($prefix)
    $listener.Start()
}

Write-Host "==========================================================" -ForegroundColor Cyan
Write-Host " SERVIDOR LOCALHOST ESTEQUIOLAB ATIVO" -ForegroundColor Green
Write-Host " URL: $prefix" -ForegroundColor Yellow
Write-Host " Diretorio Raiz: $Root" -ForegroundColor Gray
Write-Host " Pressione Ctrl+C para encerrar." -ForegroundColor DarkGray
Write-Host "==========================================================" -ForegroundColor Cyan

while ($listener.IsListening) {
    try {
        $context = $listener.GetContext()
        $request = $context.Request
        $response = $context.Response

        $urlPath = $request.Url.LocalPath.TrimStart('/')

        # Roteamento amigável
        if ([string]::IsNullOrWhiteSpace($urlPath) -or $urlPath -eq "index.php" -or $urlPath -eq "views/index.php") {
            $urlPath = "index.html"
        }

        # Trata requisições para o backend PHP simuladas em JSON
        if ($urlPath -match "^backend/.*\.php$") {
            $jsonResponse = '{"success":true,"message":"Operação processada com sucesso no ambiente Localhost!","logged":true}'
            $bytes = [System.Text.Encoding]::UTF8.GetBytes($jsonResponse)
            $response.ContentType = "application/json; charset=utf-8"
            $response.StatusCode = 200
            $response.ContentLength64 = $bytes.Length
            $response.OutputStream.Write($bytes, 0, $bytes.Length)
            $response.Close()
            continue
        }

        # Mapeia caminho no disco
        $filePath = Join-Path $Root $urlPath.Replace('/', '\')

        if (Test-Path $filePath -PathType Leaf) {
            $bytes = [System.IO.File]::ReadAllBytes($filePath)
            $ext = [System.IO.Path]::GetExtension($filePath).ToLower()
            $mime = switch ($ext) {
                ".html" { "text/html; charset=utf-8" }
                ".htm"  { "text/html; charset=utf-8" }
                ".css"  { "text/css; charset=utf-8" }
                ".js"   { "application/javascript; charset=utf-8" }
                ".json" { "application/json; charset=utf-8" }
                ".png"  { "image/png" }
                ".jpg"  { "image/jpeg" }
                ".svg"  { "image/svg+xml" }
                ".md"   { "text/plain; charset=utf-8" }
                Default { "application/octet-stream" }
            }
            $response.ContentType = $mime
            $response.ContentLength64 = $bytes.Length
            $response.StatusCode = 200
            $response.OutputStream.Write($bytes, 0, $bytes.Length)
        } else {
            # Se for requisição para página PHP nas views, serve index.html
            $fallbackPath = Join-Path $Root "index.html"
            if (Test-Path $fallbackPath) {
                $bytes = [System.IO.File]::ReadAllBytes($fallbackPath)
                $response.ContentType = "text/html; charset=utf-8"
                $response.ContentLength64 = $bytes.Length
                $response.StatusCode = 200
                $response.OutputStream.Write($bytes, 0, $bytes.Length)
            } else {
                $msg = [System.Text.Encoding]::UTF8.GetBytes("404 - Arquivo não encontrado")
                $response.StatusCode = 404
                $response.ContentLength64 = $msg.Length
                $response.OutputStream.Write($msg, 0, $msg.Length)
            }
        }
        $response.Close()
    } catch {
        # Continua o loop sem travar o listener
    }
}
