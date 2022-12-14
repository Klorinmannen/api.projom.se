<?php

declare(strict_types=1);

namespace pokemon\api;

class controller extends \api\resource\controller
{
    public const FIELDS = [
        'PokemonID' => 'pokemon_id',
        'Description' => 'description',
        'Name' => 'name',
        'Shiny' => 'shiny',
        'Shadow' => 'shadow',
        'Galar' => 'galar',
        'Alolan' => 'alolan',
        'BaseAttack' => 'base_attack',
        'BaseDefense' => 'base_defense',
        'BaseStamina' => 'base_stamina',
        'PokemonTypeID1' => 'pokemon_type_id_1',
        'PokemonTypeID2' => 'pokemon_type_id_2'
    ];

    public function pokemon_list()
    {
        $fields = array_keys(static::FIELDS);
        $pokemon_data = model::list($fields);
        if (!$pokemon_data)
            throw new \Exception('Pokemon(s) not found', 404);

        return self::response($pokemon_data);
    }

    public function pokemon_list_checksum()
    {
        $fields = array_keys(static::FIELDS);
        $pokemon_data = model::list($fields);
        return [
            md5(serialize($pokemon_data))
        ];
    }

    public function response(array $pokemon_data): array
    {
        $response = [];
        foreach ($pokemon_data as $pokemon)
            $response[] = self::format_pokemon($pokemon);
        return $response;
    }

    public function format_pokemon(array $pokemon)
    {
        $formated_pokemon = [];
        foreach (static::FIELDS as $db_field => $value_field)
            $formated_pokemon[$value_field] = $pokemon[$db_field];
        return $formated_pokemon;
    }

    public function validate(array $response): bool
    {
        return true;
    }
}
