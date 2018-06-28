<?php

namespace App\Helper;

/**
 * Created by PhpStorm.
 * User: pkasztelan
 * Date: 26.06.2018
 * Time: 09:51
 */
class MicrosoftSpeechAPI
{

    protected $subscriptionKey;
    protected $filename;
    protected $output_format = "simple";
    protected $language = "en-US";
    protected $locale = "en-US";
    protected $recognition_mode = "interactive";

    protected $_tokenUrl = 'https://api.cognitive.microsoft.com/sts/v1.0/issueToken';
    protected $_fileUrl = 'https://speech.platform.bing.com/speech/recognition/%recognition_mode%/cognitiveservices/v1?language=%language%&format=%output_format%';
    protected $_token;

    /**
     * MicrosoftSpeechAPI constructor.
     * Set default value for variable and get filename from storage/app
     * @param null $filename
     */
    public function __construct($filename = null)
    {
        $this->subscriptionKey = env('AZURE_SUBSCRIPTION_KEY', null);
        $this->output_format = env('AZURE_OUTPUT_FORMAT', 'simple');
        $this->language = env('AZURE_LANGUAGE', 'en-US');
        $this->locale = env('AZURE_LOCALE', 'en-US');
        $this->recognition_mode = env('AZURE_RECOGNITION_MODE', 'interactive');
        $this->filename = $filename;
        $this->_result = null;
    }

    /**
     * Execute query
     * @return null
     */
    public function execute()
    {
        $this->getToken();
        $this->sendFile();

        return $this->_result;
    }

    /**
     * Generates a token for the query
     * @url https://docs.microsoft.com/pl-pl/azure/cognitive-services/speech/how-to/how-to-authentication?tabs=Powershell#use-an-authorization-token
     * @return mixed
     */
    public function getToken()
    {
        $s = curl_init();

        curl_setopt($s, CURLOPT_VERBOSE, true);

        $verbose = fopen('php://temp', 'w+');
        curl_setopt($s, CURLOPT_STDERR, $verbose);

        curl_setopt($s, CURLOPT_URL, $this->_tokenUrl);
        curl_setopt($s, CURLOPT_POST, true);
        curl_setopt($s, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($s, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($s, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($s, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded',
            'Content-Length: 0',
            'Ocp-Apim-Subscription-Key: ' . $this->subscriptionKey
        ]);

        $result = curl_exec($s);
        curl_close($s);

        if ($result === false) {
            printf("cUrl error (#%d): %s<br>\n", curl_errno($s), htmlspecialchars(curl_error($s)));
        } else {
            $this->_token = $result;
            return $this->_token;
        }

    }

    /**
     * Sends wav the file to the Azure Speech API
     * @url https://docs.microsoft.com/pl-pl/azure/cognitive-services/speech/how-to/how-to-chunked-transfer
     * @return mixed|null
     */
    public function sendFile()
    {
        $s = curl_init();

        curl_setopt($s, CURLOPT_VERBOSE, true);

        $verbose = fopen('php://temp', 'w+');
        curl_setopt($s, CURLOPT_STDERR, $verbose);

        curl_setopt($s, CURLOPT_URL, $this->generateUrl());
        curl_setopt($s, CURLOPT_POST, true);
        curl_setopt($s, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($s, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($s, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($s, CURLOPT_POSTFIELDS, file_get_contents(storage_path('app/' . $this->filename)));
        curl_setopt($s, CURLOPT_HTTPHEADER, [
            'Transfer-Encoding: chunked',
            'Content-type: audio/wav; codec="audio/pcm";',
            'Authorization: Bearer ' . $this->_token
        ]);

        $result = curl_exec($s);
        curl_close($s);

        if ($result === false) {
            printf("cUrl error (#%d): %s<br>\n", curl_errno($s), htmlspecialchars(curl_error($s)));
        } else {
            $this->_result = $result;
            return $this->_result;
        }
    }

    /**
     * Replace variables from the url to variables stored in the configuration
     * @return string
     */
    public function generateUrl() : string
    {
        $this->_fileUrl = str_replace("%recognition_mode%", $this->recognition_mode, $this->_fileUrl);
        $this->_fileUrl = str_replace("%language%", $this->language, $this->_fileUrl);
        $this->_fileUrl = str_replace("%locale%", $this->locale, $this->_fileUrl);
        $this->_fileUrl = str_replace("%output_format%", $this->output_format, $this->_fileUrl);

        return $this->_fileUrl;
    }

    /**
     * Gets response
     * @return null
     */
    public function getResponse()
    {
        return $this->_result;
    }




    /**
     * Get Filename
     * @return string
     */
    public function getFilename() : string
    {
        return $this->filename;
    }

    /**
     * @param string $value
     */
    public function setFilename(string $value)
    {
        $this->filename = $value;
    }

    /**
     * Get Output Format simple / detailed
     * @url https://docs.microsoft.com/pl-pl/azure/cognitive-services/speech/concepts#output-format
     * @return string
     */
    public function getOutputFormat(): string
    {
        return $this->output_format;
    }

    /**
     * Set Output Format simple / detailed
     * @url https://docs.microsoft.com/pl-pl/azure/cognitive-services/speech/concepts#output-format
     * @param string $value
     */
    public function setOutputFormat(string $value)
    {
        if ($value = 'simple' || $value = 'detailed') {
            $this->output_format = $value;
        } else {
            $this->output_format = 'simple';
        }

    }

    /**
    protected $recognition_mode = "interactive";
     */

    /**
     * Get language
     * @url https://docs.microsoft.com/pl-pl/azure/cognitive-services/speech/api-reference-rest/supportedlanguages
     * @return string
     */
    public function getLanguage() : string
    {
        return $this->language;
    }

    /**
     * Set language
     * @url https://docs.microsoft.com/pl-pl/azure/cognitive-services/speech/api-reference-rest/supportedlanguages
     * @param string $value
     */
    public function setLanguage(string $value)
    {
        $this->language = $value;
    }

    /**
     * Get locale
     * @return string
     */
    public function getLocale() : string
    {
        return $this->locale;
    }

    /**
     * Set locale
     * @param string $value
     */
    public function setLocale(string $value)
    {
        $this->locale = $value;
    }

    /**
     * Get recognition_mode
     * @url https://docs.microsoft.com/pl-pl/azure/cognitive-services/speech/concepts#recognition-modes
     * @return string
     */
    public function getRecognitionMode() : string
    {
        return $this->recognition_mode;
    }

    /**
     * Set recognition_mode
     * @url https://docs.microsoft.com/pl-pl/azure/cognitive-services/speech/concepts#recognition-modes
     * @param string $value
     */
    public function setRecognitionMode(string $value)
    {
        $this->recognition_mode = $value;
    }
}