<?php

namespace App\Services;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;


class PoleEmploiServices
{
    private $parameterBag;

    private $bearer = null;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->parameterBag = $parameterBag;
        if ($this->bearer === null) {
            $this->init();
        }
    }

    /**
     * @param string $q
     */
    public function init()
    {
        $curl = curl_init();

        $grant_type = "client_credentials";
        $client_id = $this->parameterBag->get("pole_emploi_id");
        $client_secret = $this->parameterBag->get("pole_emploi_secret");
        $scope = "application_$client_id api_offresdemploiv2 o2dsoffre";

        $postfields = [
            'grant_type' => $grant_type,
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'scope' => $scope
        ];
        $postfields = $this->convertArrayToKeyAndValueUrl($postfields);

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://entreprise.pole-emploi.fr/connexion/oauth2/access_token?realm=partenaire',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $postfields,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded',
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);
        $this->bearer = $response->access_token;
    }

    /**
     * @param $q
     * @return bool|string
     */
    public function get($q)
    {
        $q = str_replace(' ', '-', $q);
        $q = $this->removeAccents($q);
        $url = "https://api.pole-emploi.io/partenaire/offresdemploi/v2/offres/search?codeROME=K1304&commune=74119&distance=500&sort=1&range=0-5";
        $curl = curl_init();
        $opts = [
            CURLOPT_SSL_VERIFYPEER  => false,
            CURLOPT_HTTPHEADER      => array('Authorization: Bearer ' . $this->bearer, 'Content-Type: application/json'),
            CURLOPT_URL             => $url,
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_TIMEOUT         => 30,
            CURLOPT_CONNECTTIMEOUT  => 30,
            CURLOPT_VERBOSE         => 0,
            CURLOPT_HEADER          => 0,
            CURLOPT_CUSTOMREQUEST   => "GET"
        ];
        curl_setopt_array($curl, $opts);
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

    /**
     * @param array $array
     * @return string
     */
    private function convertArrayToKeyAndValueUrl(array $array)
    {
        $array = implode('&', array_map(
            function ($v, $k) { return sprintf("%s=%s", $k, $v); },
            $array,
            array_keys($array)
        ));

        return $array;
    }

    /**
     * @param $str
     * @return string
     */
    private function removeAccents($str)
    {
        return strtr(utf8_decode($str),
            utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'),
            'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY'
        );
    }

}