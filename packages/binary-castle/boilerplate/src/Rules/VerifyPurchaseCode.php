<?php

namespace BinaryCastle\Boilerplate\Rules;

use BinaryCastle\Boilerplate\Static\Installer;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class VerifyPurchaseCode implements Rule
{

    private $message = 'Purchase Code Verification Failed';

    /**
     * @inheritDoc
     */
    public function passes($attribute, $value)
    {
        $domain = request()->getSchemeAndHttpHost();

        $response = Http::withHeaders([
            'PurchaseVerify' => 'Internal'
        ])->post("{$this->binaryCastleUrl}/verify-purchase/", [
            'code' => $value,
            'domain' => $domain,
            'project_name' => config('boilerplate.project_name')
        ]);

        if ($response->successful()) {
            $fileName = Installer::$VERIFY_FILE_NAME;
            $fileContent = "$value";
            Storage::disk('local')->put($fileName, $fileContent);
            return true;
        } else {
            if (Arr::has($response->json(), 'message')) {
                $this->message = Arr::get($response->json(), 'message');
            }
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function message(): array|string
    {
        return $this->message;
    }

    private $binaryCastleUrl = 'https://erp.binarycastle.net/purchase-verifier';
}
