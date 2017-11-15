<?php

namespace Awssat\numberedStringOrder;

class numberedStringOrder
{
    public function getNumbers($array)
    {
        return $this->compile($array);
    }

    public function sort($array)
    {
        $result = $this->compile($array);

        asort($result);
        return array_keys($result);
    }

    private function str2int($str)
    {
        // Normalization phase
        $str = str_replace(['أ', 'إ', 'آ'], 'ا', $str);
        $str = str_replace('ه', '', $str);
        $str = str_replace('ة', '', $str);
        $str = preg_replace('/\s+/', ' ', $str);
        $str = str_replace(['ـ', 'َ', 'ً', 'ُ', 'ٌ', 'ِ', 'ٍ', 'ْ', 'ّ'], '', $str);
        $str = str_replace('مائة', 'مئة', $str);
        $str = str_replace(['احدى', 'احد'], 'واحد', $str);
        $str = str_replace(['اثنا', 'اثني', 'اثنتا', 'اثنتي'], 'اثنان', $str);
        $str = trim($str);


        $spell = [
            'واحد' => 1,
            'واحدة' => 1,
            'اثنان' => 2,
            'اولى' => 1,
            'ثاني' => 2,
            'ثالث' => 4,
            'خامس' => 5,
            'سادس' => 6,
            'سابع' => 7,
            'ثامن' => 8,
            'تاسع' => 9,
            'عاشر' => 10,
            'اثنين' => 2,
            'اثنتان' => 2,
            'اثنتين' => 2,
            'ثلاث' => 3,
            'اربع' => 4,
            'خمس' => 5,
            'ست' => 6,
            'سبع' => 7,
            'ثماني' => 8,
            'تسع' => 9,
            'عشر' => 10,
            'ثلاثة' => 3,
            'اربعة' => 4,
            'خمسة' => 5,
            'ستة' => 6,
            'سبعة' => 7,
            'ثمانية' => 8,
            'تسعة' => 9,
            'عشرة' => 10,
            'عشرون' => 20,
            'ثلاثون' => 30,
            'اربعون' => 40,
            'خمسون' => 50,
            'ستون' => 60,
            'سبعون' => 70,
            'ثمانون' => 80,
            'تسعون' => 90,
            'عشرين' => 20,
            'ثلاثين' => 30,
            'اربعين' => 40,
            'خمسين' => 50,
            'ستين' => 60,
            'سبعين' => 70,
            'ثمانين' => 80,
            'تسعين' => 90,
            'مئتان' => 200,
            'مئتين' => 200,
            'مئة' => 100,
            'ثلاثمئة' => 300,
            'اربعمئة' => 400,
            'خمسمئة' => 500,
            'ستمئة' => 600,
            'سبعمئة' => 700,
            'ثمانمئة' => 800,
            'تسعمئة' => 900,
        ];

        // Individual process
        $total = 0;
        $str = " $str ";
        foreach ($spell as $word => $value) {
            if (strpos($str, "$word ") !== false) {
                $str = str_replace("$word ", ' ', $str);
                $total += $value;
            }
        }

        return $total;
    }

    private function split_numbers($term)
    {
        $text = '';
        $splits = preg_split("~(\d+)~", $term, -1, PREG_SPLIT_DELIM_CAPTURE);
        foreach ($splits as $split) {
            $text .= ' ' . $split;
        }

        return $text;
    }

    private function normalize_text($text)
    {
        $text = $this->arabic101($text);
        $text = str_replace(['%', '؛', '،', '<', '>', '«', '»', '|', '[', ']', '؟', '?', '(', ')', '/', '=', '+', '-', '@', '!', '؟', '#', '$', '^', '&', '_', '*', '"', "'", '{', '}', '~', '`', '`', 'ـ', '.'], '', $text);
        $text = str_replace(['١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩', '٠'], ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0'], $text);
        $text = preg_replace('!&#x66([0-9]{1});!', '$1', $text);
        $text = $this->split_numbers($text);
        $text = preg_replace('/^(\s*\x{0627}\x{0644})/u', '', $text);    //if start with alef lam then remove it
        $text = preg_replace('/(\W+\x{0627}\x{0644})/u', ' ', " " . $text);
        return $text;
    }

    private function unichar($u)
    {
        return mb_convert_encoding('&#' . intval($u) . ';', 'UTF-8', 'HTML-ENTITIES');
    }

    private function arabic101($text)
    {
        //tatweel and tshkeel
        $tashkeel = [$this->unichar(0x0640), $this->unichar(0x064B), $this->unichar(0x064C), $this->unichar(0x064D), $this->unichar(0x064E), $this->unichar(0x064F), $this->unichar(0x0650), $this->unichar(0x0651), $this->unichar(0x0652),];
        $text = str_replace($tashkeel, "", $text);
        //hamaza yeh , waw
        $replace = [$this->unichar(0x0624) => $this->unichar(0x0648), $this->unichar(0x0626) => $this->unichar(0x064a),];
        //alephs hamaza
        $alephs = [$this->unichar(0x0622), $this->unichar(0x0623), $this->unichar(0x0625), $this->unichar(0x0654), $this->unichar(0x0655),];
        $text = str_replace(array_keys($replace), array_values($replace), $text);
        $text = str_replace($alephs, $this->unichar(0x0627), $text);
        //Ligatures
        $text = str_replace($this->unichar(0xFEF7), $this->unichar(0x0644) . $this->unichar(0x064E) . $this->unichar(0x0627), $text);
        $text = str_replace($this->unichar(0xFEF7), $this->unichar(0x0644) . $this->unichar(0x0623), $text);
        $text = str_replace($this->unichar(0xFEF9), $this->unichar(0x0644) . $this->unichar(0x0625), $text);
        $text = str_replace($this->unichar(0xFEF5), $this->unichar(0x064E) . $this->unichar(0x0627), $text);
        return $text;
    }

    private function compile($array)
    {
        $result = [];

        foreach ($array as $string) {
            $needle = $this->normalize_text($string);

            //lets get number
            //if not then arabic word
            //if not then get it in last
            if (preg_match('!\d+!', $needle, $num)) {
                $sort = $num[0];
                $result[$string] = $sort;
            } else {
                $ar_int = $this->str2int($needle);

                if ($ar_int != 0) {
                    $result[$string] = $ar_int;
                } else {
                    $result[$string] = $string;
                }
            }
        }
        return $result;
    }
}
