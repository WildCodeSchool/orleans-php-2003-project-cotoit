<?php


namespace App\Service;

class ParsingManager
{
    private function removeSpecialCharacters(string $input)
    {
        $characters = [
            '/[áàâãªä]/u' => 'a',
            '/[ÁÀÂÃÄ]/u' => 'A',
            '/[ÍÌÎÏ]/u' => 'I',
            '/[íìîï]/u' => 'i',
            '/[éèêë]/u' => 'e',
            '/[ÉÈÊË]/u' => 'E',
            '/[óòôõºö]/u' => 'o',
            '/[ÓÒÔÕÖ]/u' => 'O',
            '/[úùûü]/u' => 'u',
            '/[ÚÙÛÜ]/u' => 'U',
            '/ç/' => 'c',
            '/Ç/' => 'C',
            '/ñ/' => 'n',
            '/Ñ/' => 'N',
            '/[«»]/u' => '',
        ];

        return preg_replace(array_keys($characters), array_values($characters), $input);
    }

    public function slugArrayKey(array $input)
    {
        $oldKeys = array_keys($input);
        $newKeys = [];
        foreach ($oldKeys as $oldKey) {
            array_push(
                $newKeys,
                trim(
                    strtolower(
                        preg_replace(
                            ['#[^A-Za-z0-9 \']+#',
                                '#[\s-]+#'],
                            ['',
                                '-'],
                            $this->removeSpecialCharacters($oldKey)
                        )
                    ),
                    '-'
                )
            );
        }

        return array_combine($newKeys, $input);
    }

    public function moveKeyBefore($array, $find, $move)
    {
        if (!isset($array[$find], $array[$move])) {
            return $array;
        }

        $length = 0;
        $keys = array_keys($array);
        foreach ($keys as $key) {
            if ($key == $find) {
                break;
            } else {
                $length += 1;
            }
        }

        $element = [$move => $array[$move]];
        $start = array_splice($array, 0, $length);
        unset($start[$move]);

        return $start + $element + $array;
    }
}
