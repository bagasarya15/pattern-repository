<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Contracts\Debug\ExceptionHandler as ExceptionHandlerContract;

class Handler implements ExceptionHandlerContract
{
    # Fungsi report: Untuk melaporkan error ke sistem logging atau pihak ketiga
    public function report(Throwable $e): void
    {
        // Anda dapat menambahkan log error di sini atau mengirimkannya ke layanan pihak ketiga seperti Sentry atau Bugsnag.
    }

    # Fungsi render: Menangani bagaimana error ditampilkan kepada user
    public function render($request, Throwable $e)
    {
        $statusCode = 500;
        $message = $e->getMessage() ?: 'An error occurred.';

        if ($e instanceof ValidationException) {
            $statusCode = 422;
            $errors = $e->errors();
            return response()->json([
                'status' => $statusCode,
                'errors' => $errors,
                'message' => $message,
            ], $statusCode);
        }

        if ($e instanceof AuthenticationException) {
            return response()->json([
                'status' => 401,
                'message' => $message,
            ], 401);
        }

        if ($e instanceof NotFoundHttpException) {
            $statusCode = 404;
            $message = 'API route not found.';
            return response()->json([
                'status' => $statusCode,
                'message' => $message,
            ], $statusCode);
        }

        if ($e instanceof HttpException) {
            $statusCode = $e->getStatusCode();
            $message = $message;
        }

        # Jika bukan validasi atau pengecualian HTTP lainnya, anggap sebagai error server (500)
        return response()->json([
            'status' => $statusCode, # Status kode
            'message' => $message, # Pesan error
        ], $statusCode);
    }

    # Fungsi shouldReport: Untuk menentukan apakah error harus dilaporkan
    public function shouldReport(Throwable $e): bool
    {
        # Anda dapat memfilter pengecualian yang ingin dilaporkan (misalnya, jangan laporkan error 404)
        return true;
    }

    # Fungsi renderForConsole: Untuk menampilkan pengecualian di konsol (command line)
    public function renderForConsole($output, Throwable $e): void
    {
        # Anda dapat menyesuaikan tampilan error untuk konsol (opsional)
        $output->writeln($e->getMessage());
    }
}
