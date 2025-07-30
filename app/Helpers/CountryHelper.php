<?php

namespace App\Helpers;

class CountryHelper
{
    /**
     * Map nationality names to ISO 3166-1 alpha-2 country codes
     * for flag display purposes
     */
    public static function getNationalityCountryCode($nationality)
    {
        $nationalityMap = [
            'Afghan' => 'af',
            'Albanian' => 'al',
            'Algerian' => 'dz',
            'American' => 'us',
            'Andorran' => 'ad',
            'Angolan' => 'ao',
            'Antiguan' => 'ag',
            'Argentine' => 'ar',
            'Armenian' => 'am',
            'Australian' => 'au',
            'Austrian' => 'at',
            'Azerbaijani' => 'az',
            'Bahamian' => 'bs',
            'Bahraini' => 'bh',
            'Bangladeshi' => 'bd',
            'Barbadian' => 'bb',
            'Belarusian' => 'by',
            'Belgian' => 'be',
            'Belizean' => 'bz',
            'Beninese' => 'bj',
            'Bhutanese' => 'bt',
            'Bolivian' => 'bo',
            'Bosnian' => 'ba',
            'Botswanan' => 'bw',
            'Brazilian' => 'br',
            'British' => 'gb',
            'Bruneian' => 'bn',
            'Bulgarian' => 'bg',
            'Burkinabe' => 'bf',
            'Burmese' => 'mm',
            'Burundian' => 'bi',
            'Cambodian' => 'kh',
            'Cameroonian' => 'cm',
            'Canadian' => 'ca',
            'Cape Verdean' => 'cv',
            'Central African' => 'cf',
            'Chadian' => 'td',
            'Chilean' => 'cl',
            'Chinese' => 'cn',
            'Colombian' => 'co',
            'Comoran' => 'km',
            'Congolese' => 'cd',
            'Costa Rican' => 'cr',
            'Croatian' => 'hr',
            'Cuban' => 'cu',
            'Cypriot' => 'cy',
            'Czech' => 'cz',
            'Danish' => 'dk',
            'Djiboutian' => 'dj',
            'Dominican' => 'do',
            'Dutch' => 'nl',
            'East Timorese' => 'tl',
            'Ecuadorean' => 'ec',
            'Egyptian' => 'eg',
            'Emirian' => 'ae',
            'Equatorial Guinean' => 'gq',
            'Eritrean' => 'er',
            'Estonian' => 'ee',
            'Ethiopian' => 'et',
            'Fijian' => 'fj',
            'Filipino' => 'ph',
            'Finnish' => 'fi',
            'French' => 'fr',
            'Gabonese' => 'ga',
            'Gambian' => 'gm',
            'Georgian' => 'ge',
            'German' => 'de',
            'Ghanaian' => 'gh',
            'Greek' => 'gr',
            'Grenadian' => 'gd',
            'Guatemalan' => 'gt',
            'Guinea-Bissauan' => 'gw',
            'Guinean' => 'gn',
            'Guyanese' => 'gy',
            'Haitian' => 'ht',
            'Herzegovinian' => 'ba',
            'Honduran' => 'hn',
            'Hungarian' => 'hu',
            'Icelander' => 'is',
            'Indian' => 'in',
            'Indonesian' => 'id',
            'Iranian' => 'ir',
            'Iraqi' => 'iq',
            'Irish' => 'ie',
            'Israeli' => 'il',
            'Italian' => 'it',
            'Ivorian' => 'ci',
            'Jamaican' => 'jm',
            'Japanese' => 'jp',
            'Jordanian' => 'jo',
            'Kazakhstani' => 'kz',
            'Kenyan' => 'ke',
            'Kittian and Nevisian' => 'kn',
            'Kuwaiti' => 'kw',
            'Kyrgyz' => 'kg',
            'Laotian' => 'la',
            'Latvian' => 'lv',
            'Lebanese' => 'lb',
            'Liberian' => 'lr',
            'Libyan' => 'ly',
            'Liechtensteiner' => 'li',
            'Lithuanian' => 'lt',
            'Luxembourgish' => 'lu',
            'Macedonian' => 'mk',
            'Malagasy' => 'mg',
            'Malawian' => 'mw',
            'Malaysian' => 'my',
            'Maldivan' => 'mv',
            'Malian' => 'ml',
            'Maltese' => 'mt',
            'Marshallese' => 'mh',
            'Mauritanian' => 'mr',
            'Mauritian' => 'mu',
            'Mexican' => 'mx',
            'Micronesian' => 'fm',
            'Moldovan' => 'md',
            'Monacan' => 'mc',
            'Mongolian' => 'mn',
            'Moroccan' => 'ma',
            'Mosotho' => 'ls',
            'Motswana' => 'bw',
            'Mozambican' => 'mz',
            'Namibian' => 'na',
            'Nauruan' => 'nr',
            'Nepalese' => 'np',
            'New Zealander' => 'nz',
            'Ni-Vanuatu' => 'vu',
            'Nicaraguan' => 'ni',
            'Nigerian' => 'ng',
            'Nigerien' => 'ne',
            'North Korean' => 'kp',
            'Northern Irish' => 'gb',
            'Norwegian' => 'no',
            'Omani' => 'om',
            'Pakistani' => 'pk',
            'Palauan' => 'pw',
            'Panamanian' => 'pa',
            'Papua New Guinean' => 'pg',
            'Paraguayan' => 'py',
            'Peruvian' => 'pe',
            'Polish' => 'pl',
            'Portuguese' => 'pt',
            'Qatari' => 'qa',
            'Romanian' => 'ro',
            'Russian' => 'ru',
            'Rwandan' => 'rw',
            'Saint Lucian' => 'lc',
            'Salvadoran' => 'sv',
            'Samoan' => 'ws',
            'San Marinese' => 'sm',
            'Sao Tomean' => 'st',
            'Saudi' => 'sa',
            'Scottish' => 'gb',
            'Senegalese' => 'sn',
            'Serbian' => 'rs',
            'Seychellois' => 'sc',
            'Sierra Leonean' => 'sl',
            'Singaporean' => 'sg',
            'Slovakian' => 'sk',
            'Slovenian' => 'si',
            'Solomon Islander' => 'sb',
            'Somali' => 'so',
            'South African' => 'za',
            'South Korean' => 'kr',
            'Spanish' => 'es',
            'Sri Lankan' => 'lk',
            'Sudanese' => 'sd',
            'Surinamese' => 'sr',
            'Swazi' => 'sz',
            'Swedish' => 'se',
            'Swiss' => 'ch',
            'Syrian' => 'sy',
            'Taiwanese' => 'tw',
            'Tajik' => 'tj',
            'Tanzanian' => 'tz',
            'Thai' => 'th',
            'Togolese' => 'tg',
            'Tongan' => 'to',
            'Trinidadian or Tobagonian' => 'tt',
            'Tunisian' => 'tn',
            'Turkish' => 'tr',
            'Tuvaluan' => 'tv',
            'Ugandan' => 'ug',
            'Ukrainian' => 'ua',
            'Uruguayan' => 'uy',
            'Uzbekistani' => 'uz',
            'Venezuelan' => 've',
            'Vietnamese' => 'vn',
            'Welsh' => 'gb',
            'Yemenite' => 'ye',
            'Zambian' => 'zm',
            'Zimbabwean' => 'zw'
        ];

        return $nationalityMap[ucfirst(strtolower($nationality))] ?? 'un'; // UN flag as fallback
    }

    /**
     * Get flag URL from FlagCDN service
     */
    public static function getFlagUrl($nationality, $size = '24')
    {
        $countryCode = self::getNationalityCountryCode($nationality);
        return "https://flagcdn.com/{$size}x{$size}/{$countryCode}.png";
    }

    /**
     * Get flag emoji for the nationality
     */
    public static function getFlagEmoji($nationality)
    {
        $countryCode = strtoupper(self::getNationalityCountryCode($nationality));
        
        if ($countryCode === 'UN') {
            return '🌐'; // Globe emoji for unknown
        }
        
        // Convert country code to flag emoji
        $flagEmoji = '';
        for ($i = 0; $i < strlen($countryCode); $i++) {
            $flagEmoji .= mb_chr(ord($countryCode[$i]) + 127397, 'UTF-8');
        }
        
        return $flagEmoji;
    }
}
